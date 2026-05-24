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
                    <h1 class="h2 mb-0">Detail Transaksi Pembayaran</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">

                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fe fe-info me-2"></i> {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fe fe-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card mb-4 shadow-sm border-0">
                        <div
                            class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center py-4">
                            <div class="mb-3 mb-md-0">
                                <h4 class="text-dark mb-1">Tagihan: {{ $transaction->invoice_number }}</h4>
                                <span class="text-muted small">Status:
                                    @if (empty($transaction->payment_proof))
                                        <span id="countdown" class="text-danger fw-bold">Menghitung...</span>
                                    @else
                                        <span class="text-info fw-bold"><i class="fe fe-refresh-cw me-1"></i>Menunggu
                                            Verifikasi Admin</span>
                                    @endif
                                </span>
                            </div>

                            <div class="text-md-end text-start bg-light p-3 rounded border">
                                <span class="text-muted small d-block mb-1">Nominal Tagihan:</span>
                                <h2 class="fw-bold mb-0 text-primary">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </h2>

                                @if ($transaction->discount_amount > 0)
                                    <div class="mt-2 text-success small fw-bold">
                                        <i class="fe fe-gift me-1"></i> Hemat Rp
                                        {{ number_format($transaction->discount_amount, 0, ',', '.') }} dari Promo!
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm border-0">

                        @if (empty($transaction->payment_proof))
                            {{-- KONDISI A: JIKA BELUM UPLOAD BUKTI (TAMPILKAN QRIS & FORM) --}}
                            <div class="card-header bg-white pt-4 pb-0 border-bottom-0 text-center">
                                <h3 class="mb-0">Scan QRIS</h3>
                                <span class="text-muted small">Gunakan Gopay, OVO, Dana, LinkAja, atau M-Banking.</span>
                            </div>

                            <div class="card-body py-4">
                                <div class="text-center mb-5 mt-2">
                                    <div class="p-2 border rounded d-inline-block bg-white shadow-sm">
                                        <img src="{{ asset('image/qris.jpeg') }}" alt="QRIS Payment" class="img-fluid"
                                            style="max-width: 250px;">
                                    </div>

                                    <div class="mt-3">
                                        <a href="{{ asset('image/qris.jpeg') }}"
                                            download="QRIS_Pembayaran_{{ $transaction->invoice_number }}.jpeg"
                                            class="btn btn-outline-primary btn-sm fw-bold shadow-sm">
                                            <i class="fe fe-download me-2"></i> Simpan / Unduh QRIS
                                        </a>
                                    </div>
                                </div>

                                <hr class="mb-4">

                                <div class="bg-light p-4 rounded border-0">
                                    <h5 class="fw-bold mb-3">
                                        <i class="fe fe-check-circle text-success me-2"></i>Konfirmasi Pembayaran
                                    </h5>
                                    <p class="text-muted small mb-4">Jika Anda sudah melakukan transfer, wajib
                                        mengunggah foto struk atau *screenshot* bukti transaksi agar Admin dapat segera
                                        memverifikasi pesanan Anda.</p>

                                    @if ($errors->any())
                                        <div class="alert alert-danger border-0 shadow-sm small mb-4">
                                            <ul class="mb-0 list-unstyled">
                                                @foreach ($errors->all() as $error)
                                                    <li><i class="fe fe-alert-circle me-2"></i> {{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form action="{{ route('payment.upload', $transaction->invoice_number) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="payment_proof" class="form-label fw-medium text-dark">Pilih File
                                                Bukti Transfer</label>

                                            <input
                                                class="form-control form-control-lg bg-white @error('payment_proof') is-invalid @enderror"
                                                type="file" id="payment_proof" name="payment_proof"
                                                accept="image/jpeg,image/png,image/jpg" required>

                                            @error('payment_proof')
                                                <div class="invalid-feedback mt-2 fw-medium">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <div class="form-text mt-2">Format yang diizinkan: JPG, JPEG, PNG. Maksimal
                                                ukuran file 15MB.</div>
                                        </div>

                                        <div class="d-grid mt-2">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                Kirim Bukti Pembayaran <i class="fe fe-arrow-right ms-2"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            {{-- KONDISI B: JIKA SUDAH UPLOAD BUKTI (TAMPILKAN PREVIEW STRUK) --}}
                            <div class="card-header bg-white pt-4 pb-0 border-bottom-0 text-center">
                                <h3 class="mb-1 text-success"><i class="fe fe-check-circle me-2"></i>Bukti Berhasil
                                    Dikirim</h3>
                                <span class="text-muted small">Berikut adalah bukti transfer yang telah Anda
                                    unggah.</span>
                            </div>

                            <div class="card-body py-4 text-center">
                                <div class="mb-4 mt-2">
                                    <div class="p-2 border rounded d-inline-block bg-white shadow-sm bg-light">
                                        <img src="{{ asset('storage/' . $transaction->payment_proof) }}"
                                            alt="Bukti Transfer User" class="img-fluid rounded"
                                            style="max-width: 300px; max-height: 400px; object-fit: contain;">
                                    </div>
                                </div>

                                <div class="alert alert-warning text-start small border-0 shadow-sm mx-md-4 mb-4">
                                    <h6 class="fw-bold text-warning-dark mb-1"><i class="fe fe-info me-2"></i>Dalam
                                        Proses Peninjauan</h6>
                                    Admin sedang mencocokkan mutasi masuk sebesar <strong>Rp
                                        {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong>. Mohon
                                    bersabar, halaman ini akan otomatis berubah setelah disetujui oleh Admin.
                                </div>

                                <div class="d-grid gap-2 mx-md-4">
                                    <a href="{{ route('riwayat') }}" class="btn btn-primary btn-lg">
                                        <i class="fe fe-arrow-left me-2"></i>Kembali ke Riwayat
                                    </a>
                                </div>
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT TIMER HANYA BERJALAN JIKA BELUM UPLOAD --}}
    @if (empty($transaction->payment_proof))
        <script>
            const expiredDate = new Date("{{ $transaction->expired_at }}").getTime();

            const timer = setInterval(function() {
                const now = new Date().getTime();
                const distance = expiredDate - now;

                if (distance < 0) {
                    clearInterval(timer);
                    document.getElementById("countdown").innerHTML = "KEDALUWARSA";
                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("countdown").innerHTML =
                    String(hours).padStart(2, '0') + ":" +
                    String(minutes).padStart(2, '0') + ":" +
                    String(seconds).padStart(2, '0');

            }, 1000);
        </script>
    @endif

    <!-- Scroll top -->
    @include('partials.btn-scroll-top')
    <!-- Scripts -->
    @include('partials.scripts')
    <script src="assets/js/vendors/tnsSlider.js"></script>
    <script src="assets/js/vendors/chart.js"></script>
    <script src="assets/js/vendors/navbar-nav.js"></script>
</body>

</html>
