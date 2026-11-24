<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Keaslian Sertifikat Resmi - CalonASN.id</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    
    <!-- Feather Icons & Bootstrap Base -->
    <link rel="stylesheet" href="{{ asset('assets/libs/feather-icons/dist/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">

    <style>
        :root {
            --navy-dark: #081a2e;
            --navy-mid: #0f2942;
            --navy-light: #1e3a5f;
            --gold-primary: #d4af37;
            --gold-dark: #b8860b;
            --gold-light: #fef08a;
            --gold-gradient: linear-gradient(135deg, #bf953f 0%, #fcf6ba 25%, #b38728 50%, #fbf5b7 75%, #aa771c 100%);
            --emerald-primary: #059669;
            --emerald-glow: rgba(16, 185, 129, 0.25);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at 50% 10%, #173b61 0%, #0c233c 45%, #071526 100%);
            color: #1e293b;
            min-height: 100vh;
            margin: 0;
            padding: 30px 15px 50px 15px;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Glow & Grid Efek Mewah */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(rgba(212, 175, 55, 0.08) 1px, transparent 1px),
                radial-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px);
            background-size: 40px 40px, 20px 20px;
            background-position: 0 0, 10px 10px;
            pointer-events: none;
            z-index: 0;
        }

        .main-wrapper {
            position: relative;
            z-index: 1;
            max-width: 740px;
            margin: 0 auto;
        }

        /* Kartu Utama Verifikasi */
        .verification-card {
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 
                0 25px 60px -15px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(212, 175, 55, 0.35);
            overflow: hidden;
            position: relative;
        }

        /* Header Mewah Navy & Emas */
        .card-header-luxury {
            background: linear-gradient(135deg, #091e38 0%, #0f2942 60%, #163659 100%);
            padding: 36px 30px 30px 30px;
            text-align: center;
            position: relative;
            border-bottom: 3px solid #d4af37;
        }

        .header-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Cinzel', serif;
            font-size: 70px;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.03);
            letter-spacing: 10px;
            pointer-events: none;
            white-space: nowrap;
        }

        /* Pulsing Status Badge */
        .verified-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(16, 185, 129, 0.15);
            border: 1.5px solid #10b981;
            color: #34d399;
            padding: 8px 20px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
            margin-bottom: 18px;
        }

        .pulse-dot {
            width: 10px;
            height: 10px;
            background-color: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 10px #10b981;
            animation: pulse-ring 1.8s infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .candidate-name-display {
            font-family: 'Cinzel', Georgia, serif;
            color: #ffffff;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 6px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
        }

        .serial-badge-box {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(212, 175, 55, 0.4);
            padding: 5px 14px;
            border-radius: 8px;
            color: #fef08a;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12.5px;
            font-weight: 600;
        }

        /* Body Konten */
        .card-body-luxury {
            padding: 35px 35px 40px 35px;
        }

        /* Info Metadata Table Strip */
        .info-grid {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 25px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 1px dashed #e2e8f0;
            font-size: 13.5px;
        }
        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .info-item:first-child {
            padding-top: 0;
        }
        .info-label {
            color: #64748b;
            font-weight: 500;
        }
        .info-value {
            color: #0f172a;
            font-weight: 700;
            text-align: right;
        }

        /* Section Skor SKD Prestisius */
        .score-headline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .score-cards-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .subtest-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px 10px;
            text-align: center;
            transition: all 0.2s ease;
            position: relative;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        }
        .subtest-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
        }

        .subtest-tag {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #475569;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .subtest-val {
            font-family: 'Inter', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: #0f2942;
            line-height: 1.1;
        }
        .subtest-pg {
            margin-top: 6px;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
            display: inline-block;
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        /* Total Score Big Highlight Banner */
        .total-score-banner {
            background: linear-gradient(135deg, #091e38 0%, #1e40af 100%);
            border-radius: 18px;
            padding: 20px 24px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px -5px rgba(30, 64, 175, 0.35);
            position: relative;
            overflow: hidden;
        }

        .total-score-banner::before {
            content: "★ ★ ★";
            position: absolute;
            right: 18px;
            bottom: 8px;
            font-size: 38px;
            color: rgba(255, 255, 255, 0.07);
            font-family: 'Cinzel', serif;
            pointer-events: none;
        }

        .total-left small {
            color: #fde68a;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 3px;
        }
        .total-left h4 {
            color: #ffffff;
            font-weight: 800;
            margin: 0;
            font-size: 17px;
        }
        .total-left p {
            color: #bfdbfe;
            font-size: 11.5px;
            margin: 3px 0 0 0;
        }

        .total-right-val {
            font-family: 'Inter', sans-serif;
            font-size: 38px;
            font-weight: 900;
            color: #ffffff;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            line-height: 1;
        }

        /* 3 Pilar Keamanan & Integritas */
        .trust-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            background: #f1f5f9;
            border-radius: 14px;
            padding: 12px;
            margin-bottom: 28px;
            text-align: center;
        }

        .trust-item {
            font-size: 11px;
            color: #475569;
            font-weight: 600;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }
        .trust-item i {
            font-size: 16px;
            color: #0f2942;
        }

        /* Action Buttons */
        .btn-view-doc {
            background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
            color: #091e38 !important;
            font-weight: 800;
            font-size: 14px;
            border-radius: 50px;
            padding: 13px 25px;
            box-shadow: 0 8px 20px -3px rgba(184, 134, 11, 0.35);
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-view-doc:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px -3px rgba(184, 134, 11, 0.5);
            color: #000 !important;
        }

        .btn-home-link {
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            color: #475569 !important;
            font-weight: 700;
            font-size: 13.5px;
            border-radius: 50px;
            padding: 12px 25px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-home-link:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #0f172a !important;
        }

        /* Footer Branding */
        .footer-branding {
            text-align: center;
            margin-top: 25px;
            color: #94a3b8;
            font-size: 12.5px;
        }
        .footer-branding a {
            color: #fde68a;
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 600px) {
            body {
                padding: 16px 10px 40px 10px;
            }
            .card-header-luxury {
                padding: 28px 18px 24px 18px;
            }
            .candidate-name-display {
                font-size: 22px;
            }
            .card-body-luxury {
                padding: 24px 18px;
            }
            .score-cards-row {
                gap: 8px;
            }
            .subtest-val {
                font-size: 20px;
            }
            .total-right-val {
                font-size: 30px;
            }
            .trust-grid {
                grid-template-columns: 1fr;
                gap: 8px;
                text-align: left;
            }
            .trust-item {
                flex-direction: row;
                justify-content: flex-start;
                gap: 8px;
            }
        }
    </style>
</head>
<body>

    <div class="main-wrapper">

        @if ($isValid && $isLulus)
            <div class="verification-card">
                
                <!-- 1. Header Prestisius dengan Lencana Hijau & Nama Peserta -->
                <div class="card-header-luxury">
                    <div class="header-watermark">AUTHENTIC</div>

                    <!-- Lencana Terverifikasi Denyut Hijau -->
                    <div class="mb-2">
                        <span class="verified-badge-pill">
                            <span class="pulse-dot"></span>
                            <span>Sertifikat Resmi Terverifikasi</span>
                        </span>
                    </div>

                    <!-- Nama Lengkap Pemilik Sertifikat -->
                    <h1 class="candidate-name-display">{{ $user->name ?? 'Peserta Tryout' }}</h1>
                    
                    <!-- Nomor Registrasi Seri Unik -->
                    <div class="mt-2">
                        <span class="serial-badge-box" title="Nomor Seri Sertifikat Resmi">
                            <i class="fe fe-shield text-warning"></i>
                            <span>{{ $noSertifikat }}</span>
                        </span>
                    </div>
                </div>

                <!-- 2. Konten Rincian Sertifikat -->
                <div class="card-body-luxury">

                    <!-- Ringkasan Info Ujian -->
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label"><i class="fe fe-bookmark me-1.5 text-primary"></i>Program Ujian</span>
                            <span class="info-value">{{ $tryout->title ?? 'Simulasi CAT SKD CPNS' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fe fe-calendar me-1.5 text-primary"></i>Tanggal Terbit</span>
                            <span class="info-value">{{ $tanggal }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fe fe-check-circle me-1.5 text-success"></i>Status SKD</span>
                            <span class="info-value">
                                <span class="badge bg-success-subtle text-success border border-success fw-bold px-2.5 py-1 rounded-pill" style="font-size: 11.5px;">
                                    ✓ LULUS PASSING GRADE RESMI
                                </span>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fe fe-hash me-1.5 text-muted"></i>Kode Token Keamanan</span>
                            <span class="info-value font-monospace text-primary" style="font-size: 12px;">{{ $token ?? ($session->certificate_token ?? 'VERIFIED') }}</span>
                        </div>
                    </div>

                    <!-- Headline Rincian Skor -->
                    <div class="score-headline">
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center">
                            <i class="fe fe-award text-warning fs-5 me-2"></i>Rincian Nilai Ujian SKD Resmi
                        </h6>
                        <span class="text-muted small">Standar BKN 2026</span>
                    </div>

                    <!-- 3 Kotak Subtes (TWK, TIU, TKP) -->
                    <div class="score-cards-row">
                        <!-- TWK -->
                        <div class="subtest-card">
                            <div class="subtest-tag">Tes Wawasan Kebangsaan</div>
                            <div class="subtest-val">{{ $skor['TWK'] ?? '-' }}</div>
                            <div class="subtest-pg">Ambang: 65 (Lulus)</div>
                        </div>

                        <!-- TIU -->
                        <div class="subtest-card">
                            <div class="subtest-tag">Tes Inteligensia Umum</div>
                            <div class="subtest-val">{{ $skor['TIU'] ?? '-' }}</div>
                            <div class="subtest-pg">Ambang: 80 (Lulus)</div>
                        </div>

                        <!-- TKP -->
                        <div class="subtest-card">
                            <div class="subtest-tag">Tes Karakteristik Pribadi</div>
                            <div class="subtest-val">{{ $skor['TKP'] ?? '-' }}</div>
                            <div class="subtest-pg">Ambang: 166 (Lulus)</div>
                        </div>
                    </div>

                    <!-- Total Skor Highlight Banner -->
                    <div class="total-score-banner">
                        <div class="total-left">
                            <small>Akumulasi Seluruh Subtes</small>
                            <h4>TOTAL SKOR AKHIR</h4>
                            <p>Memenuhi dan melampaui ambang batas Passing Grade BKN</p>
                        </div>
                        <div class="total-right">
                            <div class="total-right-val">{{ $skor['TOTAL'] ?? 0 }}</div>
                        </div>
                    </div>

                    <!-- 3 Pilar Keamanan & Integritas Credential -->
                    <div class="trust-grid">
                        <div class="trust-item">
                            <i class="fe fe-lock text-success"></i>
                            <span>Terenkripsi Digital</span>
                        </div>
                        <div class="trust-item">
                            <i class="fe fe-shield text-primary"></i>
                            <span>Sistem Anti-Curang</span>
                        </div>
                        <div class="trust-item">
                            <i class="fe fe-check text-warning"></i>
                            <span>Standar Resmi BKN</span>
                        </div>
                    </div>

                    <!-- Tombol Aksi Mewah -->
                    <div class="d-grid gap-2.5">
                        <a href="{{ route('ujian.sertifikat', $session->id) }}" target="_blank" class="btn-view-doc">
                            <i class="fe fe-file-text fs-5"></i>
                            <span>Buka & Cetak Dokumen Sertifikat Asli</span>
                        </a>

                        <a href="{{ url('/') }}" class="btn-home-link">
                            <i class="fe fe-arrow-left"></i>
                            <span>Kunjungi Website CalonASN.id</span>
                        </a>
                    </div>

                </div>

            </div>
        @else
            <!-- Tampilan Jika Token / Sertifikat Tidak Ditemukan -->
            <div class="verification-card p-5 text-center">
                <div class="rounded-circle bg-danger-subtle text-danger d-inline-flex p-3 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <h3 class="fw-bold text-dark mb-2">Sertifikat Tidak Ditemukan</h3>
                <p class="text-muted mb-4" style="max-width: 480px; margin: 0 auto;">
                    {{ $message ?? 'Kode verifikasi sertifikat tidak valid atau belum terdaftar dalam basis data kelulusan resmi CalonASN.id.' }}
                </p>
                <a href="{{ url('/') }}" class="btn-view-doc px-4 py-2.5" style="display: inline-flex;">
                    <i class="fe fe-home"></i> Kembali ke Beranda CalonASN.id
                </a>
            </div>
        @endif

        <!-- Footer Info -->
        <div class="footer-branding">
            <p class="mb-1">🌐 <a href="https://www.calonasn.id">www.calonasn.id</a> • Lembaga Bimbingan & Simulasi CAT CPNS No. 1</p>
            <p class="small text-white-50 mb-0">Hak Cipta Dilindungi Undang-Undang © 2026 CalonASN.id</p>
        </div>

    </div>

</body>
</html>
