<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UjianController extends Controller
{
    public function mulai()
    {
        $questions = [];

        // 1. Generate 30 Soal TWK (Nomor 1 - 30)
        for ($i = 1; $i <= 30; $i++) {
            $questions[] = [
                'id' => $i,
                'kategori' => 'TWK',
                'pertanyaan' => 'Soal TWK Nomor ' . $i . '. Menurut UUD 1945 pasal sekian, apa yang dimaksud dengan...',
                'opsi' => ['Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D', 'Pilihan E']
            ];
        }

        // 2. Generate 35 Soal TIU (Nomor 31 - 65)
        for ($i = 31; $i <= 65; $i++) {
            $questions[] = [
                'id' => $i,
                'kategori' => 'TIU',
                'pertanyaan' => 'Soal TIU Nomor ' . $i . '. Jika X adalah 10 dan Y adalah 15, berapakah nilai...',
                'opsi' => ['Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D', 'Pilihan E']
            ];
        }

        // 3. Generate 45 Soal TKP (Nomor 66 - 110)
        for ($i = 66; $i <= 110; $i++) {
            $questions[] = [
                'id' => $i,
                'kategori' => 'TKP',
                'pertanyaan' => 'Soal TKP Nomor ' . $i . '. Saat Anda sedang sibuk bekerja, tiba-tiba atasan meminta...',
                'opsi' => ['Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D', 'Pilihan E']
            ];
        }

        // Waktu Ujian: 100 Menit
        $duration = 100;

        return view('user.ujian.ujian', compact('questions', 'duration'));
    }

    public function selesai(Request $request)
{
    $jawabanUser = $request->input('jawaban', []);
    session(['jawabanUser' => $jawabanUser]);

    // --- AWAL TRIK JALAN PINTAS UNTUK DEMO ---
    $skor = [
        'TWK' => 125, // Di atas minimal 65
        'TIU' => 150, // Di atas minimal 80
        'TKP' => 205, // Di atas minimal 166
    ];
    $skor['TOTAL'] = $skor['TWK'] + $skor['TIU'] + $skor['TKP'];
    $lulus = true; // Paksa sistem membaca statusnya lulus
    // --- AKHIR TRIK JALAN PINTAS ---

    /* >>> LOGIKA ASLINYA KITA KOMENTAR DULU <<<
    $skor = ['TWK' => 0, 'TIU' => 0, 'TKP' => 0, 'TOTAL' => 0];
    foreach($jawabanUser as $id => $jawaban) {
        if ($id <= 30) { $skor['TWK'] += 5; }
        elseif ($id <= 65) { $skor['TIU'] += 5; }
        else { $skor['TKP'] += rand(1, 5); }
    }
    $skor['TOTAL'] = $skor['TWK'] + $skor['TIU'] + $skor['TKP'];
    $lulus = ($skor['TWK'] >= 65 && $skor['TIU'] >= 80 && $skor['TKP'] >= 166);
    */

    // Simpan hasil ke session agar bisa dibaca di rute GET
    session(['hasilUjian' => compact('skor', 'lulus')]);

    // REDIRECT ke rute GET hasil
    return redirect()->route('ujian.hasil');
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
    public function hasil()
    {
        $hasil = session('hasilUjian');
        if (!$hasil) {
            return redirect()->route('ujian.mulai');
        }

        return view('user.ujian.ujian_hasil', [
            'skor' => $hasil['skor'],
            'lulus' => $hasil['lulus']
        ]);
    }

    public function pembahasan()
    {
        // Ambil jawaban user dari sesi sebelumnya
        $jawabanUser = session('jawabanUser', []);
        $questions = [];

        // Kita buat ulang data dummy-nya beserta kunci jawaban & teks pembahasan
        for ($i = 1; $i <= 110; $i++) {
            $kategori = $i <= 30 ? 'TWK' : ($i <= 65 ? 'TIU' : 'TKP');
            
            $questions[] = [
                'id' => $i,
                'kategori' => $kategori,
                'pertanyaan' => 'Soal ' . $kategori . ' Nomor ' . $i . '. Ini adalah contoh soal simulasi...',
                'opsi' => ['Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D', 'Pilihan E'],
                'kunci' => 'Pilihan A', // Anggap saja semua kunci dummy-nya A
                'pembahasan' => 'Jawaban yang tepat adalah Pilihan A. Karena berdasarkan teori dan rumus cepat, hal ini sesuai dengan aturan dasar pengerjaan soal ' . $kategori . '.'
            ];
        }

        return view('user.ujian.ujian_pembahasan', compact('questions', 'jawabanUser'));
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
        // Data Dummy Riwayat 10x Tryout
        $riwayat = [];
        for ($i = 1; $i <= 10; $i++) {
            $riwayat[] = [
                'id' => $i,
                'nama_tryout' => 'Tryout Akbar SKD Nasional #' . (11 - $i),
                'tanggal' => date('d M Y', strtotime("-" . ($i * 2) . " days")),
                'twk' => 125 - ($i * 2),
                'tiu' => 150 - ($i * 1),
                'tkp' => 205 - ($i * 3),
                'total' => 480 - ($i * 6),
                'status' => ($i <= 7) ? 'Lulus' : 'Tidak Lulus' // Anggap 7 kali lulus, 3 kali tidak
            ];
        }

        return view('user.sertifikat.sertifikat_riwayat', compact('riwayat'));
    }
}
