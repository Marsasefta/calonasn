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
                <h1 class="h2 mb-0">Checkout Pembayaran</h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">

                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between align-items-center py-4">
                        <div>
                            <h4 class="text-dark mb-1">{{ $tryout->title ?? 'Paket Tryout CPNS' }}</h4>
                            <span class="text-muted small">Akses penuh ke semua simulasi CAT.</span>
                        </div>
                        <h2 class="fw-bold mb-0 text-primary">
                            Rp {{ number_format($tryout->price ?? 50000, 0, ',', '.') }}
                        </h2>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-white pt-4 pb-0 border-bottom-0">
                        <h3 class="mb-0">Metode Pembayaran</h3>
                    </div>
                    <div class="card-body py-4">
                        
                        <div class="border rounded p-3 mb-4 d-flex align-items-center bg-light">
                            <i class="bi bi-qr-code-scan text-success fs-2 me-3"></i>
                            <div>
                                <h5 class="mb-0 fw-bold">QRIS (Semua Pembayaran)</h5>
                                <small class="text-muted">Mendukung Gopay, OVO, Dana, LinkAja, ShopeePay, dan M-Banking.</small>
                            </div>
                        </div>

                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tryout_id" value="{{ $tryout->id ?? 1 }}">
                            <input type="hidden" name="amount" value="{{ $tryout->price ?? 50000 }}">

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Lanjutkan Pembayaran <i class="fe fe-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </form>

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
