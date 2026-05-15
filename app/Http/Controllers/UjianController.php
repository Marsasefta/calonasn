<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UjianController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Question;
use App\Models\Category;
use App\Models\Tryout;
use App\Models\Transaction;
use App\Models\ExamSession;

class UjianController extends Controller
{

    // Logika Inti Lock & Unlock
    public function checkUserAccess($tryoutId)
    {
        $userId = auth()->id();

        // 1. Cari transaksi sukses terbaru
        $lastSuccess = \App\Models\Transaction::where('user_id', $userId)
            ->where('tryout_id', $tryoutId)
            ->where('status', 'success')
            ->latest()
            ->first();

        if (!$lastSuccess) {
            return ['status' => 'locked', 'message' => 'Silakan beli paket ini terlebih dahulu.'];
        }

        // 2. Cari sesi ujian terbaru yang SUDAH SELESAI
        $lastFinishedSession = \App\Models\ExamSession::where('user_id', $userId)
            ->where('tryout_id', $tryoutId)
            ->whereNotNull('end_time') // Harus yang sudah ada waktu selesainya
            ->latest()
            ->first();

        // --- LOGIKA KUNCI ---
        // Jika belum pernah selesai ujian, akses TERBUKA.
        if (!$lastFinishedSession) {
            return ['status' => 'unlocked'];
        }

        // Jika transaksi sukses lebih baru daripada waktu selesai ujian terakhir, akses TERBUKA.
        if ($lastSuccess->updated_at > $lastFinishedSession->end_time) {
            return ['status' => 'unlocked'];
        }

        // Selain itu, akses TERKUNCI (Berarti transaksi lama sudah "dipakai" ujian).
        return ['status' => 'locked', 'message' => 'Sesi ujian telah selesai. Beli lagi untuk mencoba ulang.'];
    }

    // Halaman "Gerbang" sebelum masuk ke soal
    public function persiapan($id)
    {
        $tryout = Tryout::findOrFail($id);
        $access = $this->checkUserAccess($id);

        return view('user.ujian.persiapan', compact('tryout', 'access'));
    }

    public function mulai($id)
    {
        $tryout = \App\Models\Tryout::findOrFail($id);
        $userId = auth()->id();

        // Key Redis sesuai Blueprint
        $redisTimerKey = "timer:user_{$userId}:tryout_{$id}";
        $redisAnswersKey = "temp_answers:user_{$userId}:tryout_{$id}";
        $redisRaguKey = "temp_ragu:user_{$userId}:tryout_{$id}";
        $redisSequenceKey = "sequence:user_{$userId}:tryout_{$id}";

        // 1. Cek Sesi Ujian di MariaDB
        $session = \App\Models\ExamSession::where('user_id', $userId)
                    ->where('tryout_id', $id)
                    ->whereNull('end_time')
                    ->first();

        $questionSequence = [];

        if (!$session) {
            // --- PROSES MEMBERSIHKAN DATA LAMA (CLEAN UP) ---
            // PENTING: Bersihkan semua sisa jawaban, timer, dan ragu-ragu dari sesi sebelumnya
            \Illuminate\Support\Facades\Redis::del($redisTimerKey);
            \Illuminate\Support\Facades\Redis::del($redisAnswersKey);
            \Illuminate\Support\Facades\Redis::del($redisRaguKey);
            \Illuminate\Support\Facades\Redis::del($redisSequenceKey);

            // --- SESI BARU: GENERATE SOAL ACAK SESUAI BKN ---
            
            // Ambil ID Kategori (Pastikan penamaan di database sesuai)
            $catTwk = \App\Models\Category::where('name', 'TWK')->value('id');
            $catTiu = \App\Models\Category::where('name', 'TIU')->value('id');
            $catTkp = \App\Models\Category::where('name', 'TKP')->value('id');

            // Tarik Soal Acak per Kategori
            $twkQuestions = \App\Models\Question::with(['options', 'category'])->where('category_id', $catTwk)->inRandomOrder()->limit(30)->get();
            $tiuQuestions = \App\Models\Question::with(['options', 'category'])->where('category_id', $catTiu)->inRandomOrder()->limit(35)->get();
            $tkpQuestions = \App\Models\Question::with(['options', 'category'])->where('category_id', $catTkp)->inRandomOrder()->limit(45)->get();

            $allQuestions = $twkQuestions->merge($tiuQuestions)->merge($tkpQuestions);
            $questionSequence = $allQuestions->pluck('id')->toArray();
            $questions = $allQuestions; 

            // Buat Sesi di MariaDB
            $session = \App\Models\ExamSession::create([
                'user_id' => $userId,
                'tryout_id' => $id,
                'start_time' => now(),
            ]);

            // Simpan urutan di Redis agar tidak teracak jika user refresh browser
            \Illuminate\Support\Facades\Redis::set($redisSequenceKey, json_encode($questionSequence));
            \Illuminate\Support\Facades\Redis::expire($redisSequenceKey, ($tryout->duration_minutes + 10) * 60);

            // Set Timer awal di Redis (dalam detik)
            \Illuminate\Support\Facades\Redis::set($redisTimerKey, $tryout->duration_minutes * 60);
            \Illuminate\Support\Facades\Redis::expire($redisTimerKey, ($tryout->duration_minutes + 10) * 60);

        } else {
            // --- LANJUTKAN SESI LAMA (Biar gak ganti soal kalau di-refresh) ---
            
            $sequenceJson = \Illuminate\Support\Facades\Redis::get($redisSequenceKey);
            $questionSequence = json_decode($sequenceJson, true);

            // --- PROTEKSI DATA HILANG ---
            // Jika sesi di MariaDB ada, tapi data urutan di Redis hilang / expired
            if (empty($questionSequence)) {
                // Kita hapus sesi yang "gantung" ini di MariaDB
                $session->delete();
                
                // Lalu paksa sistem untuk me-reload halaman agar membuat sesi & urutan baru dari awal
                return redirect()->route('ujian.mulai', $id);
            }

            // Ambil data soal berdasarkan urutan yang sudah dikunci
            $questions = \App\Models\Question::with(['options', 'category']) 
                ->whereIn('id', $questionSequence)
                ->get()
                ->sortBy(function ($q) use ($questionSequence) {
                    return array_search($q->id, $questionSequence);
                })->values();
        }

        // Ambil sisa waktu dari Redis
        $durationInSeconds = \Illuminate\Support\Facades\Redis::get($redisTimerKey) ?? ($tryout->duration_minutes * 60);

        // Ambil jawaban sementara dari Redis (Format HASH: Key = Soal ID, Value = Opsi ID)
        $tempAnswers = \Illuminate\Support\Facades\Redis::hgetAll($redisAnswersKey) ?? [];

        // Ambil status ragu-ragu dari Redis
        $tempRagu = \Illuminate\Support\Facades\Redis::hgetAll($redisRaguKey) ?? [];

        return view('user.ujian.ujian', compact('questions', 'durationInSeconds', 'tryout', 'tempAnswers', 'tempRagu'));
    }

    public function selesai(Request $request, $id)
    {
        $userId = auth()->id();

        // 1. Pastikan Sesi Ujian Masih Aktif di Database
        $session = \App\Models\ExamSession::where('user_id', $userId)
            ->where('tryout_id', $id)
            ->whereNull('end_time')
            ->latest()
            ->first();

        // Jika tidak ada sesi (misal user refresh setelah selesai), cegah error
        if (!$session) {
            return redirect()->route('ujian.hasil', $id);
        }

        // 2. Ambil Jawaban User
        // Kita prioritaskan dari Form Submit. Tapi jika kosong (misal timeout otomatis), kita ambil dari Redis penyelamat kita!
        $jawabanUser = $request->input('jawaban', []);
        if (empty($jawabanUser)) {
            $redisAnswersKey = "temp_answers:user_{$userId}:tryout_{$id}";
            $jawabanUser = \Illuminate\Support\Facades\Redis::hgetAll($redisAnswersKey) ?? [];
        }
        
        // Simpan ke session untuk keperluan tampilan instan di Blade Hasil
        session(['jawabanUser' => $jawabanUser]);

        // 3. Inisialisasi Variabel Skor
        $skor = ['TWK' => 0, 'TIU' => 0, 'TKP' => 0];
        
        // Ambil referensi Kategori dari database agar id & passing_grade-nya akurat
        $categories = \App\Models\Category::all()->keyBy('id');
        $catTwk = $categories->where('name', 'TWK')->first();
        $catTiu = $categories->where('name', 'TIU')->first();
        $catTkp = $categories->where('name', 'TKP')->first();

        $examAnswersData = []; // Array untuk menyimpan detail jawaban ke MariaDB

        // 4. Hitung Skor Berdasarkan Tabel question_options
        if (!empty($jawabanUser)) {
            // Ambil semua soal dan opsi yang dijawab sekaligus agar query tidak lambat (Optimasi)
            $questionIds = array_keys($jawabanUser);
            $questions = \App\Models\Question::whereIn('id', $questionIds)->get()->keyBy('id');
            
            $optionIds = array_values($jawabanUser);
            $options = \App\Models\QuestionOption::whereIn('id', $optionIds)->get()->keyBy('id');

            foreach ($jawabanUser as $qId => $optId) {
                $question = $questions->get($qId);
                $option = $options->get($optId);

                if ($question && $option) {
                    // Tambahkan poin berdasarkan kategori soal (0-5 sesuai yang ada di DB options)
                    if ($question->category_id == $catTwk->id) {
                        $skor['TWK'] += $option->point;
                    } elseif ($question->category_id == $catTiu->id) {
                        $skor['TIU'] += $option->point;
                    } elseif ($question->category_id == $catTkp->id) {
                        $skor['TKP'] += $option->point;
                    }

                    // Kumpulkan data jawaban untuk di-insert ke tabel exam_answers
                    $examAnswersData[] = [
                        'exam_session_id' => $session->id,
                        'question_id'     => $qId,
                        'option_id'       => $optId,
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ];
                }
            }
        }

        $skor['TOTAL'] = array_sum($skor);

        // 5. Penentuan Lulus / Tidak Lulus (Sesuai Passing Grade Masing-masing)
        $passTwk = $skor['TWK'] >= ($catTwk->passing_grade_score ?? 65);
        $passTiu = $skor['TIU'] >= ($catTiu->passing_grade_score ?? 80);
        $passTkp = $skor['TKP'] >= ($catTkp->passing_grade_score ?? 166);
        
        // Lulus hanya jika KETIGA kategori memenuhi syarat minimal
        $lulus = $passTwk && $passTiu && $passTkp; 
        
        session(['hasilUjian' => compact('skor', 'lulus')]);

        // 6. Simpan Permanen ke Tabel exam_sessions (MariaDB)
        $session->update([
            'end_time'    => now(),
            'score_twk'   => $skor['TWK'],
            'score_tiu'   => $skor['TIU'],
            'score_tkp'   => $skor['TKP'],
            'total_score' => $skor['TOTAL'],
        ]);

        // 7. Simpan Riwayat Jawaban per Soal ke exam_answers (Insert Massal)
        // Syarat: Pastikan kamu sudah membuat Model ExamAnswer
        if (count($examAnswersData) > 0) {
            \App\Models\ExamAnswer::insert($examAnswersData);
        }

        // 8. PEMBERSIHAN REDIS (Wajib agar RAM server tidak penuh)
        \Illuminate\Support\Facades\Redis::del("temp_answers:user_{$userId}:tryout_{$id}");
        \Illuminate\Support\Facades\Redis::del("temp_ragu:user_{$userId}:tryout_{$id}");
        \Illuminate\Support\Facades\Redis::del("timer:user_{$userId}:tryout_{$id}");
        \Illuminate\Support\Facades\Redis::del("sequence:user_{$userId}:tryout_{$id}");

        return redirect()->route('ujian.hasil', $id);
    }

    // public function selesai(Request $request)
    // {
    //     $jawabanUser = $request->input('jawaban', []);
    //     session(['jawabanUser' => $jawabanUser]);

    //     $skor = ['TWK' => 0, 'TIU' => 0, 'TKP' => 0, 'TOTAL' => 0];
    //     foreach($jawabanUser as $id => $jawaban) {
    //         if ($id <= 30) { $skor['TWK'] += 5; }
    //         elseif ($id <= 65) { $skor['TIU'] += 5; }
    //         else { $skor['TKP'] += rand(1, 5); }
    //     }
    //     $skor['TOTAL'] = $skor['TWK'] + $skor['TIU'] + $skor['TKP'];
    //     $lulus = ($skor['TWK'] >= 65 && $skor['TIU'] >= 80 && $skor['TKP'] >= 166);

    //     // Simpan hasil ke session agar bisa dibaca di rute GET
    //     session(['hasilUjian' => compact('skor', 'lulus')]);

    //     // REDIRECT ke rute GET hasil
    //     return redirect()->route('ujian.hasil');
    // }

    // Tambahkan fungsi baru ini untuk menampilkan halaman hasil
    public function hasil($id) // Tambahkan $id agar konsisten
    {
        $hasil = session('hasilUjian');
        if (!$hasil) {
            return redirect()->route('ujian.persiapan', $id);
        }

        return view('user.ujian.ujian_hasil', [
            'id' => $id,
            'skor' => $hasil['skor'],
            'lulus' => $hasil['lulus']
        ]);
    }

    public function pembahasan($id)
    {
        $userId = auth()->id();

        // 1. Ambil sesi ujian yang sudah SELESAI
        $sessionDb = \App\Models\ExamSession::where('user_id', $userId)
            ->where('tryout_id', $id)
            ->whereNotNull('end_time')
            ->latest()
            ->firstOrFail();

        // 2. Ambil riwayat jawaban user dari database
        $examAnswers = \App\Models\ExamAnswer::where('exam_session_id', $sessionDb->id)->get();
        
        // Ubah menjadi array [ID_Soal => ID_Opsi_Yang_Dipilih] agar mudah dibaca di Blade
        $jawabanUser = $examAnswers->pluck('option_id', 'question_id')->toArray();

        // 3. Ambil detail Soal, Opsi, dan Kategorinya
        // (Kita ambil soal-soal yang ada di riwayat jawaban user)
        $questionIds = $examAnswers->pluck('question_id')->toArray();
        $questions = \App\Models\Question::with(['options', 'category'])
            ->whereIn('id', $questionIds)
            ->get();

        return view('user.ujian.ujian_pembahasan', compact('questions', 'jawabanUser', 'id'));
    }

    public function sertifikat()
    {
        $hasil = session('hasilUjian');
        
        // Proteksi: Jika tidak ada data ujian atau tidak lulus, tendang balik ke dashboard
        if (!$hasil || !$hasil['lulus']) {
            return redirect()->route('dashboard')->with('error', 'Sertifikat hanya tersedia bagi peserta yang lulus Passing Grade.');
        }

        return view('user.ujian.sertifikat', [
            'user' => auth()->user(),
            'skor' => $hasil['skor'],
            'tanggal' => date('d F Y') // Format tanggal hari ini
        ]);
    }

    public function riwayatSertifikat()
    {
        $userId = auth()->id();

        // Mengambil riwayat ujian yang sudah selesai
        $riwayatUjian = \App\Models\ExamSession::with('tryout')
            ->where('user_id', $userId)
            ->whereNotNull('end_time')
            ->latest()
            ->get();

        return view('user.sertifikat.sertifikat_riwayat', compact('riwayatUjian'));
    }

    public function simpanJawabanTemp(Request $request)
    {
        $userId = auth()->id();
        $tryoutId = $request->tryout_id;
        $questionId = $request->question_id;
        $optionId = $request->option_id;

        $redisAnswersKey = "temp_answers:user_{$userId}:tryout_{$tryoutId}";
        
        // Simpan ke Redis Hash 
        Redis::hset($redisAnswersKey, $questionId, $optionId);

        return response()->json(['status' => 'success']);
    }

    public function updateTimer(Request $request)
    {
        $userId = auth()->id();
        $tryoutId = $request->tryout_id;
        $sisaWaktu = $request->sisa_waktu; // dari frontend

        $redisTimerKey = "timer:user_{$userId}:tryout_{$tryoutId}";
        Redis::set($redisTimerKey, $sisaWaktu);

        return response()->json(['status' => 'success']);
    }

    public function simpanRaguTemp(Request $request)
    {
        $userId = auth()->id();
        $tryoutId = $request->tryout_id;
        $questionId = $request->question_id;
        $isRagu = $request->is_ragu;

        $redisRaguKey = "temp_ragu:user_{$userId}:tryout_{$tryoutId}";
        
        if ($isRagu) {
            // Jika dicentang, simpan angka 1 ke Redis
            \Illuminate\Support\Facades\Redis::hset($redisRaguKey, $questionId, 1);
        } else {
            // Jika hapus centang, hapus datanya dari Redis
            \Illuminate\Support\Facades\Redis::hdel($redisRaguKey, $questionId);
        }

        return response()->json(['status' => 'success']);
    }
}
