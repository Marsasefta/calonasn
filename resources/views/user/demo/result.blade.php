<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Student Dashboard | Geeks - Bootstrap 5 Template</title>
</head>

<body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')

    <div class="db-content text-center py-5">
        <div class="container">
            <div class="display-1 text-primary mb-3">🎉</div>
            <h1 class="fw-bold">Ujicoba Demo Selesai!</h1>
            <div class="row justify-content-center mt-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm p-4">
                        <h3>Skor Kamu: <span class="text-success">{{ $score }}</span></h3>
                        <p class="text-muted">Benar: {{ $correct }} | Salah: {{ 10 - $correct }}</p>

                        <hr>

                        <h5 class="text-danger fw-bold">Mau Lihat Pembahasan Detail?</h5>
                        <p>Maaf, fitur pembahasan detail per soal dan tips trik hanya tersedia untuk member **Premium**.
                        </p>

                        <div class="d-grid gap-2 mt-3">
                            <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg">
                                Beli Paket Sekarang (Cuma Rp 20rb)
                            </a>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Kembali ke
                                Dashboard</a>
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
