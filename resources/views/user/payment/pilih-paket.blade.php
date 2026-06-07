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

            <div class="row mb-5 text-center">
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

            <div class="row g-4 justify-content-center align-items-stretch">

                <div class="col-lg-5 col-md-6 d-flex">
                    <div
                        class="card w-100 border border-2 border-light shadow-sm rounded-4 p-4 p-md-5 d-flex flex-column bg-white">
                        <div class="mb-4">
                            <span class="badge bg-secondary px-3 py-1 rounded-pill mb-2 fw-semibold">Paket
                                Latihan</span>
                            <h3 class="fw-bold text-dark mb-1">Tryout Mandiri</h3>
                            <p class="text-muted small">Fokus latih manajemen waktu dengan simulasi CAT.</p>

                            <div class="mt-4">
                                <p class="display-5 fw-bolder text-dark mb-0">
                                    Rp 20.000 <span class="fs-6 text-muted fw-normal">/selamanya</span>
                                </p>
                            </div>
                        </div>

                        <ul class="list-unstyled d-flex flex-column gap-3 text-dark fw-medium mb-5">
                            <li class="d-flex align-items-start small">
                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                <span>110 Soal Standar HOTS 2026</span>
                            </li>
                            <li class="d-flex align-items-start small">
                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                <span>Skor Real-Time & Pembahasan</span>
                            </li>
                            <li class="d-flex align-items-start small text-muted">
                                <i class="bi bi-x-circle-fill text-danger opacity-50 me-2 mt-1"></i>
                                <span class="text-decoration-line-through">Akses Ratusan Materi Pembelajaran</span>
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

                <div class="col-lg-5 col-md-6 d-flex">
                    <div
                        class="card w-100 border-2 border-primary shadow rounded-4 p-4 p-md-5 d-flex flex-column bg-white position-relative">

                        <div class="position-absolute top-0 end-0 bg-primary text-white px-4 py-2 small fw-bold shadow-sm"
                            style="border-bottom-left-radius: 16px;">
                            REKOMENDASI
                        </div>

                        <div class="mb-4 mt-2">
                            <span class="badge bg-primary-soft text-primary px-3 py-1 rounded-pill mb-2 fw-bold">Paket
                                Super Lengkap</span>
                            <h3 class="fw-bold text-dark mb-1">Tryout + Materi Full</h3>
                            <p class="text-muted small">Solusi instan: Paham materinya, taklukkan simulasinya.</p>

                            <div class="mt-4">
                                @if ($hasPaket1 && !$isLengkap)
                                    <span class="text-muted small text-decoration-line-through d-block mb-1">Rp
                                        49.000</span>
                                    <p class="display-5 fw-bolder text-primary mb-0">
                                        Rp 29.000 <span class="fs-6 text-muted fw-normal">/selamanya</span>
                                    </p>
                                    <span class="badge bg-warning text-dark mt-2"><i
                                            class="bi bi-lightning-charge-fill"></i> Harga Khusus Upgrade</span>
                                @else
                                    <p class="display-5 fw-bolder text-primary mb-0">
                                        Rp 49.000 <span class="fs-6 text-muted fw-normal">/selamanya</span>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <ul class="list-unstyled d-flex flex-column gap-3 text-dark fw-medium mb-5">
                            <li class="d-flex align-items-start small">
                                <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                <span>Semua Fitur Paket Tryout Mandiri</span>
                            </li>
                            <li class="d-flex align-items-start small p-2 bg-primary-soft rounded-3">
                                <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                <span class="text-primary"><strong>Akses Penuh Materi Pembelajaran</strong></span>
                            </li>
                            <li class="d-flex align-items-start small">
                                <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                <span>Trik Rahasia Jawab Cepat</span>
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
