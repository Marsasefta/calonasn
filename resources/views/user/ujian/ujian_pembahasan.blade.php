<!doctype html>
<html lang="id">

<head>
    @include('partials.head')

    <title>Review &amp; Pembahasan Soal - CalonASN.id</title>

    <style>
        .pembahasan-shell {
            max-width: 960px;
            margin: 0 auto;
        }

        .question-card-item {
            scroll-margin-top: 90px;
        }

        .question-body {
            font-size: 1.04rem;
            line-height: 1.75;
            color: #0f172a;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        [data-bs-theme="dark"] .question-body {
            color: #f1f5f9;
        }

        .opt-box {
            padding: 0.85rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            margin-bottom: 0.55rem;
            background-color: #ffffff;
            color: #1e293b;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        [data-bs-theme="dark"] .opt-box {
            background-color: #0f172a;
            border-color: #334155;
            color: #e2e8f0;
        }

        .opt-box-correct {
            background-color: #dcfce7 !important;
            border-color: #16a34a !important;
            color: #14532d !important;
            font-weight: 600;
        }

        [data-bs-theme="dark"] .opt-box-correct {
            background-color: rgba(22, 163, 74, 0.22) !important;
            border-color: #22c55e !important;
            color: #bbf7d0 !important;
        }

        .opt-box-wrong {
            background-color: #fee2e2 !important;
            border-color: #dc2626 !important;
            color: #7f1d1d !important;
        }

        [data-bs-theme="dark"] .opt-box-wrong {
            background-color: rgba(220, 38, 38, 0.22) !important;
            border-color: #ef4444 !important;
            color: #fecaca !important;
        }

        .opt-box-tkp-selected {
            background-color: #dbeafe !important;
            border-color: #2563eb !important;
            color: #1e3a8a !important;
            font-weight: 600;
        }

        [data-bs-theme="dark"] .opt-box-tkp-selected {
            background-color: rgba(37, 99, 235, 0.22) !important;
            border-color: #60a5fa !important;
            color: #bfdbfe !important;
        }

        .discussion-box {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            border-left: 4px solid #2563eb;
            color: #1e3a8a;
            border-radius: 0.75rem;
            padding: 1rem 1.1rem;
            font-size: 0.96rem;
            line-height: 1.7;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        [data-bs-theme="dark"] .discussion-box {
            background-color: rgba(30, 58, 138, 0.24);
            border-color: rgba(96, 165, 250, 0.35);
            border-left-color: #60a5fa;
            color: #dbeafe;
        }

        .jump-num-btn {
            width: 38px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            border-radius: 0.5rem;
        }

        @media (max-width: 575.98px) {
            .question-body {
                font-size: 0.98rem;
            }

            .opt-box {
                padding: 0.75rem 0.85rem;
                font-size: 0.94rem;
            }

            .discussion-box {
                padding: 0.85rem 0.95rem;
                font-size: 0.92rem;
            }
        }

        @media print {
            nav, .sidenav, .navbar, .btn, .floating-wa-btn, .floating-wa-pill, .btn-scroll-top, header, footer, .no-print {
                display: none !important;
            }
            body, .db-content, .container-fluid, .pembahasan-shell {
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            .question-card-item {
                display: block !important;
            }
            .print-header {
                display: block !important;
                margin-bottom: 20px;
                padding-bottom: 12px;
                border-bottom: 2px solid #0f172a;
            }
            .card {
                border: 1px solid #cbd5e1 !important;
                box-shadow: none !important;
                page-break-inside: avoid;
                break-inside: avoid;
                margin-bottom: 18px !important;
            }
            .opt-box, .opt-box-correct, .opt-box-wrong, .opt-box-tkp-selected, .discussion-box {
                background: #ffffff !important;
                color: #0f172a !important;
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
    @include('partials.navbar')
    @include('partials.navbar-student')

    @php
        $preparedItems = [];
        $countAll = 0;
        $countCorrect = 0;
        $countWrong = 0;
        $countUnanswered = 0;
        $categoryBuckets = [];

        foreach ($questions as $index => $q) {
            $nomor = $index + 1;
            $dijawab = $jawabanUser[$q->id] ?? null;
            $catName = $q->category?->name ?? 'Umum';
            $catKey = strtoupper(trim($catName));
            $isTkp = str_contains($catKey, 'TKP');

            $kunci = $q->options->sortByDesc('point')->first();
            $kunciId = $kunci?->id;
            $isBenar = !$isTkp && $kunciId !== null && $dijawab == $kunciId;

            $poinUser = 0;
            if ($dijawab) {
                $poinUser = (int) ($q->options->firstWhere('id', $dijawab)?->point ?? 0);
            }

            if (!$dijawab) {
                $statusKey = 'unanswered';
                $countUnanswered++;
            } elseif (($isTkp && $poinUser >= 5) || (!$isTkp && $isBenar)) {
                $statusKey = 'correct';
                $countCorrect++;
            } else {
                $statusKey = 'wrong';
                $countWrong++;
            }

            $countAll++;
            $categoryBuckets[$catKey] = ($categoryBuckets[$catKey] ?? 0) + 1;

            $preparedItems[] = compact('q', 'nomor', 'dijawab', 'catName', 'catKey', 'isTkp', 'kunciId', 'isBenar', 'poinUser', 'statusKey');
        }
    @endphp

    <div class="db-content">
        <div class="container-fluid py-3 py-md-4">
            <div class="pembahasan-shell">

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

                <!-- Header Screen -->
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4 no-print">
                    <div>
                        <h2 class="fw-bold mb-1">Review &amp; Pembahasan Soal</h2>
                        <p class="text-muted small mb-0">
                            Pelajari kunci jawaban, poin tiap opsi, dan pembahasan untuk memperbaiki hasil di tes berikutnya.
                        </p>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" onclick="window.print()" class="btn btn-primary btn-sm shadow-sm fw-bold rounded-pill px-3 py-2">
                            <i class="fe fe-printer me-1"></i> Cetak / PDF
                        </button>
                        <a href="{{ route('ujian.hasil', $id) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2 fw-semibold">
                            <i class="fe fe-arrow-left me-1"></i> Kembali ke Hasil
                        </a>
                    </div>
                </div>

                <!-- 4 Kartu Ringkasan Evaluasi -->
                <div class="row g-2 g-md-3 mb-4 no-print">
                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold d-block">Total Soal</span>
                                <span class="fs-3 fw-bolder text-dark">{{ $countAll }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold d-block">Benar / Poin 5</span>
                                <span class="fs-3 fw-bolder text-success">{{ $countCorrect }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold d-block">Perlu Evaluasi</span>
                                <span class="fs-3 fw-bolder text-danger">{{ $countWrong }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold d-block">Tidak Dijawab</span>
                                <span class="fs-3 fw-bolder text-secondary">{{ $countUnanswered }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel Filter & Quick Jump Nomor Soal -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 no-print">
                    <div class="card-body p-3">
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                <div class="d-flex flex-wrap align-items-center gap-1.5">
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold js-status-filter active" data-status="all">
                                        Semua ({{ $countAll }})
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold js-status-filter" data-status="wrong">
                                        Salah / &lt; 5 Poin ({{ $countWrong }})
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold js-status-filter" data-status="unanswered">
                                        Kosong ({{ $countUnanswered }})
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold js-status-filter" data-status="correct">
                                        Benar / 5 Poin ({{ $countCorrect }})
                                    </button>
                                </div>

                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#quickJumpCollapse" aria-expanded="false">
                                    <i class="fe fe-grid me-1"></i> Lompat Nomor
                                </button>
                            </div>

                            @if (count($categoryBuckets) > 1)
                                <div class="d-flex flex-wrap align-items-center gap-1.5 pt-2 border-top">
                                    <span class="small text-muted fw-semibold me-1">Kategori:</span>
                                    <button type="button" class="btn btn-sm btn-dark rounded-pill px-3 py-1 js-cat-filter active" data-cat="all">
                                        Semua
                                    </button>
                                    @foreach ($categoryBuckets as $cKey => $cTotal)
                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 js-cat-filter" data-cat="{{ $cKey }}">
                                            {{ $cKey }} ({{ $cTotal }})
                                        </button>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Grid Lompat Nomor Soal -->
                            <div class="collapse pt-2 border-top" id="quickJumpCollapse">
                                <div class="d-flex flex-wrap gap-1.5" style="max-height: 220px; overflow-y: auto;">
                                    @foreach ($preparedItems as $item)
                                        @php
                                            $jumpBtnClass = match ($item['statusKey']) {
                                                'correct' => 'btn-outline-success',
                                                'wrong' => 'btn-outline-danger',
                                                default => 'btn-outline-secondary',
                                            };
                                        @endphp
                                        <button type="button"
                                            class="btn {{ $jumpBtnClass }} jump-num-btn js-jump-btn"
                                            data-target="soal-{{ $item['nomor'] }}"
                                            data-status="{{ $item['statusKey'] }}"
                                            data-cat="{{ $item['catKey'] }}">
                                            {{ $item['nomor'] }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State Saat Filter Tidak Cocok -->
                <div id="emptyFilterCard" class="card border-0 shadow-sm rounded-4 mb-4 d-none no-print">
                    <div class="card-body p-4 text-center">
                        <div class="fs-2 mb-2">✨</div>
                        <h5 class="fw-bold mb-1">Tidak Ada Soal pada Filter Ini</h5>
                        <p class="text-muted small mb-3">Semua soal tidak memenuhi kombinasi filter yang dipilih.</p>
                        <button type="button" id="resetFiltersBtn" class="btn btn-sm btn-primary rounded-pill px-4 fw-semibold">
                            Tampilkan Semua Soal
                        </button>
                    </div>
                </div>

                <!-- Daftar Kartu Pembahasan -->
                <div id="questionsContainer">
                    @foreach ($preparedItems as $item)
                        @php
                            $q = $item['q'];
                            $nomor = $item['nomor'];
                            $dijawab = $item['dijawab'];
                            $isTkp = $item['isTkp'];
                            $kunciId = $item['kunciId'];
                            $isBenar = $item['isBenar'];
                            $poinUser = $item['poinUser'];
                            $statusKey = $item['statusKey'];

                            $cardBorderClass = match ($statusKey) {
                                'unanswered' => 'border-secondary',
                                'correct' => 'border-success',
                                default => $isTkp ? 'border-primary' : 'border-danger',
                            };
                        @endphp

                        <article id="soal-{{ $nomor }}"
                            data-status="{{ $statusKey }}"
                            data-cat="{{ $item['catKey'] }}"
                            class="card shadow-sm mb-4 border-0 rounded-4 border-start border-4 {{ $cardBorderClass }} question-card-item">
                            <div class="card-body p-3 p-sm-4">

                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <span class="badge bg-primary rounded-pill px-3 py-1">{{ $item['catName'] }}</span>
                                        <span class="fw-bold">Soal Ke-{{ $nomor }}</span>
                                    </div>
                                    <div>
                                        @if (!$dijawab)
                                            <span class="badge bg-secondary rounded-pill px-3 py-1">Tidak Dijawab</span>
                                        @elseif ($isTkp)
                                            <span class="badge {{ $poinUser >= 5 ? 'bg-success' : 'bg-primary' }} rounded-pill px-3 py-1">
                                                Skor: {{ $poinUser }} Poin
                                            </span>
                                        @elseif ($isBenar)
                                            <span class="badge bg-success rounded-pill px-3 py-1">
                                                <i class="fe fe-check me-1"></i> Benar
                                            </span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-3 py-1">
                                                <i class="fe fe-x me-1"></i> Salah
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @if ($q->question_text)
                                    <div class="question-body fw-medium mb-3">{!! nl2br(e($q->question_text)) !!}</div>
                                @endif

                                @if ($q->question_image)
                                    <div class="mb-3 text-center">
                                        <img src="{{ asset('storage/' . $q->question_image) }}"
                                            class="img-fluid rounded-3 shadow-sm border"
                                            alt="Gambar Soal {{ $nomor }}"
                                            loading="lazy" decoding="async"
                                            style="max-height: 280px;">
                                    </div>
                                @endif

                                <div class="mb-3">
                                    @foreach ($q->options as $optIndex => $opt)
                                        @php
                                            $optBoxClass = 'opt-box';
                                            $rightBadges = '';
                                            $strikeWrong = false;

                                            if ($isTkp) {
                                                $isMaxOpt = (int) $opt->point === 5;
                                                $isPicked = $opt->id == $dijawab;

                                                if ($isPicked && $isMaxOpt) {
                                                    $optBoxClass .= ' opt-box-correct';
                                                } elseif ($isPicked) {
                                                    $optBoxClass .= ' opt-box-tkp-selected';
                                                } elseif ($isMaxOpt) {
                                                    $optBoxClass .= ' opt-box-correct';
                                                }

                                                if ($isPicked) {
                                                    $rightBadges .= '<span class="badge bg-primary rounded-pill me-1">Pilihanmu</span>';
                                                }
                                                $ptBadgeClass = $isMaxOpt ? 'bg-success text-white' : 'bg-secondary-subtle text-secondary-emphasis border';
                                                $rightBadges .= '<span class="badge ' . $ptBadgeClass . ' rounded-pill">Poin: ' . (int) $opt->point . '</span>';
                                            } else {
                                                if ($kunciId !== null && $opt->id == $kunciId) {
                                                    $optBoxClass .= ' opt-box-correct';
                                                    $rightBadges = $opt->id == $dijawab
                                                        ? '<span class="badge bg-success rounded-pill"><i class="fe fe-check me-1"></i>Jawabanmu (Benar)</span>'
                                                        : '<span class="badge bg-success rounded-pill"><i class="fe fe-check me-1"></i>Kunci</span>';
                                                } elseif ($opt->id == $dijawab && !$isBenar) {
                                                    $optBoxClass .= ' opt-box-wrong';
                                                    $strikeWrong = true;
                                                    $rightBadges = '<span class="badge bg-danger rounded-pill"><i class="fe fe-x me-1"></i>Jawabanmu</span>';
                                                }
                                            }
                                        @endphp

                                        <div class="{{ $optBoxClass }} d-flex flex-column flex-sm-row align-items-sm-start justify-content-between gap-2">
                                            <div class="d-flex align-items-start gap-2 min-w-0 flex-grow-1">
                                                <span class="fw-bold flex-shrink-0">{{ chr(65 + $optIndex) }}.</span>
                                                <div class="min-w-0 flex-grow-1">
                                                    @if ($opt->option_text)
                                                        <div class="lh-base {{ $strikeWrong ? 'text-decoration-line-through' : '' }}">
                                                            {!! nl2br(e($opt->option_text)) !!}
                                                        </div>
                                                    @endif

                                                    @if ($opt->option_image)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('storage/' . $opt->option_image) }}"
                                                                class="img-fluid rounded border bg-white p-1"
                                                                alt="Opsi {{ chr(65 + $optIndex) }}"
                                                                loading="lazy" decoding="async"
                                                                style="max-height: 120px;">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            @if ($rightBadges !== '')
                                                <div class="d-flex align-items-center gap-1 flex-shrink-0 align-self-end align-self-sm-center">
                                                    {!! $rightBadges !!}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <div class="discussion-box">
                                    <div class="fw-bold mb-1">
                                        <i class="fe fe-info me-1"></i> Pembahasan:
                                    </div>
                                    <div>
                                        @if (!empty(trim((string) $q->discussion)))
                                            {!! nl2br(e($q->discussion)) !!}
                                        @else
                                            <span class="fst-italic opacity-75">Belum ada pembahasan untuk soal ini.</span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </article>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    @include('partials.btn-scroll-top')
    @include('partials.scripts')
    <script src="/build/assets/js/vendors/navbar-nav.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let activeStatus = 'all';
            let activeCat = 'all';

            const cards = Array.from(document.querySelectorAll('.question-card-item'));
            const jumpBtns = Array.from(document.querySelectorAll('.js-jump-btn'));
            const emptyCard = document.getElementById('emptyFilterCard');
            const statusBtns = Array.from(document.querySelectorAll('.js-status-filter'));
            const catBtns = Array.from(document.querySelectorAll('.js-cat-filter'));

            function applyFilters() {
                let visibleCount = 0;

                cards.forEach(function (card) {
                    const st = card.getAttribute('data-status');
                    const cat = card.getAttribute('data-cat');
                    const show = (activeStatus === 'all' || st === activeStatus) && (activeCat === 'all' || cat === activeCat);
                    card.classList.toggle('d-none', !show);
                    if (show) visibleCount++;
                });

                jumpBtns.forEach(function (btn) {
                    const st = btn.getAttribute('data-status');
                    const cat = btn.getAttribute('data-cat');
                    const show = (activeStatus === 'all' || st === activeStatus) && (activeCat === 'all' || cat === activeCat);
                    btn.classList.toggle('d-none', !show);
                });

                if (emptyCard) {
                    emptyCard.classList.toggle('d-none', visibleCount > 0);
                }
            }

            statusBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    activeStatus = this.getAttribute('data-status') || 'all';
                    statusBtns.forEach(function (b) {
                        b.classList.remove('active', 'btn-primary', 'btn-danger', 'btn-secondary', 'btn-success');
                        const st = b.getAttribute('data-status');
                        if (st === 'wrong') b.classList.add('btn-outline-danger');
                        else if (st === 'unanswered') b.classList.add('btn-outline-secondary');
                        else if (st === 'correct') b.classList.add('btn-outline-success');
                        else b.classList.add('btn-outline-primary');
                    });

                    this.classList.remove('btn-outline-primary', 'btn-outline-danger', 'btn-outline-secondary', 'btn-outline-success');
                    this.classList.add('active');
                    if (activeStatus === 'wrong') this.classList.add('btn-danger');
                    else if (activeStatus === 'unanswered') this.classList.add('btn-secondary');
                    else if (activeStatus === 'correct') this.classList.add('btn-success');
                    else this.classList.add('btn-primary');

                    applyFilters();
                });
            });

            catBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    activeCat = this.getAttribute('data-cat') || 'all';
                    catBtns.forEach(function (b) {
                        b.classList.remove('active', 'btn-dark');
                        b.classList.add('btn-outline-secondary');
                    });
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('active', 'btn-dark');
                    applyFilters();
                });
            });

            jumpBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const el = targetId ? document.getElementById(targetId) : null;
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            const resetBtn = document.getElementById('resetFiltersBtn');
            if (resetBtn) {
                resetBtn.addEventListener('click', function () {
                    const allStatusBtn = document.querySelector('.js-status-filter[data-status="all"]');
                    const allCatBtn = document.querySelector('.js-cat-filter[data-cat="all"]');
                    if (allStatusBtn) allStatusBtn.click();
                    if (allCatBtn) allCatBtn.click();
                });
            }
        });
    </script>
</body>

</html>
