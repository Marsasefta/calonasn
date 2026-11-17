<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Review & Pembahasan Soal - CalonASN.id</title>

    <style>
        @media print {
            nav, .sidenav, .navbar, .btn, .floating-wa-btn, .floating-wa-pill, .btn-scroll-top, header, footer {
                display: none !important;
            }
            body, .db-content, .container {
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            .print-header {
                display: block !important;
                margin-bottom: 25px;
                padding-bottom: 15px;
                border-bottom: 2px solid #0f172a;
            }
            .no-print {
                display: none !important;
            }
            .card {
                border: 1px solid #cbd5e1 !important;
                box-shadow: none !important;
                page-break-inside: avoid;
                break-inside: avoid;
                margin-bottom: 20px !important;
            }
            .badge {
                border: 1px solid #64748b !important;
                color: #0f172a !important;
                background: #f1f5f9 !important;
            }
        }
        @media screen {
            .print-header {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')

    <div class="db-content text-dark">
        <div class="container py-4">
            <!-- Print Header (Tampil saat dicetak/disimpan ke PDF) -->
            <div class="print-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold text-dark mb-1">CalonASN.id - Lembar Pembahasan Tryout CAT</h3>
                        <p class="mb-0 text-muted small">Simulasi CAT CPNS 2026 Standar BKN | TWK, TIU, TKP</p>
                    </div>
                    <div class="text-end">
                        <p class="mb-0 small fw-bold text-dark">Peserta: {{ auth()->user()->name }}</p>
                        <p class="mb-0 small text-muted">Dicetak pada: {{ now()->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="row mb-4 align-items-center no-print">
                <div class="col-md-7">
                    <h2 class="fw-bold mb-0">Review & Pembahasan</h2>
                    <p class="text-muted">Pelajari letak kesalahanmu agar tidak mengulanginya di tes asli.</p>
                </div>
                <div class="col-md-5 text-end d-flex justify-content-md-end align-items-center gap-2">
                    <button type="button" onclick="window.print()" class="btn btn-primary shadow-sm fw-bold rounded-pill px-3 py-2">
                        <i class="fe fe-printer me-1"></i> Cetak / Simpan PDF
                    </button>
                    <a href="{{ route('ujian.hasil', $id) }}" class="btn btn-outline-secondary rounded-pill px-3 py-2">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @foreach ($questions as $index => $q)
                        @php
                            $nomor = $index + 1;
                            $dijawab = $jawabanUser[$q->id] ?? null;

                            // Menentukan apakah soal ini kategori TKP
                            $isTkp = str_contains(strtoupper($q->category->name), 'TKP');

                            // Mencari Kunci Jawaban (Opsi dengan poin tertinggi, max 5)
                            $kunci = $q->options->sortByDesc('point')->first();

                            // Logika Benar/Salah untuk TWK & TIU
                            $isBenar = $dijawab == $kunci->id;

                            // Mencari poin yang didapat user (Khusus TKP)
                            $poinUser = 0;
                            if ($dijawab) {
                                $poinUser = $q->options->where('id', $dijawab)->first()->point ?? 0;
                            }
                        @endphp

                        <div
                            class="card shadow-sm mb-4 border-0 {{ $dijawab ? ($isTkp ? 'border-start border-primary border-4' : ($isBenar ? 'border-start border-success border-4' : 'border-start border-danger border-4')) : 'border-start border-secondary border-4' }}">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="badge bg-primary me-2">{{ $q->category->name }}</span>
                                        <span class="fw-bold">Soal Ke-{{ $nomor }}</span>
                                    </div>
                                    <div>
                                        @if (!$dijawab)
                                            <span class="badge bg-secondary">Tidak Dijawab</span>
                                        @elseif($isTkp)
                                            <span class="badge bg-primary">Skor: {{ $poinUser }} Poin</span>
                                        @elseif($isBenar)
                                            <span class="badge bg-success"><i class="fe fe-check"></i> Benar</span>
                                        @else
                                            <span class="badge bg-danger"><i class="fe fe-x"></i> Salah</span>
                                        @endif
                                    </div>
                                </div>

                                @if ($q->question_text)
                                    <h5 class="lh-base mb-3">{{ $q->question_text }}</h5>
                                @endif

                                @if ($q->question_image)
                                    <div class="mb-4 text-center">
                                        <img src="{{ asset('storage/' . $q->question_image) }}"
                                            class="img-fluid rounded shadow-sm border" alt="Gambar Soal"
                                            style="max-height: 250px;">
                                    </div>
                                @endif

                                <div class="mb-4">
                                    @foreach ($q->options as $optIndex => $opt)
                                        @php
                                            $bgColor = 'bg-white text-dark';
                                            $icon = '';
                                            $poinLabel = '';

                                            if ($isTkp) {
                                                // LOGIKA TAMPILAN TKP (Tampilkan semua poin)
                                                $poinLabel =
                                                    '<span class="badge bg-light text-dark border ms-2 float-end">Poin: ' .
                                                    $opt->point .
                                                    '</span>';

                                                if ($opt->id == $dijawab) {
                                                    $bgColor = 'bg-primary-soft text-primary fw-bold border-primary';
                                                    $icon =
                                                        '<i class="fe fe-check-circle float-end text-primary me-2 mt-1"></i>';
                                                }
                                            } else {
                                                // LOGIKA TAMPILAN TWK & TIU
                                                if ($opt->id == $kunci->id) {
                                                    // Kunci Jawaban (Warna Hijau)
                                                    $bgColor = 'bg-success text-white fw-bold border-success';
                                                    $icon =
                                                        '<i class="fe fe-check-circle float-end text-white mt-1"></i>';
                                                } elseif ($opt->id == $dijawab && !$isBenar) {
                                                    // Jawaban User yang Salah (Warna Merah Dicoret)
                                                    // Menghilangkan text-decoration-line-through agar gambar tidak ikut tercoret, diganti opacity
                                                    $bgColor = 'bg-danger text-white border-danger opacity-75';
                                                    $icon = '<i class="fe fe-x-circle float-end text-white mt-1"></i>';
                                                }
                                            }
                                        @endphp

                                        <div class="p-3 border rounded mb-2 {{ $bgColor }} clearfix">
                                            {!! $icon !!}
                                            {!! $poinLabel !!}

                                            <div class="d-flex align-items-start">
                                                <span class="me-3 fw-bold">{{ chr(65 + $optIndex) }}.</span>
                                                <div>
                                                    @if ($opt->option_text)
                                                        <div
                                                            class="lh-base {{ $opt->id == $dijawab && !$isBenar && !$isTkp ? 'text-decoration-line-through' : '' }}">
                                                            {{ $opt->option_text }}</div>
                                                    @endif

                                                    @if ($opt->option_image)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('storage/' . $opt->option_image) }}"
                                                                class="img-fluid rounded border bg-white p-1"
                                                                alt="Opsi {{ chr(65 + $optIndex) }}"
                                                                style="max-height: 120px;">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="alert alert-info border-0 mb-0">
                                    <h6 class="alert-heading fw-bold"><i class="fe fe-info me-1"></i> Pembahasan:</h6>
                                    <p class="mb-0 small">
                                        {{ $q->discussion ?? 'Belum ada pembahasan untuk soal ini.' }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    @endforeach
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
</body>

</html>
