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

    <div class="db-content">
        <div class="container mb-4">
            <div class="row mb-5">
                <div class="col-12">
                    <h1 class="h2 mb-0">Status Pembayaran</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">

                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-body text-center py-5 px-4 px-md-5">

                            <div class="mb-4">
                                <i class="fe fe-clock text-warning" style="font-size: 72px;"></i>
                            </div>

                            <h2 class="fw-bold mb-2 text-dark">Menunggu Pembayaran</h2>
                            <p class="text-muted mb-4">Tagihan kamu telah berhasil dibuat. Silakan selesaikan pembayaran
                                sesuai metode yang dipilih agar paket ujian dapat diakses.</p>

                            <div class="bg-light p-4 rounded mb-4 text-center border">
                                <p class="mb-1 text-muted small">Status Transaksi Saat Ini:</p>
                                <h3 class="text-warning fw-bold mb-0">
                                    <i class="fe fe-loader me-1 align-middle"></i> PENDING
                                </h3>
                            </div>

                            <hr class="my-4">

                            <div class="d-grid mt-4">
                                <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg">
                                    <i class="fe fe-arrow-left me-2"></i> Kembali ke Dashboard
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
