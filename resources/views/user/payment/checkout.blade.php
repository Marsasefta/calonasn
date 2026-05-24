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
                            <div class="text-end">
                                <span class="text-muted small d-block">Harga Paket</span>
                                <h3 class="fw-bold mb-0 text-dark" id="display-original-price"
                                    data-price="{{ $tryout->price ?? 50000 }}">
                                    Rp {{ number_format($tryout->price ?? 50000, 0, ',', '.') }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header bg-white pt-4 pb-0 border-bottom-0">
                            <h3 class="mb-0">Rincian Pembayaran</h3>
                        </div>
                        <div class="card-body py-4">

                            <div class="mb-4 p-3 bg-light rounded border">
                                <label class="form-label fw-bold">Punya Kode Promo?</label>
                                <div class="input-group">
                                    <input type="text" id="promo_code_input" class="form-control text-uppercase"
                                        placeholder="Masukkan kode promo...">
                                    <button class="btn btn-dark" type="button" id="btn-apply-promo">Terapkan</button>
                                </div>
                                <small id="promo-message" class="d-block mt-2 fw-bold"></small>
                            </div>

                            <div class="mb-4 px-2">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal:</span>
                                    <span class="fw-bold">Rp
                                        {{ number_format($tryout->price ?? 50000, 0, ',', '.') }}</span>
                                </div>

                                <div class="d-flex justify-content-between mb-2 text-success d-none" id="discount-row">
                                    <span>Potongan Promo:</span>
                                    <span class="fw-bold" id="discount-amount">- Rp 0</span>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between fs-4">
                                    <span class="fw-bold">Total Bayar:</span>
                                    <span class="fw-bold text-primary" id="total-price">
                                        Rp {{ number_format($tryout->price ?? 50000, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <h5 class="mb-3 fw-bold mt-4">Metode Pembayaran</h5>
                            <div class="border rounded p-3 mb-4 d-flex align-items-center bg-light">
                                <i class="bi bi-qr-code-scan text-success fs-2 me-3"></i>
                                <div>
                                    <h5 class="mb-0 fw-bold">QRIS (Semua Pembayaran)</h5>
                                    <small class="text-muted">Mendukung Gopay, OVO, Dana, LinkAja, ShopeePay, dan
                                        M-Banking.</small>
                                </div>
                            </div>

                            <form action="{{ route('checkout.process') }}" method="POST">
                                @csrf
                                <input type="hidden" name="tryout_id" value="{{ $tryout->id ?? 1 }}">
                                <input type="hidden" name="amount" value="{{ $tryout->price ?? 50000 }}">

                                <input type="hidden" name="promo_code_id" id="hidden_promo_id" value="">

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg py-3">
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


    <script>
        document.getElementById('btn-apply-promo').addEventListener('click', function() {
            let codeInput = document.getElementById('promo_code_input');
            let code = codeInput.value.trim();
            let messageEl = document.getElementById('promo-message');
            // Ambil harga asli dari atribut data-price yang kita siapkan di atas
            let originalPrice = parseInt(document.getElementById('display-original-price').getAttribute(
                'data-price'));

            if (code === '') {
                messageEl.innerHTML =
                    '<span class="text-danger"><i class="fe fe-alert-circle"></i> Masukkan kode promo terlebih dahulu!</span>';
                return;
            }

            messageEl.innerHTML =
                '<span class="text-info"><i class="fe fe-loader"></i> Sedang mengecek kode...</span>';
            this.disabled = true;

            // Pastikan route ini sesuai dengan yang kamu buat di web.php
            fetch('{{ route('transaction.checkPromo') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        code: code
                    })
                })
                .then(response => response.json())
                .then(data => {
                    let btnApply = document.getElementById('btn-apply-promo');

                    if (data.success) {
                        // Tampilkan sukses
                        messageEl.innerHTML = '<span class="text-success"><i class="fe fe-check-circle"></i> ' +
                            data.message + '</span>';

                        // Munculkan baris diskon
                        document.getElementById('discount-row').classList.remove('d-none');

                        // KODE BARU
                        let discountBulat = parseInt(data.discount_amount); // Paksa hilangkan koma desimal

                        document.getElementById('discount-amount').innerText = '- Rp ' + discountBulat
                            .toLocaleString('id-ID');

                        let total = originalPrice - discountBulat;


                        if (total < 0) total = 0;
                        document.getElementById('total-price').innerText = 'Rp ' + total.toLocaleString(
                            'id-ID');

                        // Masukkan ID promo ke hidden input form
                        document.getElementById('hidden_promo_id').value = data.promo_id;

                        // Kunci inputan agar tidak bisa diubah lagi
                        codeInput.setAttribute('readonly', true);
                        btnApply.innerText = 'Diterapkan';
                    } else {
                        // Tampilkan error
                        messageEl.innerHTML = '<span class="text-danger"><i class="fe fe-x-circle"></i> ' + data
                            .message + '</span>';
                        document.getElementById('hidden_promo_id').value = '';
                        btnApply.disabled = false;
                    }
                })
                .catch(error => {
                    messageEl.innerHTML =
                        '<span class="text-danger"><i class="fe fe-alert-triangle"></i> Terjadi kesalahan sistem. Coba lagi nanti.</span>';
                    document.getElementById('btn-apply-promo').disabled = false;
                });
        });
    </script>
</body>

</html>
