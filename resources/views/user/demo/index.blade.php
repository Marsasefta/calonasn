<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Tryout Gratis</title>
</head>

<body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')


    <div class="db-content text-dark">
        <div class="container-fluid mb-4">

            <div class="row align-items-center mb-4 bg-white p-3 shadow-sm rounded">
                <div class="col-md-6">
                    <h4 class="mb-0 fw-bold text-primary">Simulasi Tryout CPNS (Demo)</h4>
                    <p class="mb-0 text-muted small">Persiapan Uji Coba Gratis</p>
                </div>
                <div class="col-md-6 text-end">
                    <h3 class="mb-0 fw-bold text-dark">10 Menit</h3>
                    <span class="small text-muted">Durasi Pengerjaan</span>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body p-5 text-center">

                            <div class="mb-4">
                                <div class="display-4 text-success mb-3">
                                    <i class="fe fe-unlock"></i>
                                </div>
                                <h3 class="fw-bold">Uji Coba Gratis Terbuka!</h3>
                                <p class="text-muted">Mau tahu sejauh mana kemampuanmu? Coba simulasi singkat ini untuk
                                    mendapatkan gambaran nyata pengerjaan soal TWK, TIU, dan TKP.</p>
                            </div>

                            <div class="alert alert-info border-0 shadow-sm mb-4">
                                <ul class="text-start mb-0 small">
                                    <li class="mb-1">10 Butir Soal Pilihan (Kombinasi Acak TWK, TIU, TKP).</li>
                                    <li class="mb-1">Durasi batas waktu pengerjaan maksimal 10 Menit.</li>
                                    <li class="mb-1">Sistem penilai otomatis langsung keluar setelah selesai.</li>
                                    <li>Pastikan koneksi internet Anda stabil sebelum menekan tombol mulai.</li>
                                </ul>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="{{ route('demo.ujian') }}" class="btn btn-primary btn-lg w-100 shadow-sm">
                                    <i class="fe fe-play me-2"></i> Mulai Ujicoba Sekarang
                                </a>
                                <a href="{{ route('dashboard') }}" class="btn btn-link text-muted small mt-2">
                                    Kembali ke Dashboard
                                </a>
                            </div>

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
