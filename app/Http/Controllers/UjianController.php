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

    // Logika Inti Lock & Unlock (Mendukung Multi-Paket & Retry Ujian)
    public function checkUserAccess($tryoutId)
    {
        $userId = auth()->id();
        $user = auth()->user();

        // 1. Ambil transaksi sukses terbaru untuk MASING-MASING ID paket
        // Menggunakan LOWER agar aman dari salah ketik 'Success' atau 'success' di database
        $trx1 = Transaction::where('user_id', $userId)->where('tryout_id', 1)->whereRaw('LOWER(status) = ?', ['success'])->latest()->first();
        $trx2 = Transaction::where('user_id', $userId)->where('tryout_id', 2)->whereRaw('LOWER(status) = ?', ['success'])->latest()->first();
        $trx3 = Transaction::where('user_id', $userId)->where('tryout_id', 3)->whereRaw('LOWER(status) = ?', ['success'])->latest()->first();

        // Cek status Paket Lengkap (Beli Paket 2 langsung, atau Upgrade Paket 1 + Paket 3, atau manual is_premium)
        $isUnlimited = $trx2 || ($trx1 && $trx3) || ($user && $user->is_premium);

        // JIKA USER MEMILIKI PAKET 2 (LENGKAP/UNLIMITED):
        // Akses untuk Tryout 1 sepuasnya tanpa batas dan tidak pernah terkunci
        if ($tryoutId == 1 && $isUnlimited) {
            return [
                'status' => 'unlocked',
                'is_unlimited' => true,
                'message' => 'Akses Unlimited (Paket Lengkap) aktif.'
            ];
        }

        $hasAccess = false;
        $lastTransactionTime = null;

        // 2. Tentukan Hak Akses & Ambil Waktu Pembelian Terakhir (Untuk Paket Mandiri / Non-Unlimited)
        if ($tryoutId == 1) {
            if ($trx1) {
                $hasAccess = true;
                $lastTransactionTime = $trx1->updated_at;
            }
        } elseif ($tryoutId == 2) {
            if ($isUnlimited) {
                return [
                    'status' => 'unlocked',
                    'is_unlimited' => true,
                    'message' => 'Akses Paket Lengkap aktif.'
                ];
            }
        }

        // Jika setelah dicek ternyata tidak punya akses sama sekali
        if (!$hasAccess) {
            return [
                'status' => 'locked',
                'is_unlimited' => false,
                'message' => 'Silakan miliki paket yang sesuai terlebih dahulu.'
            ];
        }

        // 3. Cari sesi ujian terbaru yang SUDAH SELESAI (berdasarkan tryout yang mau diakses)
        $lastFinishedSession = ExamSession::where('user_id', $userId)
            ->where('tryout_id', $tryoutId)
            ->whereNotNull('end_time') // Harus yang sudah ada waktu selesainya
            ->latest()
            ->first();

        // --- LOGIKA KUNCI (RETRY EXAM UNTUK PAKET MANDIRI / NON-UNLIMITED) ---
        // Jika belum pernah selesai ujian ini sama sekali, akses TERBUKA.
        if (!$lastFinishedSession) {
            return [
                'status' => 'unlocked',
                'is_unlimited' => false,
            ];
        }

        // Jika waktu pembelian paket (yang valid) LEBIH BARU daripada waktu selesai ujian terakhir, 
        // berarti dia sudah "Beli Lagi", maka akses TERBUKA.
        if ($lastTransactionTime > $lastFinishedSession->end_time) {
            return [
                'status' => 'unlocked',
                'is_unlimited' => false,
            ];
        }

        // Selain itu, akses TERKUNCI (Berarti kuota transaksi sudah "dipakai" / hangus).
        return [
            'status' => 'locked',
            'is_unlimited' => false,
            'message' => 'Sesi ujian telah selesai. Beli lagi paket ini untuk mencoba ulang.'
        ];
    }

    // Halaman "Gerbang" sebelum masuk ke soal
    public function persiapan($id)
    {
        $tryout = Tryout::findOrFail($id);
        $access = $this->checkUserAccess($id);

        $tryoutMandiri = Tryout::find(1);
        $tryoutLengkap = Tryout::find(2);
        $tryoutUpgrade = Tryout::find(3);
        $promo24h = auth()->user()?->newMemberPromo();

        return view('user.ujian.persiapan', compact(
            'tryout',
            'access',
            'tryoutMandiri',
            'tryoutLengkap',
            'tryoutUpgrade',
            'promo24h'
        ));
    }

    public function mulai($id)
    {
        $tryout = Tryout::findOrFail($id);
        $userId = auth()->id();

        // Key Redis sesuai Blueprint
        $redisTimerKey = "timer:user_{$userId}:tryout_{$id}";
        $redisAnswersKey = "temp_answers:user_{$userId}:tryout_{$id}";
        $redisRaguKey = "temp_ragu:user_{$userId}:tryout_{$id}";
        $redisSequenceKey = "sequence:user_{$userId}:tryout_{$id}";

        // 1. Cek Sesi Ujian di MariaDB
        $session = ExamSession::where('user_id', $userId)
                    ->where('tryout_id', $id)
                    ->whereNull('end_time')
                    ->first();

        $questionSequence = [];

        if (!$session) {
            // --- PROSES MEMBERSIHKAN DATA LAMA (CLEAN UP) ---
            Redis::del($redisTimerKey);
            Redis::del($redisAnswersKey);
            Redis::del($redisRaguKey);
            Redis::del($redisSequenceKey);

            // --- SESI BARU: GENERATE SOAL ACAK SESUAI BKN ---
            
            // Ambil ID Kategori (Pastikan penamaan di database sesuai)
            $catTwk = Category::where('name', 'TWK')->value('id');
            $catTiu = Category::where('name', 'TIU')->value('id');
            $catTkp = Category::where('name', 'TKP')->value('id');

            // Tarik Soal Acak TWK (30) & TKP (45) seperti biasa
            $twkQuestions = Question::with(['options', 'category'])->where('category_id', $catTwk)->inRandomOrder()->limit(30)->get();
            $tkpQuestions = Question::with(['options', 'category'])->where('category_id', $catTkp)->inRandomOrder()->limit(45)->get();

            // ==========================================
            // LOGIKA KHUSUS TIU (MAX 5 GAMBAR)
            // ==========================================
            
            // Tahap 1: Tarik Soal Gambar TIU (Maksimal 5)
            $tiuImageQuestions = Question::with(['options', 'category'])
                ->where('category_id', $catTiu)
                ->where(function($query) {
                    $query->whereNotNull('question_image')->where('question_image', '!=', '');
                })
                ->inRandomOrder()
                ->limit(5)
                ->get();

            // Tahap 2: Hitung kekurangan kuota untuk pas 35 soal
            $imageCount = $tiuImageQuestions->count();
            $textNeeded = 35 - $imageCount;

            // Tahap 3: Tarik Soal Teks TIU murni sesuai sisa kuota
            $tiuTextQuestions = Question::with(['options', 'category'])
                ->where('category_id', $catTiu)
                ->where(function($query) {
                    $query->whereNull('question_image')->orWhere('question_image', '');
                })
                ->inRandomOrder()
                ->limit($textNeeded)
                ->get();

            // Tahap 4: Gabungkan gambar & teks, lalu ACAK ULANG (shuffle) agar posisinya natural
            $tiuQuestions = $tiuImageQuestions->merge($tiuTextQuestions)->shuffle();
            
            // ==========================================

            // Gabungkan Semua Kategori (TWK -> TIU -> TKP)
            $allQuestions = $twkQuestions->merge($tiuQuestions)->merge($tkpQuestions);
            $questionSequence = $allQuestions->pluck('id')->toArray();
            $questions = $allQuestions; 

            // Buat Sesi di MariaDB
            $session = ExamSession::create([
                'user_id' => $userId,
                'tryout_id' => $id,
                'start_time' => now(),
            ]);

            // Simpan urutan di Redis agar tidak teracak jika user refresh browser
            Redis::set($redisSequenceKey, json_encode($questionSequence));
            Redis::expire($redisSequenceKey, ($tryout->duration_minutes + 10) * 60);

            // Set Timer awal di Redis (dalam detik)
            Redis::set($redisTimerKey, $tryout->duration_minutes * 60);
            Redis::expire($redisTimerKey, ($tryout->duration_minutes + 10) * 60);

        } else {
            // --- LANJUTKAN SESI LAMA ---
            $sequenceJson = Redis::get($redisSequenceKey);
            $questionSequence = json_decode($sequenceJson, true);

            // --- PROTEKSI DATA HILANG ---
            if (empty($questionSequence)) {
                $session->delete();
                return redirect()->route('ujian.mulai', $id);
            }

            // Ambil data soal berdasarkan urutan yang sudah dikunci
            $questions = Question::with(['options', 'category']) 
                ->whereIn('id', $questionSequence)
                ->get()
                ->sortBy(function ($q) use ($questionSequence) {
                    return array_search($q->id, $questionSequence);
                })->values();
        }

        // Ambil sisa waktu & state dari Redis
        $durationInSeconds = Redis::get($redisTimerKey) ?? ($tryout->duration_minutes * 60);
        $tempAnswers = Redis::hgetAll($redisAnswersKey) ?? [];
        $tempRagu = Redis::hgetAll($redisRaguKey) ?? [];

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

        return redirect()->route('ujian.hasil', $session->id);
    }


    // FUNGSI HASIL (Mendukung ID Sesi Ujian maupun ID Tryout)
    public function hasil($id)
    {
        $userId = auth()->id();

        // 1. Cek apakah $id adalah ID ExamSession langsung
        $session = \App\Models\ExamSession::where('user_id', $userId)
            ->where('id', $id)
            ->whereNotNull('end_time')
            ->first();

        // 2. Jika bukan ID ExamSession, cari sesi terbaru berdasarkan tryout_id
        if (!$session) {
            $session = \App\Models\ExamSession::where('user_id', $userId)
                ->where('tryout_id', $id)
                ->whereNotNull('end_time')
                ->latest()
                ->first();
        }

        // 3. Jika sesi tidak ditemukan di database:
        if (!$session) {
            return redirect()->route('dashboard')->with('error', 'Riwayat sesi ujian tidak ditemukan.');
        }

        // 4. Susun data hasil per kategori langsung dari database (Permanen & Tidak bergantung pada flash session)
        $categories = \App\Models\Category::all()->keyBy('id');
        $twkId = $categories->where('name', 'TWK')->first()->id ?? 1;
        $tiuId = $categories->where('name', 'TIU')->first()->id ?? 2;
        $tkpId = $categories->where('name', 'TKP')->first()->id ?? 3;

        $scoreTwk = $session->score_twk ?? 0;
        $scoreTiu = $session->score_tiu ?? 0;
        $scoreTkp = $session->score_tkp ?? 0;
        $totalSkor = $session->total_score ?? ($scoreTwk + $scoreTiu + $scoreTkp);

        $hasilPerKategori = [
            $twkId => [
                'name' => 'TWK',
                'skor' => $scoreTwk,
                'passing_grade' => 65,
                'max_score' => 150,
            ],
            $tiuId => [
                'name' => 'TIU',
                'skor' => $scoreTiu,
                'passing_grade' => 80,
                'max_score' => 175,
            ],
            $tkpId => [
                'name' => 'TKP',
                'skor' => $scoreTkp,
                'passing_grade' => 166,
                'max_score' => 225,
            ],
        ];

        $lulus = ($scoreTwk >= 65 && $scoreTiu >= 80 && $scoreTkp >= 166);

        $access = $this->checkUserAccess($session->tryout_id);
        $user = auth()->user();
        $isUnlimited = !empty($access['is_unlimited']);
        $isPaketMandiri = ($user?->package_status === 'tryout');
        $hargaUpgrade = (int) (Tryout::find(3)->price ?? 29000);

        $totalParticipants = ExamSession::whereNotNull('end_time')
            ->distinct('user_id')
            ->count('user_id');
        $sessionRank = ExamSession::whereNotNull('end_time')
            ->where('total_score', '>', $totalSkor)
            ->distinct('user_id')
            ->count('user_id') + 1;

        $existingFeedback = \App\Models\TryoutFeedback::where('user_id', $userId)->first();

        return view('user.ujian.ujian_hasil', [
            'id' => $session->id,
            'tryoutId' => $session->tryout_id,
            'hasilPerKategori' => $hasilPerKategori,
            'totalSkor' => $totalSkor,
            'lulus' => $lulus,
            'access' => $access,
            'isUnlimited' => $isUnlimited,
            'isPaketMandiri' => $isPaketMandiri,
            'hargaUpgrade' => $hargaUpgrade,
            'totalParticipants' => $totalParticipants,
            'sessionRank' => $sessionRank,
            'existingFeedback' => $existingFeedback,
        ]);
    }

    public function pembahasan($id)
    {
        $userId = auth()->id();

        // 1. Cek apakah $id ini adalah ID ExamSession langsung
        $sessionDb = \App\Models\ExamSession::where('user_id', $userId)
            ->where('id', $id)
            ->whereNotNull('end_time')
            ->first();

        // 2. Jika bukan ID ExamSession, cari sesi terbaru berdasarkan tryout_id
        if (!$sessionDb) {
            $sessionDb = \App\Models\ExamSession::where('user_id', $userId)
                ->where('tryout_id', $id)
                ->whereNotNull('end_time')
                ->latest()
                ->first();
        }

        if (!$sessionDb) {
            return redirect()->route('dashboard')->with('error', 'Sesi ujian untuk pembahasan tidak ditemukan.');
        }

        // 3. Ambil riwayat jawaban user dari database
        $examAnswers = \App\Models\ExamAnswer::where('exam_session_id', $sessionDb->id)
            ->orderBy('id', 'asc')
            ->get();
        
        // Ubah menjadi array [ID_Soal => ID_Opsi_Yang_Dipilih] agar mudah dibaca di Blade
        $jawabanUser = $examAnswers->pluck('option_id', 'question_id')->toArray();

        // 4. Ambil detail Soal, Opsi, dan Kategorinya
        $questionIds = $examAnswers->pluck('question_id')->toArray();
        
        if (empty($questionIds)) {
            $questions = \App\Models\Question::with(['options', 'category'])
                ->where('tryout_id', $sessionDb->tryout_id)
                ->orderBy('category_id', 'asc')
                ->orderBy('id', 'asc')
                ->take(110)
                ->get();
        } else {
            $questions = \App\Models\Question::with(['options', 'category'])
                ->whereIn('id', $questionIds)
                ->get()
                ->sortBy(function ($q) use ($questionIds) {
                    return array_search($q->id, $questionIds);
                })
                ->values();
        }

        return view('user.ujian.ujian_pembahasan', [
            'questions' => $questions,
            'jawabanUser' => $jawabanUser,
            'id' => $sessionDb->id
        ]);
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
                return $group->first()->id; 
            })->toArray();

        // 3. Hitung Statistik Ringkasan Pengguna
        $totalTryout = $riwayatUjian->count();
        $skorTertinggi = $riwayatUjian->max('total_score') ?? 0;
        $totalLulus = $riwayatUjian->filter(function ($item) {
            return ($item->score_twk >= 65 && $item->score_tiu >= 80 && $item->score_tkp >= 166);
        })->count();

        $hasSubmittedFeedback = \App\Models\TryoutFeedback::where('user_id', $userId)->exists();

        // 4. Lempar variabel ke file View
        return view('user.riwayat_tryout.riwayat_ujian', compact(
            'riwayatUjian', 
            'sessionTerbaruPerTryout', 
            'totalTryout', 
            'skorTertinggi', 
            'totalLulus',
            'hasSubmittedFeedback'
        ));
    }

    public function sertifikat($id)
    {
        $userId = auth()->id();

        // 1. Ambil data sesi ujian berdasarkan ID sesi ujian & milik user aktif
        $session = \App\Models\ExamSession::where('user_id', $userId)
            ->where('id', $id)
            ->first();

        if (!$session) {
            return redirect()->route('sertifikat.riwayat')->with('error', 'Sesi ujian tidak ditemukan.');
        }

        // 2. Cek apakah memenuhi ambang batas (Passing Grade) resmi BKN untuk masing-masing kategori
        $twk = $session->score_twk ?? 0;
        $tiu = $session->score_tiu ?? 0;
        $tkp = $session->score_tkp ?? 0;
        $isLulus = ($twk >= 65 && $tiu >= 80 && $tkp >= 166);

        if (!$isLulus) {
            return redirect()->route('sertifikat.riwayat')->with('error', 'Sesi ujian ini belum memenuhi syarat kelulusan Passing Grade SKD BKN (TWK 65, TIU 80, TKP 166).');
        }

        // 3. Susun format skor & metadata untuk dilempar ke Blade Sertifikat
        $totalSkorReal = $session->total_score ?? ($twk + $tiu + $tkp);
        $skorFormat = [
            'TWK' => $twk,
            'TIU' => $tiu,
            'TKP' => $tkp,
            'TOTAL' => $totalSkorReal
        ];

        $tahun = $session->end_time ? $session->end_time->format('Y') : date('Y');
        $noSertifikat = 'CASN-' . $tahun . '/SKD/' . str_pad($session->id, 5, '0', STR_PAD_LEFT);

        return view('user.ujian.sertifikat', [
            'user' => auth()->user(),
            'session' => $session,
            'skor' => $skorFormat,
            'noSertifikat' => $noSertifikat,
            'token' => $session->certificate_token ?? strtolower(\Illuminate\Support\Str::random(10)),
            'tanggal' => $session->end_time ? $session->end_time->format('d F Y') : date('d F Y')
        ]);
    }

    /**
     * Halaman Publik Verifikasi Sertifikat Resmi (Akses Terbuka & Aman Menggunakan Token Acak Unik)
     */
    public function verifikasiSertifikat($identifier)
    {
        // 1. Cari berdasarkan certificate_token (random unguessable slug, e.g. dc750jiihh)
        $session = \App\Models\ExamSession::with(['user', 'tryout'])
            ->where('certificate_token', $identifier)
            ->first();

        // 2. Jika tidak ditemukan, coba cari berdasarkan format nomor registrasi resmi (CASN-2026/SKD/00022)
        if (!$session && preg_match('/(\d+)$/', $identifier, $matches)) {
            $session = \App\Models\ExamSession::with(['user', 'tryout'])->find(intval($matches[1]));
        }

        // 3. Fallback jika numeric ID
        if (!$session && is_numeric($identifier)) {
            $session = \App\Models\ExamSession::with(['user', 'tryout'])->find($identifier);
        }

        if (!$session) {
            return view('user.ujian.verifikasi', [
                'isValid' => false,
                'message' => 'Sertifikat tidak ditemukan atau kode verifikasi tidak valid di database CalonASN.id.'
            ]);
        }

        $twk = $session->score_twk ?? 0;
        $tiu = $session->score_tiu ?? 0;
        $tkp = $session->score_tkp ?? 0;
        $isLulus = ($twk >= 65 && $tiu >= 80 && $tkp >= 166);

        $tahun = $session->end_time ? $session->end_time->format('Y') : ($session->created_at ? $session->created_at->format('Y') : date('Y'));
        $noSertifikat = 'CASN-' . $tahun . '/SKD/' . str_pad($session->id, 5, '0', STR_PAD_LEFT);

        return view('user.ujian.verifikasi', [
            'isValid' => true,
            'isLulus' => $isLulus,
            'session' => $session,
            'user' => $session->user,
            'tryout' => $session->tryout,
            'noSertifikat' => $noSertifikat,
            'token' => $session->certificate_token,
            'skor' => [
                'TWK' => $twk,
                'TIU' => $tiu,
                'TKP' => $tkp,
                'TOTAL' => $session->total_score ?? ($twk + $tiu + $tkp)
            ],
            'tanggal' => $session->end_time ? $session->end_time->format('d F Y') : date('d F Y')
        ]);
    }
}
