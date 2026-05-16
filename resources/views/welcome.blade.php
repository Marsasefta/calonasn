@extends('layouts.landing')
@push('styles')
    <style>
        :root {
            --color-primary: #1e40af;
            --color-secondary: #3b82f6;
            --color-accent: #06b6d4;
            --color-success: #10b981;
            --color-light: #f8fafc;
            --color-light-blue: #e0f2fe;
            --color-gradient-start: #1e40af;
            --color-gradient-end: #3b82f6;
            --color-text-dark: #1e293b;
            --color-text-muted: #64748b;
            --shadow-light: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-medium: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-large: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: #ffffff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--color-light-blue) 0%, #ffffff 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23e0f2fe" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23e0f2fe" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%233b82f6" opacity="0.05"/><circle cx="10" cy="50" r="0.5" fill="%233b82f6" opacity="0.05"/><circle cx="90" cy="30" r="0.5" fill="%233b82f6" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
        }

        .hero-title {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeInUp 1s ease-out;
        }

        .hero-subtitle {
            color: var(--color-text-muted);
            animation: fadeInUp 1.2s ease-out;
        }

        .hero-buttons {
            animation: fadeInUp 1.4s ease-out;
        }

        .hero-image {
            animation: slideInRight 1.6s ease-out;
            position: relative;
        }

        .hero-image::after {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-success) 100%);
            border-radius: 50%;
            opacity: 0.1;
            z-index: -1;
            animation: pulse 3s infinite;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, var(--color-light) 100%);
            border: 1px solid rgba(59, 130, 246, 0.1);
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-success) 100%);
            transition: width 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-large);
        }

        .stat-card:hover::before {
            width: 100%;
        }

        .stat-number {
            background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-success) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }

        .feature-card {
            background: #ffffff;
            border: 1px solid rgba(59, 130, 246, 0.1);
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-success) 100%);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-12px);
            box-shadow: var(--shadow-large);
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--color-light-blue) 0%, rgba(59, 130, 246, 0.1) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
            background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-success) 100%);
            color: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 32px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .btn-outline-primary {
            border: 2px solid var(--color-primary);
            color: var(--color-primary);
            border-radius: 12px;
            padding: 12px 32px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--color-primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .cta-section {
            background: linear-gradient(135deg, var(--color-gradient-start) 0%, var(--color-gradient-end) 100%);
            border-radius: 24px;
            padding: 4rem 2rem;
            margin: 4rem 0;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="60" cy="30" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="30" cy="70" r="0.5" fill="rgba(255,255,255,0.1)"/></svg>');
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }

            100% {
                transform: translate(-20px, -20px) rotate(360deg);
            }
        }

        .section-title {
            color: var(--color-text-dark);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: var(--color-text-muted);
            font-size: 1.125rem;
            line-height: 1.75;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .stat-card,
            .feature-card {
                margin-bottom: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <main>
        <section class="py-xl-9 py-6 bg-white">
            <div class="container py-xl-4">
                <div class="row align-items-center gy-6 gy-xl-0">
                    <div class="col-lg-6 col-12">
                        <div class="d-flex flex-column gap-4 pe-lg-5">
                            <div class="d-flex flex-row gap-2 align-items-center">
                                <span class="fs-4">🚀</span>
                                <span class="text-primary fw-semibold text-uppercase tracking-wider fs-6">
                                    Platform Tryout CPNS Standar CAT BKN Terbaru
                                </span>
                            </div>

                            <div class="d-flex flex-column gap-3">
                                <h1 class="mb-0 display-3 fw-xl-bolder fw-bold text-dark lh-sm">
                                    Taklukkan Seleksi CPNS dengan Simulasi Terakurat
                                </h1>
                                <p class="mb-0 text-muted fs-4 lh-base">
                                    Latih kesiapanmu dengan platform ujian yang dirancang 100% mirip dengan sistem asli.
                                    Rasakan atmosfer ujian riil, ukur skor Passing Grade secara instan, dan amankan NIP
                                    impianmu.
                                </p>
                            </div>

                            <div class="d-flex flex-wrap gap-3 mt-2">
                                {{-- Tombol Demo: Magnet Paling Ampuh --}}
                                <a href="#"
                                    class="btn btn-success btn-lg px-4 py-3 border-0 shadow-sm text-white fw-bold">
                                    <i class="fe fe-play-circle me-2 fs-4 align-middle"></i> Coba Demo Gratis (5 Soal)
                                </a>

                                @guest
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4 py-3 fw-bold">
                                        Daftar Akun Baru <i class="fe fe-arrow-right ms-2"></i>
                                    </a>
                                @else
                                    <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg px-4 py-3 fw-bold">
                                        Beli Paket Premium <i class="fe fe-shopping-cart ms-2"></i>
                                    </a>
                                @endguest
                            </div>

                            <div class="d-flex flex-row gap-4 align-items-center mt-2 text-muted small">
                                <span><i class="fe fe-check text-success me-1"></i> Tanpa Install Aplikasi</span>
                                <span><i class="fe fe-check text-success me-1"></i> Langsung Mulai Sekali Klik</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-12 text-center">
                        <div class="bg-light p-4 p-md-5 rounded-4 border shadow-sm">
                            <div
                                class="badge bg-danger-soft text-danger mb-3 px-3 py-2 fw-bold text-uppercase tracking-wider">
                                ⚡ Penawaran Terbatas Minggu Ini
                            </div>
                            <h3 class="text-dark fw-bold mb-1">Paket Tryout Mandiri Premium</h3>
                            <p class="text-muted small mb-4">Akses penuh ke seluruh sistem penilaian otomatis & kunci
                                pembahasan lengkap.</p>

                            <div class="py-3 mb-4 bg-white rounded border">
                                <span class="text-muted small text-decoration-line-through d-block mb-1">Harga Normal: Rp
                                    99.000</span>
                                <h1 class="display-4 fw-bolder text-primary mb-0">Rp 20.000 <span
                                        class="fs-4 text-muted fw-normal">/paket</span></h1>
                            </div>

                            <ul class="list-unstyled text-start mx-auto my-4 d-flex flex-column gap-3 text-dark fw-medium"
                                style="max-width: 380px;">
                                <li class="d-flex align-items-start">
                                    <i class="fe fe-check-circle text-success me-3 mt-1 fs-5"></i>
                                    <span>110 Soal Standar <strong>HOTS Terbaru 2026</strong></span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="fe fe-check-circle text-success me-3 mt-1 fs-5"></i>
                                    <span>Skor Real-Time Kelulusan (TWK, TIU, TKP)</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="fe fe-check-circle text-success me-3 mt-1 fs-5"></i>
                                    <span>Kunci Jawaban & Trik Pembahasan Cepat</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="fe fe-check-circle text-success me-3 mt-1 fs-5"></i>
                                    <span>Akses Selamanya Tanpa Biaya Bulanan</span>
                                </li>
                            </ul>

                            @guest
                                <div class="d-grid mt-4">
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg py-3 fw-bold shadow">
                                        Amankan Paket Premium Sekarang <i class="fe fe-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            @else
                                <div class="d-grid mt-4">
                                    <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg py-3 fw-bold shadow">
                                        Beli Sekarang via QRIS <i class="fe fe-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-xl-8 py-6 bg-light border-top border-bottom">
            <div class="container">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-8 col-12">
                        <h2 class="display-4 fw-bold text-dark mb-2">Mengapa Berlatih di CalonASN.id?</h2>
                        <p class="lead text-muted">Investasi kecil seharga segelas es kopi untuk melipatgandakan peluang
                            kelulusan NIP kamu.</p>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 col-lg-3 col-12">
                        <div class="card h-100 border-0 shadow-sm p-4 rounded-3 bg-white text-center">
                            <div class="icon-shape icon-lg bg-primary-soft text-primary rounded-circle mb-4 mx-auto"
                                style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background-color: #e6f0ff;">
                                <i class="fe fe-monitor fs-3"></i>
                            </div>
                            <h4 class="fw-bold mb-2 text-dark">Simulasi CAT Akurat</h4>
                            <p class="text-muted small mb-0">Tampilan tombol navigasi nomor, waktu mundur, dan panel soal
                                dirancang presisi mengikuti ujian CAT BKN asli.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-12">
                        <div class="card h-100 border-0 shadow-sm p-4 rounded-3 bg-white text-center">
                            <div class="icon-shape icon-lg bg-success-soft text-success rounded-circle mb-4 mx-auto"
                                style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background-color: #e6f7ed;">
                                <i class="fe fe-bar-chart-2 fs-3"></i>
                            </div>
                            <h4 class="fw-bold mb-2 text-dark">Analisis Instan</h4>
                            <p class="text-muted small mb-0">Nilai sub-materi TWK, TIU, dan TKP langsung pecah otomatis
                                sesaat setelah tombol selesai ujian kamu klik.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-12">
                        <div class="card h-100 border-0 shadow-sm p-4 rounded-3 bg-white text-center">
                            <div class="icon-shape icon-lg bg-warning-soft text-warning rounded-circle mb-4 mx-auto"
                                style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background-color: #fff9e6;">
                                <i class="fe fe-book-open fs-3"></i>
                            </div>
                            <h4 class="fw-bold mb-2 text-dark">Soal Kriteria HOTS</h4>
                            <p class="text-muted small mb-0">Bank soal berkualitas tinggi yang diperbarui sesuai kisi-kisi
                                permenpan-RB terbaru untuk melatih kepekaan logika.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-12">
                        <div class="card h-100 border-0 shadow-sm p-4 rounded-3 bg-white text-center">
                            <div class="icon-shape icon-lg bg-danger-soft text-danger rounded-circle mb-4 mx-auto"
                                style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background-color: #ffe6e6;">
                                <i class="fe fe-zap fs-3"></i>
                            </div>
                            <h4 class="fw-bold mb-2 text-dark">Trik Solusi Cepat</h4>
                            <p class="text-muted small mb-0">Menu riwayat pembahasan menyediakan metode eliminasi opsi
                                jawaban buruk agar menghemat waktu pengerjaan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-xl-8 py-6 bg-white">
            <div class="container">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-6 col-12">
                        <h2 class="display-5 fw-bold text-dark">3 Langkah Mudah Memulai</h2>
                        <p class="text-muted">Tidak pakai ribet, beres beli langsung bisa simulasi detik ini juga.</p>
                    </div>
                </div>

                <div class="row g-4 text-center">
                    <div class="col-md-4 col-12">
                        <div class="p-3">
                            <h1 class="display-3 fw-bold text-primary-soft mb-2 opacity-50" style="color: #cbdffa;">01
                            </h1>
                            <h4 class="fw-bold text-dark">Registrasi & QRIS</h4>
                            <p class="text-muted small mx-auto" style="max-width: 280px;">Buat akun barumu secara instan,
                                lakukan pembayaran murah aman via scan kode QRIS otomatis.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="p-3">
                            <h1 class="display-3 fw-bold text-primary-soft mb-2 opacity-50" style="color: #cbdffa;">02
                            </h1>
                            <h4 class="fw-bold text-dark">Simulasi Ujian</h4>
                            <p class="text-muted small mx-auto" style="max-width: 280px;">Kerjakan simulasi CAT mandiri
                                berdurasi penuh kapan saja dari laptop atau handphone-mu.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="p-3">
                            <h1 class="display-3 fw-bold text-primary-soft mb-2 opacity-50" style="color: #cbdffa;">03
                            </h1>
                            <h4 class="fw-bold text-dark">Evaluasi Kelulusan</h4>
                            <p class="text-muted small mx-auto" style="max-width: 280px;">Buka lembar riwayat evaluasi
                                nilai, pelajari trik materi yang salah, dan ulangi hingga paham.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="/build/assets/js/vendors/tnsSlider.js"></script>
@endpush
