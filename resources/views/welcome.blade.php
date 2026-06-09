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

        /* Efek memperbesar gambar secara smooth saat card disentuh */
        .blog-card:hover img {
            transform: scale(1.06);
        }

        /* Efek panah bergeser ke kanan saat tombol Baca Selengkapnya disentuh */
        .blog-card:hover .blog-read-more-btn i {
            transform: translateX(4px);
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

        .hover-lift:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endpush

@section('content')
    <main>
        <section class="py-xl-9 py-6" bg-white>
            <div class="container py-xl-4">
                <div class="row align-items-center gy-6 gy-xl-0">
                    <div class="col-lg-6 col-12">
                        <div class="d-flex flex-column gap-4 pe-lg-5">
                            <div class="d-flex flex-row gap-2 align-items-center">
                                <span class="fs-4">🚀</span>
                                <!-- Diubah ke H2 sebagai sub-topik pengantar (opsional tapi baik untuk SEO) -->
                                <h2 class="text-primary fw-semibold text-uppercase tracking-wider fs-6 mb-0">
                                    Platform Tryout CPNS Standar CAT BKN Terbaru
                                </h2>
                            </div>

                            <div class="d-flex flex-column gap-3">
                                <h1 class="mb-0 display-4 fw-xl-bolder fw-bold text-dark lh-sm">
                                    Taklukkan SKD CPNS 2026: <span class="text-primary">Belajar GRATIS</span> & Tryout CAT
                                </h1>

                                <div
                                    class="alert alert-success border-0 shadow-sm py-2 px-3 mt-3 d-inline-flex align-items-center gap-2 flex-nowrap">
                                    <span>🎁</span>
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <span>Daftar sekarang, dapatkan akses</span>
                                        <span class="fw-bold text-dark">Materi TWK, TIU, TKP 100% GRATIS!</span>
                                    </div>
                                </div>

                                <p class="mb-0 text-muted fs-5 lh-base">
                                    Jangan buang waktu mencari materi yang berceceran. Pelajari rangkuman materi terlengkap
                                    secara cuma-cuma, lalu latih kesiapanmu dengan platform CAT BKN terakurat.
                                </p>
                            </div>

                            <div class="d-flex flex-wrap gap-3 mt-4">
                                @guest
                                    {{-- <a href="{{ route('register') }}"
                                        class="btn btn-primary btn-lg px-4 py-3 fw-bold shadow-sm">
                                        <i class="fe fe-unlock ms-1"></i> Daftar & Buka Materi Gratis
                                    </a> --}}
                                    <a href="{{ route('demo.cat') }}" class="btn btn-outline-dark btn-lg px-4 py-3 fw-bold">
                                        Coba Demo CAT
                                    </a>
                                @else
                                    {{-- <a href="{{ route('materi.index') }}"
                                        class="btn btn-primary btn-lg px-4 py-3 fw-bold shadow-sm">
                                        Lanjut Belajar <i class="fe fe-book-open ms-2"></i>
                                    </a> --}}
                                    <a href="{{ route('checkout') }}" class="btn btn-success btn-lg px-4 py-3 fw-bold">
                                        Beli Paket Tryout <i class="fe fe-shopping-cart ms-2"></i>
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
                        <div
                            class="bg-white p-4 p-md-5 rounded-4 border border-2 border-primary shadow-lg position-relative overflow-hidden">
                            <div class="position-absolute top-0 end-0 bg-danger text-white px-4 py-1 small fw-bold"
                                style="border-bottom-left-radius: 12px;">
                                TERBATAS!
                            </div>

                            <div
                                class="badge bg-success-soft text-success mb-3 px-3 py-2 fw-bold text-uppercase tracking-wider">
                                🎁 Spesial Pendaftar Hari Ini
                            </div>

                            <h2 class="h3 text-dark fw-bold mb-2">Akses Ratusan Materi CPNS</h2>
                            <p class="text-muted small mb-4">Buat akun sekarang dan dapatkan akses langsung ke rangkuman
                                materi TWK, TIU, dan TKP.</p>

                            <div class="py-3 mb-4 bg-light rounded border border-success border-opacity-25">
                                <span class="text-muted small d-block mb-1">
                                    Biaya Pendaftaran:
                                </span>
                                <p class="display-4 fw-bolder text-success mb-0">
                                    100% GRATIS
                                </p>
                            </div>

                            <ul class="list-unstyled text-start mx-auto my-4 d-flex flex-column gap-3 text-dark fw-medium"
                                style="max-width: 380px;">
                                <li class="d-flex align-items-start">
                                    <i class="fe fe-check-circle text-primary me-3 mt-1 fs-5"></i>
                                    <span>Buka Akses <strong>Materi Rahasia SKD</strong></span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="fe fe-check-circle text-primary me-3 mt-1 fs-5"></i>
                                    <span>Trik Cepat Jawab Soal Kurang dari 1 Menit</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="fe fe-check-circle text-primary me-3 mt-1 fs-5"></i>
                                    <span>Coba Sistem Simulasi CAT BKN Asli</span>
                                </li>
                            </ul>

                            @guest
                                <div class="d-grid mt-4">
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg py-3 fw-bold shadow-sm">
                                        Buat Akun Gratis Sekarang <i class="fe fe-arrow-right ms-2"></i>
                                    </a>
                                </div>
                                <p class="text-muted small mt-3 mb-0"><i class="fe fe-clock me-1"></i> Proses daftar cuma butuh
                                    1 menit.</p>
                            @else
                                <div class="d-grid mt-4">
                                    <a href="{{ route('materi.index') }}" class="btn btn-primary btn-lg py-3 fw-bold shadow-sm">
                                        Buka Dashboard Materi Saya <i class="fe fe-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-xl-8 py-6" style="background-color: #f7f9fb;">
            <div class="container">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-7">
                        <span
                            class="badge bg-primary-soft text-primary px-3 py-2 fw-bold text-uppercase rounded-pill mb-3 shadow-sm">
                            <i class="bi bi-tags-fill me-1"></i> Investasi Sekali Bayar
                        </span>
                        <h2 class="display-5 fw-bold text-dark mb-3">
                            Persiapkan SKD CPNS 2026 dari Sekarang!
                        </h2>
                        <p class="lead text-muted">
                            Pelajari materi SKD CPNS 2026, latihan soal, dan ikuti tryout CAT dengan pembahasan lengkap. Akses selamanya tanpa biaya langganan bulanan.
                        </p>

                        <div class="alert alert-success d-inline-block px-4 py-2 mt-2 shadow-sm border border-success"
                            role="alert">
                            <i class="bi bi-ticket-perforated-fill me-2 fs-5"></i>
                            Gunakan kode promo <strong class="fs-5 ms-1">ASN2026</strong> untuk potongan ekstra <strong>Rp
                                7.000</strong>!
                        </div>
                    </div>
                </div>

                <div class="row g-4 justify-content-center align-items-stretch">

                    <div class="col-lg-5 col-md-6 d-flex">
                        <div
                            class="card w-100 border-0 shadow-sm rounded-4 p-4 p-md-5 d-flex flex-column bg-white transition-hover">
                            <div class="mb-4">
                                <span class="badge bg-secondary px-3 py-1 rounded-pill mb-2 fw-semibold">
                                    Paket Latihan
                                </span>
                                <h3 class="fw-bold text-dark mb-1">Tryout Premium CPNS</h3>
                                <p class="text-muted small">Fokus latih manajemen waktu dengan simulasi CAT.</p>

                                <div class="mt-4 p-3 bg-light rounded-3 border">
                                    <p class="text-muted small mb-1">Investasi Normal:</p>
                                    <p class="display-5 fw-bolder text-dark mb-0">
                                        Rp 20.000 <span class="fs-6 text-muted fw-normal">/selamanya</span>
                                    </p>
                                    <div class="mt-2 pt-2 border-top border-secondary border-opacity-25">
                                        <span class="badge bg-success text-white px-2 py-1 small">
                                            <i class="bi bi-tag-fill me-1"></i> + Kode ASN2026 jadi: <strong
                                                class="fs-6">Rp 13.000</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <ul class="list-unstyled d-flex flex-column gap-3 text-dark fw-medium mb-5">
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                    <span>110 Soal Standar <strong>FR (Field Report) 2024</strong></span>
                                </li>
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                    <span>Skor Real-Time Kelulusan (TWK, TIU, TKP)</span>
                                </li>
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                    <span>Kunci Jawaban & Pembahasan</span>
                                </li>
                                <li class="d-flex align-items-start small text-muted">
                                    <i class="bi bi-x-circle-fill text-danger opacity-50 me-2 mt-1"></i>
                                    <span class="text-decoration-line-through">Akses Ratusan Materi Micro-Learning</span>
                                </li>
                                <li class="d-flex align-items-start small text-muted">
                                    <i class="bi bi-x-circle-fill text-danger opacity-50 me-2 mt-1"></i>
                                    <span class="text-decoration-line-through">Trik Rahasia Jawab Cepat</span>
                                </li>
                            </ul>

                            <div class="mt-auto">
                                @guest
                                    <a href="{{ route('register', ['package' => 'tryout-only']) }}"
                                        class="btn btn-outline-dark rounded-pill py-3 fw-bold w-100">
                                        Pilih Paket Latihan
                                    </a>
                                @else
                                    <a href="{{ route('checkout', ['package' => 'tryout-only']) }}"
                                        class="btn btn-outline-dark rounded-pill py-3 fw-bold w-100">
                                        Lanjut Pembayaran
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-6 d-flex">
                        <div class="card w-100 border-2 border-primary shadow-lg rounded-4 p-4 p-md-5 d-flex flex-column bg-white position-relative overflow-hidden hover-lift"
                            style="transform: scale(1.02); z-index: 10;">

                            <div class="position-absolute top-0 end-0 bg-primary text-white px-4 py-2 small fw-bold shadow-sm"
                                style="border-bottom-left-radius: 16px;">
                                ⭐ PALING BANYAK DIPILIH
                            </div>

                            <div class="mb-4 mt-2">
                                <span class="badge bg-primary-soft text-primary px-3 py-1 rounded-pill mb-2 fw-bold">
                                    Paket Super Lengkap
                                </span>
                                <h3 class="fw-bold text-dark mb-1">Tryout Premium + Materi Pembelajaran (Micro Learning)
                                </h3>
                                <p class="text-muted small">Solusi instan: Paham materinya, taklukkan simulasinya.</p>

                                <div class="mt-4 p-3 bg-primary-soft rounded-3 border border-primary border-opacity-25">
                                    <p class="text-primary small mb-1 fw-semibold">Investasi Normal:</p>
                                    <p class="display-5 fw-bolder text-primary mb-0">
                                        Rp 49.000 <span class="fs-6 text-muted fw-normal">/selamanya</span>
                                    </p>
                                    <div class="mt-2 pt-2 border-top border-primary border-opacity-25">
                                        <span class="badge bg-primary text-white px-2 py-1 small shadow-sm">
                                            <i class="bi bi-tag-fill me-1"></i> + Kode ASN2026 jadi: <strong
                                                class="fs-6 text-warning">Rp 42.000</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <ul class="list-unstyled d-flex flex-column gap-3 text-dark fw-medium mb-5">
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                    <span><strong>Semua Fitur Paket Tryout Mandiri</strong></span>
                                </li>
                                <li
                                    class="d-flex align-items-start small p-2 bg-white rounded-3 shadow-sm border border-primary border-opacity-10">
                                    <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                    <span class="text-primary"><strong>Akses Penuh Materi Pembelajaran
                                            (Micro-Learning)</strong></span>
                                </li>
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                    <span>Update Kisi-Kisi CPNS BKN 2026</span>
                                </li>
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                    <span>Trik Rahasia Jawab Soal Kurang dari 1 Menit</span>
                                </li>
                                <li class="d-flex align-items-start small">
                                    <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                                    <span>Akses Fleksibel via HP/Laptop Kapan Saja</span>
                                </li>
                            </ul>

                            <div class="mt-auto">
                                @guest
                                    <a href="{{ route('register', ['package' => 'tryout-pdf']) }}"
                                        class="btn btn-primary rounded-pill py-3 fw-bold w-100 shadow">
                                        Amankan Paket Lengkap <i class="bi bi-arrow-right ms-2"></i>
                                    </a>
                                @else
                                    <a href="{{ route('checkout', ['package' => 'tryout-pdf']) }}"
                                        class="btn btn-primary rounded-pill py-3 fw-bold w-100 shadow">
                                        Beli via QRIS / Transfer <i class="bi bi-arrow-right ms-2"></i>
                                    </a>
                                @endguest
                                <p class="text-center text-muted small mt-3 mb-0"><i
                                        class="bi bi-shield-check text-success me-1"></i> Garansi akses langsung aktif
                                    setelah bayar.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>



        {{-- <section class="py-xl-8 py-6 bg-white">
            <div class="container">
                <!-- HEADER SECTION: Fokus ke Copywriting yang "Menampar" -->
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-8">
                        <!-- Badge ditekankan dengan ikon hadiah dan nama brand -->
                        <span
                            class="badge bg-danger text-white px-4 py-2 fw-bold text-uppercase rounded-pill mb-3 fs-6 animate__animated animate__pulse animate__infinite shadow-sm">
                            <i class="bi bi-gift-fill me-1"></i> SPESIAL DARI CALONASN.ID: 100% GRATIS!
                        </span>

                        <h2 class="display-4 fw-bold text-dark mb-3">Akses Ratusan Materi Rahasia Tanpa Biaya</h2>

                        <p class="lead text-muted px-md-4">
                            Gak perlu mikir biaya. Cukup buat akun gratis dalam 1 menit, dan materi terstruktur TWK, TIU,
                            dan TKP ini otomatis terbuka untukmu selamanya!
                        </p>
                    </div>
                </div>

                <!-- KARTU MATERI -->
                <div class="row g-4">
                    @foreach ($categories as $category)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 border-2 border-success shadow-sm rounded-4 overflow-hidden hover-lift">
                                <div class="card-body p-4 text-center">

                                    <!-- Icon Kategori -->
                                    <div class="bg-{{ $category->color_theme }} text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4 shadow-sm"
                                        style="width: 70px; height: 70px;">
                                        <i class="{{ $category->icon }} fs-2"></i>
                                    </div>

                                    <h3 class="fw-bold mb-2">{{ $category->name }}</h3>

                                    <!-- Deskripsi Materi -->
                                    <p class="text-muted mb-4">{{ $category->description }}</p>

                                    <!-- Tombol Call to Action (Ajakan Daftar) -->
                                    <!-- Menggunakan outline-dark sesuai selera eleganmu, tapi text-nya lebih agresif -->
                                    <a href="{{ route('register') }}"
                                        class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold w-100">
                                        <i class="bi bi-unlock me-1"></i> Daftar & Buka Aksesnya
                                    </a>

                                    <!-- Teks garansi kecil di bawah tombol untuk meyakinkan lagi -->
                                    <p class="small text-danger fw-semibold mt-3 mb-0">
                                        <i class="bi bi-check-circle-fill me-1"></i> Bebas Akses Selamanya
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>         --}}

        <section class="py-xl-8 py-6 bg-light border-top border-bottom">
            <div class="container">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-8 col-12">
                        <!-- PERBAIKAN: Penambahan Keyword -->
                        <h2 class="display-4 fw-bold text-dark mb-2">Mengapa Harus Tryout CPNS di CalonASN.id?</h2>
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
                            <!-- PERBAIKAN: Diubah ke H3 agar urut setelah H2 (Class h4 menjaga visual aslinya) -->
                            <h3 class="h4 fw-bold mb-2 text-dark">Simulasi CAT Akurat</h3>
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
                            <h3 class="h4 fw-bold mb-2 text-dark">Analisis Instan</h3>
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
                            <h3 class="h4 fw-bold mb-2 text-dark">Soal Kriteria HOTS</h3>
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
                            <h3 class="h4 fw-bold mb-2 text-dark">Trik Solusi Cepat</h3>
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
                        <h2 class="display-5 fw-bold text-dark">3 Langkah Mudah Memulai CAT</h2>
                        <p class="text-muted">Tidak pakai ribet, beres beli langsung bisa simulasi detik ini juga.</p>
                    </div>
                </div>

                <div class="row g-4 text-center">
                    <div class="col-md-4 col-12">
                        <div class="p-3">
                            <!-- PERBAIKAN FATAL: H1 diganti jadi span dengan d-block. Visual tetap persis sama. -->
                            <span class="d-block display-3 fw-bold text-primary-soft mb-2 opacity-50"
                                style="color: #cbdffa;">01</span>
                            <!-- PERBAIKAN: H4 jadi H3 -->
                            <h3 class="h4 fw-bold text-dark">Daftar Akun Gratis</h3>
                            <p class="text-muted small mx-auto" style="max-width: 280px;">Buat akun barumu secara instan
                                dalam hitungan detik. Akses ke ratusan materi SKD akan langsung terbuka.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="p-3">
                            <span class="d-block display-3 fw-bold text-primary-soft mb-2 opacity-50"
                                style="color: #cbdffa;">02</span>
                            <h3 class="h4 fw-bold text-dark">Pahami Materinya</h3>
                            <p class="text-muted small mx-auto" style="max-width: 280px;">Pelajari rangkuman materi TWK,
                                TIU, dan TKP secara terstruktur. Pahami konsep dasar dan trik cepatnya.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="p-3">
                            <span class="d-block display-3 fw-bold text-primary-soft mb-2 opacity-50"
                                style="color: #cbdffa;">03</span>
                            <h3 class="h4 fw-bold text-dark">Uji dengan Tryout CAT</h3>
                            <p class="text-muted small mx-auto" style="max-width: 280px;">Setelah yakin, beli paket Tryout
                                Premium yang super murah untuk mengukur seberapa jauh kesiapanmu dengan sistem CAT asli.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-xl-8 py-6 bg-light border-top border-bottom">
            <div class="container">
                <div class="row align-items-end mb-5">
                    <div class="col-md-8 col-12 text-center text-md-start">
                        <!-- PERBAIKAN: Injeksi keyword CPNS -->
                        <h2 class="display-5 fw-bold text-dark mb-2">Info Pendaftaran & Kisi-kisi CPNS 2026</h2>
                        <p class="text-muted mb-0">Ikuti tips sukses, info regulasi CPNS, dan materi pembelajaran terupdate
                            langsung dari ahlinya.</p>
                    </div>
                    <div class="col-md-4 col-12 text-center text-md-end d-none d-md-block">
                        <a href="{{ route('blog.index') }}" class="btn btn-outline-primary rounded-3">
                            Lihat Semua Artikel <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="row gy-4">
                    @forelse($latestPosts as $post)
                        <div class="col-lg-4 col-md-6 col-12">
                            <article class="blog-card card border-0 shadow-sm h-100 overflow-hidden"
                                style="transition: all 0.3s ease;">
                                <div class="position-relative overflow-hidden bg-light" style="height: 220px;">
                                    <a href="{{ route('blog.show', $post->slug) }}">
                                        <img src="{{ $post->image_url ?? '/build/assets/images/course/default-blog.png' }}"
                                            alt="{{ $post->title }}" class="w-100 h-100"
                                            style="object-fit: cover; object-position: center; transition: transform 0.5s ease;" />
                                    </a>
                                    <span
                                        class="blog-category-badge position-absolute bg-white text-primary fw-bold shadow-sm"
                                        style="top: 1rem; left: 1rem; z-index: 2; font-size: 0.75rem; padding: 6px 14px; border-radius: 30px;">
                                        {{ $post->category->name }}
                                    </span>
                                </div>

                                <div class="card-body p-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex align-items-center gap-3 mb-3 text-muted small">
                                            <span class="d-flex align-items-center gap-1">
                                                <i class="far fa-calendar-alt text-secondary"></i>
                                                {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                                            </span>
                                            <span class="text-secondary opacity-25">|</span>
                                            <span class="d-flex align-items-center gap-1">
                                                <i class="far fa-user text-secondary"></i>
                                                {{ $post->author->name ?? 'Admin' }}
                                            </span>
                                        </div>

                                        <!-- PERBAIKAN: Diubah jadi H3 -->
                                        <h3 class="card-title fw-bold lh-base mb-2 h4">
                                            <a href="{{ route('blog.show', $post->slug) }}"
                                                class="blog-title-link text-dark text-decoration-none"
                                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 3rem;">
                                                {{ $post->title }}
                                            </a>
                                        </h3>

                                        <p class="card-text text-muted fs-6 mb-4"
                                            style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                                        </p>
                                    </div>

                                    <div class="pt-3 border-top mt-auto">
                                        <a href="{{ route('blog.show', $post->slug) }}"
                                            class="text-primary fw-bold text-decoration-none d-flex align-items-center gap-1 fs-6 blog-read-more-btn">
                                            Baca Selengkapnya
                                            <i class="fas fa-arrow-right fs-7 ms-1 transition-transform"
                                                style="transition: transform 0.2s ease;"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <div class="text-muted p-5 bg-white rounded-4 shadow-sm">
                                <i class="far fa-newspaper fa-3x mb-3 text-secondary opacity-50"></i>
                                <p class="mb-0 fw-medium fs-5">Belum ada artikel yang diterbitkan.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="row d-md-none mt-4">
                    <div class="col-12 text-center">
                        <a href="#!" class="btn btn-outline-primary w-100 rounded-3">Lihat Semua Artikel</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-xl-9 py-6 bg-white">
            <div class="container py-xl-4">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-12">

                        <div class="text-center mb-5">
                            <span class="text-primary fw-semibold text-uppercase tracking-wider fs-6">F.A.Q</span>
                            <h2 class="display-5 fw-bold text-dark mt-2">Pertanyaan yang Sering Diajukan</h2>
                            <p class="text-muted fs-5">Masih ragu? Temukan jawaban seputar platform simulasi CAT
                                CalonASN.id di bawah ini.</p>
                        </div>

                        <div class="accordion" id="faqAccordion">

                            <div class="accordion-item mb-3 border-0 rounded-4 shadow-sm overflow-hidden"
                                style="background-color: #f1f5f9 !important;">
                                <h2 class="accordion-header" id="headingOne">
                                    <button
                                        class="accordion-button collapsed bg-transparent shadow-none fw-bold text-dark fs-5 py-4"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                        aria-expanded="false" aria-controls="collapseOne">
                                        Apakah harus install aplikasi di HP/Laptop?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-dark pb-4 pt-0">
                                        <strong>Tentu saja tidak!</strong> CalonASN.id berbasis 100% Web (Cloud). Kamu bisa
                                        langsung mengerjakan Tryout dari <i>browser</i> (Chrome/Safari) di HP, Tablet,
                                        maupun Laptop kapan saja dan di mana saja.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item mb-3 border-0 rounded-4 shadow-sm overflow-hidden"
                                style="background-color: #f1f5f9 !important;">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button
                                        class="accordion-button collapsed bg-transparent shadow-none fw-bold text-dark fs-5 py-4"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                        aria-expanded="false" aria-controls="collapseTwo">
                                        Apakah soalnya sudah disesuaikan dengan kisi-kisi 2026?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-dark pb-4 pt-0">
                                        Ya. Kami memiliki tim penyusun bank soal yang selalu mengikuti <i>update</i>
                                        peraturan dan kisi-kisi resmi dari BKN. Soal Tryout kami mencakup porsi yang presisi
                                        untuk TWK (Tes Wawasan Kebangsaan), TIU (Tes Intelegensia Umum), dan TKP (Tes
                                        Karakteristik Pribadi) dengan format <strong>HOTS (Higher Order Thinking
                                            Skills)</strong>.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item mb-3 border-0 rounded-4 shadow-sm overflow-hidden"
                                style="background-color: #f1f5f9 !important;">
                                <h2 class="accordion-header" id="headingThree">
                                    <button
                                        class="accordion-button collapsed bg-transparent shadow-none fw-bold text-dark fs-5 py-4"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                        aria-expanded="false" aria-controls="collapseThree">
                                        Berapa kali saya bisa mengerjakan Tryout Premium?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-dark pb-4 pt-0">
                                        Sistem kami sangat fleksibel, <strong>beli sesuai kebutuhan!</strong> Satu kali
                                        pembayaran berlaku untuk pengerjaan <strong>satu paket Tryout penuh (110
                                            soal)</strong> tanpa sistem langganan bulanan yang mahal.
                                        <br><br>
                                        Menariknya, setelah selesai ujian, akses ke <strong>Skor, Kunci Jawaban, dan Trik
                                            Pembahasan</strong> untuk paket tersebut akan terbuka selamanya. Jadi kamu bisa
                                        <i>review</i> materi kapan saja. Jika butuh tantangan soal yang baru, kamu tinggal
                                        membeli paket Tryout lainnya dengan harga promo yang super terjangkau!
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item mb-3 border-0 rounded-4 shadow-sm overflow-hidden"
                                style="background-color: #f1f5f9 !important;">
                                <h2 class="accordion-header" id="headingFour">
                                    <button
                                        class="accordion-button collapsed bg-transparent shadow-none fw-bold text-dark fs-5 py-4"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        Bagaimana sistem penilaian dan pembahasannya?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-dark pb-4 pt-0">
                                        Begitu <i>timer</i> ujian habis atau kamu menekan tombol "Selesai", sistem akan
                                        langsung menghitung skormu secara <i>real-time</i> dan menunjukkan apakah kamu lolos
                                        <i>Passing Grade</i> atau belum. Kunci jawaban dan trik pembahasan cepat juga akan
                                        langsung terbuka untuk kamu pelajari.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item mb-3 border-0 rounded-4 shadow-sm overflow-hidden"
                                style="background-color: #f1f5f9 !important;">
                                <h2 class="accordion-header" id="headingFive">
                                    <button
                                        class="accordion-button collapsed bg-transparent shadow-none fw-bold text-dark fs-5 py-4"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                        aria-expanded="false" aria-controls="collapseFive">
                                        Metode pembayaran apa saja yang diterima?
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-dark pb-4 pt-0">
                                        Kami menggunakan sistem otomatis. Kamu bisa membayar dengan mudah melalui
                                        <strong>QRIS</strong> menggunakan m-Banking (BCA, Mandiri, BRI, dll) atau e-Wallet
                                        kesayanganmu (GoPay, OVO, Dana, ShopeePay). Pembayaran akan diverifikasi secepatnya
                                        oleh admin dan aksesmu langsung terbuka. Jangan lupa gunakan kode promo
                                        <strong>ASN2026</strong> ya!
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="text-center mt-5">
                            <p class="text-muted mb-2">Punya pertanyaan lain yang belum terjawab?</p>
                            <a href="mailto:admincalonasn@gmail.com?subject=Pertanyaan%20seputar%20Tryout%20CalonASN"
                                class="btn btn-outline-primary rounded-pill px-4 fw-medium bg-white">
                                <i class="fe fe-mail me-1"></i> Hubungi Admin via Email
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
    <div class="toast-container position-fixed bottom-0 start-0 p-3" style="z-index: 1055;">
        <div id="liveSalesToast"
            class="toast align-items-center text-bg-white border-0 shadow-lg rounded-4 overflow-hidden" role="alert"
            aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-3 py-3 px-3">
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm"
                        style="width: 45px; height: 45px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#ffffff"
                            viewBox="0 0 16 16">
                            <path
                                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-0 text-dark fw-bold fs-6" id="toast-title">Budi dari Semarang</p>
                        <p class="mb-1 text-muted small lh-sm" id="toast-desc" style="max-width: 220px;">Baru saja
                            membeli Paket Premium</p>
                        <p class="mb-0 text-primary small fw-semibold" style="font-size: 0.70rem;" id="toast-time">
                            Beberapa detik yang lalu</p>
                    </div>
                </div>
                <button type="button" class="btn-close me-3 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastEl = document.getElementById('liveSalesToast');
            if (!toastEl) return; // Mencegah error jika elemen tidak ada

            // Inisialisasi Toast Bootstrap
            const toast = new bootstrap.Toast(toastEl);

            // Data Dummy yang diracik untuk FOMO (30 Data)
            const salesData = [{
                    name: "Rizky",
                    city: "Yogyakarta",
                    action: "baru saja membeli <b>Paket Premium</b> 🚀",
                    time: "Baru saja"
                },
                {
                    name: "Siti",
                    city: "Makassar",
                    action: "berhasil lolos <i>Passing Grade</i> simulasi CAT!",
                    time: "2 menit yang lalu"
                },
                {
                    name: "Andi",
                    city: "Jakarta",
                    action: "mendaftar dan memakai kode promo <b>ASN2026</b> 🔥",
                    time: "1 menit yang lalu"
                },
                {
                    name: "Budi",
                    city: "Surabaya",
                    action: "baru saja membeli <b>Paket Tryout</b>",
                    time: "5 menit yang lalu"
                },
                {
                    name: "Ayu",
                    city: "Medan",
                    action: "sedang mengerjakan <i>Tryout Gratis</i>",
                    time: "Baru saja"
                },
                {
                    name: "Dimas",
                    city: "Bandung",
                    action: "baru saja bergabung menjadi member <b>CalonASN.id</b> 🤝",
                    time: "Beberapa detik yang lalu"
                },
                {
                    name: "Putri",
                    city: "Semarang",
                    action: "sedang membaca materi <b>TWK Gratis</b> 📖",
                    time: "3 menit yang lalu"
                },
                {
                    name: "Hendra",
                    city: "Palembang",
                    action: "membeli <b>Paket Mandiri Premium</b> via QRIS 💸",
                    time: "Baru saja"
                },
                {
                    name: "Cut Nisa",
                    city: "Banda Aceh",
                    action: "berhasil lolos <i>Passing Grade</i> dengan skor tinggi! 🏆",
                    time: "4 menit yang lalu"
                },
                {
                    name: "Wayan",
                    city: "Denpasar",
                    action: "sedang latihan soal <b>TKP HOTS 2026</b> 🧠",
                    time: "1 menit yang lalu"
                },
                {
                    name: "Fajar",
                    city: "Balikpapan",
                    action: "mendaftar dan memakai kode promo <b>ASN2026</b> 🔥",
                    time: "Baru saja"
                },
                {
                    name: "Lestari",
                    city: "Pontianak",
                    action: "baru saja menyelesaikan Tryout SKD ke-3 hari ini 📈",
                    time: "6 menit yang lalu"
                },
                {
                    name: "Kevin",
                    city: "Manado",
                    action: "baru saja membeli <b>Paket Premium</b> 🚀",
                    time: "2 menit yang lalu"
                },
                {
                    name: "Ratna",
                    city: "Malang",
                    action: "sedang membaca materi <b>TIU Gratis</b> 📖",
                    time: "Baru saja"
                },
                {
                    name: "Ilham",
                    city: "Padang",
                    action: "berhasil menaklukkan soal deret angka TIU! 🎯",
                    time: "3 menit yang lalu"
                },
                {
                    name: "Eko",
                    city: "Solo",
                    action: "baru saja bergabung menjadi member <b>CalonASN.id</b> 🤝",
                    time: "10 detik yang lalu"
                },
                {
                    name: "Maya",
                    city: "Banjarmasin",
                    action: "membeli <b>Paket Tryout</b> untuk persiapan ujian 📚",
                    time: "4 menit yang lalu"
                },
                {
                    name: "Rina",
                    city: "Pekanbaru",
                    action: "sedang mengerjakan <i>Tryout Gratis</i>",
                    time: "Baru saja"
                },
                {
                    name: "Samuel",
                    city: "Jayapura",
                    action: "berhasil lolos <i>Passing Grade</i> simulasi CAT!",
                    time: "5 menit yang lalu"
                },
                {
                    name: "Dewi",
                    city: "Mataram",
                    action: "mendaftar dan memakai kode promo <b>ASN2026</b> 🔥",
                    time: "1 menit yang lalu"
                },
                {
                    name: "Ahmad",
                    city: "Bogor",
                    action: "baru saja membeli <b>Paket Mandiri Premium</b> 🚀",
                    time: "Baru saja"
                },
                {
                    name: "Siska",
                    city: "Samarinda",
                    action: "sedang latihan soal <b>TWK HOTS 2026</b> 🧠",
                    time: "2 menit yang lalu"
                },
                {
                    name: "Reza",
                    city: "Tangerang",
                    action: "berhasil mencapai skor tertinggi di sesi hari ini! 🏆",
                    time: "7 menit yang lalu"
                },
                {
                    name: "Nadia",
                    city: "Batam",
                    action: "baru saja bergabung dan langsung mengakses materi 📖",
                    time: "Baru saja"
                },
                {
                    name: "Yusuf",
                    city: "Ambon",
                    action: "membeli <b>Paket Premium</b> via Transfer Bank 💳",
                    time: "3 menit yang lalu"
                },
                {
                    name: "Dita",
                    city: "Madiun",
                    action: "baru saja menyelesaikan simulasi ujian CAT ⏱️",
                    time: "4 menit yang lalu"
                },
                {
                    name: "Anton",
                    city: "Cirebon",
                    action: "mendaftar dan memakai kode promo <b>ASN2026</b> 🔥",
                    time: "Baru saja"
                },
                {
                    name: "Fira",
                    city: "Jambi",
                    action: "sedang mengerjakan <i>Tryout Gratis</i>",
                    time: "1 menit yang lalu"
                },
                {
                    name: "Bagus",
                    city: "Kediri",
                    action: "berhasil lolos <i>Passing Grade</i> TKP! 🎉",
                    time: "2 menit yang lalu"
                },
                {
                    name: "Vina",
                    city: "Gorontalo",
                    action: "baru saja membeli <b>Paket Premium</b> 🚀",
                    time: "Baru saja"
                }
            ];

            // Fungsi untuk mengacak array (Fisher-Yates Shuffle)
            function shuffleArray(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
            }

            // Acak data saat halaman pertama kali dimuat
            shuffleArray(salesData);
            let currentIndex = 0; // Mulai dari urutan pertama hasil acakan

            function showRandomToast() {
                // Ambil item berdasarkan index saat ini
                const currentItem = salesData[currentIndex];

                // Suntikkan data tersebut ke dalam HTML Toast
                document.getElementById('toast-title').innerText = `${currentItem.name} dari ${currentItem.city}`;
                document.getElementById('toast-desc').innerHTML = currentItem.action;
                document.getElementById('toast-time').innerText = currentItem.time;

                // Tampilkan Toast-nya
                toast.show();

                // Lanjut ke index berikutnya
                currentIndex++;

                // Jika semua data sudah ditampilkan, acak ulang dan kembali ke index 0
                if (currentIndex >= salesData.length) {
                    shuffleArray(salesData);
                    currentIndex = 0;
                }

                // Atur waktu acak untuk memunculkan notifikasi berikutnya (antara 8 sampai 15 detik)
                const nextTime = Math.floor(Math.random() * (15000 - 8000 + 1) + 8000);
                setTimeout(showRandomToast, nextTime);
            }

            // Tunda kemunculan pertama selama 5 detik agar pengunjung tidak kaget saat baru buka web
            setTimeout(showRandomToast, 5000);
        });
    </script>
@endsection

@push('scripts')
    <script src="/build/assets/js/vendors/tnsSlider.js"></script>
@endpush
