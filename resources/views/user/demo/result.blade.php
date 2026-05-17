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
                <h4 class="mb-0 fw-bold text-primary">Ujicoba Demo Selesai!</h4>
                <p class="mb-0 text-muted small">Hasil Evaluasi Simulasi Singkat</p>
            </div>
            <div class="col-md-6 text-end">
                <h3 class="mb-0 fw-bold text-success">{{ $score }} Poin</h3>
                <span class="small text-muted">Total Skor Kamu</span>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body p-5 text-center">

                        <div class="mb-4">
                            <div class="display-4 mb-3">🎉</div>
                            <h3 class="fw-bold">Latihan Selesai, Kerja Bagus!</h3>
                            <p class="text-muted">Berikut adalah ringkasan performa pengerjaan 10 soal acak kamu.</p>
                        </div>

                        <div class="bg-light p-3 rounded border-0 mb-4 text-start">
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <span class="text-muted small fw-medium">Jawaban Benar</span>
                                <span class="badge bg-success-soft text-success fw-bold">{{ $correct }} Soal</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small fw-medium">Jawaban Salah / Kosong</span>
                                <span class="badge bg-danger-soft text-danger fw-bold">{{ $totalSoal - $correct }} Soal</span>
                            </div>
                        </div>

                        <div class="alert alert-warning border-0 shadow-sm mb-4 text-start">
                            <h5 class="fw-bold text-danger mb-2">
                                <i class="fe fe-lock me-2"></i> Mau Lihat Pembahasan Detail?
                            </h5>
                            <p class="small mb-0 text-dark lh-base">
                                Maaf, fitur analisis lembar jawaban, kunci jawaban resmi, serta **Pembahasan Mendalam & Rumus Praktis** per butir soal hanya terbuka untuk anggota <strong>Premium</strong>.
                            </p>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg w-100 shadow-sm fw-bold">
                                <i class="fe fe-shopping-cart me-2"></i> Beli Paket Sekarang (Cuma Rp 20rb)
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
