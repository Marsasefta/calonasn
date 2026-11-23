<!doctype html>
<html lang="id">

<head>
    @include('partials.head')
    <title>Hasil Evaluasi Demo CAT | CalonASN.id</title>
    <style>
        .blurred-content {
            filter: blur(4px);
            user-select: none;
            opacity: 0.55;
            pointer-events: none;
        }
        .lock-overlay-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }
        .lock-overlay-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            text-align: center;
            width: 90%;
        }
        .pricing-card-highlight {
            border: 2px solid #0d6efd !important;
            box-shadow: 0 0.5rem 1.5rem rgba(13, 110, 253, 0.15) !important;
            transform: translateY(-4px);
            transition: all 0.25s ease;
        }
        .voucher-badge {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: #000;
            font-weight: 700;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')

    <div class="db-content">
        <div class="container-fluid mb-5 px-3 px-md-4">

            <!-- Header Section -->
            <div class="row align-items-center mb-4 bg-white p-3 p-md-4 shadow-sm rounded-3 border">
                <div class="col-md-7 mb-3 mb-md-0">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-success-soft text-success px-2 py-1 rounded-pill fw-semibold">
                            <i class="bi bi-check-circle-fill me-1"></i> Simulasi Selesai
                        </span>
                        <span class="badge bg-light text-muted border px-2 py-1 rounded-pill">10 Soal Acak Kisi BKN</span>
                    </div>
                    <h3 class="mb-1 fw-bold text-dark">Hasil Evaluasi Simulasi Demo CAT</h3>
                    <p class="mb-0 text-muted small">
                        Ujicoba cepat untuk mengukur kesiapan awal kamu sebelum menghadapi ujian CAT SKD 110 Soal sesungguhnya.
                    </p>
                </div>
                <div class="col-md-5 text-md-end">
                    <div class="d-inline-block bg-primary-soft p-3 rounded-3 border border-primary border-opacity-25 text-center">
                        <span class="small text-muted d-block fw-medium">Total Skor Demo</span>
                        <h2 class="mb-0 fw-bolder text-primary display-6">{{ $score }} <span class="fs-6 fw-normal text-muted">/ 50 Poin</span></h2>
                    </div>
                </div>
            </div>

            <!-- Score Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-medium">Jawaban Benar</span>
                                <span class="badge bg-success-soft text-success"><i class="bi bi-check-lg"></i></span>
                            </div>
                            <h3 class="fw-bold text-success mb-1">{{ $correct }} <span class="fs-6 text-muted fw-normal">Soal</span></h3>
                            <span class="small text-muted">Akurasi {{ round(($correct / max(1, $totalSoal)) * 100) }}%</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-medium">Salah / Kosong</span>
                                <span class="badge bg-danger-soft text-danger"><i class="bi bi-x-lg"></i></span>
                            </div>
                            <h3 class="fw-bold text-danger mb-1">{{ $totalSoal - $correct }} <span class="fs-6 text-muted fw-normal">Soal</span></h3>
                            <span class="small text-muted">Perlu perbaikan konsep</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-medium">Pecahan Sub-Tes</span>
                                <span class="badge bg-primary-soft text-primary"><i class="bi bi-pie-chart-fill"></i></span>
                            </div>
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">TWK:</span>
                                <strong class="text-dark">{{ $twkCorrect ?? 0 }}/{{ $twkTotal ?? 3 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">TIU:</span>
                                <strong class="text-dark">{{ $tiuCorrect ?? 0 }}/{{ $tiuTotal ?? 3 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span class="text-muted">TKP:</span>
                                <strong class="text-dark">{{ $tkpCorrect ?? 0 }}/{{ $tkpTotal ?? 4 }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-3 h-100 bg-gradient text-white" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                            <div>
                                <span class="badge bg-warning text-dark px-2 py-1 rounded-pill small mb-2 fw-bold">
                                    <i class="bi bi-lightning-charge-fill"></i> SKD CAT Penuh
                                </span>
                                <h6 class="text-white mb-1 fw-bold">110 Soal Berstandar BKN</h6>
                                <p class="small text-white-50 mb-0">Simulasi asli berdurasi 100 menit dengan Passing Grade BKN.</p>
                            </div>
                            <a href="#pilihan-paket" class="btn btn-warning btn-sm fw-bold mt-2 rounded-pill">
                                Buka Paket Full <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promo Voucher Callout Banner -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 text-white overflow-hidden"
                 style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 50%, #4338ca 100%);">
                <div class="card-body p-4 p-md-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8 mb-3 mb-lg-0">
                            <span class="badge bg-white text-primary px-3 py-1 rounded-pill fw-bold text-uppercase mb-2 shadow-sm">
                                <i class="bi bi-ticket-perforated-fill text-warning me-1"></i> Voucher Diskon Spesial Demo
                            </span>
                            <h4 class="fw-bold mb-1 text-white">Selamat! Kamu Mendapatkan Potongan Rp 7.000</h4>
                            <p class="mb-0 text-white-50 small">
                                Gunakan kode kupon di bawah saat checkout untuk langsung memotong harga paket latihan CalonASN.id.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <div class="d-inline-flex align-items-center bg-white bg-opacity-15 p-2 rounded-pill border border-white border-opacity-25 shadow-sm">
                                <span class="voucher-badge px-3 py-1 rounded-pill me-2 fs-6" id="voucherCode">ASN2026</span>
                                <button type="button" class="btn btn-light btn-sm rounded-pill fw-bold px-3" onclick="copyVoucherCode()">
                                    <i class="bi bi-clipboard me-1" id="copyIcon"></i> <span id="copyText">Salin</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Evaluasi Butir Soal & Teaser Pembahasan (FOMO Builder) -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-list-check text-primary me-2"></i> Lembar Review 10 Soal Demo
                        </h5>
                        <small class="text-muted">Cek jawaban yang kamu pilih dan lihat evaluasi kebenarannya.</small>
                    </div>
                    <span class="badge bg-warning-soft text-warning fw-bold px-3 py-2 rounded-pill border border-warning border-opacity-25">
                        <i class="bi bi-lock-fill me-1"></i> Kunci & Pembahasan Terkunci
                    </span>
                </div>
                <div class="card-body p-3 p-md-4">

                    <div class="row g-3">
                        @foreach ($detailHasil as $item)
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100 bg-light bg-opacity-50">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-dark rounded-pill px-2 py-1">No. {{ $item['no'] }}</span>
                                            <span class="badge @if($item['kategori'] == 'TWK') bg-info-soft text-info @elseif($item['kategori'] == 'TIU') bg-primary-soft text-primary @else bg-success-soft text-success @endif fw-bold">
                                                {{ $item['kategori'] }}
                                            </span>
                                        </div>
                                        <div>
                                            @if ($item['status'])
                                                <span class="badge bg-success text-white px-2 py-1 rounded-pill">
                                                    <i class="bi bi-check-circle-fill me-1"></i> Benar (+5)
                                                </span>
                                            @else
                                                <span class="badge bg-danger text-white px-2 py-1 rounded-pill">
                                                    <i class="bi bi-x-circle-fill me-1"></i> Salah / Kosong
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <p class="text-dark small mb-2 fw-medium text-truncate-2" style="min-height: 40px;">
                                        {{ $item['pertanyaan'] }}...
                                    </p>

                                    <div class="bg-white p-2 rounded border small mb-2">
                                        <span class="text-muted">Pilihan Kamu:</span>
                                        <strong class="text-dark ms-1">
                                            {{ $item['user'] ? \Illuminate\Support\Str::limit($item['user'], 45) : '(Tidak Dijawab)' }}
                                        </strong>
                                    </div>

                                    <!-- Locked Discussion Teaser -->
                                    <div class="lock-overlay-wrapper bg-white border p-3">
                                        <div class="blurred-content small text-muted">
                                            <strong>Kunci Jawaban: [X]</strong><br>
                                            <strong>Pembahasan:</strong> Berdasarkan PermenPAN-RB No. 321 Tahun 2024 dan kisi-kisi resmi BKN, rumus cepat penyelesaian soal tipe ini menggunakan eliminasi pola logika beruntun...
                                        </div>
                                        <div class="lock-overlay-center">
                                            <span class="badge bg-dark bg-opacity-90 text-white px-3 py-1 rounded-pill shadow-sm small">
                                                <i class="bi bi-lock-fill text-warning me-1"></i> Kunci & Trik Lengkap Terkunci
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="alert alert-warning border-0 rounded-3 mt-4 mb-0 d-flex align-items-center gap-3">
                        <div class="fs-2 text-warning"><i class="bi bi-info-circle-fill"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">Mau Tahu Kenapa Jawaban Kamu Salah & Bagaimana Trik Cepat Menjawabnya?</h6>
                            <p class="small mb-0 text-muted">
                                Kunci jawaban resmi, formula cepat TIU, pembahasan kontekstual TWK & TKP, serta 110 butir soal simulasi CAT SKD lengkap tersedia eksklusif di paket premium CalonASN.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Package Selection Section -->
            <div id="pilihan-paket" class="mb-5 pt-3">
                <div class="text-center mb-4">
                    <span class="badge bg-primary-soft text-primary px-3 py-2 fw-bold text-uppercase rounded-pill mb-2 shadow-sm">
                        <i class="bi bi-gem text-warning me-1"></i> Investasi Kelulusan ASN
                    </span>
                    <h2 class="fw-bold text-dark mb-1">Buka Akses Penuh Sekarang</h2>
                    <p class="text-muted">Pilih paket yang paling pas untuk memaksimalkan peluang lolos SKD CPNS 2026 kamu.</p>
                </div>

                <div class="row g-4 justify-content-center align-items-stretch">

                    <!-- Paket 2: Super Lengkap (RECOMMENDED) -->
                    <div class="col-lg-6 d-flex">
                        <div class="card w-100 rounded-4 p-4 p-md-5 d-flex flex-column bg-white position-relative pricing-card-highlight">

                            <div class="position-absolute top-0 end-0 bg-primary text-white px-4 py-2 small fw-bold shadow-sm"
                                style="border-bottom-left-radius: 16px; border-top-right-radius: 14px;">
                                ⭐ PALING BANYAK DIPILIH
                            </div>

                            <div class="mb-4 mt-2">
                                <span class="badge bg-primary-soft text-primary px-3 py-1 rounded-pill mb-2 fw-bold">
                                    Paket Super Lengkap (Tryout + Materi)
                                </span>
                                <h3 class="fw-bold text-dark mb-1">Tryout CAT + Ratusan Materi Belajar</h3>
                                <p class="text-muted small">Solusi komprehensif: Paham konsep materinya, taklukkan ribuan variasi simulasinya.</p>

                                <div class="mt-3 p-3 bg-primary-soft rounded-3 border border-primary border-opacity-25">
                                    <div class="d-flex align-items-baseline gap-2">
                                        <span class="text-decoration-line-through text-muted small">Rp 49.000</span>
                                        <h3 class="fw-bolder text-primary mb-0">Rp 42.000</h3>
                                        <span class="badge bg-danger text-white rounded-pill small">Hemat Rp 7.000</span>
                                    </div>
                                    <div class="mt-2 pt-2 border-top border-primary border-opacity-25 small text-primary fw-medium">
                                        <i class="bi bi-tag-fill me-1 text-warning"></i> Gunakan kupon <strong class="text-dark bg-white px-2 py-0.5 rounded border">ASN2026</strong> di checkout
                                    </div>
                                </div>
                            </div>

                            <ul class="list-unstyled d-flex flex-column gap-3 text-dark fw-medium mb-4">
                                <li class="d-flex align-items-start small p-2 bg-primary-soft rounded-3">
                                    <i class="bi bi-infinity text-primary me-2 mt-1 fs-5"></i>
                                    <span class="text-primary"><strong>Akses Tryout Unlimited (Tanpa Batas):</strong> Ulangi simulasi tryout berkali-kali sepuasnya tanpa biaya tambahan</span>
                                </li>
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                    <span><strong>110 Soal CAT Lengkap SKD</strong> (TWK, TIU, TKP) berstandar kisi-kisi resmi BKN 2024/2026</span>
                                </li>
                                <li class="d-flex align-items-start small p-2 bg-primary-soft rounded-3">
                                    <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                    <span class="text-primary"><strong>Akses Ratusan Modul Micro-Learning:</strong> Rangkuman materi padat TWK, TIU, TKP + Pelacak Progres</span>
                                </li>
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                    <span><strong>Sistem Perankingan Nasional Real-Time:</strong> Ukur posisi kelulusanmu terhadap ribuan peserta se-Indonesia</span>
                                </li>
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                    <span><strong>Fitur Cetak / Simpan PDF Pembahasan:</strong> Arsipkan pembahasan untuk dibaca offline</span>
                                </li>
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                    <span>Akses Selamanya (Sekali Bayar, Tanpa Biaya Berlangganan)</span>
                                </li>
                            </ul>

                            <div class="mt-auto">
                                @if ($isLengkap)
                                    <a href="{{ route('ujian.persiapan', 1) }}" class="btn btn-success rounded-pill py-3 fw-bold w-100 shadow-sm">
                                        <i class="bi bi-shield-check me-1"></i> Akses Sudah Aktif - Masuk Ujian CAT
                                    </a>
                                @elseif($hasPaket1)
                                    <a href="{{ route('checkout', 3) }}" class="btn btn-warning text-dark rounded-pill py-3 fw-bold w-100 shadow-sm hover-lift">
                                        <i class="bi bi-arrow-up-circle-fill me-1"></i> Upgrade ke Paket Lengkap (Cuma Rp 29.000)
                                    </a>
                                @else
                                    <a href="{{ route('checkout', 2) }}" class="btn btn-primary rounded-pill py-3 fw-bold w-100 shadow-sm hover-lift fs-6">
                                        Ambil Paket Super Lengkap Sekarang <i class="bi bi-arrow-right ms-2"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Paket 1: Tryout Mandiri -->
                    <div class="col-lg-6 d-flex">
                        <div class="card w-100 border border-2 border-light shadow-sm rounded-4 p-4 p-md-5 d-flex flex-column bg-white">
                            <div class="mb-4">
                                <span class="badge bg-secondary px-3 py-1 rounded-pill mb-2 fw-semibold">
                                    Paket Simulasi Mandiri
                                </span>
                                <h3 class="fw-bold text-dark mb-1">Tryout Mandiri (Simulasi CAT SKD)</h3>
                                <p class="text-muted small">Fokus uji ketahanan, kecepatan, dan manajemen waktu 100 menit.</p>

                                <div class="mt-3 p-3 bg-light rounded-3 border">
                                    <div class="d-flex align-items-baseline gap-2">
                                        <span class="text-decoration-line-through text-muted small">Rp 20.000</span>
                                        <h3 class="fw-bolder text-dark mb-0">Rp 13.000</h3>
                                        <span class="badge bg-danger text-white rounded-pill small">Hemat Rp 7.000</span>
                                    </div>
                                    <div class="mt-2 pt-2 border-top border-secondary border-opacity-25 small text-muted">
                                        <i class="bi bi-tag-fill me-1 text-success"></i> Gunakan kupon <strong class="text-dark bg-white px-2 py-0.5 rounded border">ASN2026</strong> di checkout
                                    </div>
                                </div>
                            </div>

                            <ul class="list-unstyled d-flex flex-column gap-3 text-dark fw-medium mb-4">
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                    <span><strong>110 Soal CAT Lengkap SKD</strong> (TWK, TIU, TKP) berstandar BKN</span>
                                </li>
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                    <span><strong>Kunci Jawaban Resmi & Pembahasan Rinci</strong> per butir soal</span>
                                </li>
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                    <span><strong>Sistem Perankingan Nasional Real-Time</strong></span>
                                </li>
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                    <span><strong>Fitur Cetak / Simpan PDF Pembahasan</strong></span>
                                </li>
                                <li class="d-flex align-items-start small text-muted">
                                    <i class="bi bi-x-circle-fill text-danger opacity-50 me-2 mt-1"></i>
                                    <span class="text-decoration-line-through">Akses Ratusan Modul Micro-Learning Belajar</span>
                                </li>
                                <li class="d-flex align-items-start small text-muted">
                                    <i class="bi bi-x-circle-fill text-danger opacity-50 me-2 mt-1"></i>
                                    <span class="text-decoration-line-through">Trik Sakti & Catatan Konsep Cepat Jawab</span>
                                </li>
                            </ul>

                            <div class="mt-auto">
                                @if ($isLengkap || $hasPaket1)
                                    <button class="btn btn-light rounded-pill py-3 fw-bold w-100 border text-muted" disabled>
                                        <i class="bi bi-check-all me-1"></i> Sudah Kamu Miliki
                                    </button>
                                @else
                                    <a href="{{ route('checkout', 1) }}" class="btn btn-outline-dark rounded-pill py-3 fw-bold w-100 hover-lift fs-6">
                                        Pilih Tryout Mandiri <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Secondary Action Links -->
                <div class="text-center mt-4 pt-2">
                    <div class="d-flex flex-wrap justify-content-center gap-3 align-items-center">
                        <a href="{{ route('user.pilih-paket') }}" class="btn btn-link text-primary fw-semibold small text-decoration-none">
                            <i class="bi bi-columns-gap me-1"></i> Lihat Tabel Perbandingan Detail Paket
                        </a>
                        <span class="text-muted d-none d-sm-inline">•</span>
                        <a href="{{ route('demo.ujian') }}" class="btn btn-link text-muted small text-decoration-none">
                            <i class="bi bi-arrow-repeat me-1"></i> Ulangi Simulasi Demo
                        </a>
                        <span class="text-muted d-none d-sm-inline">•</span>
                        <a href="{{ route('dashboard') }}" class="btn btn-link text-muted small text-decoration-none">
                            <i class="bi bi-speedometer2 me-1"></i> Ke Dashboard Peserta
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Scroll top -->
    @include('partials.btn-scroll-top')
    <!-- Scripts -->
    @include('partials.scripts')

    <script>
        function copyVoucherCode() {
            const code = document.getElementById('voucherCode').innerText;
            navigator.clipboard.writeText(code).then(() => {
                const copyText = document.getElementById('copyText');
                const copyIcon = document.getElementById('copyIcon');
                copyText.innerText = 'Tersalin!';
                copyIcon.className = 'bi bi-check2 text-success me-1';
                setTimeout(() => {
                    copyText.innerText = 'Salin';
                    copyIcon.className = 'bi bi-clipboard me-1';
                }, 2500);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>
</body>

</html>
