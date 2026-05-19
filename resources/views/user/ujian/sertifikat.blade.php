<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kelulusan - {{ $user->name }}</title>
    <style>
        /* Pengaturan Kertas A4 Landscape */
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background-color: #e2e8f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Kanvas Sertifikat */
        .certificate-container {
            width: 297mm;
            height: 210mm;
            background: white;
            border: 15px solid #1a202c;
            padding: 40px;
            box-sizing: border-box;
            text-align: center;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .certificate-inner {
            border: 4px double #1a202c;
            height: 100%;
            padding: 40px;
            box-sizing: border-box;
        }

        .title {
            font-size: 50px;
            font-weight: bold;
            color: #b7791f;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .subtitle {
            font-size: 22px;
            color: #4a5568;
            margin-bottom: 40px;
            letter-spacing: 1px;
        }

        .presented-to {
            font-size: 20px;
            margin-bottom: 15px;
            font-style: italic;
        }

        .name {
            font-size: 45px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 25px;
            text-decoration: underline;
            text-underline-offset: 8px;
        }

        .description {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 40px;
            color: #4a5568;
            padding: 0 60px;
        }

        /* Kotak Nilai */
        .scores {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 50px;
            font-family: 'Arial', sans-serif;
        }

        .score-box {
            border: 2px solid #e2e8f0;
            padding: 15px 30px;
            border-radius: 8px;
            background: #f7fafc;
            min-width: 80px;
        }

        .score-title {
            font-size: 16px;
            font-weight: bold;
            color: #718096;
            margin-bottom: 5px;
        }

        .score-value {
            font-size: 28px;
            font-weight: bold;
            color: #2b6cb0;
        }

        .score-box.total {
            background: #2b6cb0;
            border-color: #2b6cb0;
        }

        .score-box.total .score-title {
            color: #e2e8f0;
        }

        .score-box.total .score-value {
            color: white;
        }

        /* Footer & Tanda Tangan */
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 0 60px;
            margin-top: 30px;
        }

        .signature {
            text-align: center;
        }

        .signature-line {
            border-bottom: 2px solid #1a202c;
            width: 220px;
            margin-bottom: 10px;
        }

        .date {
            text-align: left;
            font-size: 18px;
        }

        /* Tombol Cetak (Akan hilang saat diprint) */
        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #38a169;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-family: sans-serif;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-weight: bold;
            z-index: 1000;
        }

        .btn-print:hover {
            background: #2f855a;
        }

        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
            }

            .certificate-container {
                box-shadow: none;
                border: 15px solid #1a202c !important;
                width: 100%;
                height: 100%;
                page-break-after: avoid;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <button class="btn-print no-print" onclick="window.print()">🖨️ Cetak / Simpan sebagai PDF</button>

    <div class="certificate-container">
        <div class="certificate-inner">
            <div class="title">Sertifikat Kelulusan</div>
            <div class="subtitle">Simulasi Tryout CAT CPNS 2026 - CalonASN.id</div>

            <div class="presented-to">Diberikan dengan bangga kepada:</div>
            <div class="name">{{ $user->name }}</div>

            <div class="description">
                Telah berhasil menyelesaikan Simulasi Tryout Calon Pegawai Negeri Sipil (CPNS)
                di platform <strong>CalonASN.id</strong> dan dinyatakan
                <strong>MEMENUHI AMBANG BATAS (PASSING GRADE)</strong> sesuai standar evaluasi nasional.
            </div>

            <div class="scores">
                <div class="score-box">
                    <div class="score-title">TWK</div>
                    <div class="score-value">{{ $skor['TWK'] }}</div>
                </div>
                <div class="score-box">
                    <div class="score-title">TIU</div>
                    <div class="score-value">{{ $skor['TIU'] }}</div>
                </div>
                <div class="score-box">
                    <div class="score-title">TKP</div>
                    <div class="score-value">{{ $skor['TKP'] }}</div>
                </div>
                <div class="score-box total">
                    <div class="score-title">TOTAL SKOR</div>
                    <div class="score-value">{{ $skor['TOTAL'] }}</div>
                </div>
            </div>

            <div class="footer">
                <div class="date">
                    Diterbitkan pada:<br>
                    <strong>{{ $tanggal }}</strong>
                </div>
                <div class="signature">
                    <div class="signature-line"></div>
                    <strong>Penyelenggara</strong><br>
                    CalonASN.id - Platform Tryout No. 1
                </div>
            </div>
        </div>
    </div>

</body>

</html>
