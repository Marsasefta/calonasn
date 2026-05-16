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

    <div class="db-content text-center py-5 text-dark">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <i class="fe fe-unlock display-1 text-primary mb-4"></i>

                    <h1 class="fw-bold">Simulasi Tryout CPNS (Demo)</h1>
                    <p class="lead text-muted mb-4">
                        Mau tahu sejauh mana kemampuanmu? Coba simulasi singkat ini.
                        Dapatkan gambaran soal TWK, TIU, dan TKP dalam waktu 10 menit!
                    </p>

                    <div class="card bg-light border-0 p-4 mb-4 text-start">
                        <h5 class="mb-3">Detail Ujicoba:</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fe fe-check-circle text-success me-2"></i> 10 Soal Pilihan
                                (Acak)</li>
                            <li class="mb-2"><i class="fe fe-clock text-danger me-2"></i> Durasi 10 Menit</li>
                            <li class="mb-2"><i class="fe fe-bar-chart-2 text-info me-2"></i> Penilaian Otomatis</li>
                        </ul>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('demo.ujian') }}" class="btn btn-primary btn-lg shadow-sm">
                            Mulai Ujicoba Sekarang
                        </a>
                        <a href="{{ route('dashboard') }}" class="text-muted small">Kembali ke Dashboard</a>
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
