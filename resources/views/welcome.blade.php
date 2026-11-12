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

        /* Animasi Modern Mockup 2026 */
        @keyframes catFloatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-7px); }
        }
        @keyframes catFloatReverse {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(7px); }
        }
        .cat-float-1 {
            animation: catFloatSlow 4s ease-in-out infinite;
        }
        .cat-float-2 {
            animation: catFloatReverse 4.8s ease-in-out infinite;
        }
        .hero-glow-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
            opacity: 0.18;
            z-index: 0;
        }

        /* Modern FAQ & Blog Enhancements 2026 */
        .modern-faq .accordion-item {
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .modern-faq .accordion-item:hover {
            border-color: #cbd5e1 !important;
        }
        .modern-faq .accordion-button {
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .modern-faq .accordion-button:not(.collapsed) {
            background-color: #f0f7ff !important;
            color: #1e40af !important;
            box-shadow: none !important;
        }
        .blog-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }
        .blog-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 32px -8px rgba(15, 23, 42, 0.1) !important;
            border-color: #cbd5e1 !important;
        }
        .blog-card:hover .blog-thumb-img {
            transform: scale(1.05);
        }
        .hover-primary:hover {
            color: #2563eb !important;
        }
        .blog-read-more-btn:hover .fe-arrow-right {
            transform: translateX(4px);
        }
        .fe-arrow-right {
            transition: transform 0.2s ease;
        }
    </style>
@endpush

@section('content')
    <main>
        <!-- HERO SECTION 2026 -->
        <section class="py-xl-8 py-5 position-relative overflow-hidden" style="background: radial-gradient(circle at 85% 20%, rgba(59, 130, 246, 0.08) 0%, rgba(248, 250, 252, 0) 60%), linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);">
            <!-- Ambient Glow Blobs -->
            <div class="hero-glow-blob bg-primary" style="top: -80px; right: -80px; width: 350px; height: 350px;"></div>
            <div class="hero-glow-blob bg-success" style="bottom: 20px; right: 25%; width: 280px; height: 280px;"></div>

            <div class="container position-relative" style="z-index: 1;">
                <div class="row align-items-center gy-5 gy-xl-0">
                    <!-- Sisi Kiri: Value Proposition & CTA -->
                    <div class="col-lg-6 col-12">
                        <div class="d-flex flex-column gap-3 pe-lg-4 text-center text-lg-start">
                            <!-- Eyebrow Badge -->
                            <div class="d-inline-flex align-items-center gap-2 bg-primary-soft text-primary px-3 py-1.5 rounded-pill border border-primary border-opacity-20 shadow-xs align-self-lg-start mx-auto mx-lg-0" style="width: fit-content;">
                                <span class="badge bg-primary text-white rounded-pill px-2 py-0.5 small fw-bold">UPDATE 2026</span>
                                <span class="fw-semibold small">Simulasi CAT CPNS Standar Resmi BKN</span>
                            </div>

                            <!-- Main Headline -->
                            <h1 class="display-4 fw-xl-bolder fw-bold text-dark lh-sm mb-1">
                                Lolos Passing Grade SKD CPNS dengan <span class="text-primary fw-bolder">Simulasi CAT Terakurat</span>
                            </h1>

                            <p class="text-muted fs-5 lh-base mb-2">
                                Rasakan pengalaman ujian CAT BKN sesungguhnya. Bank soal HOTS ter-update, hitung mundur presisi, sistem penilaian otomatis, dan kunci pembahasan trik 1 menit.
                            </p>

                            <!-- Mini Offer Pill -->
                            <div class="p-3 bg-white rounded-3 border border-success border-opacity-30 shadow-xs d-flex align-items-center gap-3 text-start mx-auto mx-lg-0" style="max-width: 520px;">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                    <i class="fe fe-gift fs-5"></i>
                                </div>
                                <div class="small">
                                    <span class="d-block text-dark fw-bold">Spesial Calon Abdi Negara Hari Ini:</span>
                                    <span class="text-muted">Akses materi TWK, TIU, TKP <strong>100% GRATIS</strong> + Diskon Tryout ekstra pakai voucher <strong>ASN2026</strong></span>
                                </div>
                            </div>

                            <!-- Dual CTA Buttons -->
                            <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start mt-3">
                                @guest
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 py-3 fw-bold rounded-pill shadow-sm d-inline-flex align-items-center gap-2">
                                        <i class="fe fe-user-plus"></i>
                                        <span>Daftar & Mulai Gratis</span>
                                    </a>
                                    <a href="{{ route('demo.cat') }}" class="btn btn-outline-dark btn-lg px-4 py-3 fw-bold rounded-pill d-inline-flex align-items-center gap-2">
                                        <i class="fe fe-play-circle text-primary"></i>
                                        <span>Coba Demo CAT</span>
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4 py-3 fw-bold rounded-pill shadow-sm d-inline-flex align-items-center gap-2">
                                        <i class="fe fe-grid"></i>
                                        <span>Buka Dashboard Tryout</span>
                                    </a>
                                    <a href="#paket" class="btn btn-outline-primary btn-lg px-4 py-3 fw-bold rounded-pill">
                                        Pilih Paket Tryout <i class="fe fe-arrow-down ms-1"></i>
                                    </a>
                                @endguest
                            </div>

                            <!-- Trust Badges -->
                            <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 gap-md-4 pt-2 text-muted small">
                                <span class="d-flex align-items-center gap-1.5">
                                    <i class="fe fe-check-circle text-success fs-6"></i> Standar Resmi BKN 2026
                                </span>
                                <span class="d-flex align-items-center gap-1.5">
                                    <i class="fe fe-check-circle text-success fs-6"></i> Tanpa Perlu Install Aplikasi
                                </span>
                                <span class="d-flex align-items-center gap-1.5">
                                    <i class="fe fe-check-circle text-success fs-6"></i> Skor & Pembahasan Instan
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Modern Interactive CAT Mockup 2026 -->
                    <div class="col-lg-6 col-12">
                        <div class="position-relative mx-auto" style="max-width: 580px;">
                            <!-- Floating Badge 1 (Atas Kiri): Skor & Kelulusan -->
                            <div class="cat-float-1 position-absolute text-white p-2 px-3 rounded-4 shadow-lg border border-secondary border-opacity-25 d-flex align-items-center gap-2.5" 
                                 style="top: -24px; left: -14px; z-index: 10; backdrop-filter: blur(12px); background: rgba(15, 23, 42, 0.95) !important;">
                                <div class="bg-warning text-dark rounded-3 d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 1.2rem;">
                                    🏆
                                </div>
                                <div>
                                    <div class="text-secondary small fw-medium" style="font-size: 0.72rem; color: #94a3b8 !important;">Hasil Simulasi CAT</div>
                                    <div class="fw-bold d-flex align-items-center gap-1.5" style="font-size: 0.9rem;">
                                        Skor: <span class="text-success fw-bolder">468</span>
                                        <span class="badge bg-success text-white rounded-pill px-2 py-0.5 fw-bold" style="font-size: 0.65rem;">LOLOS PG</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Floating Badge 2 (Bawah Kanan): Standar BKN -->
                            <div class="cat-float-2 position-absolute text-white p-2 px-3 rounded-4 shadow-lg border border-secondary border-opacity-25 d-none d-sm-flex align-items-center gap-2.5" 
                                 style="bottom: -22px; right: -14px; z-index: 10; backdrop-filter: blur(12px); background: rgba(15, 23, 42, 0.95) !important;">
                                <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                                    <i class="fe fe-cpu fs-5"></i>
                                </div>
                                <div>
                                    <div class="text-secondary small fw-medium" style="font-size: 0.72rem; color: #94a3b8 !important;">Kisi-kisi Terbaru</div>
                                    <div class="fw-bold text-white" style="font-size: 0.85rem;">Standar Resmi BKN 2026</div>
                                </div>
                            </div>

                            <!-- Main Device / Browser Frame -->
                            <div class="rounded-4 overflow-hidden shadow-2xl border border-secondary border-opacity-25" style="background: #0f172a; box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35);">
                                <!-- Browser Window Bar -->
                                <div class="px-3 py-2.5 border-bottom border-dark d-flex align-items-center justify-content-between" style="background: #090d16;">
                                    <div class="d-flex align-items-center gap-1.5">
                                        <span class="rounded-circle" style="width: 10px; height: 10px; background: #ef4444; display: inline-block;"></span>
                                        <span class="rounded-circle" style="width: 10px; height: 10px; background: #f59e0b; display: inline-block;"></span>
                                        <span class="rounded-circle" style="width: 10px; height: 10px; background: #10b981; display: inline-block;"></span>
                                    </div>
                                    <div class="px-3 py-1 rounded-2 text-secondary small font-monospace d-flex align-items-center gap-1.5" style="background: #1e293b; font-size: 0.72rem; color: #94a3b8;">
                                        <i class="fe fe-lock text-success" style="font-size: 0.65rem;"></i>
                                        calonasn.id/simulasi/skd-cat
                                    </div>
                                    <span class="badge bg-success text-white px-2 py-0.5 rounded fw-bold" style="font-size: 0.65rem;">
                                        LIVE CAT
                                    </span>
                                </div>

                                <!-- CAT Header (Participant info & Live Timer) -->
                                <div class="px-3 py-2.5 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between" style="background: #1e293b;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow-xs" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                            ASN
                                        </div>
                                        <div class="text-start">
                                            <div class="text-white fw-bold" style="font-size: 0.75rem;">Peserta: Calon ASN</div>
                                            <div class="text-secondary" style="font-size: 0.68rem; color: #94a3b8 !important;">Sub-Tes: <span class="text-info fw-semibold">TIU (Logika Silogisme)</span></div>
                                        </div>
                                    </div>

                                    <!-- Timer Box -->
                                    <div class="px-2.5 py-1 rounded-2 d-flex align-items-center gap-1.5 border border-danger border-opacity-50" style="background: #090d16;">
                                        <span class="rounded-circle bg-danger" style="width: 7px; height: 7px; animation: pulse 1.5s infinite; display: inline-block;"></span>
                                        <span class="text-secondary uppercase" style="font-size: 0.65rem; color: #94a3b8 !important;">Sisa Waktu:</span>
                                        <span id="heroLiveTimer" class="font-monospace fw-bolder text-danger" style="font-size: 0.82rem; letter-spacing: 0.5px;">01:24:39</span>
                                    </div>
                                </div>

                                <!-- Question Area & Mini Navigation -->
                                <div class="p-3 p-sm-4 text-start">
                                    <div class="row g-3">
                                        <!-- Left: Question Body (8 cols) -->
                                        <div class="col-8">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="badge bg-primary text-white px-2 py-1 rounded fw-bold" style="font-size: 0.7rem;">
                                                    Soal No. 42
                                                </span>
                                                <span class="text-secondary small" style="font-size: 0.7rem; color: #94a3b8 !important;">Bobot: 5 Poin</span>
                                            </div>

                                            <p class="text-light small mb-3 lh-sm" style="font-size: 0.8rem; color: #e2e8f0 !important;">
                                                Semua atlet berlari setiap pagi. Sebagian atlet mengonsumsi suplemen vitamin. Kesimpulan yang paling tepat adalah ...
                                            </p>

                                            <!-- Options List -->
                                            <div class="d-flex flex-column gap-1.5 mb-3">
                                                <div class="p-2 rounded-2 border border-secondary border-opacity-25 d-flex align-items-center gap-2" style="background: rgba(30, 41, 59, 0.4); font-size: 0.74rem;">
                                                    <span class="badge bg-secondary bg-opacity-50 text-white rounded-circle" style="width: 18px; height: 18px; padding: 0; line-height: 18px;">A</span>
                                                    <span class="text-secondary" style="color: #cbd5e1 !important;">Semua yang berlari adalah atlet</span>
                                                </div>

                                                <div class="p-2 rounded-2 border border-primary d-flex align-items-center gap-2" style="background: rgba(30, 58, 138, 0.45); font-size: 0.74rem;">
                                                    <span class="badge bg-primary text-white rounded-circle shadow-xs" style="width: 18px; height: 18px; padding: 0; line-height: 18px;">B</span>
                                                    <span class="text-white fw-bold">Sebagian yang berlari pagi minum vitamin</span>
                                                </div>

                                                <div class="p-2 rounded-2 border border-secondary border-opacity-25 d-flex align-items-center gap-2" style="background: rgba(30, 41, 59, 0.4); font-size: 0.74rem;">
                                                    <span class="badge bg-secondary bg-opacity-50 text-white rounded-circle" style="width: 18px; height: 18px; padding: 0; line-height: 18px;">C</span>
                                                    <span class="text-secondary" style="color: #cbd5e1 !important;">Tidak ada atlet yang minum suplemen</span>
                                                </div>
                                            </div>

                                            <!-- Bottom buttons -->
                                            <div class="d-flex align-items-center justify-content-between pt-1">
                                                <span class="btn btn-dark btn-sm py-1 px-2 text-secondary border border-secondary border-opacity-25 rounded" style="font-size: 0.68rem;">← Sebelum</span>
                                                <span class="btn btn-sm py-1 px-2 rounded fw-bold text-dark" style="background: #fbbf24; font-size: 0.68rem;">Ragu-ragu</span>
                                                <span class="btn btn-primary btn-sm py-1 px-2 rounded fw-bold" style="font-size: 0.68rem;">Selanjutnya →</span>
                                            </div>
                                        </div>

                                        <!-- Right: Mini Number Palette (4 cols) -->
                                        <div class="col-4">
                                            <div class="p-2 rounded-3 border border-secondary border-opacity-25 h-100 d-flex flex-column justify-content-between" style="background: #090d16;">
                                                <div>
                                                    <div class="text-center text-secondary small fw-bold text-uppercase mb-2" style="font-size: 0.62rem; color: #94a3b8 !important;">Nomor Soal (110)</div>
                                                    <div class="d-grid" style="grid-template-columns: repeat(3, 1fr); gap: 4px; font-size: 0.68rem;">
                                                        <span class="badge bg-success text-white py-1">40</span>
                                                        <span class="badge bg-success text-white py-1">41</span>
                                                        <span class="badge bg-primary text-white py-1 border border-light">42</span>
                                                        <span class="badge text-dark py-1 fw-bold" style="background: #f59e0b;">43</span>
                                                        <span class="badge py-1" style="background: #1e293b; color: #94a3b8 !important;">44</span>
                                                        <span class="badge py-1" style="background: #1e293b; color: #94a3b8 !important;">45</span>
                                                        <span class="badge py-1" style="background: #1e293b; color: #94a3b8 !important;">46</span>
                                                        <span class="badge py-1" style="background: #1e293b; color: #94a3b8 !important;">47</span>
                                                        <span class="badge py-1" style="background: #1e293b; color: #94a3b8 !important;">48</span>
                                                    </div>
                                                </div>

                                                <!-- Legend -->
                                                <div class="pt-2 border-top border-secondary border-opacity-25" style="font-size: 0.58rem; color: #94a3b8 !important;">
                                                    <div class="d-flex align-items-center gap-1 mb-1">
                                                        <span class="rounded-circle bg-success" style="width: 6px; height: 6px; display: inline-block;"></span>
                                                        <span>Terjawab (28)</span>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <span class="rounded-circle" style="width: 6px; height: 6px; background: #f59e0b; display: inline-block;"></span>
                                                        <span>Ragu-ragu (1)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION PAKET & PRICING 2026 -->
        <section id="paket" class="py-xl-9 py-6 position-relative" style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);">
            <div class="container position-relative" style="z-index: 1;">
                <!-- Header Section -->
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-8">
                        <div class="d-inline-flex align-items-center gap-2 bg-primary-soft text-primary px-3 py-1.5 rounded-pill border border-primary border-opacity-20 shadow-xs mb-3">
                            <i class="fe fe-tag"></i>
                            <span class="fw-semibold small text-uppercase tracking-wider">Investasi Sekali Bayar • Tanpa Biaya Bulanan</span>
                        </div>
                        <h2 class="display-5 fw-bold text-dark mb-3">
                            Pilih Paket Tryout CAT CPNS 2026
                        </h2>
                        <p class="text-muted fs-5 mb-3" style="max-width: 620px; margin: 0 auto;">
                            Akses simulasi CAT BKN terakurat, uji ketahanan manajemen waktu, dan taklukkan passing grade SKD dengan mudah.
                        </p>

                        <!-- Copyable Promo Voucher Banner -->
                        <div class="d-inline-flex align-items-center gap-2 p-2 px-3 bg-white rounded-pill border border-success border-opacity-50 shadow-sm mt-2" 
                             style="cursor: pointer;" 
                             onclick="copyPromoCode()" 
                             id="promoBanner" 
                             title="Klik untuk salin kode voucher">
                            <span class="badge bg-success text-white rounded-pill px-2.5 py-1">HEMAT RP 7.000</span>
                            <span class="small text-muted">Gunakan kode: <strong class="text-dark font-monospace fs-6">ASN2026</strong></span>
                            <span id="copyPromoBtn" class="badge rounded-pill px-2 py-1 ms-1 small fw-bold" style="background: #f1f5f9; color: #059669 !important; border: 1px solid rgba(5, 150, 105, 0.3);">
                                <i class="fe fe-copy me-1"></i>Salin
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Two Pricing Cards -->
                <div class="row g-4 justify-content-center align-items-stretch">
                    
                    <!-- Card 1: Paket Latihan (Reguler) -->
                    <div class="col-lg-5 col-md-6 d-flex">
                        <div class="card w-100 border-0 shadow-sm rounded-4 p-4 p-xl-5 d-flex flex-column bg-white transition-hover hover-lift" 
                             style="border: 1px solid rgba(226, 232, 240, 0.9) !important;">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge rounded-pill px-3 py-1 fw-bold small text-uppercase" style="background: #f1f5f9; color: #475569 !important;">
                                        Paket Latihan
                                    </span>
                                </div>
                                <h3 class="fw-bold text-dark mb-1">Tryout Premium Mandiri</h3>
                                <p class="text-muted small">Khusus untuk latihan manajemen waktu dan uji simulasi CAT.</p>

                                <!-- Price Box -->
                                <div class="mt-4 p-3 rounded-3 border border-light-subtle" style="background: #f8fafc;">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="text-muted text-decoration-line-through small">Rp 20.000</span>
                                        <span class="badge bg-success text-white rounded-pill px-2.5 py-1 fw-bold shadow-xs" style="font-size: 0.72rem;">
                                            Hemat Rp 7.000!
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-baseline gap-1">
                                        <span class="display-5 fw-bold text-dark lh-1">Rp 13.000</span>
                                        <span class="text-muted small">/ sekali bayar</span>
                                    </div>
                                    <div class="small text-muted mt-2 pt-2 border-top border-light-subtle d-flex align-items-center gap-1">
                                        <i class="fe fe-check-circle text-success" style="font-size: 0.75rem;"></i>
                                        <span>Harga otomatis dengan kode <strong>ASN2026</strong></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Features List -->
                            <ul class="list-unstyled d-flex flex-column gap-3 text-dark mb-5 small">
                                <li class="d-flex align-items-start gap-2.5">
                                    <i class="fe fe-check-circle text-success fs-5 mt-0.5"></i>
                                    <span><strong>110 Soal CAT Lengkap</strong> (TWK, TIU, TKP Standar BKN)</span>
                                </li>
                                <li class="d-flex align-items-start gap-2.5">
                                    <i class="fe fe-check-circle text-success fs-5 mt-0.5"></i>
                                    <span>Sistem Scoring Otomatis & Status Kelulusan Passing Grade</span>
                                </li>
                                <li class="d-flex align-items-start gap-2.5">
                                    <i class="fe fe-check-circle text-success fs-5 mt-0.5"></i>
                                    <span>Kunci Jawaban & Pembahasan Lengkap</span>
                                </li>
                                <li class="d-flex align-items-start gap-2.5">
                                    <i class="fe fe-check-circle text-success fs-5 mt-0.5"></i>
                                    <span>Sertifikat Hasil Ujian Tryout Resmi</span>
                                </li>
                                <li class="d-flex align-items-start gap-2.5 text-muted opacity-50">
                                    <i class="fe fe-x-circle text-secondary fs-5 mt-0.5"></i>
                                    <span class="text-decoration-line-through">Akses Ratusan Modul Micro-Learning SKD</span>
                                </li>
                                <li class="d-flex align-items-start gap-2.5 text-muted opacity-50">
                                    <i class="fe fe-x-circle text-secondary fs-5 mt-0.5"></i>
                                    <span class="text-decoration-line-through">Trik Cepat Menjawab Soal Kurang dari 1 Menit</span>
                                </li>
                            </ul>

                            <!-- Action Button -->
                            <div class="mt-auto">
                                @guest
                                    <a href="{{ route('register', ['package' => 'tryout-only']) }}"
                                        class="btn btn-outline-dark rounded-pill py-3 fw-bold w-100 transition shadow-none hover-shadow">
                                        Pilih Paket Latihan <i class="fe fe-arrow-right ms-1"></i>
                                    </a>
                                @else
                                    <a href="{{ route('checkout', ['package' => 'tryout-only']) }}"
                                        class="btn btn-outline-dark rounded-pill py-3 fw-bold w-100 transition shadow-none hover-shadow">
                                        Lanjut Pembayaran (Rp 13rb) <i class="fe fe-arrow-right ms-1"></i>
                                    </a>
                                @endguest
                                <p class="text-center text-muted small mt-2 mb-0" style="font-size: 0.75rem;">
                                    <i class="fe fe-zap text-warning me-1"></i>Akses langsung aktif otomatis
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Paket Super Lengkap (Hero / Best Seller) -->
                    <div class="col-lg-5 col-md-6 d-flex">
                        <div class="card w-100 rounded-4 p-4 p-xl-5 d-flex flex-column bg-white position-relative overflow-hidden hover-lift shadow-lg"
                             style="border: 2px solid #2563eb !important; box-shadow: 0 20px 40px -15px rgba(37, 99, 235, 0.2) !important;">
                            
                            <!-- Top Right Banner Badge -->
                            <div class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1.5 fw-bold shadow-xs"
                                style="border-bottom-left-radius: 14px; font-size: 0.72rem; letter-spacing: 0.5px;">
                                ⭐ PALING BANYAK DIPILIH
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge rounded-pill px-3 py-1 fw-bold small text-uppercase" style="background: #eff6ff; color: #1e40af !important; border: 1px solid rgba(30, 64, 175, 0.2);">
                                        Paket Super Lengkap
                                    </span>
                                    <span class="badge rounded-pill px-2.5 py-0.5 fw-bold" style="background: #fef3c7; color: #92400e !important; border: 1px solid #fde68a; font-size: 0.68rem;">
                                        🔥 REKOMENDASI
                                    </span>
                                </div>
                                <h3 class="fw-bold text-dark mb-1">Tryout Premium + Modul Materi</h3>
                                <p class="text-muted small">Solusi total: Kuasai teori materinya, taklukkan simulasinya.</p>

                                <!-- Price Box -->
                                <div class="mt-4 p-3 rounded-3 border border-primary border-opacity-25 position-relative" style="background: rgba(239, 246, 255, 0.7);">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="text-muted text-decoration-line-through small">Rp 49.000</span>
                                        <span class="badge bg-primary text-white rounded-pill px-2.5 py-1 fw-bold shadow-xs" style="font-size: 0.72rem;">
                                            Hemat Rp 7.000!
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-baseline gap-1">
                                        <span class="display-5 fw-bold text-primary lh-1">Rp 42.000</span>
                                        <span class="text-muted small">/ selamanya</span>
                                    </div>
                                    <div class="small text-primary mt-2 pt-2 border-top border-primary border-opacity-20 d-flex align-items-center gap-1 fw-semibold">
                                        <i class="fe fe-tag"></i>
                                        <span>Gunakan kode voucher <strong>ASN2026</strong> saat checkout</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Features List -->
                            <ul class="list-unstyled d-flex flex-column gap-3 text-dark mb-5 small">
                                <li class="d-flex align-items-start gap-2.5">
                                    <i class="fe fe-check-circle text-primary fs-5 mt-0.5"></i>
                                    <span><strong>Semua Fitur di Paket Tryout Mandiri</strong> (110 Soal CAT BKN)</span>
                                </li>
                                <li class="d-flex align-items-start gap-2.5 p-2 rounded-3 border border-primary border-opacity-25" style="background: #f0f7ff;">
                                    <i class="fe fe-star text-primary fs-5 mt-0.5"></i>
                                    <span class="text-primary fw-bold">Akses Penuh Ratusan Modul Materi (Micro-Learning)</span>
                                </li>
                                <li class="d-flex align-items-start gap-2.5">
                                    <i class="fe fe-check-circle text-primary fs-5 mt-0.5"></i>
                                    <span>Trik Rahasia Menjawab Soal Kurang dari 1 Menit</span>
                                </li>
                                <li class="d-flex align-items-start gap-2.5">
                                    <i class="fe fe-check-circle text-primary fs-5 mt-0.5"></i>
                                    <span>Update Kisi-Kisi Resmi CPNS & PPPK 2026</span>
                                </li>
                                <li class="d-flex align-items-start gap-2.5">
                                    <i class="fe fe-check-circle text-primary fs-5 mt-0.5"></i>
                                    <span>Akses Fleksibel via HP / Laptop Selamanya</span>
                                </li>
                                <li class="d-flex align-items-start gap-2.5">
                                    <i class="fe fe-check-circle text-primary fs-5 mt-0.5"></i>
                                    <span>Sertifikat Kelulusan & Pembahasan Lengkap</span>
                                </li>
                            </ul>

                            <!-- Action Button -->
                            <div class="mt-auto">
                                @guest
                                    <a href="{{ route('register', ['package' => 'tryout-pdf']) }}"
                                        class="btn btn-primary rounded-pill py-3 fw-bold w-100 shadow d-inline-flex align-items-center justify-content-center gap-2">
                                        <span>Amankan Paket Lengkap</span>
                                        <i class="fe fe-arrow-right"></i>
                                    </a>
                                @else
                                    <a href="{{ route('checkout', ['package' => 'tryout-pdf']) }}"
                                        class="btn btn-primary rounded-pill py-3 fw-bold w-100 shadow d-inline-flex align-items-center justify-content-center gap-2">
                                        <span>Beli Sekarang via QRIS / Transfer</span>
                                        <i class="fe fe-arrow-right"></i>
                                    </a>
                                @endguest
                                <p class="text-center text-muted small mt-2 mb-0" style="font-size: 0.75rem;">
                                    <i class="fe fe-shield text-success me-1"></i>Garansi akses instan aktif otomatis setelah verifikasi
                                </p>
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

        <!-- SECTION BENTO GRID KEUNGGULAN 2026 -->
        <section id="keunggulan" class="py-xl-9 py-6 bg-white position-relative overflow-hidden">
            <div class="container">
                <!-- Header -->
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-8 col-12">
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill shadow-xs mb-3" style="background: #eff6ff; color: #1e40af !important; border: 1px solid rgba(30, 64, 175, 0.2);">
                            <i class="fe fe-check-circle"></i>
                            <span class="fw-semibold small text-uppercase tracking-wider">Standar CAT BKN Resmi</span>
                        </div>
                        <h2 class="display-5 fw-bold text-dark mb-3">Mengapa Harus Tryout di CalonASN.id?</h2>
                        <p class="text-muted fs-5 mb-0" style="max-width: 650px; margin: 0 auto;">
                            Bukan sekadar bank soal biasa. Kami merancang ekosistem belajar dan simulasi paling presisi untuk memperbesar peluang NIP CPNS kamu.
                        </p>
                    </div>
                </div>

                <!-- Bento Grid Layout -->
                <div class="row g-4">
                    <!-- Bento 1: Fitur Utama (Besar - col-lg-7) -->
                    <div class="col-lg-7 col-12">
                        <div class="card h-100 rounded-4 border-0 shadow-sm p-4 p-md-5 overflow-hidden position-relative hover-lift"
                             style="background: linear-gradient(135deg, #f8fafc 0%, #edf4fe 100%); border: 1px solid rgba(226, 232, 240, 0.8) !important;">
                            
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="badge bg-primary text-white rounded-pill px-3 py-1 fw-bold small">
                                    FITUR UTAMA
                                </span>
                                <span class="badge rounded-pill px-2.5 py-1 small fw-bold border border-primary border-opacity-25" style="background: #ffffff; color: #1e40af !important;">
                                    Presisi 100% BKN
                                </span>
                            </div>

                            <h3 class="h3 fw-bold text-dark mb-2">Simulasi CAT Presisi Standar BKN</h3>
                            <p class="text-muted fs-6 mb-4" style="max-width: 480px;">
                                Tampilan antarmuka, nomor soal palet, navigasi ragu-ragu, hingga timer hitung mundur dirancang presisi mengikuti sistem Computer Assisted Test (CAT) resmi BKN.
                            </p>

                            <!-- Mini Interactive Showcase Box inside Bento 1 -->
                            <div class="p-3 bg-white rounded-3 shadow-xs border border-light-subtle d-flex flex-wrap gap-2 align-items-center justify-content-between mt-auto">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.75rem;">
                                        <i class="fe fe-check"></i>
                                    </span>
                                    <div>
                                        <div class="fw-bold text-dark small" style="font-size: 0.78rem;">Sistem Autosave Cloud</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Jawaban aman jika koneksi terputus</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center fw-bold" style="width: 28px; height: 28px; font-size: 0.75rem;">
                                        !
                                    </span>
                                    <div>
                                        <div class="fw-bold text-dark small" style="font-size: 0.78rem;">Tombol Ragu-ragu</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Review cepat sebelum submit</div>
                                    </div>
                                </div>
                                <a href="{{ route('demo.cat') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold">
                                    Coba Demo
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Bento 2: Analisis Skor Real-Time (col-lg-5) -->
                    <div class="col-lg-5 col-12">
                        <div class="card h-100 rounded-4 border-0 shadow-sm p-4 p-md-5 overflow-hidden position-relative hover-lift bg-white"
                             style="border: 1px solid rgba(226, 232, 240, 0.8) !important;">
                            <div class="d-inline-flex align-items-center justify-content-center bg-success-soft text-success rounded-3 mb-3 shadow-xs" style="width: 48px; height: 48px; background-color: #e6f7ed;">
                                <i class="fe fe-bar-chart-2 fs-4 text-success"></i>
                            </div>

                            <h3 class="h4 fw-bold text-dark mb-2">Analisis & Skor Passing Grade</h3>
                            <p class="text-muted small mb-4">
                                Skor langsung terhitung sesaat setelah selesai. Ketahui posisi nilai TWK, TIU, dan TKP terhadap ambang batas kelulusan.
                            </p>

                            <!-- Score Breakdown Preview -->
                            <div class="p-3 rounded-3 border border-light-subtle d-flex flex-column gap-2 mt-auto" style="background: #f8fafc;">
                                <div class="d-flex justify-content-between align-items-center small">
                                    <span class="fw-semibold text-dark">TWK (Wawasan Kebangsaan)</span>
                                    <span class="badge bg-success text-white rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">115 / 65 PG</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%;"></div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center small pt-1">
                                    <span class="fw-semibold text-dark">TIU (Intelegensia Umum)</span>
                                    <span class="badge bg-success text-white rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">135 / 80 PG</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 90%;"></div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center small pt-1">
                                    <span class="fw-semibold text-dark">TKP (Karakteristik Pribadi)</span>
                                    <span class="badge bg-success text-white rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">190 / 166 PG</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 92%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bento 3: Bank Soal HOTS 2026 (col-lg-6) -->
                    <div class="col-lg-6 col-12">
                        <div class="card h-100 rounded-4 border-0 shadow-sm p-4 p-md-5 overflow-hidden position-relative hover-lift bg-white"
                             style="border: 1px solid rgba(226, 232, 240, 0.8) !important;">
                            <div class="d-flex align-items-start gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                                     style="width: 52px; height: 52px; background: #fff9e6; color: #d97706;">
                                    <i class="fe fe-book-open fs-3"></i>
                                </div>
                                <div>
                                    <h3 class="h4 fw-bold text-dark mb-1">Bank Soal HOTS Kisi-Kisi 2026</h3>
                                    <p class="text-muted small mb-0">
                                        Soal disusun mengacu pada Permenpan-RB terbaru dan kompilasi Field Report (FR) peserta seleksi. Dilengkapi tingkat kesulitan bertingkat untuk mengasah kepekaan logika berpikir kritis.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bento 4: Trik Solusi Cepat < 1 Menit (col-lg-6) -->
                    <div class="col-lg-6 col-12">
                        <div class="card h-100 rounded-4 border-0 shadow-sm p-4 p-md-5 overflow-hidden position-relative hover-lift bg-white"
                             style="border: 1px solid rgba(226, 232, 240, 0.8) !important;">
                            <div class="d-flex align-items-start gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                                     style="width: 52px; height: 52px; background: #ffe6e6; color: #dc2626;">
                                    <i class="fe fe-zap fs-3"></i>
                                </div>
                                <div>
                                    <h3 class="h4 fw-bold text-dark mb-1">Trik Eliminasi Opsi & Solusi Cepat</h3>
                                    <p class="text-muted small mb-0">
                                        Waktu SKD sangat singkat (110 soal dalam 100 menit). Di setiap pembahasan, Anda dibekali metode eliminasi opsi jawaban salah dan rumus cepat untuk menghemat 30–45 detik per soal.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 3 LANGKAH MUDAH 2026 -->
        <section id="cara-mulai" class="py-xl-9 py-6 position-relative overflow-hidden" style="background: #f8fafc;">
            <div class="container position-relative" style="z-index: 1;">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-7 col-12">
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill small fw-semibold mb-3" 
                             style="background: #eff6ff; color: #1e40af !important; border: 1px solid rgba(30, 64, 175, 0.2);">
                            <i class="fe fe-compass"></i>
                            <span class="text-uppercase tracking-wider">Alur Singkat & Praktis</span>
                        </div>
                        <h2 class="display-5 fw-bold text-dark mb-3">3 Langkah Cepat Menuju Ujian</h2>
                        <p class="text-muted fs-5 mb-0" style="max-width: 620px; margin: 0 auto;">
                            Tidak perlu proses rumit. Daftarkan dirimu dan mulai asah kemampuan detik ini juga.
                        </p>
                    </div>
                </div>

                <div class="row g-4 text-start position-relative">
                    <!-- Step 1 -->
                    <div class="col-lg-4 col-12">
                        <div class="card h-100 rounded-4 border-0 shadow-sm p-4 p-xl-5 bg-white position-relative hover-lift"
                             style="border: 1px solid rgba(226, 232, 240, 0.9) !important;">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-primary shadow-xs"
                                     style="width: 48px; height: 48px; background: #eff6ff; font-size: 1.25rem;">
                                    <i class="fe fe-user-plus"></i>
                                </div>
                                <span class="badge bg-primary text-white rounded-pill px-3 py-1 small fw-bold">LANGKAH 01</span>
                            </div>
                            <span class="badge rounded-pill px-2.5 py-0.5 fw-bold mb-2 align-self-start" style="background: #dcfce7; color: #166534 !important; font-size: 0.72rem;">
                                GRATIS 100%
                            </span>
                            <h3 class="h4 fw-bold text-dark mb-2">Daftar Akun Kilat</h3>
                            <p class="text-muted small mb-0 lh-base">
                                Registrasi dalam 1 menit via email atau Google. Begitu login, ratusan materi modul ringkas TWK, TIU, dan TKP langsung dapat diakses tanpa biaya.
                            </p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="col-lg-4 col-12">
                        <div class="card h-100 rounded-4 border-0 shadow-sm p-4 p-xl-5 bg-white position-relative hover-lift"
                             style="border: 1px solid rgba(226, 232, 240, 0.9) !important;">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="rounded-3 d-flex align-items-center justify-content-center shadow-xs"
                                     style="width: 48px; height: 48px; background: #fef3c7; color: #d97706; font-size: 1.25rem;">
                                    <i class="fe fe-book-open"></i>
                                </div>
                                <span class="badge rounded-pill px-3 py-1 small fw-bold" style="background: #eff6ff; color: #1e40af !important; border: 1px solid rgba(30, 64, 175, 0.2);">
                                    LANGKAH 02
                                </span>
                            </div>
                            <span class="badge rounded-pill px-2.5 py-0.5 fw-bold mb-2 align-self-start" style="background: #fef3c7; color: #92400e !important; font-size: 0.72rem;">
                                PENGUASAAN MATERI
                            </span>
                            <h3 class="h4 fw-bold text-dark mb-2">Pahami Teori & Trik Cepat</h3>
                            <p class="text-muted small mb-0 lh-base">
                                Pelajari konsep materi terstruktur di HP atau laptop. Kuasai trik eliminasi jawaban salah dan rumus cepat untuk menghemat 30–45 detik di tiap butir soal.
                            </p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="col-lg-4 col-12">
                        <div class="card h-100 rounded-4 border-0 shadow-sm p-4 p-xl-5 bg-white position-relative hover-lift"
                             style="border: 1px solid rgba(226, 232, 240, 0.9) !important;">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-success shadow-xs"
                                     style="width: 48px; height: 48px; background: #dcfce7; font-size: 1.25rem;">
                                    <i class="fe fe-award"></i>
                                </div>
                                <span class="badge bg-success text-white rounded-pill px-3 py-1 small fw-bold">LANGKAH 03</span>
                            </div>
                            <span class="badge rounded-pill px-2.5 py-0.5 fw-bold mb-2 align-self-start" style="background: #dbeafe; color: #1e40af !important; font-size: 0.72rem;">
                                SIMULASI CAT BKN
                            </span>
                            <h3 class="h4 fw-bold text-dark mb-2">Uji Kesiapan Tryout CAT</h3>
                            <p class="text-muted small mb-0 lh-base">
                                Taklukkan simulasi 110 soal ber-timer presisi BKN. Dapatkan skor kelulusan passing grade seketika, pembahasan lengkap, dan sertifikat hasil tryout.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION BLOG & KISI-KISI CPNS 2026 -->
        <section id="blog" class="py-xl-9 py-6 position-relative" style="background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);">
            <div class="container position-relative">
                <div class="row align-items-end mb-5">
                    <div class="col-md-8 col-12 text-center text-md-start">
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill small fw-semibold mb-3" 
                             style="background: #eff6ff; color: #1e40af !important; border: 1px solid rgba(30, 64, 175, 0.2);">
                            <i class="fe fe-file-text"></i>
                            <span class="text-uppercase tracking-wider">Kabar & Wawasan Terupdate</span>
                        </div>
                        <h2 class="display-5 fw-bold text-dark mb-2">Info Pendaftaran & Kisi-kisi CPNS 2026</h2>
                        <p class="text-muted fs-5 mb-0">Ikuti tips sukses, panduan formasi resmi, dan strategi lolos passing grade langsung dari mentor kami.</p>
                    </div>
                    <div class="col-md-4 col-12 text-center text-md-end d-none d-md-block">
                        <a href="{{ route('blog.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2.5 fw-semibold shadow-xs">
                            Lihat Semua Artikel <i class="fe fe-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <div class="row gy-4">
                    @forelse($latestPosts as $post)
                        <div class="col-lg-4 col-md-6 col-12">
                            <article class="blog-card card border-0 shadow-sm h-100 rounded-4 overflow-hidden position-relative hover-lift bg-white"
                                style="border: 1px solid rgba(226, 232, 240, 0.9) !important; transition: all 0.3s ease;">
                                <div class="position-relative overflow-hidden" style="height: 210px; background: #f1f5f9;">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="d-block w-100 h-100 overflow-hidden">
                                        <img src="{{ $post->image_url ?? '/build/assets/images/course/default-blog.png' }}"
                                            alt="{{ $post->title }}" class="w-100 h-100 blog-thumb-img"
                                            style="object-fit: cover; object-position: center; transition: transform 0.4s ease;" />
                                    </a>
                                    @if(isset($post->category))
                                        <span class="position-absolute shadow-sm fw-bold small rounded-pill px-3 py-1"
                                            style="top: 1rem; left: 1rem; z-index: 2; font-size: 0.72rem; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(8px); color: #1e40af !important; border: 1px solid rgba(30, 64, 175, 0.2);">
                                            {{ $post->category->name }}
                                        </span>
                                    @endif
                                </div>

                                <div class="card-body p-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex align-items-center gap-3 mb-2.5 text-muted small" style="font-size: 0.8rem;">
                                            <span class="d-flex align-items-center gap-1.5">
                                                <i class="fe fe-calendar text-primary"></i>
                                                {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                                            </span>
                                            <span class="text-secondary opacity-25">•</span>
                                            <span class="d-flex align-items-center gap-1.5">
                                                <i class="fe fe-user text-muted"></i>
                                                {{ $post->author->name ?? 'Tim CalonASN' }}
                                            </span>
                                        </div>

                                        <h3 class="card-title fw-bold lh-base mb-2 h4">
                                            <a href="{{ route('blog.show', $post->slug) }}"
                                                class="blog-title-link text-dark text-decoration-none hover-primary transition"
                                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                                                {{ $post->title }}
                                            </a>
                                        </h3>

                                        <p class="card-text text-muted small mb-4"
                                            style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.6;">
                                            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                                        </p>
                                    </div>

                                    <div class="pt-3 border-top mt-auto d-flex align-items-center justify-content-between">
                                        <a href="{{ route('blog.show', $post->slug) }}"
                                            class="text-primary fw-bold text-decoration-none d-inline-flex align-items-center gap-1.5 small blog-read-more-btn">
                                            <span>Baca Selengkapnya</span>
                                            <i class="fe fe-arrow-right"></i>
                                        </a>
                                        <span class="text-muted small" style="font-size: 0.75rem;">
                                            <i class="fe fe-clock me-1"></i>3 mnt baca
                                        </span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <div class="text-muted p-5 bg-white rounded-4 shadow-sm border">
                                <i class="fe fe-book-open display-4 mb-3 text-secondary opacity-50"></i>
                                <p class="mb-0 fw-medium fs-5">Belum ada artikel yang diterbitkan.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Tombol Mobile (Route Valid) -->
                <div class="row d-md-none mt-4">
                    <div class="col-12 text-center">
                        <a href="{{ route('blog.index') }}" class="btn btn-outline-primary w-100 rounded-pill py-2.5 fw-semibold shadow-xs">
                            Lihat Semua Artikel <i class="fe fe-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- SECTION FAQ 2026 -->
        <section id="faq" class="py-xl-9 py-6 bg-white position-relative">
            <div class="container py-xl-4">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-12">
                        <div class="text-center mb-5">
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill small fw-semibold mb-3" 
                                 style="background: #eff6ff; color: #1e40af !important; border: 1px solid rgba(30, 64, 175, 0.2);">
                                <i class="fe fe-help-circle"></i>
                                <span class="text-uppercase tracking-wider">F.A.Q • Pertanyaan Umum</span>
                            </div>
                            <h2 class="display-5 fw-bold text-dark mb-3">Pertanyaan yang Sering Diajukan</h2>
                            <p class="text-muted fs-5 mb-0" style="max-width: 600px; margin: 0 auto;">
                                Masih ragu atau butuh informasi lebih lanjut? Temukan jawaban seputar platform CalonASN.id di bawah ini.
                            </p>
                        </div>

                        <div class="accordion modern-faq" id="faqAccordion">

                            <!-- FAQ 1 -->
                            <div class="accordion-item mb-3 border rounded-4 shadow-xs overflow-hidden" 
                                 style="border-color: #e2e8f0 !important; background: #ffffff;">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed bg-transparent shadow-none fw-bold text-dark fs-5 py-4 px-4"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                            aria-expanded="false" aria-controls="collapseOne">
                                        Apakah harus install aplikasi di HP/Laptop?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-dark px-4 pb-4 pt-0" style="line-height: 1.7; color: #475569 !important;">
                                        <strong class="text-dark">Tentu saja tidak!</strong> CalonASN.id berbasis 100% Cloud Web App. Kamu bisa langsung mengerjakan Tryout dari browser modern (Chrome, Safari, Edge) di HP, Tablet, maupun Laptop kapan saja dan di mana saja tanpa membebani memori penyimpanan perangkatmu.
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ 2 -->
                            <div class="accordion-item mb-3 border rounded-4 shadow-xs overflow-hidden"
                                 style="border-color: #e2e8f0 !important; background: #ffffff;">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed bg-transparent shadow-none fw-bold text-dark fs-5 py-4 px-4"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                        Apakah bank soal sudah disesuaikan dengan kisi-kisi resmi BKN 2026?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-dark px-4 pb-4 pt-0" style="line-height: 1.7; color: #475569 !important;">
                                        <strong>Ya, 100% disesuaikan.</strong> Tim penyusun materi kami selalu memantau pembaruan regulasi KemenPAN-RB dan kisi-kisi resmi BKN. Tryout mencakup proporsi presisi: <strong>30 soal TWK</strong>, <strong>35 soal TIU</strong>, dan <strong>45 soal TKP</strong> dengan dominasi soal tipe penalaran analisis <strong>HOTS (Higher Order Thinking Skills)</strong> terbaru.
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ 3 -->
                            <div class="accordion-item mb-3 border rounded-4 shadow-xs overflow-hidden"
                                 style="border-color: #e2e8f0 !important; background: #ffffff;">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed bg-transparent shadow-none fw-bold text-dark fs-5 py-4 px-4"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="false" aria-controls="collapseThree">
                                        Berapa kali saya bisa mengerjakan paket Tryout Premium?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-dark px-4 pb-4 pt-0" style="line-height: 1.7; color: #475569 !important;">
                                        Sistem kami sangat bersahabat: <strong>Beli sesuai kebutuhan tanpa langganan bulanan mahal!</strong> Satu kali pembayaran memberi hak ujian 1 paket Tryout lengkap (110 butir soal).
                                        <div class="mt-2 p-3 rounded-3" style="background: #f8fafc; border-left: 3px solid #2563eb;">
                                            <i class="fe fe-check-circle text-primary me-1"></i> Setelah selesai ujian, akses ke <strong>Skor, Analisis Passing Grade, Kunci Jawaban, dan Trik Pembahasan Cepat</strong> terbuka <strong>selamanya</strong> untuk dipelajari ulang kapan pun kamu mau.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ 4 -->
                            <div class="accordion-item mb-3 border rounded-4 shadow-xs overflow-hidden"
                                 style="border-color: #e2e8f0 !important; background: #ffffff;">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed bg-transparent shadow-none fw-bold text-dark fs-5 py-4 px-4"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                            aria-expanded="false" aria-controls="collapseFour">
                                        Bagaimana sistem penilaian dan pembahasan tryout bekerja?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-dark px-4 pb-4 pt-0" style="line-height: 1.7; color: #475569 !important;">
                                        Begitu waktu habis atau tombol "Selesai Ujian" diklik, sistem mesin kami secara otomatis mengkalkulasi skormu secara instan: bobot benar 5/0 untuk TWK & TIU, serta skala 1–5 untuk TKP. Kamu langsung mengetahui status <strong>Lolos / Tidak Lolos Passing Grade</strong> beserta kunci dan rumus eliminasi opsi trik 1 menit.
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ 5 -->
                            <div class="accordion-item mb-3 border rounded-4 shadow-xs overflow-hidden"
                                 style="border-color: #e2e8f0 !important; background: #ffffff;">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed bg-transparent shadow-none fw-bold text-dark fs-5 py-4 px-4"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                            aria-expanded="false" aria-controls="collapseFive">
                                        Metode pembayaran apa saja yang didukung?
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-dark px-4 pb-4 pt-0" style="line-height: 1.7; color: #475569 !important;">
                                        Kami mendukung pembayaran instan via <strong>QRIS</strong> standar Bank Indonesia yang kompatibel dengan seluruh aplikasi m-Banking (BCA, Mandiri, BRI, BNI, BSI) serta e-Wallet (GoPay, OVO, Dana, ShopeePay, LinkAja). Jangan lupa gunakan voucher <strong>ASN2026</strong> saat checkout untuk potongan langsung Rp 7.000!
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- FAQ Bottom Help Desk Card -->
                        <div class="text-center mt-5 p-4 rounded-4 border bg-white shadow-xs d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3"
                             style="border: 1px solid rgba(226, 232, 240, 0.9) !important;">
                            <div class="text-center text-sm-start">
                                <h4 class="fw-bold text-dark mb-1 fs-5">Masih punya pertanyaan lain?</h4>
                                <p class="text-muted small mb-0">Tim layanan CalonASN.id siap membantumu setiap hari.</p>
                            </div>
                            <a href="mailto:support@calonasn.id?subject=Pertanyaan%20seputar%20Tryout%20CalonASN"
                               class="btn btn-outline-primary rounded-pill px-4 py-2.5 fw-semibold d-inline-flex align-items-center gap-2 text-nowrap shadow-xs">
                                <i class="fe fe-mail"></i>
                                <span>Hubungi support@calonasn.id</span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION FINAL CTA BANNER 2026 -->
        <section class="py-xl-8 py-6 position-relative overflow-hidden" style="background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);">
            <div class="container position-relative" style="z-index: 1;">
                <div class="rounded-5 p-5 p-md-7 text-center position-relative overflow-hidden shadow-2xl" 
                     style="background: radial-gradient(100% 100% at 50% 0%, #1e3a8a 0%, #0f172a 100%); border: 1px solid rgba(59, 130, 246, 0.3);">
                    
                    <!-- Decorative Ambient Glow -->
                    <div class="position-absolute top-0 start-50 translate-middle-x" 
                         style="width: 500px; height: 250px; background: radial-gradient(ellipse, rgba(59, 130, 246, 0.35) 0%, transparent 70%); filter: blur(40px); pointer-events: none;"></div>

                    <div class="position-relative" style="z-index: 2; max-width: 760px; margin: 0 auto;">
                        <!-- Floating Eyebrow Chip -->
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill mb-4 shadow-sm"
                             style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                            <span class="badge bg-warning text-dark rounded-pill px-2 py-0.5 fw-bold" style="font-size: 0.68rem;">UPDATE 2026</span>
                            <span class="text-white small fw-medium">Persaingan NIP CPNS Semakin Ketat</span>
                        </div>

                        <h2 class="display-4 fw-bold text-white mb-3 tracking-tight">
                            Siap Amankan Kursi NIP Impianmu di Seleksi CPNS 2026?
                        </h2>
                        
                        <p class="fs-5 mb-5 opacity-90 lh-base" style="color: #cbd5e1 !important;">
                            Jangan tunggu pengumuman jadwal mepet. Mulai simulasi CAT standar resmi BKN sekarang, uji ketahanan manajemen waktumu, dan taklukkan passing grade dengan percaya diri.
                        </p>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center gap-3 mb-4">
                            @guest
                                <a href="{{ route('register') }}" 
                                   class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg d-inline-flex align-items-center gap-2 text-white hover-lift"
                                   style="background: #2563eb !important; border-color: #2563eb !important; font-size: 1.05rem;">
                                    <span>Mulai Sekarang Gratis</span>
                                    <i class="fe fe-arrow-right"></i>
                                </a>
                            @else
                                <a href="#paket" 
                                   class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg d-inline-flex align-items-center gap-2 text-white hover-lift"
                                   style="background: #2563eb !important; border-color: #2563eb !important; font-size: 1.05rem;">
                                    <span>Pilih Paket Tryout</span>
                                    <i class="fe fe-arrow-right"></i>
                                </a>
                            @endguest

                            <a href="{{ route('demo.cat') }}" 
                               class="btn btn-outline-light btn-lg rounded-pill px-4 py-3 fw-semibold d-inline-flex align-items-center gap-2 hover-white"
                               style="font-size: 1.05rem; border-color: rgba(255, 255, 255, 0.4);">
                                <i class="fe fe-play-circle text-warning fs-5"></i>
                                <span>Coba Demo CAT Gratis</span>
                            </a>
                        </div>

                        <!-- Voucher Note -->
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill" 
                             style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(52, 211, 153, 0.3);">
                            <i class="fe fe-tag text-success" style="color: #34d399 !important;"></i>
                            <span class="small" style="color: #a7f3d0 !important;">
                                Diskon otomatis Rp 7.000 dengan kode promo: <strong class="text-white font-monospace">ASN2026</strong>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Sticky Mobile Bottom CTA Bar (Khusus Layar HP) -->
    <div id="mobileBottomBar" class="d-block d-md-none position-fixed bottom-0 start-0 end-0 bg-white border-top p-2 px-3" 
         style="z-index: 1040; transform: translateY(120%); transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 -4px 20px rgba(15, 23, 42, 0.12) !important;">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <span class="d-block" style="font-size: 0.72rem; color: #64748b !important; font-weight: 500;">Tryout CAT CPNS 2026</span>
                <div class="d-flex align-items-baseline gap-1.5">
                    <span class="fw-bold" style="font-size: 1rem; color: #059669 !important;">Mulai Rp 13.000</span>
                    <span class="text-decoration-line-through" style="font-size: 0.72rem; color: #94a3b8 !important;">Rp 20.000</span>
                </div>
            </div>
            <div>
                <a href="#paket" class="btn btn-primary btn-sm rounded-pill px-3 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-1.5"
                   style="background: #2563eb !important; border-color: #2563eb !important; color: #ffffff !important;">
                    <span>Pilih Paket</span>
                    <i class="fe fe-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Live countdown timer untuk Hero Mockup CAT
            const heroTimerEl = document.getElementById('heroLiveTimer');
            if (heroTimerEl) {
                let heroSeconds = 5079;
                setInterval(() => {
                    if (heroSeconds > 0) {
                        heroSeconds--;
                        const h = String(Math.floor(heroSeconds / 3600)).padStart(2, '0');
                        const m = String(Math.floor((heroSeconds % 3600) / 60)).padStart(2, '0');
                        const s = String(heroSeconds % 60).padStart(2, '0');
                        heroTimerEl.textContent = `${h}:${m}:${s}`;
                    }
                }, 1000);
            }

            // Sticky Mobile CTA Bar show/hide on scroll
            const mobileBar = document.getElementById('mobileBottomBar');
            if (mobileBar) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 350) {
                        mobileBar.style.transform = 'translateY(0)';
                    } else {
                        mobileBar.style.transform = 'translateY(120%)';
                    }
                });
            }
        });

        // Fitur One-Click Salin Kode Promo ASN2026
        function copyPromoCode() {
            navigator.clipboard.writeText('ASN2026').then(() => {
                const btn = document.getElementById('copyPromoBtn');
                if (btn) {
                    btn.innerHTML = '<i class="fe fe-check me-1"></i>Tersalin!';
                    btn.classList.remove('text-success', 'bg-light');
                    btn.classList.add('bg-success', 'text-white');
                    setTimeout(() => {
                        btn.innerHTML = '<i class="fe fe-copy me-1"></i>Salin';
                        btn.classList.remove('bg-success', 'text-white');
                        btn.classList.add('text-success', 'bg-light');
                    }, 2500);
                }
            }).catch(err => {
                console.log('Clipboard error:', err);
            });
        }
    </script>
@endsection

@push('scripts')
    <script src="/build/assets/js/vendors/tnsSlider.js"></script>
@endpush
