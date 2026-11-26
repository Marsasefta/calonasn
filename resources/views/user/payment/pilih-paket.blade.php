<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Upgrade Paket Premium</title>
</head>

<body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')

    <div class="db-content">
        <div class="container mb-4">

            <div class="row mb-4 text-center">
                <div class="col-12 col-md-8 offset-md-2">
                    <span
                        class="badge bg-primary-soft text-primary px-3 py-2 fw-bold text-uppercase rounded-pill mb-3 shadow-sm">
                        <i class="bi bi-star-fill text-warning me-1"></i> Upgrade Akun
                    </span>
                    <h1 class="h2 mb-3 fw-bold text-dark">Tingkatkan Peluang Lulusmu!</h1>
                    <p class="text-muted fs-5">Buka akses ke fitur premium CalonASN. Pilih paket yang paling pas untuk
                        menemanimu belajar.</p>
                </div>
            </div>

            @include('partials.promo-24h-banner', ['showCta' => false, 'promo24h' => $promo24h ?? null])

            <div class="row g-4 justify-content-center align-items-stretch">

                <!-- PAKET 1: TRYOUT MANDIRI -->
                <div class="col-lg-5 col-md-6 d-flex">
                    <div
                        class="card w-100 border border-2 border-light shadow-sm rounded-4 p-4 p-md-5 d-flex flex-column bg-white">
                        <div class="mb-4">
                            <span class="badge bg-secondary px-3 py-1 rounded-pill mb-2 fw-semibold">Paket
                                Latihan</span>

                            <h3 class="fw-bold text-dark mb-1">{{ $tryoutMandiri->title ?? 'Tryout Mandiri' }}</h3>
                            <p class="text-muted small">Fokus latih manajemen waktu dengan 1x simulasi CAT.</p>

                            <div class="mt-4 p-3 bg-light rounded-3 border">
                                <p class="text-muted small mb-1"><del>Rp 50.000</del> • Investasi Normal:</p>
                                <p class="display-5 fw-bolder text-dark mb-0">
                                    Rp 20.000 <span class="fs-6 text-muted fw-normal">/selamanya</span>
                                </p>
                                @if (!empty($promo24h))
                                    <div class="mt-2 pt-2 border-top border-secondary border-opacity-25">
                                        <span class="badge bg-success text-white px-2.5 py-1 small shadow-xs">
                                            <i class="bi bi-tag-fill me-1"></i> + Kupon {{ $promo24h['code'] }} (s/d 23:59 WIB) jadi: <strong
                                                class="fs-6">Rp 13.000</strong>
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <ul class="list-unstyled d-flex flex-column gap-3 text-dark fw-medium mb-5">
                            <li class="d-flex align-items-start small p-2 bg-light rounded-3 border border-secondary-subtle">
                                <i class="bi bi-1-circle-fill text-primary me-2 mt-1 fs-5"></i>
                                <span><strong>1x Kesempatan Tryout CAT</strong> (Akses 1 kali simulasi)</span>
                            </li>
                            <li class="d-flex align-items-start small">
                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                <span><strong>Trial Modul Pembelajaran</strong> (Bab 1 Gratis di tiap kategori)</span>
                            </li>
                            <li class="d-flex align-items-start small">
                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                <span>110 Soal Standar Kisi-kisi CalonASN.id</span>
                            </li>
                            <li class="d-flex align-items-start small">
                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                <span>Skor Real-Time & Pembahasan Lengkap</span>
                            </li>
                            <li class="d-flex align-items-start small">
                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                <span>Masuk Ranking Nasional CalonASN.id</span>
                            </li>
                            <li class="d-flex align-items-start small">
                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                <span>Sertifikat Ber-QR Code CalonASN.id (Jika Lulus PG)</span>
                            </li>
                            <li class="d-flex align-items-start small text-muted">
                                <i class="bi bi-x-circle-fill text-danger opacity-50 me-2 mt-1"></i>
                                <span class="text-decoration-line-through">Full Modul Pembelajaran (Terkunci Bab 2+)</span>
                            </li>
                            <li class="d-flex align-items-start small text-muted">
                                <i class="bi bi-x-circle-fill text-danger opacity-50 me-2 mt-1"></i>
                                <span class="text-decoration-line-through">Tryout Berkali-kali (Unlimited)</span>
                            </li>
                        </ul>

                        <div class="mt-auto">
                            @if ($isLengkap || $hasPaket1)
                                <button class="btn btn-light rounded-pill py-3 fw-bold w-100 border text-muted"
                                    disabled>
                                    <i class="bi bi-check-all me-1"></i> Sudah Dimiliki
                                </button>
                            @else
                                <a href="{{ route('checkout', 1) }}"
                                    class="btn btn-outline-dark rounded-pill py-3 fw-bold w-100 hover-lift">
                                    Pilih Paket Ini
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- PAKET 2: PAKET SUPER LENGKAP / UNLIMITED -->
                <div class="col-lg-5 col-md-6 d-flex">
                    <div
                        class="card w-100 border-2 border-primary shadow rounded-4 p-4 p-md-5 d-flex flex-column bg-white position-relative">

                        <div class="position-absolute top-0 end-0 bg-primary text-white px-4 py-2 small fw-bold shadow-sm"
                            style="border-bottom-left-radius: 16px;">
                            ⭐ REKOMENDASI TERBAIK
                        </div>

                        <div class="mb-4 mt-2">
                            <span class="badge bg-primary-soft text-primary px-3 py-1 rounded-pill mb-2 fw-bold">Paket
                                Super Lengkap</span>

                            <h3 class="fw-bold text-dark mb-1">{{ $tryoutLengkap->title ?? 'Tryout + Materi Full' }}
                            </h3>
                            <p class="text-muted small">Solusi instan: Paham materinya, taklukkan simulasinya.</p>

                            <div class="mt-4">
                                @if ($hasPaket1 && !$isLengkap)
                                    <!-- Opsi Upgrade (Paket 3) -->
                                    <div
                                        class="p-3 bg-warning bg-opacity-10 rounded-3 border border-warning border-opacity-25">
                                        <p class="text-muted small mb-1"><del>Rp 49.000</del> • Biaya Khusus Upgrade:</p>
                                        <p class="display-5 fw-bolder text-dark mb-0">
                                            Rp 29.000 <span class="fs-6 text-muted fw-normal">/selamanya</span>
                                        </p>
                                        <span class="badge bg-warning text-dark mt-2 shadow-sm fw-bold">
                                            <i class="bi bi-lightning-charge-fill me-1"></i> Buka Tryout Coba Berkali-kali & Full Modul
                                        </span>
                                    </div>
                                @else
                                    <div class="p-3 bg-primary-soft rounded-3 border border-primary border-opacity-25">
                                        <p class="text-primary small mb-1 fw-semibold"><del class="text-muted">Rp 149.000</del> • Investasi Normal:</p>
                                        <p class="display-5 fw-bolder text-primary mb-0">
                                            Rp 49.000 <span class="fs-6 text-muted fw-normal">/selamanya</span>
                                        </p>
                                        @if (!empty($promo24h))
                                            <div class="mt-2 pt-2 border-top border-primary border-opacity-25">
                                                <span class="badge bg-primary text-white px-2.5 py-1 small shadow-sm">
                                                    <i class="bi bi-tag-fill me-1"></i> + Kupon {{ $promo24h['code'] }} (s/d 23:59 WIB) jadi: <strong
                                                        class="fs-6 text-warning">Rp 42.000</strong>
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <ul class="list-unstyled d-flex flex-column gap-3 text-dark fw-medium mb-5">
                            <li class="d-flex align-items-start small p-2 bg-primary-soft rounded-3">
                                <i class="bi bi-infinity text-primary me-2 mt-1 fs-5"></i>
                                <span class="text-primary"><strong>Tryout Coba Berkali-kali (Unlimited)</strong> — Latihan sepuasnya kapan saja</span>
                            </li>
                            <li class="d-flex align-items-start small p-2 bg-primary-soft rounded-3">
                                <i class="bi bi-book-half text-primary me-2 mt-1 fs-5"></i>
                                <span class="text-primary"><strong>Full Modul Pembelajaran</strong> — Akses penuh semua bab TWK, TIU, TKP</span>
                            </li>
                            <li class="d-flex align-items-start small">
                                <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                <span>110 Soal CAT Standar Kisi-kisi CalonASN.id Terupdate</span>
                            </li>
                            <li class="d-flex align-items-start small">
                                <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                <span>Trik Rahasia Jawab Cepat & Pembahasan Mendalam</span>
                            </li>
                            <li class="d-flex align-items-start small">
                                <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                <span>Rapor Evaluasi Lengkap & Grafik Perkembangan Skor</span>
                            </li>
                            <li class="d-flex align-items-start small">
                                <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                <span>Masuk Ranking Nasional Real-Time CalonASN.id</span>
                            </li>
                            <li class="d-flex align-items-start small">
                                <i class="bi bi-award-fill text-warning me-2 mt-1 fs-5"></i>
                                <span><strong>Sertifikat Kelulusan Ber-QR Code Resmi CalonASN.id</strong></span>
                            </li>
                        </ul>

                        <div class="mt-auto">
                            @if ($isLengkap)
                                <button class="btn btn-success rounded-pill py-3 fw-bold w-100 shadow-sm" disabled>
                                    <i class="bi bi-shield-check me-1"></i> Akses Premium Aktif
                                </button>
                            @elseif($hasPaket1)
                                <a href="{{ route('checkout', 3) }}"
                                    class="btn btn-warning text-dark rounded-pill py-3 fw-bold w-100 shadow-sm hover-lift">
                                    Upgrade Sekarang (Cukup 29rb) <i class="bi bi-arrow-up-circle ms-1"></i>
                                </a>
                            @else
                                <a href="{{ route('checkout', 2) }}"
                                    class="btn btn-primary rounded-pill py-3 fw-bold w-100 shadow-sm hover-lift">
                                    Beli Paket Lengkap <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Scroll top -->
    @include('partials.btn-scroll-top')
    <!-- Scripts -->
    @include('partials.scripts')
    <script src="assets/js/vendors/tnsSlider.js"></script>
    <script src="assets/js/vendors/chart.js"></script>
    <script src="assets/js/vendors/navbar-nav.js"></script>
</body>

</html>
