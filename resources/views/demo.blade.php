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
            background-color: var(--bs-body-bg, #ffffff);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--color-light-blue) 0%, var(--bs-body-bg, #ffffff) 100%);
            position: relative;
            overflow: hidden;
        }

        [data-bs-theme="dark"] .hero-section {
            background: radial-gradient(circle at 85% 20%, rgba(59, 130, 246, 0.15) 0%, rgba(15, 23, 42, 0) 60%), linear-gradient(180deg, #090d16 0%, #0f172a 100%) !important;
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
    <div class="py-3 py-md-5 bg-light">
        <div class="container-fluid px-2 px-sm-3 px-md-5">

            <div class="row align-items-center mb-3 mb-md-4 bg-white p-3 rounded-3 shadow-sm border mx-1 mx-md-0">
                <div class="col-md-6 col-12 text-center text-md-start mb-2 mb-md-0">
                    <h4 class="fs-5 fs-md-4 mb-1 text-dark fw-bold"><i class="fe fe-monitor text-primary me-2"></i>SIMULASI CAT CPNS
                        (HALAMAN DEMO)</h4>
                    <p class="text-muted small mb-0">Materi Campuran: TWK, TIU, TKP | <span
                            class="badge bg-danger-soft text-danger fw-bold">PRO-VERSION TEASER</span></p>
                </div>
                <div class="col-md-6 col-12 d-flex justify-content-center justify-content-md-end align-items-center gap-3">
                    <div class="text-md-end text-center">
                        <span class="text-muted small d-block mb-1 fw-medium">SISA WAKTU</span>
                        <h2 id="timer" class="fw-bolder mb-0 text-danger"
                            style="font-family: monospace; letter-spacing: 1px;">05:00</h2>
                    </div>
                </div>
            </div>

            <div class="row g-3 g-md-4">

                <div class="col-lg-9 col-12">
                    <div
                        class="card shadow-sm border-0 rounded-3 min-vh-50 d-flex flex-column justify-content-between p-3 p-md-4 bg-white">
                        <div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 border-bottom pb-3 mb-3 mb-md-4">
                                <h5 class="text-primary fw-bold mb-0 fs-6 fs-md-5" id="soal-materi">Menghitung...</h5>
                                <span class="badge bg-secondary text-white fw-bold py-1.5 py-md-2 px-2.5 px-md-3" id="soal-nomor-badge">Soal No
                                    1</span>
                            </div>

                            <div class="mb-4 text-dark fs-5 fs-md-4 lh-base fw-medium text-start text-md-justify" id="soal-teks">
                                Loading text...
                            </div>

                            <div class="d-flex flex-column gap-2.5 gap-md-3 mb-4 mb-md-5" id="soal-opsi">
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-between align-items-center border-top pt-3 pt-md-4 gap-2">
                            <button class="btn btn-outline-secondary px-3 px-md-4 py-2 py-md-2.5 fs-6 flex-grow-1 flex-md-grow-0 text-center" id="btn-prev"
                                onclick="changeQuestion(-1)">
                                <i class="fe fe-arrow-left me-1 me-md-2"></i> Sebelumnya
                            </button>

                            <button class="btn btn-warning text-white px-3 px-md-4 py-2 py-md-2.5 fs-6 fw-bold flex-grow-1 flex-md-grow-0 text-center" id="btn-ragu"
                                onclick="toggleRaguRagu()">
                                <i class="fe fe-help-circle me-1 me-md-2"></i> Ragu-Ragu
                            </button>

                            <button class="btn btn-primary px-3 px-md-4 py-2 py-md-2.5 fs-6 flex-grow-1 flex-md-grow-0 text-center" id="btn-next" onclick="changeQuestion(1)">
                                Selanjutnya <i class="fe fe-arrow-right ms-1 ms-md-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-12">
                    <div class="card shadow-sm border-0 rounded-3 p-3 p-md-4 bg-white text-center">
                        <h5 class="fw-bold text-dark mb-3 text-start border-bottom pb-2">Navigasi Soal</h5>

                        <div class="d-flex flex-wrap justify-content-start gap-2 mb-4" id="grid-navigasi">
                        </div>

                        <div class="text-start bg-light p-3 rounded border small mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <span class="d-inline-block bg-primary rounded me-2"
                                    style="width: 14px; height: 14px;"></span>
                                <span class="text-muted">Posisi Soal Saat Ini</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="d-inline-block bg-success rounded me-2"
                                    style="width: 14px; height: 14px;"></span>
                                <span class="text-muted">Sudah Dijawab</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="d-inline-block bg-warning rounded me-2"
                                    style="width: 14px; height: 14px;"></span>
                                <span class="text-muted">Ragu-Ragu</span>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-danger btn-lg fw-bold py-3 shadow-sm" onclick="finishExamPrompt()">
                                <i class="fe fe-check-square me-2"></i> SELESAI UJIAN
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL PENAWARAN & HASIL SKOR DEMO (SIMPLE, CLEAN & HIGH CONVERTING) -->
    <div class="modal fade" id="closingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 540px;">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-body p-3 p-md-4 text-center position-relative">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                        aria-label="Close"></button>

                    <!-- 1. Box Skor Demo Jelas & Menonjol -->
                    <div class="d-flex align-items-center justify-content-center gap-2 gap-sm-3 p-2.5 p-sm-3 bg-light rounded-4 border mb-3 text-start">
                        <div class="text-center px-2 px-sm-3 border-end">
                            <span class="text-muted small fw-bold d-block text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">SKOR DEMO</span>
                            <div class="d-flex align-items-baseline justify-content-center gap-1">
                                <h1 class="display-6 display-sm-5 fw-bolder text-primary mb-0 lh-1" id="modal-skor-akhir">0</h1>
                                <span class="fs-6 fs-sm-5 text-muted fw-bold">/ 25</span>
                            </div>
                        </div>
                        <div class="ps-1">
                            <span id="modal-evaluasi-ringkas" class="badge bg-warning-subtle text-dark border border-warning px-2.5 py-1 rounded-pill small fw-bold mb-1">
                                ⚡ Zona Rawan, Perlu Pemantapan
                            </span>
                            <h6 class="fw-bold text-dark mb-0 fs-6">Mau Cek Pembahasan 5 Soal Tadi?</h6>
                            <span class="text-muted small d-block" style="font-size: 0.74rem; line-height: 1.35;">
                                Pelajari trik jawab <strong>&lt; 1 menit</strong> & kuasai 110 Soal HOTS BKN 2026:
                            </span>
                        </div>
                    </div>

                    <!-- 2. Hero Offer: Paket Super Lengkap Unlimited (Pilihan Utama) -->
                    <div class="card border-2 border-primary rounded-4 p-3 text-start mb-3 shadow-xs position-relative overflow-hidden"
                        style="background: linear-gradient(180deg, #f0f7ff 0%, #ffffff 100%);">
                        
                        <div class="position-absolute top-0 end-0 bg-primary text-white px-2.5 px-sm-3 py-1 fw-bold small"
                            style="border-bottom-left-radius: 12px; font-size: 0.65rem; letter-spacing: 0.5px;">
                            ⭐ REKOMENDASI 95% PESERTA
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-primary-soft text-primary rounded-pill px-2.5 py-0.5 fw-bold small">
                                PAKET SUPER LENGKAP
                            </span>
                        </div>

                        <!-- Harga & Kupon Diskon -->
                        <div class="d-flex align-items-baseline gap-2 my-1 flex-wrap">
                            <span class="text-muted text-decoration-line-through small">Rp 49.000</span>
                            <h3 class="fw-bolder text-primary mb-0 lh-1">Rp 42.000</h3>
                            <span class="badge bg-success-subtle text-success border border-success rounded-pill px-2 py-0.5 small fw-bold" style="font-size: 0.7rem;">
                                Hemat Rp 7rb (Kupon: <strong>ASN2026</strong>)
                            </span>
                        </div>
                        <span class="text-muted small d-block mb-2.5" style="font-size: 0.74rem;">
                            Sekali bayar, aktif selamanya tanpa biaya langganan bulanan.
                        </span>

                        <!-- 3 Poin Keunggulan Utama -->
                        <ul class="list-unstyled d-flex flex-column gap-2 text-dark small mb-3">
                            <li class="d-flex align-items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-primary flex-shrink-0 mt-0.5"><path d="M18.178 8c5.096 0 5.096 8 0 8-5.095 0-7.133-8-12.739-8-4.585 0-4.585 8 0 8 5.606 0 7.644-8 12.74-8z"/></svg>
                                <span><strong class="text-primary">Akses Tryout UNLIMITED:</strong> Ulangi simulasi sepuasnya tanpa batas kuota!</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fe fe-book-open text-primary fs-5 flex-shrink-0 mt-0.5"></i>
                                <span><strong>Ratusan Modul Micro-Learning:</strong> Rangkuman materi resmi TWK, TIU, TKP</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fe fe-check-circle text-success fs-5 flex-shrink-0 mt-0.5"></i>
                                <span><strong>110 Soal CAT BKN + Pembahasan Trik &lt; 1 Menit</strong> + Ranking Nasional</span>
                            </li>
                        </ul>

                        <!-- Tombol Beli Paket Lengkap -->
                        @guest
                            <a href="{{ route('register', ['package' => 'tryout-pdf']) }}"
                                class="btn btn-primary rounded-pill py-2.5 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 w-100 text-nowrap"
                                style="font-size: 0.93rem;">
                                <span>Amankan Akses Unlimited • Rp 42.000</span>
                                <i class="fe fe-arrow-right"></i>
                            </a>
                        @else
                            <a href="{{ route('checkout', 2) }}"
                                class="btn btn-primary rounded-pill py-2.5 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 w-100 text-nowrap"
                                style="font-size: 0.93rem;">
                                <span>Amankan Akses Unlimited • Rp 42.000</span>
                                <i class="fe fe-arrow-right"></i>
                            </a>
                        @endguest
                    </div>

                    <!-- 3. Alternatif Pilihan Simple: Paket Latihan Mandiri 13rb (Voucher Card Kuning Menarik) -->
                    <div class="card rounded-4 p-2.5 p-sm-3 text-start mb-3 shadow-xs position-relative"
                        style="background: linear-gradient(135deg, #fffdf5 0%, #fef3c7 100%); border: 1.5px dashed #f59e0b !important;">
                        <div class="d-flex align-items-center justify-content-between gap-2 gap-sm-3">
                            <div class="pe-1">
                                <div class="mb-1">
                                    <span class="badge rounded-pill fw-bold me-1"
                                        style="background: #f59e0b; color: #ffffff; font-size: 0.62rem; padding: 3px 6px; letter-spacing: 0.5px;">
                                        🔥 OPSI HEMAT
                                    </span>
                                    <strong class="text-dark small align-middle">Tryout Mandiri (1x Latihan)</strong>
                                </div>
                                <span class="text-dark opacity-75 d-block" style="font-size: 0.72rem; line-height: 1.3;">
                                    1x CAT BKN (110 Soal) + Kunci & Pembahasan
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-2 gap-sm-2.5 flex-shrink-0">
                                <div class="text-end">
                                    <span class="text-muted text-decoration-line-through d-block" style="font-size: 0.68rem; line-height: 1.2;">Rp 20.000</span>
                                    <span class="fw-bolder text-dark fs-5 lh-1">Rp 13.000</span>
                                </div>
                                @guest
                                    <a href="{{ route('register', ['package' => 'tryout-only']) }}"
                                        class="btn btn-dark btn-sm rounded-pill fw-bold px-2.5 px-sm-3 py-1.5 shadow-xs text-nowrap"
                                        style="font-size: 0.78rem;">
                                        Pilih <i class="fe fe-arrow-right ms-1"></i>
                                    </a>
                                @else
                                    <a href="{{ route('checkout', 1) }}"
                                        class="btn btn-dark btn-sm rounded-pill fw-bold px-2.5 px-sm-3 py-1.5 shadow-xs text-nowrap"
                                        style="font-size: 0.78rem;">
                                        Pilih <i class="fe fe-arrow-right ms-1"></i>
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>

                    <!-- Trust Footer -->
                    <span class="d-block text-muted opacity-75 small text-center" style="font-size: 0.72rem;">
                        <i class="fe fe-shield text-success me-1"></i>Akses instan aktif otomatis • Pembayaran aman via QRIS & Transfer Bank
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 1. BANK SOAL DEMO (TWK, TIU, TKP dengan Aturan Skor Presisi)
        const bankSoal = [{
                materi: "TES WAWASAN KEBANGSAAN (TWK)",
                pertanyaan: "Dalam merumuskan dasar negara Indonesia Pancasila, terjadi perdebatan hangat mengenai sila pertama piagam jakarta. Demi menjaga persatuan bangsa dan menghormati kemajemukan wilayah Indonesia Timur, para tokoh pendiri bangsa sepakat mengubah kalimat tersebut menjadi 'Ketuhanan Yang Maha Esa'. Sikap keteladanan yang paling menonjol dari para tokoh pendiri bangsa dalam peristiwa tersebut melambangkan penjiwaan dari prinsip...",
                opsi: {
                    A: "Nasionalisme chauvinistik demi kepentingan golongan tertentu.",
                    B: "Mengutamakan konsensus kelompok mayoritas di pulau Jawa.",
                    C: "Kompromi politik demi meraih kemerdekaan kilat.",
                    D: "Semangat toleransi tinggi, kebesaran jiwa, dan persatuan nasional.",
                    E: "Ketundukan kaum minoritas terhadap tekanan diplomasi luar negeri."
                },
                tipe: "REGULER", // Skor +5 jika Benar, 0 jika Salah
                kunci: "D"
            },
            {
                materi: "TES INTELIGENCE UMUM (TIU) - BERHITUNG",
                pertanyaan: "Seorang calon peserta seleksi CPNS berlatih mengerjakan tryout selama 5 hari berturut-turut. Pada hari pertama ia mengerjakan 15 soal, hari kedua 18 soal, hari ketiga 24 soal, dan hari keempat 33 soal. Jika pola perkembangan jumlah soal yang dikerjakan mengikuti deret aritmatika bertingkat konstan, berapakah jumlah soal yang ia kerjakan pada hari kelima?",
                opsi: {
                    A: "42 Soal",
                    B: "45 Soal",
                    C: "48 Soal",
                    D: "51 Soal",
                    E: "54 Soal"
                },
                tipe: "REGULER",
                kunci: "B" // Pola selisih (+3, +6, +9, +12) -> 33 + 12 = 45
            },
            {
                materi: "TES INTELIGENCE UMUM (TIU) - SILOGISME",
                pertanyaan: "Semua peserta tryout yang mendapatkan skor di atas passing grade akan diberikan sertifikat kelulusan. Sebagian peserta tryout CalonASN.id adalah mahasiswa tingkat akhir yang belum mendapatkan skor di atas passing grade. Kesimpulan yang paling tepat secara logis adalah...",
                opsi: {
                    A: "Semua mahasiswa tingkat akhir tidak mendapatkan sertifikat kelulusan.",
                    B: "Sebagian peserta tryout CalonASN.id mendapatkan sertifikat kelulusan.",
                    C: "Sebagian peserta tryout CalonASN.id yang merupakan mahasiswa tingkat akhir tidak diberikan sertifikat kelulusan.",
                    D: "Semua peserta tryout CalonASN.id mendapatkan sertifikat kelulusan.",
                    E: "Tidak ada mahasiswa tingkat akhir yang mengikuti tryout di CalonASN.id."
                },
                tipe: "REGULER",
                kunci: "C"
            },
            {
                materi: "TES KARAKTERISTIK PRIBADI (TKP) - PELAYANAN PUBLIK",
                pertanyaan: "Anda adalah seorang petugas loket pelayanan publik informasi instansi pemerintah. Menjelang jam istirahat siang, datang seorang warga lansia yang berjalan pincang ingin mengurus berkas administrasi jaminan sosial yang salah input data. Padahal sistem komputer pusat terpusat sedang mengalami maintenance berkala selama 30 menit ke depan. Sikap tindakan Anda adalah...",
                opsi: {
                    A: "Meminta warga lansia tersebut pulang dan datang kembali besok pagi saat sistem dipastikan sudah normal.",
                    B: "Menjelaskan dengan ramah bahwa sistem sedang maintenance, mempersilakan beliau duduk beristirahat, menawarkan segelas air, dan membantu memeriksa kelengkapan berkas fisik secara manual terlebih dahulu.",
                    C: "Meninggalkan loket untuk pergi makan siang tepat waktu karena sistem komputer sedang rusak dan tidak bisa dipaksakan.",
                    D: "Menyuruh warga tersebut komplain langsung ke bagian tim IT center agar sistem diperbaiki lebih cepat.",
                    E: "Menerima berkasnya begitu saja, menumpuknya di meja loket, lalu menyuruhnya menunggu tanpa penjelasan durasi waktu."
                },
                tipe: "TKP", // Pembobotan Skor Skala 1 - 5
                bobot: {
                    A: 1,
                    B: 5,
                    C: 2,
                    D: 3,
                    E: 4
                }
            },
            {
                materi: "TES KARAKTERISTIK PRIBADI (TKP) - JEJARING KERJA",
                pertanyaan: "Tim kerja Anda di kantor ditugaskan untuk menyusun blueprints inovasi pelayanan digital berbasis mobile. Namun, terdapat dua rekan tim senior yang sangat kaku, menolak perubahan (gaptek), dan selalu mengkritik ide-ide kreatif platform modern yang diajukan oleh rekan kerja angkatan muda. Menghadapi situasi hambatan internal ini, respon Anda adalah...",
                opsi: {
                    A: "Melaporkan perilaku kedua senior tersebut ke atasan agar mereka dikeluarkan dari komite proyek inovasi.",
                    B: "Mengalah dan mengikuti kemauan metode manual lama para senior demi menghindari pergesekan konflik kerja.",
                    C: "Membentuk kelompok obrolan tandingan tersendiri tanpa melibatkan unsur senior agar pengerjaan modul selesai cepat.",
                    D: "Melakukan pendekatan personal secara persuasif, mendengarkan kekhawatiran mereka, lalu membantu melatih mereka menggunakan tools digital baru secara bertahap serta menunjukkan efisiensi hasilnya.",
                    E: "Melanjutkan presentasi proyek dan mengabaikan semua interupsi kritik dari senior karena menganggap mereka ketinggalan zaman."
                },
                tipe: "TKP",
                bobot: {
                    A: 2,
                    B: 1,
                    C: 3,
                    D: 5,
                    E: 4
                }
            }
        ];

        // 2. STATE VARIABEL AKTIF SIMULASI
        let currentIdx = 0;
        let jawabanUser = new Array(bankSoal.length).fill(null);
        let statusRagu = new Array(bankSoal.length).fill(false);
        let sisaWaktu = 5 * 60; // 5 Menit dalam hitungan detik

        // 3. RENDER KONTEN KE INTERFACE WEB
        function renderQuestion() {
            const q = bankSoal[currentIdx];

            // Atur teks header & nomor
            document.getElementById('soal-materi').innerText = q.materi;
            document.getElementById('soal-nomor-badge').innerText = `Soal No ${currentIdx + 1}`;
            document.getElementById('soal-teks').innerText = q.pertanyaan;

            // Atur Opsi Radio Pilihan Ganda
            const opsiContainer = document.getElementById('soal-opsi');
            opsiContainer.innerHTML = '';

            for (let key in q.opsi) {
                const isChecked = jawabanUser[currentIdx] === key ? 'checked' : '';
                const isActiveClass = jawabanUser[currentIdx] === key ? 'border-primary bg-primary-soft' : 'bg-white';

                opsiContainer.innerHTML += `
                <div class="card p-3 border rounded-3 cursor-pointer option-card transition-all ${isActiveClass}" onclick="selectOption('${key}')" style="cursor: pointer;">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="radio" name="radio-soal" id="opsi-${key}" value="${key}" ${isChecked}>
                        <label class="form-check-input-label text-dark fw-medium ps-2 mb-0 cursor-pointer" for="opsi-${key}">
                            <strong class="me-1">${key}.</strong> ${q.opsi[key]}
                        </label>
                    </div>
                </div>
            `;
            }

            // Kontrol Kondisi Tombol Ragu-Ragu Aktif
            const btnRagu = document.getElementById('btn-ragu');
            if (statusRagu[currentIdx]) {
                btnRagu.classList.remove('btn-warning');
                btnRagu.classList.add('btn-dark');
            } else {
                btnRagu.classList.remove('btn-dark');
                btnRagu.classList.add('btn-warning');
            }

            // Atur visibilitas tombol Navigasi Pojok & Tombol Selesai Ujian
            document.getElementById('btn-prev').disabled = currentIdx === 0;

            const allAnswered = bankSoal.every((_, i) => jawabanUser[i] !== null);
            const isLastQuestion = (currentIdx === bankSoal.length - 1);
            const btnNext = document.getElementById('btn-next');

            if (isLastQuestion) {
                if (allAnswered) {
                    btnNext.innerHTML = '<i class="fe fe-check-square me-1 me-md-2"></i> Selesai Ujian';
                    btnNext.className = 'btn btn-danger px-3 px-md-4 py-2 py-md-2.5 fs-6 fw-bold shadow-sm flex-grow-1 flex-md-grow-0 text-center';
                    btnNext.disabled = false;
                    btnNext.onclick = function() {
                        finishExamPrompt();
                    };
                } else {
                    btnNext.innerHTML = 'Selanjutnya <i class="fe fe-arrow-right ms-1 ms-md-2"></i>';
                    btnNext.className = 'btn btn-primary px-3 px-md-4 py-2 py-md-2.5 fs-6 flex-grow-1 flex-md-grow-0 text-center';
                    btnNext.disabled = true;
                    btnNext.onclick = function() {
                        changeQuestion(1);
                    };
                }
            } else {
                btnNext.innerHTML = 'Selanjutnya <i class="fe fe-arrow-right ms-1 ms-md-2"></i>';
                btnNext.className = 'btn btn-primary px-3 px-md-4 py-2 py-md-2.5 fs-6 flex-grow-1 flex-md-grow-0 text-center';
                btnNext.disabled = false;
                btnNext.onclick = function() {
                    changeQuestion(1);
                };
            }

            // Render ulang kotak navigasi kanan agar sinkron warnanya
            renderNavGrid();
        }

        // 4. LOGIKA EVENT JAVASCRIPT
        function selectOption(key) {
            jawabanUser[currentIdx] = key;
            renderQuestion();
        }

        function toggleRaguRagu() {
            if (jawabanUser[currentIdx] === null) {
                alert('Pilih satu opsi jawaban terlebih dahulu sebelum menandai Ragu-Ragu!');
                return;
            }
            statusRagu[currentIdx] = !statusRagu[currentIdx];
            renderQuestion();
        }

        function changeQuestion(direction) {
            currentIdx += direction;
            renderQuestion();
        }

        function jumpToQuestion(idx) {
            currentIdx = idx;
            renderQuestion();
        }

        // 5. RENDER GRID ANGKA SEBELAH KANAN
        function renderNavGrid() {
            const grid = document.getElementById('grid-navigasi');
            grid.innerHTML = '';

            bankSoal.forEach((soal, i) => {
                let btnClass = "btn-outline-secondary"; // Default belum diisi

                if (jawabanUser[i] !== null) {
                    btnClass = "btn-success text-white border-success"; // Sudah diisi sukses
                }
                if (statusRagu[i]) {
                    btnClass = "btn-warning text-white border-warning"; // Status ragu mengalahkan status sukses
                }
                if (i === currentIdx) {
                    btnClass = "btn-primary text-white border-primary shadow"; // Posisi aktif mengunci segalanya
                }

                grid.innerHTML += `
                <button class="btn ${btnClass} fw-bold" style="width: 48px; height: 48px;" onclick="jumpToQuestion(${i})">
                    ${i + 1}
                </button>
            `;
            });
        }

        // 6. MOTOR COUNTDOWN TIMER
        const timerInterval = setInterval(function() {
            let menit = Math.floor(sisaWaktu / 60);
            let detik = sisaWaktu % 60;

            document.getElementById('timer').innerText =
                String(menit).padStart(2, '0') + ":" + String(detik).padStart(2, '0');

            if (sisaWaktu <= 0) {
                clearInterval(timerInterval);
                calculateFinalScore(); // Otomatis kumpul jika waktu habis
            }
            sisaWaktu--;
        }, 1000);

        // 7. PROMPT SEBELUM KUMPUL DATA
        function finishExamPrompt() {
            // Cek apakah ada yang ragu-ragu atau belum diisi
            const belumDiisi = jawabanUser.filter(j => j === null).length;
            const masihRagu = statusRagu.filter(r => r === true).length;

            let pesan = 'Apakah Anda yakin ingin mengakhiri sesi simulasi demo ini?';
            if (belumDiisi > 0 || masihRagu > 0) {
                pesan =
                    `Peringatan: Terdapat ${belumDiisi} soal belum dijawab dan ${masihRagu} soal berstatus Ragu-Ragu. Yakin ingin mengakhiri sekarang?`;
            }

            if (confirm(pesan)) {
                clearInterval(timerInterval);
                calculateFinalScore();
            }
        }

        // 8. ENGINE UTAMA HITUNG SKOR SECARA ADIL (TWK/TIU VS TKP SKALA)
        function calculateFinalScore() {
            let totalSkor = 0;

            bankSoal.forEach((soal, i) => {
                const jawaban = jawabanUser[i];

                if (jawaban !== null) {
                    if (soal.tipe === "REGULER") {
                        // Sistem skor TWK/TIU: Benar dapat 5, salah 0
                        if (jawaban === soal.kunci) {
                            totalSkor += 5;
                        }
                    } else if (soal.tipe === "TKP") {
                        // Sistem skor TKP: Skala pembobotan 1-5 berdasarkan pilihan huruf
                        const poin = soal.bobot[jawaban] || 0;
                        totalSkor += poin;
                    }
                }
            });

            // Lempar skor ke dalam Modal pop-up closing
            document.getElementById('modal-skor-akhir').innerText = totalSkor;

            // Evaluasi skor dinamis ringkas (Tetap mempertahankan styling badge pill elegan)
            const evaluasiRingkas = document.getElementById('modal-evaluasi-ringkas');
            if (evaluasiRingkas) {
                if (totalSkor >= 20) {
                    evaluasiRingkas.className = 'badge bg-success-subtle text-success border border-success rounded-pill px-2.5 py-1 small fw-bold mb-1';
                    evaluasiRingkas.innerText = '🔥 Potensi Bagus, Siap Lolos!';
                } else if (totalSkor >= 12) {
                    evaluasiRingkas.className = 'badge bg-warning-subtle text-dark border border-warning px-2.5 py-1 rounded-pill small fw-bold mb-1';
                    evaluasiRingkas.innerText = '⚡ Zona Rawan, Perlu Pemantapan';
                } else {
                    evaluasiRingkas.className = 'badge bg-danger-subtle text-danger border border-danger rounded-pill px-2.5 py-1 small fw-bold mb-1';
                    evaluasiRingkas.innerText = '⚠️ Waspada, Butuh Latihan Rutin';
                }
            }

            // Panggil modal Bootstrap secara otomatis tanpa jQuery
            var closingModal = new bootstrap.Modal(document.getElementById('closingModal'));
            closingModal.show();
        }

        // Jalankan inisialisasi awal saat halaman dibuka
        window.onload = function() {
            renderQuestion();
        };
    </script>
@endsection

@push('scripts')
    <script src="/build/assets/js/vendors/tnsSlider.js"></script>
@endpush
