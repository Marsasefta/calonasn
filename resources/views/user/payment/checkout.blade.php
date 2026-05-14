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
                            <h2 class="fw-bold mb-0 text-primary">Rp
                                {{ number_format($tryout->price ?? 50000, 0, ',', '.') }}</h2>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header bg-white pt-4 pb-0 border-bottom-0">
                            <h3 class="mb-0">Pilih Metode Pembayaran</h3>
                            <span class="text-muted small">Tampilan demo untuk presentasi alur pembayaran.</span>
                        </div>
                        <div class="card-body py-4">

                            <form action="{{ route('checkout.process') }}" method="POST" id="formCheckout">
                                @csrf
                                <input type="hidden" name="tryout_id" value="{{ $tryout->id ?? 1 }}">
                                <input type="hidden" name="amount" value="{{ $tryout->price ?? 50000 }}">

                                <div class="accordion" id="paymentAccordion">

                                    <div class="accordion-item border rounded mb-2">
                                        <h2 class="accordion-header" id="headingVA">
                                            <button class="accordion-button bg-light" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseVA"
                                                aria-expanded="true">
                                                <i class="fe fe-credit-card text-success me-3 fs-4"></i>
                                                <span class="fw-bold">Transfer Bank (Virtual Account)</span>
                                            </button>
                                        </h2>
                                        <div id="collapseVA" class="accordion-collapse collapse show"
                                            data-bs-parent="#paymentAccordion">
                                            <div class="accordion-body px-4 py-3">
                                                <div class="form-check mb-3 border-bottom pb-2">
                                                    <input class="form-check-input mt-1" type="radio"
                                                        name="payment_method" id="bankBCA" value="bca" checked>
                                                    <label class="form-check-label fw-medium ms-2" for="bankBCA">BCA
                                                        Virtual Account</label>
                                                </div>
                                                <div class="form-check mb-3 border-bottom pb-2">
                                                    <input class="form-check-input mt-1" type="radio"
                                                        name="payment_method" id="bankMandiri" value="mandiri">
                                                    <label class="form-check-label fw-medium ms-2"
                                                        for="bankMandiri">Mandiri Virtual Account</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input mt-1" type="radio"
                                                        name="payment_method" id="bankBRI" value="bri">
                                                    <label class="form-check-label fw-medium ms-2" for="bankBRI">BRI
                                                        Virtual Account</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingQRIS">
                                            <button class="accordion-button bg-light collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseQRIS">
                                                <i class="fe fe-smartphone text-primary me-3 fs-4"></i>
                                                <span class="fw-bold">QRIS (Gopay, OVO, Dana, dll)</span>
                                            </button>
                                        </h2>
                                        <div id="collapseQRIS" class="accordion-collapse collapse"
                                            data-bs-parent="#paymentAccordion">
                                            <div class="accordion-body text-center py-4">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg"
                                                    alt="Simulasi QRIS" width="120" class="mb-3 border p-2 rounded">
                                                <p class="text-muted small mb-0">Peserta cukup scan QR Code ini melalui
                                                    aplikasi M-Banking atau e-Wallet mereka.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="d-grid mt-4">
                                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
                                        data-bs-target="#demoPaymentModal">
                                        Bayar Sekarang <i class="fe fe-arrow-right ms-2"></i>
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="demoPaymentModal" tabindex="-1" aria-labelledby="demoPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="demoPaymentModalLabel">Selesaikan Pembayaran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-5">
                    <p class="text-muted mb-1">Batas Waktu Pembayaran</p>
                    <h3 class="text-danger mb-4 fw-bold">23:59:59</h3>

                    <p class="mb-1">Nomor Virtual Account BCA</p>
                    <h2 class="fw-bold text-dark mb-3 tracking-wide">8077 0123 4567 8910</h2>
                    <p class="text-muted">Total Tagihan: <strong class="text-dark">Rp
                            {{ number_format($tryout->price ?? 50000, 0, ',', '.') }}</strong></p>

                    <hr class="my-4">

                    <div class="alert alert-warning text-start small">
                        <i class="fe fe-info me-1"></i> <strong>Mode Demo:</strong> Di versi aslinya, peserta akan
                        mentransfer uang ke nomor VA di atas. Untuk keperluan demo presentasi, silakan klik tombol hijau
                        di bawah untuk mensimulasikan pembayaran sukses.
                    </div>
                </div>
                <div class="modal-footer justify-content-between bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>

                    <button type="button" class="btn btn-success px-4"
                        onclick="document.getElementById('formCheckout').submit();">
                        <i class="fe fe-check-circle me-1"></i> Simulasikan Bayar (Simpan ke DB)
                    </button>
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
