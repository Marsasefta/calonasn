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
            <div class="row mb-5">
                <div class="col-12">
                    <h1 class="h2 mb-0">Pembayaran Berhasil</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">

                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-body text-center py-5 px-4 px-md-5">

                            <div class="mb-4">
                                <i class="fe fe-check-circle text-success" style="font-size: 80px;"></i>
                            </div>

                            <h2 class="fw-bold mb-2 text-dark">Terima Kasih, Pembayaran Berhasil!</h2>
                            <p class="text-muted mb-4">Paket
                                <strong>{{ $transaction->order_id ?? 'Tryout CPNS' }}</strong> kamu sekarang sudah
                                aktif. Kamu bisa langsung memulai ujian sekarang.
                            </p>

                            <div class="bg-light p-4 rounded mb-4 text-start border">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Order ID:</span>
                                    <span class="fw-bold text-dark">{{ $transaction->order_id ?? '-' }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Total Bayar:</span>
                                    <span class="fw-bold text-success">Rp
                                        {{ number_format($transaction->amount ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Status:</span>
                                    <span class="badge bg-success">SUCCESS</span>
                                </div>
                            </div>

                            <div class="alert alert-success border-success-subtle mb-4 text-start">
                                <div class="d-flex">
                                    <i class="fe fe-unlock fs-3 me-3 mt-1"></i>
                                    <div>
                                        <h5 class="mb-1 text-success">Akses Terbuka!</h5>
                                        <p class="mb-0 small">Menu simulasi soal sudah dapat diakses. Silakan klik
                                            tombol di bawah untuk mulai mengerjakan.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="{{ route('ujian.persiapan', 1) }}" class="btn btn-success btn-lg shadow-sm">
                                    <i class="fe fe-play-circle me-2"></i> Mulai Ujian Sekarang
                                </a>
                                <a href="{{ route('checkout') }}" class="btn btn-outline-secondary">
                                    Kembali
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
