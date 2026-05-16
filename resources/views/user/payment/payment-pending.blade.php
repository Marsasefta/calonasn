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

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm"
                            role="alert">
                            <i class="fe fe-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-body text-center py-5 px-4 px-md-5">

                            <div class="mb-4 position-relative d-inline-block">
                                <i class="fe fe-file-text text-muted" style="font-size: 72px;"></i>
                                <span class="position-absolute top-50 start-50 translate-middle mt-2 ms-2">
                                    <i class="fe fe-clock text-warning bg-white rounded-circle p-1"
                                        style="font-size: 32px;"></i>
                                </span>
                            </div>

                            <h2 class="fw-bold mb-2 text-dark">Pembayaran Sedang Diperiksa</h2>
                            <p class="text-muted mb-4 lead fs-6">
                                Terima kasih! Bukti transfer Anda telah berhasil kami terima. <br>
                                Saat ini Admin sedang melakukan validasi mutasi bank. Paket tryout Anda akan otomatis
                                terbuka setelah disetujui.
                            </p>

                            <div class="bg-warning-soft p-4 rounded mb-4 text-center border border-warning border-opacity-25"
                                style="background-color: #fff9e6;">
                                <p class="mb-1 text-muted small fw-medium">Status Transaksi Saat Ini:</p>
                                <h3 class="text-warning fw-bold mb-0">
                                    <i class="fe fe-refresh-cw me-1 align-middle"></i> MENUNGGU VERIFIKASI ADMIN
                                </h3>
                            </div>

                            <div class="alert alert-info text-start small border-0 shadow-sm mb-4">
                                <i class="fe fe-info me-2"></i>
                                Proses pengecekan biasanya memakan waktu <strong>5 - 15 menit</strong>. Anda dapat
                                meninggalkan halaman ini atau menutup browser, status pemesanan tetap dapat Anda pantau
                                melalui menu <strong>Riwayat Transaksi</strong>.
                            </div>

                            <hr class="my-4">

                            <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                                <a href="{{ route('riwayat') }}" class="btn btn-outline-secondary btn-lg px-4">
                                    <i class="fe fe-list me-2"></i> Cek Riwayat Transaksi
                                </a>
                                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4">
                                    <i class="fe fe-home me-2"></i> Kembali ke Dashboard
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
