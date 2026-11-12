<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <title>Selesaikan Pembayaran | CalonASN.id</title>
    <style>
        body {
            background-color: #f8fafc;
        }

        .payment-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background: #ffffff;
            transition: transform 0.3s ease;
        }

        .payment-card:hover {
            transform: translateY(-5px);
        }

        .gradient-header {
            background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);
            color: white;
            padding: 2.5rem 2rem 4rem;
            text-align: center;
        }

        .timer-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            letter-spacing: 1px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: inline-block;
        }

        .qr-wrapper {
            background: white;
            padding: 1.5rem;
            border-radius: 24px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
            display: inline-block;
            margin: -3.5rem auto 2rem;
            border: 4px solid #f8fafc;
            position: relative;
            z-index: 10;
        }

        .qr-wrapper img {
            max-width: 220px;
            border-radius: 12px;
        }

        .upload-zone {
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            background: #f8fafc;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .upload-zone:hover {
            border-color: #4f46e5;
            background: #f1f5f9;
        }

        .upload-zone input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .btn-glow {
            background: linear-gradient(135deg, #4f46e5, #0ea5e9);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
        }

        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4);
            color: white;
        }

        .price-tag {
            font-size: 2.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #0f172a, #334155);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body>
    @include('partials.navbar')
    @include('partials.navbar-student')

    <div class="container py-5 mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10">

                @if (session('info'))
                    <div class="alert alert-info border-0 shadow-sm rounded-4 mb-4">
                        <i class="fe fe-info me-2"></i> {{ session('info') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                        <i class="fe fe-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="payment-card mb-4">

                    @if (empty($transaction->payment_proof))
                        <!-- HEADER GRADIENT -->
                        <div class="gradient-header">
                            <h2 class="fw-bold mb-2 text-white">Selesaikan Pembayaran</h2>
                            <p class="text-white-50 mb-4 px-3">Pindai kode QRIS di bawah ini menggunakan aplikasi
                                E-Wallet atau Mobile Banking Anda.</p>

                            <div class="timer-badge">
                                <i class="fe fe-clock me-1"></i> Sisa Waktu: <span id="countdown">Menghitung...</span>
                            </div>
                        </div>

                        <!-- BODY QR & UPLOAD -->
                        <div class="card-body px-4 px-md-5 text-center pb-5">
                            <div class="qr-wrapper">
                                <img src="{{ asset('image/qris.jpeg') }}" alt="QRIS Payment">
                                <div class="mt-3">
                                    <a href="{{ asset('image/qris.jpeg') }}"
                                        download="QRIS_{{ $transaction->invoice_number }}.jpeg"
                                        class="text-primary fw-bold small text-decoration-none bg-light px-3 py-2 rounded-pill shadow-sm">
                                        <i class="fe fe-download me-1"></i> Simpan Kode QR
                                    </a>
                                </div>
                            </div>

                            <div class="mb-4 mt-2">
                                <p class="text-muted small text-uppercase fw-bold tracking-wider mb-1">Total Pembayaran
                                </p>
                                <h1 class="price-tag mb-0 lh-1">Rp
                                    {{ number_format($transaction->total_amount, 0, ',', '.') }}</h1>

                                @if ($transaction->discount_amount > 0)
                                    <div class="badge bg-success text-white mt-3 px-3 py-2 rounded-pill shadow-sm">
                                        <i class="fe fe-gift me-1"></i> Promo Terpakai: Hemat Rp
                                        {{ number_format($transaction->discount_amount, 0, ',', '.') }}
                                    </div>
                                @endif

                                <p class="text-muted small mt-3 mb-0">No. Invoice: <strong
                                        class="text-dark">{{ $transaction->invoice_number }}</strong></p>
                            </div>

                            <hr class="my-4 border-light">

                            <h5 class="fw-bold text-dark mb-2">Konfirmasi Pembayaran</h5>
                            <p class="text-muted small mb-4">Sudah transfer? Wajib unggah bukti transfer/screenshot agar
                                Admin dapat segera memverifikasi pesanan Anda.</p>

                            @if ($errors->any())
                                <div class="alert alert-danger border-0 text-start small mb-4 rounded-3 shadow-sm">
                                    <ul class="mb-0 list-unstyled">
                                        @foreach ($errors->all() as $error)
                                            <li><i class="fe fe-alert-circle me-1"></i> {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('payment.upload', $transaction->invoice_number) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="upload-zone mb-4" id="upload-zone">
                                    <input type="file" id="payment_proof" name="payment_proof"
                                        accept="image/jpeg,image/png,image/jpg" required
                                        onchange="previewFileName(this)">
                                    <i class="fe fe-upload-cloud fs-1 text-primary mb-2 d-block"></i>
                                    <h6 class="fw-bold mb-1">Klik atau Tarik File Bukti Transfer</h6>
                                    <p class="text-muted small mb-0" id="file-name">Format JPG, JPEG, PNG (Maks 15MB)
                                    </p>
                                </div>

                                <button type="submit" class="btn btn-glow w-100">
                                    Kirim Bukti Pembayaran <i class="fe fe-arrow-right ms-2"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- STATUS REVIEW -->
                        <div class="gradient-header py-5"
                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding-bottom: 3rem;">
                            <h2 class="fw-bold mb-2 text-white"><i class="fe fe-check-circle me-2"></i>Bukti Diterima
                            </h2>
                            <p class="text-white-50 mb-0">Pembayaran Anda sedang dalam proses verifikasi Admin</p>
                        </div>
                        <div class="card-body px-4 px-md-5 text-center pb-5">
                            <div class="qr-wrapper mt-0 mb-4"
                                style="border-radius: 16px; padding: 0.5rem; max-width: 250px;">
                                <img src="{{ asset('storage/' . $transaction->payment_proof) }}"
                                    alt="Bukti Transfer User" class="img-fluid rounded" style="object-fit: contain;">
                            </div>

                            <p class="text-muted small text-uppercase fw-bold tracking-wider mb-1">Total Tagihan</p>
                            <h2 class="fw-bold text-dark mb-4 lh-1">Rp
                                {{ number_format($transaction->total_amount, 0, ',', '.') }}</h2>

                            <div class="alert bg-light border-0 text-start small p-3 rounded-4 mb-4">
                                <strong><i class="fe fe-info me-1"></i> Mohon Bersabar</strong><br>
                                Admin sedang memverifikasi mutasi bank. Halaman ini akan berubah otomatis setelah
                                transaksi disetujui, atau Anda dapat mengecek status di Riwayat Transaksi.
                            </div>

                            <a href="{{ route('riwayat') }}"
                                class="btn btn-outline-primary w-100 py-3 rounded-pill fw-bold">
                                <i class="fe fe-clock me-2"></i> Cek Riwayat Transaksi
                            </a>
                        </div>
                    @endif
                </div>

                <div class="text-center mt-3 opacity-75">
                    <span class="text-muted small fw-medium">Transaksi Aman & Terverifikasi</span>
                </div>
            </div>
        </div>
    </div>

    @if (empty($transaction->payment_proof))
        <script>
            const expiredDate = new Date("{{ $transaction->expired_at }}").getTime();
            const timer = setInterval(function() {
                const now = new Date().getTime();
                const distance = expiredDate - now;

                if (distance < 0) {
                    clearInterval(timer);
                    document.getElementById("countdown").innerHTML = "WAKTU HABIS";
                    setTimeout(() => window.location.reload(), 1500);
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

            function previewFileName(input) {
                const fileName = input.files[0] ? input.files[0].name : "Format JPG, JPEG, PNG (Maks 15MB)";
                const textElement = document.getElementById('file-name');
                textElement.innerHTML = `<strong class="text-primary">${fileName}</strong>`;
            }
        </script>
    @endif

    @include('partials.scripts')
</body>

</html>
