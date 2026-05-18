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

        if (!$session) {
            return redirect()->route('ujian.hasil', $id);
        }

        // 2. Ambil Jawaban User
        $jawabanUser = $request->input('jawaban', []);
        if (empty($jawabanUser)) {
            $redisAnswersKey = "temp_answers:user_{$userId}:tryout_{$id}";
            $jawabanUser = \Illuminate\Support\Facades\Redis::hgetAll($redisAnswersKey) ?? [];
        }

        // 3. Ambil Urutan Soal Asli dari Redis SEBELUM Dihapus
        $redisSequenceKey = "sequence:user_{$userId}:tryout_{$id}";
        $sequenceJson = \Illuminate\Support\Facades\Redis::get($redisSequenceKey);
        $questionSequence = json_decode($sequenceJson, true);

        if (empty($questionSequence)) {
            $questionSequence = array_keys($jawabanUser);
        }

        // ==========================================
        // 4. PERSIAPAN SKOR DINAMIS BERDASARKAN KATEGORI
        // ==========================================
        $categories = \App\Models\Category::all()->keyBy('id');
        $skorPerKategori = []; // Array penampung dinamis
        $totalSkorKeseluruhan = 0;

        // Inisialisasi awal nilai 0 untuk setiap kategori yang ada di DB
        foreach ($categories as $catId => $catData) {
            $skorPerKategori[$catId] = [
                'name' => $catData->name,
                'skor' => 0,
                'passing_grade' => $catData->passing_grade_score ?? 0 // Sesuaikan nama kolom PG kamu
            ];
        }

        $examAnswersData = [];
        $questions = \App\Models\Question::whereIn('id', $questionSequence)->get()->keyBy('id');
        $optionIds = array_values($jawabanUser);
        $options = \App\Models\QuestionOption::whereIn('id', $optionIds)->get()->keyBy('id');

        // ==========================================
        // 5. PROSES PERHITUNGAN DINAMIS (TANPA HARDCODE TWK/TIU/TKP)
        // ==========================================
        foreach ($questionSequence as $qId) {
            $question = $questions->get($qId);
            $optId = $jawabanUser[$qId] ?? null;
            $option = $optId ? $options->get($optId) : null;

            $pointEarned = 0;

            if ($question) {
                if ($option) {
                    $pointEarned = $option->point;
                    // Tambahkan poin ke array dinamis berdasarkan category_id soal
                    if (isset($skorPerKategori[$question->category_id])) {
                        $skorPerKategori[$question->category_id]['skor'] += $pointEarned;
                    }
                }

                $totalSkorKeseluruhan += $pointEarned;

                $examAnswersData[] = [
                    'exam_session_id' => $session->id,
                    'question_id'     => $qId,
                    'option_id'       => $optId,
                    'score_earned'    => $pointEarned,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
            }
        }

        // ==========================================
        // 6. PENENTUAN KELULUSAN (LULUS SEMUA KATEGORI)
        // ==========================================
        $lulus = true;
        foreach ($skorPerKategori as $hasilKategori) {
            if ($hasilKategori['skor'] < $hasilKategori['passing_grade']) {
                $lulus = false;
                break; // Jika ada 1 yang di bawah passing grade, langsung tidak lulus
            }
        }

        // Lempar data matang ke Session untuk diambil di fungsi hasil()
        session([
            'hasilUjian' => [
                'skorPerKategori' => $skorPerKategori,
                'total_score' => $totalSkorKeseluruhan,
                'lulus' => $lulus
            ]
        ]);

        // ==========================================
        // 7. SIMPAN PERMANEN KE DB
        // ==========================================
        // CATATAN: Kolom score_twk, score_tiu, score_tkp di tabel exam_sessions
        // bisa kamu pertahankan dulu untuk kompatibilitas data lama. 
        // Tapi nilai dinamis kita simpan sebagai JSON di kolom 'total_score' (jika memungkinkan)
        // atau simpan totalnya saja.
        
        // Cari ID TWK, TIU, TKP untuk mengisi legacy column secara aman
        $twkId = $categories->where('name', 'TWK')->first()->id ?? null;
        $tiuId = $categories->where('name', 'TIU')->first()->id ?? null;
        $tkpId = $categories->where('name', 'TKP')->first()->id ?? null;

        $session->update([
            'end_time'    => now(),
            'score_twk'   => $twkId ? $skorPerKategori[$twkId]['skor'] : 0,
            'score_tiu'   => $tiuId ? $skorPerKategori[$tiuId]['skor'] : 0,
            'score_tkp'   => $tkpId ? $skorPerKategori[$tkpId]['skor'] : 0,
            'total_score' => $totalSkorKeseluruhan,
        ]);

        if (count($examAnswersData) > 0) {
            \App\Models\ExamAnswer::insert($examAnswersData);
        }

        // ==========================================
        // 8. PEMBERSIHAN REDIS 
        // ==========================================
        \Illuminate\Support\Facades\Redis::del("temp_answers:user_{$userId}:tryout_{$id}");
        \Illuminate\Support\Facades\Redis::del("temp_ragu:user_{$userId}:tryout_{$id}");
        \Illuminate\Support\Facades\Redis::del("timer:user_{$userId}:tryout_{$id}");
        \Illuminate\Support\Facades\Redis::del("sequence:user_{$userId}:tryout_{$id}");

        return redirect()->route('ujian.hasil', $id);
    }


    // FUNGSI HASIL
    public function hasil($id)
    {
        $hasil = session('hasilUjian');
        
        if (!$hasil) {
            return redirect()->route('ujian.persiapan', $id);
        }

        return view('user.ujian.ujian_hasil', [
            'id' => $id,
            'hasilPerKategori' => $hasil['skorPerKategori'],
            'totalSkor' => $hasil['total_score'],
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

        // 2. Ambil riwayat jawaban user dari database (Urutkan dari ID terkecil agar konsisten saat di-insert)
        $examAnswers = \App\Models\ExamAnswer::where('exam_session_id', $sessionDb->id)
            ->orderBy('id', 'asc')
            ->get();
        
        // Ubah menjadi array [ID_Soal => ID_Opsi_Yang_Dipilih] agar mudah dibaca di Blade
        $jawabanUser = $examAnswers->pluck('option_id', 'question_id')->toArray();

        // 3. Ambil detail Soal, Opsi, dan Kategorinya
        $questionIds = $examAnswers->pluck('question_id')->toArray();
        
        // KUNCI PERBAIKAN: Gunakan sortBy agar data soal dipaksa mengikuti urutan array $questionIds
        $questions = \App\Models\Question::with(['options', 'category'])
            ->whereIn('id', $questionIds)
            ->get()
            ->sortBy(function ($q) use ($questionIds) {
                return array_search($q->id, $questionIds);
            })
            ->values(); // Mengembalikan indeks array menjadi 0, 1, 2, dst.

        return view('user.ujian.ujian_pembahasan', compact('questions', 'jawabanUser', 'id'));
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

    public function riwayatSertifikat()
    {
        $userId = auth()->id();

        // 1. Mengambil riwayat ujian yang sudah selesai (Diurutkan dari yang paling baru)
        $riwayatUjian = \App\Models\ExamSession::with('tryout')
            ->where('user_id', $userId)
            ->whereNotNull('end_time')
            ->latest() // Ini sama dengan orderBy('created_at', 'desc')
            ->get();

        // 2. Mencari ID sesi terbaru untuk masing-masing Tryout
        $sessionTerbaruPerTryout = $riwayatUjian->groupBy('tryout_id')
            ->map(function ($group) {
                // Karena $riwayatUjian di atas sudah diurutkan (latest), 
                // maka urutan pertama (first) di setiap grup pasti adalah data yang paling baru.
                return $group->first()->id; 
            })->toArray();

        // 3. Lempar kedua variabel ke file View
        return view('user.riwayat_tryout.riwayat_ujian', compact('riwayatUjian', 'sessionTerbaruPerTryout'));
    }

    public function sertifikat($id)
    {
        $userId = auth()->id();

        // 1. Ambil data BERDASARKAN ID SESI UJIAN LANGSUNG (bukan tryout_id)
        $session = \App\Models\ExamSession::where('user_id', $userId)
            ->where('id', $id) // Tembak langsung ke primary key id session-nya
            ->first();

        // 🔴 TEPAT DI SINI KITA PASANG ALAT DETEKTIF (DEBBUGING)
        // Jika kamu masih mental ke dashboard, hapus tanda komentar (//) pada baris dd di bawah ini:
        // dd($session->toArray());

        if (!$session) {
            return redirect()->route('dashboard')->with('error', 'Sesi ujian tidak ditemukan.');
        }

        // 2. Kalkulasi aman untuk mengantisipasi data lama yang total_score-nya masih 0
        $totalSkorReal = $session->total_score;
        if (!$totalSkorReal || $totalSkorReal == 0) {
            $totalSkorReal = ($session->score_twk ?? 0) + ($session->score_tiu ?? 0) + ($session->score_tkp ?? 0);
        }

        // 3. Cek passing grade total
        if ($totalSkorReal < 311) {
            return redirect()->route('dashboard')->with('error', 'Skor Anda (' . $totalSkorReal . ') belum memenuhi passing grade kelulusan.');
        }

        // 4. Susun format untuk dilempar ke Blade Sertifikat
        $skorFormat = [
            'TWK' => $session->score_twk ?? 0,
            'TIU' => $session->score_tiu ?? 0,
            'TKP' => $session->score_tkp ?? 0,
            'TOTAL' => $totalSkorReal
        ];

        return view('user.ujian.sertifikat', [
            'user' => auth()->user(),
            'skor' => $skorFormat,
            'tanggal' => $session->end_time ? $session->end_time->format('d F Y') : date('d F Y')
        ]);
    }    
}
