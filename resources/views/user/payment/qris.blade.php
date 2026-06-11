<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Upgrade Paket Premium</title>
    <style>
        /* Desain kustom agar komponen accordion selaras dengan tema modern */
        .accordion-button:not(.collapsed) {
            background-color: rgba(13, 110, 253, 0.05);
            color: #0d6efd;
            box-shadow: none;
        }
        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(13, 110, 253, 0.25);
        }
        .copy-btn {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .copy-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    @include('partials.navbar')
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
                            {{-- KONDISI A: JIKA BELUM UPLOAD BUKTI (TAMPILKAN PILIHAN METODE ACCORDION & FORM) --}}
                            <div class="card-header bg-white pt-4 pb-2 border-bottom-0 text-center">
                                <h3 class="mb-1">Pilih Metode Pembayaran</h3>
                                <span class="text-muted small">Silakan pilih salah satu opsi pembayaran di bawah ini.</span>
                            </div>

                            <div class="card-body py-2">
                                
                                <div class="accordion mb-4 shadow-sm" id="paymentAccordion">
                                    
                                    <div class="accordion-item border-0 border-bottom">
                                        <h2 class="accordion-header" id="headingQris">
                                            <button class="accordion-button fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseQris" aria-expanded="true" aria-controls="collapseQris">
                                                <i class="fe fe-scan text-primary me-2 fs-4"></i> QRIS
                                            </button>
                                        </h2>
                                        <div id="collapseQris" class="accordion-collapse collapse " aria-labelledby="headingQris" data-bs-parent="#paymentAccordion">
                                            <div class="accordion-body text-center bg-white py-4">
                                                <div class="p-2 border rounded d-inline-block bg-white shadow-sm mb-3">
                                                    <img src="{{ asset('image/qris.jpeg') }}" alt="QRIS Payment" class="img-fluid" style="max-width: 220px;">
                                                </div>
                                                <div>
                                                    <a href="{{ asset('image/qris.jpeg') }}"
                                                        download="QRIS_Pembayaran_{{ $transaction->invoice_number }}.jpeg"
                                                        class="btn btn-outline-primary btn-sm fw-bold shadow-sm">
                                                        <i class="fe fe-download me-2"></i> Simpan / Unduh QRIS
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item border-0 border-bottom">
                                        <h2 class="accordion-header" id="headingMandiri">
                                            <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMandiri" aria-expanded="false" aria-controls="collapseMandiri">
                                                <i class="fe fe-credit-card text-info me-2"></i> Transfer Bank Mandiri
                                            </button>
                                        </h2>
                                        <div id="collapseMandiri" class="accordion-collapse collapse" aria-labelledby="headingMandiri" data-bs-parent="#paymentAccordion">
                                            <div class="accordion-body bg-white py-4">
                                                <div class="bg-light p-3 rounded border">
                                                    <span class="text-muted small d-block mb-1">Nama Bank:</span>
                                                    <h5 class="fw-bold text-dark mb-3">Bank Mandiri</h5>
                                                    
                                                    <span class="text-muted small d-block mb-1">Nomor Rekening:</span>
                                                    <div class="d-flex align-items-center mb-3">
                                                        <h4 class="fw-bold text-primary mb-0 me-3" id="norekMandiri">1370023310705</h4>
                                                        <button class="btn btn-sm btn-light border copy-btn text-dark py-1 px-2 fw-medium" onclick="copyText('1370023310705', this)">
                                                            <i class="fe fe-copy me-1"></i>Salin
                                                        </button>
                                                    </div>

                                                    <span class="text-muted small d-block mb-1">Nama Pemilik Rekening:</span>
                                                    <h5 class="fw-bold text-dark mb-0">FENTHA LARI LESMANA</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header" id="headingBsi">
                                            <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBsi" aria-expanded="false" aria-controls="collapseBsi">
                                                <i class="fe fe-credit-card text-success me-2"></i> Transfer Bank BSI
                                            </button>
                                        </h2>
                                        <div id="collapseBsi" class="accordion-collapse collapse" aria-labelledby="headingBsi" data-bs-parent="#paymentAccordion">
                                            <div class="accordion-body bg-white py-4">
                                                <div class="bg-light p-3 rounded border">
                                                    <span class="text-muted small d-block mb-1">Nama Bank:</span>
                                                    <h5 class="fw-bold text-dark mb-3">Bank Syariah Indonesia (BSI)</h5>
                                                    
                                                    <span class="text-muted small d-block mb-1">Nomor Rekening:</span>
                                                    <div class="d-flex align-items-center mb-3">
                                                        <h4 class="fw-bold text-primary mb-0 me-3" id="norekBsi">6913630680</h4>
                                                        <button class="btn btn-sm btn-light border copy-btn text-dark py-1 px-2 fw-medium" onclick="copyText('6913630680', this)">
                                                            <i class="fe fe-copy me-1"></i>Salin
                                                        </button>
                                                    </div>

                                                    <span class="text-muted small d-block mb-1">Nama Pemilik Rekening:</span>
                                                    <h5 class="fw-bold text-dark mb-0">FENTHA LARI LESMANA</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <hr class="my-4">

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
                                    <div class="p-2 border rounded d-inline-block bg-white shadow-sm">
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

            // Fungsi pembantu JavaScript untuk menyalin nomor rekening secara instan
            function copyText(text, element) {
                navigator.clipboard.writeText(text).then(() => {
                    const originalText = element.innerHTML;
                    element.innerHTML = '<i class="fe fe-check me-1"></i>Tersalin!';
                    element.classList.remove('btn-light');
                    element.classList.add('btn-success', 'text-white');
                    
                    setTimeout(() => {
                        element.innerHTML = originalText;
                        element.classList.remove('btn-success', 'text-white');
                        element.classList.add('btn-light');
                    }, 2000);
                }).catch(err => {
                    console.error('Gagal menyalin teks: ', err);
                });
            }
        </script>
    @endif

    @include('partials.btn-scroll-top')
    @include('partials.scripts')
    <script src="assets/js/vendors/tnsSlider.js"></script>
    <script src="assets/js/vendors/chart.js"></script>
    <script src="assets/js/vendors/navbar-nav.js"></script>
</body>

</html>