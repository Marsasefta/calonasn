<!doctype html>
<html lang="id">

<head>
    @include('partials.head')
    <title>{{ $currentMaterial->title }} - CalonASN.id</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Reading Scroll Progress Indicator */
        #readingScrollBar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, #2563eb, #10b981);
            z-index: 1055;
            transition: width 0.08s linear;
            pointer-events: none;
        }

        /* Reader Typography & Sizing */
        .reading-card {
            --reader-fs: 1.06rem;
        }

        .reading-card[data-font-scale="sm"] {
            --reader-fs: 0.96rem;
        }

        .reading-card[data-font-scale="md"] {
            --reader-fs: 1.06rem;
        }

        .reading-card[data-font-scale="lg"] {
            --reader-fs: 1.18rem;
        }

        .reading-area {
            font-size: var(--reader-fs);
            line-height: 1.85;
            color: #1e293b;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .reading-area > p,
        .reading-area > ul,
        .reading-area > ol,
        .reading-area > blockquote {
            max-width: 72ch;
        }

        .reading-area p {
            margin-bottom: 1.15rem;
        }

        .reading-area ul,
        .reading-area ol {
            padding-left: 1.35rem;
            margin-bottom: 1.25rem;
        }

        .reading-area li {
            margin-bottom: 0.45rem;
        }

        .reading-area h1,
        .reading-area h2,
        .reading-area h3,
        .reading-area h4 {
            color: #0f172a;
            font-weight: 700;
            margin-top: 1.75rem;
            margin-bottom: 0.75rem;
            line-height: 1.35;
        }

        .reading-area h2 {
            font-size: calc(var(--reader-fs) * 1.35);
        }

        .reading-area h3 {
            font-size: calc(var(--reader-fs) * 1.18);
        }

        .reading-area blockquote {
            margin: 1.25rem 0;
            padding: 0.9rem 1.15rem;
            border-left: 4px solid #2563eb;
            background: #eff6ff;
            border-radius: 0 0.75rem 0.75rem 0;
            color: #1e3a8a;
        }

        .reading-area pre,
        .reading-area code {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.9em;
        }

        .reading-area pre {
            padding: 1rem;
            border-radius: 0.75rem;
            background: #0f172a;
            color: #f8fafc;
            overflow-x: auto;
            margin: 1.25rem 0;
        }

        .reading-area img {
            max-width: 100% !important;
            height: auto !important;
            border-radius: 12px;
            margin: 1.25rem 0;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }

        /* Responsive Table Container */
        .reading-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 1.25rem 0;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
        }

        .reading-area table {
            width: 100% !important;
            margin: 0 !important;
            border-collapse: collapse;
            font-size: 0.94em;
        }

        .reading-area table th,
        .reading-area table td {
            padding: 0.7rem 0.95rem;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .reading-area table th {
            background-color: #f8fafc;
            font-weight: 700;
            color: #0f172a;
        }

        /* Dark Mode Reader Styles */
        [data-bs-theme="dark"] .reading-area {
            color: #e2e8f0;
        }

        [data-bs-theme="dark"] .reading-area h1,
        [data-bs-theme="dark"] .reading-area h2,
        [data-bs-theme="dark"] .reading-area h3,
        [data-bs-theme="dark"] .reading-area h4 {
            color: #f8fafc;
        }

        [data-bs-theme="dark"] .reading-area blockquote {
            background: rgba(30, 58, 138, 0.25);
            color: #bfdbfe;
            border-left-color: #60a5fa;
        }

        [data-bs-theme="dark"] .reading-table-wrap,
        [data-bs-theme="dark"] .reading-area table,
        [data-bs-theme="dark"] .reading-area table td {
            border-color: #334155;
        }

        [data-bs-theme="dark"] .reading-area table th {
            background-color: #0f172a;
            border-color: #334155;
            color: #f8fafc;
        }

        @media (max-width: 575.98px) {
            .reading-card {
                --reader-fs: 0.98rem;
            }

            .reading-card[data-font-scale="sm"] {
                --reader-fs: 0.9rem;
            }

            .reading-card[data-font-scale="lg"] {
                --reader-fs: 1.1rem;
            }

            .reading-area table th,
            .reading-area table td {
                padding: 0.55rem 0.7rem;
                font-size: 0.88em;
            }
        }

        /* Sticky Chapter Sidebar */
        .sidebar-sticky {
            position: sticky;
            top: 84px;
            max-height: calc(100vh - 104px);
            overflow-y: auto;
            padding-right: 2px;
        }

        .materi-link {
            transition: background-color 0.16s ease, color 0.16s ease;
        }

        .materi-link:hover {
            background-color: rgba(148, 163, 184, 0.12);
        }

        .materi-link.active {
            background-color: rgba(37, 99, 235, 0.12) !important;
            color: #2563eb !important;
        }

        [data-bs-theme="dark"] .materi-link.active {
            background-color: rgba(59, 130, 246, 0.22) !important;
            color: #93c5fd !important;
        }

        .materi-link.locked {
            cursor: pointer;
            background-color: rgba(220, 53, 69, 0.04);
            border: 1px dashed rgba(220, 53, 69, 0.24);
        }

        .materi-link.locked:hover {
            background-color: rgba(220, 53, 69, 0.1);
            border-color: rgba(220, 53, 69, 0.45);
        }

        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        @media (hover: hover) {
            .hover-lift:hover {
                transform: translateY(-2px);
                box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.12) !important;
            }
        }
    </style>
</head>

<body>
    <div id="readingScrollBar" aria-hidden="true"></div>

    @include('partials.navbar')
    @include('partials.navbar-student')

    <div class="db-content">
        <div class="container-fluid py-3 py-md-4">

            {{-- TOP ACTION & READER BAR --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <a href="{{ route('materi.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1.5 fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Semua Kategori
                    </a>
                    <span class="badge bg-{{ $category->color_theme ?? 'primary' }}-soft text-{{ $category->color_theme ?? 'primary' }} border border-{{ $category->color_theme ?? 'primary' }} px-3 py-2 rounded-pill fw-bold">
                        <i class="bi bi-journal-bookmark-fill me-1"></i> {{ $category->name }}
                    </span>
                </div>

                <div class="d-flex align-items-center gap-2 ms-auto">
                    {{-- Font Size Control --}}
                    <div class="btn-group btn-group-sm shadow-xs" role="group" aria-label="Ukuran Teks Materi">
                        <button type="button" class="btn btn-outline-secondary px-2.5 js-font-btn" data-scale="sm" title="Teks Kecil">A-</button>
                        <button type="button" class="btn btn-outline-secondary px-2.5 js-font-btn active" data-scale="md" title="Teks Normal">A</button>
                        <button type="button" class="btn btn-outline-secondary px-2.5 js-font-btn" data-scale="lg" title="Teks Besar">A+</button>
                    </div>

                    {{-- Mobile/Tablet Chapters Drawer Trigger --}}
                    <button type="button"
                        class="btn btn-sm btn-primary rounded-pill px-3 py-1.5 fw-bold shadow-sm d-lg-none"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#mobileChaptersDrawer"
                        aria-controls="mobileChaptersDrawer">
                        <i class="bi bi-list-nested me-1"></i> Daftar Bab (<span class="js-progress-count-short">{{ $completedCategoryCount ?? 0 }}/{{ $totalCategoryMaterials ?? 0 }}</span>)
                    </button>
                </div>
            </div>

            <div class="row g-4 align-items-start">

                {{-- 1. AREA BACA MATERI (Lega di Desktop: col-lg-8 col-xl-9, Penuh di Mobile) --}}
                <div class="col-lg-8 col-xl-9">
                    <article class="card border-0 shadow-sm rounded-4 mb-4 reading-card" id="readingCard" data-font-scale="md">
                        <div class="card-body p-3 p-sm-4 p-md-5">

                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <span class="badge bg-light text-secondary border px-3 py-1.5 rounded-pill fw-semibold small">
                                        <i class="bi bi-book me-1"></i> {{ $currentMaterial->chapter->title ?? 'Modul SKD' }}
                                    </span>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1.5 fw-semibold small">
                                        <i class="bi bi-clock me-1"></i> ~{{ $readingMinutes ?? 2 }} mnt baca
                                    </span>
                                </div>

                                @if (isset($hasFullAccess) && $hasFullAccess)
                                    <span class="badge bg-success-soft text-success border border-success px-3 py-1 rounded-pill small fw-semibold">
                                        <i class="bi bi-patch-check-fill me-1"></i> Akses Modul Lengkap
                                    </span>
                                @endif
                            </div>

                            <h1 class="fw-bold mb-4 text-dark fs-3 fs-md-2">{{ $currentMaterial->title }}</h1>

                            <div class="reading-area" id="readingContent">
                                {!! preg_replace('/<img(?![^>]*loading=)/i', '<img loading="lazy" decoding="async"', $currentMaterial->content ?? '') !!}
                            </div>

                            <hr class="my-4 my-md-5">

                            {{-- Footer Navigasi & Tandai Selesai --}}
                            <div class="d-flex flex-column gap-3 bg-light p-3 p-sm-4 rounded-4 border">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" id="btnToggleProgress" data-material-id="{{ $currentMaterial->id }}"
                                            class="btn {{ $isCurrentCompleted ? 'btn-success' : 'btn-outline-success' }} rounded-pill px-3 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-1.5">
                                            <i class="bi {{ $isCurrentCompleted ? 'bi-check-circle-fill' : 'bi-check-circle' }}" id="btnCheckIcon"></i>
                                            <span id="btnCheckLabel">{{ $isCurrentCompleted ? 'Selesai Dibaca' : 'Tandai Selesai' }}</span>
                                        </button>
                                        <span class="small text-muted d-none d-sm-inline" id="statusSaveHint">
                                            {{ $isCurrentCompleted ? 'Tersimpan di progres' : 'Klik jika sudah paham' }}
                                        </span>
                                    </div>

                                    <span class="small fw-semibold text-muted d-lg-none js-progress-summary">
                                        {{ $completedCategoryCount ?? 0 }}/{{ $totalCategoryMaterials ?? 0 }} ({{ $progressPercent ?? 0 }}%)
                                    </span>
                                </div>

                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-2 pt-2 border-top">
                                    {{-- Tombol Sebelumnya --}}
                                    <div>
                                        @if (!empty($prevMaterial))
                                            @php
                                                $canAccessPrev = (isset($hasFullAccess) && $hasFullAccess) || !$prevMaterial->is_locked;
                                            @endphp
                                            @if ($canAccessPrev)
                                                <a href="{{ route('materi.show', [$category->slug, $prevMaterial->slug]) }}"
                                                    class="btn btn-outline-secondary rounded-pill px-3 py-2 fw-semibold w-100 w-sm-auto d-inline-flex align-items-center justify-content-center gap-1.5">
                                                    <i class="bi bi-arrow-left"></i>
                                                    <span>Sebelumnya</span>
                                                </a>
                                            @endif
                                        @endif
                                    </div>

                                    {{-- Tombol Berikutnya --}}
                                    <div>
                                        @if ($nextMaterial)
                                            @php
                                                $canAccessNext = (isset($hasFullAccess) && $hasFullAccess) || !$nextMaterial->is_locked;
                                            @endphp

                                            @if ($canAccessNext)
                                                <a href="{{ route('materi.show', [$category->slug, $nextMaterial->slug]) }}"
                                                    class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm w-100 w-sm-auto d-inline-flex align-items-center justify-content-center gap-1.5">
                                                    <span>Lanjut Materi Berikutnya</span>
                                                    <i class="bi bi-arrow-right"></i>
                                                </a>
                                            @else
                                                <button type="button"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalLockedMaterial"
                                                    data-material-name="{{ $nextMaterial->title }}"
                                                    class="btn btn-danger rounded-pill px-4 py-2 fw-bold shadow-sm hover-lift w-100 w-sm-auto d-inline-flex align-items-center justify-content-center gap-1.5">
                                                    <i class="bi bi-lock-fill"></i>
                                                    <span>Buka Bab Berikutnya ({{ $upgradePrice ?? 'Upgrade' }})</span>
                                                </button>
                                            @endif
                                        @else
                                            <a href="{{ route('ujian.persiapan', $tryout->id ?? 1) }}"
                                                class="btn btn-warning text-dark rounded-pill px-4 py-2 fw-bold shadow-sm w-100 w-sm-auto d-inline-flex align-items-center justify-content-center gap-1.5">
                                                <i class="bi bi-play-circle-fill"></i>
                                                <span>Materi Selesai &bull; Coba Simulasi CAT</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                {{-- 2. SIDEBAR KANAN DESKTOP (Daftar Bab + CTA Ringkas) --}}
                <aside class="col-lg-4 col-xl-3 d-none d-lg-block" id="sidebarChapters">
                    <div class="sidebar-sticky">
                        @include('user.materi.partials.chapter-list', ['accordionId' => 'accordionChaptersDesktop'])

                        @if (!isset($hasFullAccess) || !$hasFullAccess)
                            <div class="card border border-primary border-2 rounded-4 shadow-sm text-center mt-3 overflow-hidden">
                                <div class="bg-primary text-white py-1 small fw-bold">REKOMENDASI</div>
                                <div class="card-body p-3">
                                    <h6 class="fw-bold text-dark mb-1">Buka 100% Materi &amp; Tryout</h6>
                                    <p class="text-muted small mb-2">
                                        Akses penuh seluruh bab TWK, TIU, TKP + Tryout CAT Unlimited.
                                    </p>
                                    @if (($upgradePriceNum ?? 49000) < ($upgradeNormalPriceNum ?? 49000))
                                        <div class="p-2 rounded-3 bg-warning-subtle border border-warning mb-2">
                                            <span class="small text-muted text-decoration-line-through me-1">Rp {{ number_format($upgradeNormalPriceNum, 0, ',', '.') }}</span>
                                            <strong class="text-primary">{{ $upgradePrice }}</strong>
                                        </div>
                                    @endif
                                    <a href="{{ $upgradeRoute ?? route('checkout', 2) }}"
                                        class="btn btn-primary btn-sm text-white w-100 rounded-pill fw-bold py-2 hover-lift">
                                        <i class="bi bi-unlock-fill me-1"></i>
                                        {{ $upgradeLabel ?? 'Buka Semua Materi' }}
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="card border border-warning border-2 rounded-4 shadow-sm text-center mt-3">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold text-dark mb-1">Uji Pemahamanmu!</h6>
                                    <p class="text-muted small mb-3">Sudah paham konsepnya? Latihan langsung di Tryout CAT.</p>
                                    <a href="{{ route('ujian.persiapan', $tryout->id ?? 2) }}"
                                        class="btn btn-warning btn-sm text-dark w-100 rounded-pill fw-bold py-2 hover-lift">
                                        Mulai Simulasi CAT
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </aside>

            </div>
        </div>
    </div>

    {{-- OFFCANVAS DRAWER DAFTAR BAB (Khusus Mobile & Tablet < lg) --}}
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileChaptersDrawer" aria-labelledby="mobileChaptersDrawerLabel" style="max-width: 88vw; width: 340px;">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold" id="mobileChaptersDrawerLabel">
                <i class="bi bi-list-nested text-primary me-1"></i> Daftar Bab {{ $category->name }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
        </div>
        <div class="offcanvas-body p-3">
            @include('user.materi.partials.chapter-list', ['accordionId' => 'accordionChaptersMobile'])

            @if (!isset($hasFullAccess) || !$hasFullAccess)
                <div class="mt-3 p-3 bg-danger-soft border border-danger border-opacity-25 rounded-4 text-center">
                    <p class="small text-danger fw-bold mb-2">
                        <i class="bi bi-lock-fill me-1"></i> Buka Semua Bab Premium
                    </p>
                    <a href="{{ $upgradeRoute ?? route('checkout', 2) }}"
                        class="btn btn-sm btn-danger rounded-pill w-100 shadow-sm fw-bold">
                        {{ $upgradeLabel ?? 'Buka Semua Materi' }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- MODAL INTERAKTIF: MATERI TERKUNCI --}}
    <div class="modal fade" id="modalLockedMaterial" tabindex="-1" aria-labelledby="modalLockedMaterialLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-primary text-white p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; flex-shrink: 0; background-color: #ffffff !important;">
                            <i class="bi bi-lock-fill fs-4" style="color: #2563eb !important;"></i>
                        </div>
                        <div>
                            <span class="badge rounded-pill px-2.5 py-1 small fw-semibold mb-1" style="background-color: rgba(15, 23, 42, 0.3) !important; color: #fde68a !important; border: 1px solid rgba(253, 230, 138, 0.45) !important;">
                                Akses Eksklusif CalonASN.id
                            </span>
                            <h5 class="modal-title fw-bold mb-0" id="modalLockedMaterialLabel" style="color: #ffffff !important;">Materi Belajar Terkunci</h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-dark fw-medium mb-3">
                        Materi <strong class="text-primary" id="modalLockedMaterialTitle">ini</strong> merupakan materi premium yang dirancang khusus untuk mematangkan persiapan ujian SKD Anda.
                    </p>

                    <div class="bg-light p-3.5 rounded-3 mb-4 border">
                        <div class="small fw-bold text-dark mb-2.5">
                            <i class="bi bi-stars text-warning me-1"></i> Keuntungan Buka Akses Paket Lengkap:
                        </div>
                        <ul class="list-unstyled mb-0 small text-secondary d-flex flex-column gap-2">
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-circle-fill text-success mt-0.5"></i>
                                <span>Akses <strong>100% Seluruh Bab &amp; Modul</strong> TWK, TIU, dan TKP</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-circle-fill text-success mt-0.5"></i>
                                <span>Akses <strong>Tryout CAT SKD Unlimited</strong> (Bebas ulang latihan sepuasnya)</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-circle-fill text-success mt-0.5"></i>
                                <span>Sertifikat Kelulusan Resmi CalonASN.id dengan <strong>QR Code Verifikasi</strong></span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-circle-fill text-success mt-0.5"></i>
                                <span>Ranking Nasional Real-time &amp; Pembahasan Kunci Jawaban Lengkap</span>
                            </li>
                        </ul>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        @if (($upgradePriceNum ?? 49000) < ($upgradeNormalPriceNum ?? 49000))
                            <div class="text-center small text-muted">
                                Harga promo pendaftar baru:
                                <span class="text-decoration-line-through">Rp {{ number_format($upgradeNormalPriceNum, 0, ',', '.') }}</span>
                                <strong class="text-primary">{{ $upgradePrice }}</strong>
                                @if (!empty($promo24h))
                                    <span class="badge bg-warning text-dark ms-1">{{ $promo24h['code'] }}</span>
                                @endif
                            </div>
                        @endif
                        <a href="{{ $upgradeRoute ?? route('checkout', 2) }}" class="btn btn-primary rounded-pill py-2.5 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 hover-lift">
                            <i class="bi bi-unlock-fill"></i>
                            <span>{{ $upgradeLabel ?? 'Buka Semua Akses (Rp 49.000)' }}</span>
                        </a>
                        <button type="button" class="btn btn-outline-secondary rounded-pill py-2 fw-semibold" data-bs-dismiss="modal">
                            Nanti Saja
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.btn-scroll-top')
    @include('partials.scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Wrap any table inside reading content so mobile horizontal scroll works cleanly
            const readingContent = document.getElementById('readingContent');
            if (readingContent) {
                readingContent.querySelectorAll('table').forEach(function(tbl) {
                    if (tbl.parentElement && tbl.parentElement.classList.contains('reading-table-wrap')) return;
                    const wrap = document.createElement('div');
                    wrap.className = 'reading-table-wrap';
                    tbl.parentNode.insertBefore(wrap, tbl);
                    wrap.appendChild(tbl);
                });
            }

            // 2. Reading Scroll Progress Bar
            const scrollBar = document.getElementById('readingScrollBar');
            const readingCard = document.getElementById('readingCard');
            function updateScrollProgress() {
                if (!scrollBar || !readingCard) return;
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                if (docHeight <= 0) {
                    scrollBar.style.width = '100%';
                    return;
                }
                const pct = Math.min(100, Math.max(0, (window.scrollY / docHeight) * 100));
                scrollBar.style.width = pct.toFixed(1) + '%';
            }
            window.addEventListener('scroll', updateScrollProgress, { passive: true });
            updateScrollProgress();

            // 3. Reader Font Scale Toggle (A- / A / A+)
            const FONT_KEY = 'calonasn_reader_font_scale';
            const fontBtns = document.querySelectorAll('.js-font-btn');
            function applyFontScale(scale) {
                const validScale = ['sm', 'md', 'lg'].includes(scale) ? scale : 'md';
                if (readingCard) readingCard.setAttribute('data-font-scale', validScale);
                fontBtns.forEach(function(btn) {
                    btn.classList.toggle('active', btn.getAttribute('data-scale') === validScale);
                });
                localStorage.setItem(FONT_KEY, validScale);
            }
            applyFontScale(localStorage.getItem(FONT_KEY) || 'md');
            fontBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    applyFontScale(this.getAttribute('data-scale'));
                });
            });

            // 4. AJAX Toggle Progress Belajar (syncs both desktop sidebar & mobile drawer)
            const btnToggle = document.getElementById('btnToggleProgress');
            if (btnToggle) {
                btnToggle.addEventListener('click', function() {
                    const materialId = this.getAttribute('data-material-id');
                    const icon = document.getElementById('btnCheckIcon');
                    const label = document.getElementById('btnCheckLabel');
                    const hint = document.getElementById('statusSaveHint');

                    btnToggle.disabled = true;

                    fetch(`/materi-belajar/toggle-progress/${materialId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(function(res) {
                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        return res.json();
                    })
                    .then(function(data) {
                        btnToggle.disabled = false;
                        if (data.status === 'success') {
                            const sidebarIcons = document.querySelectorAll('.js-materi-icon-' + materialId);
                            if (data.is_completed) {
                                btnToggle.classList.remove('btn-outline-success');
                                btnToggle.classList.add('btn-success');
                                icon.className = 'bi bi-check-circle-fill';
                                label.textContent = 'Selesai Dibaca';
                                if (hint) hint.textContent = 'Tersimpan di progres';
                                sidebarIcons.forEach(function(el) {
                                    el.className = `bi bi-check-circle-fill text-success fs-6 flex-shrink-0 js-materi-icon-${materialId}`;
                                });
                            } else {
                                btnToggle.classList.remove('btn-success');
                                btnToggle.classList.add('btn-outline-success');
                                icon.className = 'bi bi-check-circle';
                                label.textContent = 'Tandai Selesai';
                                if (hint) hint.textContent = 'Klik jika sudah paham';
                                sidebarIcons.forEach(function(el) {
                                    el.className = `bi bi-play-circle-fill text-primary fs-6 flex-shrink-0 js-materi-icon-${materialId}`;
                                });
                            }

                            document.querySelectorAll('.js-progress-bar').forEach(function(bar) {
                                bar.style.width = data.percentage + '%';
                                bar.setAttribute('aria-valuenow', String(data.percentage));
                            });
                            document.querySelectorAll('.js-progress-summary').forEach(function(el) {
                                el.textContent = `${data.completed_count}/${data.total_count} (${data.percentage}%)`;
                            });
                            document.querySelectorAll('.js-progress-count-short').forEach(function(el) {
                                el.textContent = `${data.completed_count}/${data.total_count}`;
                            });
                        }
                    })
                    .catch(function() {
                        btnToggle.disabled = false;
                        if (hint) hint.textContent = 'Gagal menyimpan progres, coba lagi.';
                    });
                });
            }

            // 5. Modal Locked Material Dynamic Title Listener
            const modalLocked = document.getElementById('modalLockedMaterial');
            if (modalLocked) {
                modalLocked.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    if (button) {
                        const materialName = button.getAttribute('data-material-name');
                        const titleElem = document.getElementById('modalLockedMaterialTitle');
                        if (titleElem && materialName) {
                            titleElem.textContent = `"${materialName}"`;
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
