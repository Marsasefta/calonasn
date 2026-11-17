<?php

namespace App\Services;

use App\Models\Post;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BlogAutomationService
{
    /**
     * Pastikan kategori-kategori standar blog CPNS tersedia di database.
     */
    public function ensureCategoriesExist(): void
    {
        $defaultCategories = [
            'Info CPNS' => 'info-cpns',
            'Tips & Trik TIU' => 'tips-trik-tiu',
            'Kisi-Kisi TWK' => 'kisi-kisi-twk',
            'Strategi TKP' => 'strategi-tkp',
            'Simulasi & Soal SKD' => 'simulasi-soal-skd',
        ];

        foreach ($defaultCategories as $name => $slug) {
            BlogCategory::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }
    }

    /**
     * Dapatkan daftar antrian topik harian SEO CPNS 2026.
     */
    public function getTopicQueue(): array
    {
        return [
            [
                'title' => 'Passing Grade & Kisi-Kisi SKD CPNS 2026 Terbaru: Strategi Tembus Nilai Maksimal',
                'category_slug' => 'info-cpns',
                'category_name' => 'Info CPNS',
                'subtitle' => 'Bedah Lengkap TWK, TIU, TKP Berdasarkan Standar PermenPAN-RB Terbaru',
                'keyword' => 'passing grade skd cpns 2026 kisi-kisi bkn',
            ],
            [
                'title' => '7 Trik Kilat Menjawab Soal Deret Angka TIU CPNS Tanpa Pusing Rumus Rumit',
                'category_slug' => 'tips-trik-tiu',
                'category_name' => 'Tips & Trik TIU',
                'subtitle' => 'Kuasai Pola Aritmatika, Geometri, dan Deret Bertingkat Hanya dalam 30 Detik',
                'keyword' => 'trik cepat deret angka tiu cpns 2026',
            ],
            [
                'title' => 'Kumpulan Soal HOTS TWK Bela Negara & Nasionalisme Standar Kisi-Kisi BKN 2026',
                'category_slug' => 'kisi-kisi-twk',
                'category_name' => 'Kisi-Kisi TWK',
                'subtitle' => 'Pahami Konsep Implementasi Sila Pancasila dan Integritas ASN Tanpa Menghafal Butir',
                'keyword' => 'soal hots twk cpns bela negara nasionalisme',
            ],
            [
                'title' => 'Kunci Sukses TKP CPNS: Cara Memilih Opsi Jawaban Berbobot Nilai 5 di Setiap Soal',
                'category_slug' => 'strategi-tkp',
                'category_name' => 'Strategi TKP',
                'subtitle' => 'Metode Eliminasi Opsi Menjebak & Trik Mengidentifikasi Karakteristik ASN Ideal',
                'keyword' => 'cara dapat nilai 5 tkp cpns bkn 2026',
            ],
            [
                'title' => 'Manajemen Waktu 100 Menit Mengerjakan 110 Soal CAT BKN: Taktik Lolos Perankingan',
                'category_slug' => 'simulasi-soal-skd',
                'category_name' => 'Simulasi & Soal SKD',
                'subtitle' => 'Urutan Terbaik Mengerjakan TWK, TIU, TKP Agar Tidak Kehabisan Waktu di Akhir Ujian',
                'keyword' => 'manajemen waktu cat cpns 100 menit 110 soal',
            ],
            [
                'title' => 'Perbedaan Alur Seleksi CPNS dan PPPK 2026: Syarat, Hak Gaji, dan Tahapan Ujian',
                'category_slug' => 'info-cpns',
                'category_name' => 'Info CPNS',
                'subtitle' => 'Panduan Menentukan Pilihan Formasi Sesuai Kualifikasi Pendidikan dan Usia Pelamar',
                'keyword' => 'perbedaan cpns dan pppk 2026 syarat gaji tahapan',
            ],
            [
                'title' => 'Trik Cepat Menaklukkan Soal Silogisme dan Logika Posisi TIU CPNS 2026',
                'category_slug' => 'tips-trik-tiu',
                'category_name' => 'Tips & Trik TIU',
                'subtitle' => 'Rumus Semua-Sebagian, Negasi Logika, dan Diagram Venn untuk Jawaban Pasti Benar',
                'keyword' => 'trik silogisme logika posisi tiu cpns',
            ],
            [
                'title' => 'Bedah Materi Pilar Negara TWK: Pancasila, UUD 1945, NKRI, dan Bhinneka Tunggal Ika',
                'category_slug' => 'kisi-kisi-twk',
                'category_name' => 'Kisi-Kisi TWK',
                'subtitle' => 'Kupas Tuntas Kasus Nyata Sejarah Bangsa dan Kebijakan Publik Berstandar Soal BKN',
                'keyword' => 'materi pilar negara twk uudd 1945 pancasila',
            ],
        ];
    }

    /**
     * Pilih topik berikutnya yang belum pernah diterbitkan.
     */
    public function getNextTopic(): array
    {
        $queue = $this->getTopicQueue();

        foreach ($queue as $topic) {
            $slug = Str::slug($topic['title']);
            if (!Post::where('slug', $slug)->exists()) {
                return $topic;
            }
        }

        // Jika semua topik standar sudah terbit, buat topik variasi dinamis
        $dayOfWeek = date('l');
        $randomHash = substr(md5(uniqid()), 0, 4);
        return [
            'title' => "Latihan Soal & Pembahasan SKD CPNS 2026 Edisi {$dayOfWeek} (#{$randomHash})",
            'category_slug' => 'simulasi-soal-skd',
            'category_name' => 'Simulasi & Soal SKD',
            'subtitle' => 'Latih Kecepatan Analisis Soal TWK, TIU, dan TKP Bersama Bank Soal CalonASN.id',
            'keyword' => "latihan soal skd cpns 2026 {$dayOfWeek}",
        ];
    }

    /**
     * Generate isi artikel lengkap (via Gemini API atau Template Berbobot).
     */
    public function generateArticleContent(array $topic): array
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!empty($apiKey)) {
            try {
                return $this->generateWithGemini($topic, $apiKey);
            } catch (\Throwable $e) {
                Log::warning("Gemini API call failed, falling back to local substantive template: " . $e->getMessage());
            }
        }

        return $this->generateLocalSubstantiveArticle($topic);
    }

    /**
     * Panggilan langsung ke Gemini API jika GEMINI_API_KEY ada di .env.
     */
    protected function generateWithGemini(array $topic, string $apiKey): array
    {
        $prompt = <<<PROMPT
Anda adalah Pakar Senior Tutor Seleksi CPNS dan Penulis SEO Edukasi di CalonASN.id.
Tulis artikel blog yang sangat mendalam, akurat, informatif, dan praktis dengan judul:
"{$topic['title']}"

Kategori: {$topic['category_name']}
Target Keyword: {$topic['keyword']}

Ketentuan Wajib:
1. Format output HANYA JSON valid tanpa markdown backticks (tanpa ```json ... ```):
{
  "title": "{$topic['title']}",
  "excerpt": "Ringkasan menarik 1-2 kalimat (maksimal 160 karakter) untuk meta description Google.",
  "content": "Isi artikel lengkap format HTML rapi minimal 1000 kata..."
}
2. Struktur konten dalam format HTML:
   - Gunakan sub-judul <h2> dan <h3> secara terstruktur agar otomatis terbaca oleh Table of Contents.
   - Paragraf jelas (<p>), daftar poin (<ul>/<li>), dan tabel perbandingan jika relevan.
   - Sertakan tips praktis dan trik cepat ala ujian CAT BKN.
   - Jangan sertakan tag <h1> karena judul artikel sudah ditampilkan di halaman.
3. Gaya bahasa ramah, memotivasi, profesional, dan mudah dipahami pejuang CPNS 2026.
PROMPT;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(60)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
            ]
        ]);

        if ($response->successful()) {
            $rawText = $response->json('candidates.0.content.parts.0.text');
            $cleanJson = trim(preg_replace('/^```json|```$/m', '', $rawText));
            $data = json_decode($cleanJson, true);

            if (isset($data['title'], $data['content'])) {
                // Tambahkan CTA Banner ke produk CalonASN
                $data['content'] .= $this->buildCtaBanner();
                return $data;
            }
        }

        throw new \Exception("Invalid response from Gemini API: " . $response->body());
    }

    /**
     * Template artikel substansial lokal berkualitas tinggi (Fallback / Trial).
     */
    protected function generateLocalSubstantiveArticle(array $topic): array
    {
        $title = $topic['title'];
        $excerpt = "Pelajari strategi lolos seleksi SKD CPNS 2026, analisis passing grade terbaru BKN, dan trik jitu menaklukkan soal TWK, TIU, TKP bersama CalonASN.id.";

        $content = <<<HTML
<p class="lead">
    Menghadapi seleksi Seleksi Kompetensi Dasar (SKD) Calon Pegawai Negeri Sipil (CPNS) 2026 memerlukan persiapan yang matang dan terencana. Berdasarkan evaluasi pelaksanaan tahun-tahun sebelumnya serta kisi-kisi resmi Badan Kepegawaian Negara (BKN) dan PermenPAN-RB, persaingan formasi ASN semakin ketat dengan nilai ambang batas (<em>passing grade</em>) yang menuntut penguasaan konsep mendalam.
</p>

<h2>1. Memahami Peta Persaingan & Ambang Batas (Passing Grade) SKD 2026</h2>
<p>
    Dalam ujian CAT SKD, peserta akan berhadapan dengan 110 butir soal dalam waktu 100 menit. Artinya, Anda hanya memiliki rata-rata waktu kurang dari 54 detik per butir soal. Ujian ini terbagi menjadi tiga sub-tes dengan bobot dan karakteristik berbeda:
</p>
<ul>
    <li><strong>Tes Wawasan Kebangsaan (TWK) - 30 Soal:</strong> Nilai ambang batas 65. Bobot jawaban benar bernilai 5, salah bernilai 0. Fokus utama terletak pada implementasi nilai Pancasila, UUD 1945, NKRI, dan integritas bela negara.</li>
    <li><strong>Tes Inteligensi Umum (TIU) - 35 Soal:</strong> Nilai ambang batas 80. Bobot jawaban benar bernilai 5, salah bernilai 0. Menguji kemampuan verbal, numerik (deret, pecahan, perbandingan), serta penalaran logis analitis.</li>
    <li><strong>Tes Karakteristik Pribadi (TKP) - 45 Soal:</strong> Nilai ambang batas 166. Tidak ada nilai 0 (skala 1 sampai 5). Menguji pelayanan publik, jejaring kerja, profesionalisme, sosial budaya, TIK, serta integritas anti-radikalisme.</li>
</ul>

<h2>2. Strategi Efektif Taklukkan Setiap Sub-Tes</h2>
<h3>A. Tes Wawasan Kebangsaan (TWK): Fokus Penalaran HOTS</h3>
<p>
    Tren soal TWK saat ini telah bergeser dari sekadar hafalan tanggal sejarah menjadi analisis studi kasus (<em>Higher Order Thinking Skills</em>). Peserta dihadapkan pada dilema kebijakan publik atau dinamika kebangsaan dan diminta menentukan tindakan yang paling mencerminkan pengamalan sila Pancasila atau undang-undang.
</p>

<h3>B. Tes Inteligensi Umum (TIU): Kuasai Pola Cepat</h3>
<p>
    Kunci utama TIU adalah mengenali pola. Pada soal deret angka, hindari langsung menghitung rumus rumit. Cobalah melihat lompatan pola selang satu atau kombinasi dua operasi matematika. Pada soal silogisme, gunakan hukum diagram Venn dan kaidah penarikan kesimpulan modus ponens/tollens.
</p>

<h3>C. Tes Karakteristik Pribadi (TKP): Pola Pikir ASN Berintegritas</h3>
<p>
    TKP memiliki bobot soal terbanyak (45 butir) dengan total poin maksimal 225. Untuk meraih poin sempurna (skala 5), pilihlah opsi yang menunjukkan inisiatif tinggi, orientasi pada pelayanan masyarakat, kolaboratif dalam tim, serta kepatuhan teguh pada kode etik birokrasi tanpa kompromi.
</p>

<h2>3. Manajemen Waktu 100 Menit di Ruang CAT</h2>
<p>
    Banyak peserta berprestasi gagal bukan karena tidak tahu jawabannya, melainkan karena kehabisan waktu. Terapkan urutan pengerjaan taktis berikut:
</p>
<ol>
    <li><strong>Menit 0 - 30:</strong> Kerjakan seluruh soal TKP terlebih dahulu. Karena semua jawaban memiliki poin (1-5), pastikan jangan ada nomor yang kosong.</li>
    <li><strong>Menit 30 - 60:</strong> Lanjutkan ke TWK. Bacalah soal kasus secara teliti pada kalimat pertanyaannya terlebih dahulu sebelum membaca narasi panjang.</li>
    <li><strong>Menit 60 - 95:</strong> Kerjakan TIU yang membutuhkan perhitungan matematis dan logika. Lewati nomor yang macet lebih dari 1 menit dan beri tanda ragu-ragu.</li>
    <li><strong>Menit 95 - 100:</strong> Tinjau ulang nomor-nomor yang masih ragu-ragu dan pastikan lembar jawaban terkirim sempurna.</li>
</ol>
HTML;

        $content .= $this->buildCtaBanner();

        return [
            'title' => $title,
            'excerpt' => $excerpt,
            'content' => $content,
        ];
    }

    /**
     * Buat Call-To-Action (CTA) Banner yang memikat pembaca mencoba Demo / Tryout.
     */
    public function buildCtaBanner(): string
    {
        $demoUrl = route('demo.index');
        $packageUrl = route('user.pilih-paket');

        return <<<HTML
<div class="my-5 p-4 p-md-5 rounded-4 shadow-sm border text-white" 
     style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 50%, #4338ca 100%);">
    <div class="row align-items-center">
        <div class="col-lg-8 mb-3 mb-lg-0">
            <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold small mb-2 shadow-sm">
                ⭐ SIMULASI CAT SKD CPNS 2026
            </span>
            <h3 class="fw-bold mb-2 text-white">Uji Kemampuanmu Sekarang dengan Sistem CAT Standar BKN!</h3>
            <p class="mb-0 text-white-50 small">
                Coba latihan 10 soal singkat secara <strong>GRATIS</strong> atau buka akses ke 110 Soal Lengkap + Ratusan Materi Micro-Learning di CalonASN.id. Gunakan kode promo <strong>ASN2026</strong> untuk hemat Rp 7.000!
            </p>
        </div>
        <div class="col-lg-4 text-lg-end d-flex flex-column gap-2">
            <a href="{$demoUrl}" class="btn btn-warning text-dark fw-bold rounded-pill px-4 py-2.5 shadow-sm">
                Coba Demo Gratis <i class="fas fa-play ms-1"></i>
            </a>
            <a href="{$packageUrl}" class="btn btn-outline-light fw-bold rounded-pill px-4 py-2">
                Lihat Paket Tryout <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>
HTML;
    }

    /**
     * Generate Cover Banner 1200x630 pixel profesional menggunakan PHP GD.
     */
    public function generateCoverImage(string $title, string $categoryName, string $slug): string
    {
        $width = 1200;
        $height = 630;

        $image = imagecreatetruecolor($width, $height);
        imagesavealpha($image, true);

        // Background Gradient: Navy (#0f172a) to Royal Deep Blue (#1e3a8a)
        $bgStart = [15, 23, 42];
        $bgEnd   = [30, 58, 138];

        for ($y = 0; $y < $height; $y++) {
            $r = (int) ($bgStart[0] + ($bgEnd[0] - $bgStart[0]) * ($y / $height));
            $g = (int) ($bgStart[1] + ($bgEnd[1] - $bgStart[1]) * ($y / $height));
            $b = (int) ($bgStart[2] + ($bgEnd[2] - $bgStart[2]) * ($y / $height));
            $color = imagecolorallocate($image, $r, $g, $b);
            imageline($image, 0, $y, $width, $y, $color);
        }

        // Geometric Glow / Accents
        $accentCircle = imagecolorallocatealpha($image, 59, 130, 246, 110);
        imagefilledellipse($image, 1050, 150, 420, 420, $accentCircle);
        $accentCircle2 = imagecolorallocatealpha($image, 245, 158, 11, 118);
        imagefilledellipse($image, 1120, 480, 320, 320, $accentCircle2);

        // Fonts
        $fontBold = base_path('resources/fonts/bold.ttf');
        $fontRegular = base_path('resources/fonts/regular.ttf');

        // Fallback jika font lokal belum tersedia
        if (!file_exists($fontBold)) {
            $fontBold = 'C:/Windows/Fonts/arialbd.ttf';
            $fontRegular = 'C:/Windows/Fonts/arial.ttf';
        }

        $white = imagecolorallocate($image, 255, 255, 255);
        $gold = imagecolorallocate($image, 251, 191, 36);
        $cyan = imagecolorallocate($image, 56, 189, 248);
        $slateLight = imagecolorallocate($image, 148, 163, 184);

        // Top Brand Logo + Nama
        $logoPath = public_path('image/logoasn-96.png');
        if (file_exists($logoPath)) {
            $logo = @imagecreatefrompng($logoPath);
            if ($logo) {
                imagecopyresampled($image, $logo, 70, 60, 0, 0, 52, 52, imagesx($logo), imagesy($logo));
                imagedestroy($logo);
            }
        }
        imagettftext($image, 22, 0, 135, 96, $white, $fontBold, 'CalonASN.id');

        // Top Right Category Pill Badge
        $catLabel = strtoupper($categoryName) . ' • 2026';
        $catBg = imagecolorallocatealpha($image, 255, 255, 255, 105);
        imagefilledrectangle($image, 780, 60, 1130, 105, $catBg);
        imagettftext($image, 13, 0, 805, 90, $gold, $fontBold, $catLabel);

        // Accent gold line
        $accentLine = imagecolorallocate($image, 245, 158, 11);
        imagefilledrectangle($image, 70, 160, 170, 166, $accentLine);

        // Word-wrap Headline Title
        $words = explode(' ', $title);
        $lines = [];
        $currentLine = '';

        foreach ($words as $word) {
            $testLine = $currentLine . ($currentLine === '' ? '' : ' ') . $word;
            $box = imagettfbbox(31, 0, $fontBold, $testLine);
            $textWidth = abs($box[4] - $box[0]);
            if ($textWidth > 1000 && $currentLine !== '') {
                $lines[] = $currentLine;
                $currentLine = $word;
            } else {
                $currentLine = $testLine;
            }
        }
        if ($currentLine !== '') {
            $lines[] = $currentLine;
        }

        $titleY = 245;
        foreach ($lines as $i => $line) {
            imagettftext($image, 31, 0, 70, $titleY + ($i * 62), $white, $fontBold, $line);
        }

        // Subtitle Info
        $subY = $titleY + (count($lines) * 62) + 36;
        $featureText = "Berdasarkan Standar Kisi-Kisi BKN & Modul Evaluasi Micro-Learning";
        imagettftext($image, 16, 0, 70, $subY, $cyan, $fontRegular, $featureText);

        // Bottom Footer Bar
        imagefilledrectangle($image, 70, 530, 1130, 532, $catBg);
        imagettftext($image, 14, 0, 70, 570, $slateLight, $fontRegular, "Simulasi Ujian CAT BKN & Bank Soal Terupdate • calonasn.id");

        $badgeBg = imagecolorallocate($image, 14, 165, 233);
        imagefilledrectangle($image, 940, 545, 1130, 585, $badgeBg);
        imagettftext($image, 13, 0, 960, 571, $white, $fontBold, "TRYOUT ONLINE");

        // Save Image to storage/app/public/blog-images/ & public/storage/blog-images/
        $directory = storage_path('app/public/blog-images');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = $slug . '-' . time() . '.jpg';
        $fullPath = $directory . '/' . $filename;
        imagejpeg($image, $fullPath, 92);
        imagedestroy($image);

        // Salin ke public/storage/blog-images untuk kompatibilitas penuh (misal symlink cPanel)
        $publicDir = public_path('storage/blog-images');
        if (!file_exists($publicDir)) {
            @mkdir($publicDir, 0755, true);
        }
        if (!file_exists($publicDir . '/' . $filename) && file_exists($fullPath)) {
            @copy($fullPath, $publicDir . '/' . $filename);
        }

        // Return URL format
        return '/storage/blog-images/' . $filename;
    }

    /**
     * Jalankan proses pembuatan artikel baru secara penuh (Publishing Pipeline).
     */
    public function generateDailyPost(): Post
    {
        // 1. Pastikan kategori ada
        $this->ensureCategoriesExist();

        // 2. Pilih topik yang belum terbit
        $topic = $this->getNextTopic();
        $slug = Str::slug($topic['title']);

        // 3. Generate konten artikel
        $articleData = $this->generateArticleContent($topic);

        // 4. Cari kategori
        $category = BlogCategory::where('slug', $topic['category_slug'])->first()
            ?? BlogCategory::firstOrCreate(['slug' => 'info-cpns'], ['name' => 'Info CPNS']);

        // 5. Cari author admin
        $admin = User::where('role', 'admin')->first()
            ?? User::first();

        // 6. Generate cover image otomatis
        $imageUrl = $this->generateCoverImage($articleData['title'], $category->name, $slug);

        // 7. Simpan Post ke Database
        $post = Post::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $articleData['title'],
                'blog_category_id' => $category->id,
                'user_id' => $admin ? $admin->id : 1,
                'excerpt' => $articleData['excerpt'],
                'content' => $articleData['content'],
                'image_url' => $imageUrl,
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        return $post;
    }
}
