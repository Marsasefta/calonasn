<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <title>{{ $currentMaterial->title }} - CalonASN.id</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .reading-area {
            font-size: 1.1rem;
            line-height: 1.85;
            color: #2d3748;
        }

        .reading-area p {
            margin-bottom: 1.25rem;
        }

        .reading-area h1, .reading-area h2, .reading-area h3, .reading-area h4 {
            color: #1a202c;
            font-weight: 700;
            margin-top: 1.75rem;
            margin-bottom: 0.75rem;
        }

        .reading-area img {
            max-width: 100% !important;
            height: auto !important;
            border-radius: 12px;
            margin: 1.25rem 0;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.07);
        }

        .reading-area table {
            width: 100% !important;
            display: block;
            overflow-x: auto;
            margin: 1.25rem 0;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            border-collapse: collapse;
        }

        .reading-area table th,
        .reading-area table td {
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
        }

        .reading-area table th {
            background-color: #f8fafc;
            font-weight: 600;
        }

        .sidebar-sticky {
            position: sticky;
            top: 85px;
        }

        .materi-link {
            display: flex;
            align-items: center;
            padding: 10px 14px;
            color: #4a5568;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.2s ease;
        }

        .materi-link:hover {
            background-color: #f8f9fa;
        }

        .materi-link.active {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            font-weight: 600;
        }

        .materi-link.locked {
            cursor: pointer;
            background-color: rgba(220, 53, 69, 0.03);
            border: 1px dashed rgba(220, 53, 69, 0.2);
        }

        .materi-link.locked:hover {
            background-color: rgba(220, 53, 69, 0.08);
            border-color: rgba(220, 53, 69, 0.4);
        }

        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.12) !important;
        }
    </style>
</head>

<body>
    @include('partials.navbar')
    @include('partials.navbar-student')

    <div class="db-content">
        <div class="container-fluid py-4">

            {{-- Breadcrumb & Category Badge --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('materi.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1.5 fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Semua Kategori
                    </a>
                    <span class="badge bg-{{ $category->color_theme ?? 'primary' }}-soft text-{{ $category->color_theme ?? 'primary' }} border border-{{ $category->color_theme ?? 'primary' }} px-3 py-2 rounded-pill fw-bold">
                        <i class="bi bi-journal-bookmark-fill me-1"></i> Materi {{ $category->name }}
                    </span>
                </div>

                {{-- Mobile Quick Toggle Daftar Bab --}}
                <div class="d-lg-none">
                    <a href="#sidebarChapters" class="btn btn-sm btn-primary rounded-pill px-3 py-1.5 fw-bold shadow-sm">
                        <i class="bi bi-list-nested me-1"></i> Daftar Bab ({{ $completedCategoryCount ?? 0 }}/{{ $totalCategoryMaterials ?? 0 }})
                    </a>
                </div>
            </div>

            <div class="row g-4">

                {{-- 1. AREA BACA MATERI (Ditampilkan paling atas di Mobile agar siswa langsung membaca) --}}
                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4 p-md-5">

                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                <span class="badge bg-light text-secondary border px-3 py-1.5 rounded-pill fw-semibold small">
                                    <i class="bi bi-book me-1"></i> {{ $currentMaterial->chapter->title ?? 'Modul SKD' }}
                                </span>
                                @if (isset($hasFullAccess) && $hasFullAccess)
                                    <span class="badge bg-success-soft text-success border border-success px-3 py-1 rounded-pill small fw-semibold">
                                        <i class="bi bi-patch-check-fill me-1"></i> Akses Modul Lengkap
                                    </span>
                                @endif
                            </div>

                            <h1 class="fw-bold mb-4 text-dark fs-2">{{ $currentMaterial->title }}</h1>

                            <div class="reading-area lh-lg">
                                {!! preg_replace('/<img(?![^>]*loading=)/i', '<img loading="lazy" decoding="async"', $currentMaterial->content ?? '') !!}
                            </div>

                            <hr class="my-5">

                            {{-- Footer Navigasi Materi --}}
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 bg-light p-3.5 rounded-4 border">
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" id="btnToggleProgress" data-material-id="{{ $currentMaterial->id }}"
                                            class="btn {{ $isCurrentCompleted ? 'btn-success' : 'btn-outline-success' }} rounded-pill px-3 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-1.5">
                                        <i class="bi {{ $isCurrentCompleted ? 'bi-check-circle-fill' : 'bi-check-circle' }}" id="btnCheckIcon"></i>
                                        <span id="btnCheckLabel">{{ $isCurrentCompleted ? 'Selesai Dibaca' : 'Tandai Selesai' }}</span>
                                    </button>
                                    <span class="small text-muted d-none d-md-inline" id="statusSaveHint">
                                        {{ $isCurrentCompleted ? 'Tersimpan di progres' : 'Klik jika sudah paham' }}
                                    </span>
                                </div>

                                @if ($nextMaterial)
                                    @php
                                        $canAccessNext = (isset($hasFullAccess) && $hasFullAccess) || !$nextMaterial->is_locked;
                                    @endphp

                                    @if ($canAccessNext)
                                        <a href="{{ route('materi.show', [$category->slug, $nextMaterial->slug]) }}"
                                            class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-1.5">
                                            <span>Lanjut Materi Berikutnya</span>
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    @else
                                        <button type="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalLockedMaterial"
                                            data-material-name="{{ $nextMaterial->title }}"
                                            class="btn btn-danger rounded-pill px-4 py-2 fw-bold shadow-sm hover-lift d-inline-flex align-items-center gap-1.5">
                                            <i class="bi bi-lock-fill"></i>
                                            <span>Buka Bab Berikutnya ({{ $upgradePrice ?? 'Upgrade' }})</span>
                                        </button>
                                    @endif
                                @else
                                    <button class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm" disabled>
                                        Materi Selesai <i class="bi bi-check-circle-fill ms-1"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. SIDEBAR DAFTAR BAB (Kiri di Desktop, di bawah konten di Mobile) --}}
                <div class="col-lg-3 order-2 order-lg-1" id="sidebarChapters">
                    <div class="sidebar-sticky">
                        <!-- Progress Belajar Kategori -->
                        <div class="card border-0 shadow-sm rounded-4 mb-3 p-3 bg-white border border-light">
                            <div class="d-flex justify-content-between align-items-center mb-1.5">
                                <span class="small fw-bold text-dark">Progres Belajar</span>
                                <span class="small fw-bold text-success" id="progressSummary">{{ $completedCategoryCount ?? 0 }}/{{ $totalCategoryMaterials ?? 0 }} ({{ $progressPercent ?? 0 }}%)</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 7px; background-color: #f1f5f9;">
                                <div class="progress-bar bg-success rounded-pill" id="progressBarCategory" role="progressbar" 
                                     style="width: {{ $progressPercent ?? 0 }}%;" 
                                     aria-valuenow="{{ $progressPercent ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="accordion" id="accordionChapters">
                            @foreach ($chapters as $chapter)
                                @php
                                    $isActiveChapter = $chapter->id == $currentMaterial->learning_chapter_id;
                                @endphp

                                <div class="accordion-item border-0 mb-2 shadow-sm rounded-3 overflow-hidden">
                                    <h2 class="accordion-header">
                                        <button
                                            class="accordion-button fw-bold {{ $isActiveChapter ? '' : 'collapsed' }}"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $chapter->id }}"
                                            aria-expanded="{{ $isActiveChapter ? 'true' : 'false' }}">
                                            {{ $chapter->title }}
                                        </button>
                                    </h2>

                                    <div id="collapse{{ $chapter->id }}"
                                        class="accordion-collapse collapse {{ $isActiveChapter ? 'show' : '' }}"
                                        data-bs-parent="#accordionChapters">

                                        <div class="accordion-body p-2">
                                            @foreach ($chapter->materials as $materi)
                                                @php
                                                    $canAccess = (isset($hasFullAccess) && $hasFullAccess) || !$materi->is_locked;
                                                    $isDone = in_array($materi->id, $completedMaterialIds ?? []);
                                                @endphp

                                                @if ($canAccess)
                                                    <a href="{{ route('materi.show', [$category->slug, $materi->slug]) }}"
                                                        class="materi-link d-flex align-items-center justify-content-between p-2 rounded text-decoration-none {{ $currentMaterial->id == $materi->id ? 'bg-primary-soft text-primary fw-bold' : 'text-dark' }}">
                                                        <div class="d-flex align-items-center">
                                                            @if ($isDone)
                                                                <i class="bi bi-check-circle-fill text-success me-2 fs-6" id="icon-materi-{{ $materi->id }}"></i>
                                                            @elseif ($currentMaterial->id == $materi->id)
                                                                <i class="bi bi-play-circle-fill text-primary me-2 fs-6" id="icon-materi-{{ $materi->id }}"></i>
                                                            @else
                                                                <i class="bi bi-circle text-muted me-2 fs-6" id="icon-materi-{{ $materi->id }}"></i>
                                                            @endif
                                                            <span class="small">{{ $materi->title }}</span>
                                                        </div>
                                                    </a>
                                                @else
                                                    {{-- Bab Terkunci: Membuka Modal Penawaran Akses Interaktif --}}
                                                    <a href="javascript:void(0);"
                                                        role="button"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalLockedMaterial"
                                                        data-material-name="{{ $materi->title }}"
                                                        class="materi-link locked d-flex align-items-center justify-content-between p-2 rounded text-decoration-none">
                                                        <div class="d-flex align-items-center">
                                                            <i class="bi bi-lock-fill text-danger me-2 fs-6"></i>
                                                            <span class="small text-secondary">{{ $materi->title }}</span>
                                                        </div>
                                                        <span class="badge bg-danger text-white rounded-pill px-2 py-0.5" style="font-size: 0.65rem;">PRO</span>
                                                    </a>
                                                @endif
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if (!isset($hasFullAccess) || !$hasFullAccess)
                            <div class="mt-3 p-3 bg-danger-soft border border-danger border-opacity-25 rounded-4 text-center">
                                <p class="small text-danger fw-bold mb-2">
                                    <i class="bi bi-lock-fill me-1"></i> Buka Semua Bab Materi Premium
                                </p>
                                <a href="{{ $upgradeRoute ?? route('checkout', 2) }}"
                                    class="btn btn-sm btn-danger rounded-pill w-100 shadow-sm fw-bold hover-lift">
                                    <i class="bi bi-key-fill me-1"></i>
                                    {{ $upgradeLabel ?? 'Buka Semua Materi (Rp 49.000)' }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- 3. SIDEBAR KANAN (Widget Rekomendasi / CTA Simulasi CAT) --}}
                <div class="col-lg-3 order-3 order-lg-3">
                    <div class="sidebar-sticky">
                        @if (!isset($hasFullAccess) || !$hasFullAccess)
                            <div class="card bg-white border border-primary border-2 rounded-4 shadow-sm text-center mb-4 overflow-hidden">
                                <div class="bg-primary text-white py-1 small fw-bold tracking-wider">REKOMENDASI</div>
                                <div class="card-body p-4">
                                    <div class="bg-primary-soft text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm"
                                        style="width: 60px; height: 60px;">
                                        <i class="bi bi-patch-check-fill fs-2"></i>
                                    </div>

                                    <h5 class="fw-bold text-dark mb-2">Ingin Lulus SKD Sekali Tes?</h5>

                                    <p class="text-muted small mb-3">
                                        Buka <strong>100% Seluruh Bab Materi</strong> + <strong>Tryout CAT Unlimited</strong> untuk mempertajam insting dan hafalan materi ujianmu.
                                    </p>

                                    @if (($upgradePriceNum ?? 49000) < ($upgradeNormalPriceNum ?? 49000))
                                        <div class="p-2.5 rounded-3 bg-warning-subtle border border-warning mb-3">
                                            <div class="small text-muted text-decoration-line-through">Rp {{ number_format($upgradeNormalPriceNum, 0, ',', '.') }}</div>
                                            <div class="fs-4 fw-bolder text-primary lh-1">{{ $upgradePrice }}</div>
                                            @if (!empty($promo24h))
                                                <span class="badge bg-dark text-warning mt-1" style="font-size: 0.68rem;">
                                                    Kode {{ $promo24h['code'] }} • {{ $promo24h['deadline_label'] }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    <a href="{{ $upgradeRoute ?? route('checkout', 2) }}"
                                        class="btn btn-primary text-white w-100 rounded-pill fw-bold shadow-sm py-2 hover-lift">
                                        {{ $upgradeLabel ?? 'Buka Semua Materi (Rp 49.000)' }}
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="card bg-white border border-warning border-2 rounded-4 shadow-sm text-center">
                                <div class="card-body p-4">
                                    <div class="bg-warning text-dark rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm"
                                        style="width: 60px; height: 60px;">
                                        <i class="bi bi-hourglass-split fs-2"></i>
                                    </div>

                                    <h5 class="fw-bold text-dark mb-2">Tantang Dirimu!</h5>
                                    <p class="text-muted small mb-4">Materi sudah dipahami? Uji ketajaman instingmu dengan simulasi CAT CalonASN.id sekarang.</p>

                                    <a href="{{ route('ujian.persiapan', $tryout->id ?? 2) }}"
                                        class="btn btn-warning text-dark w-100 rounded-pill fw-bold shadow-sm py-2 hover-lift">
                                        Mulai Simulasi CAT
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL INTERAKTIF: MATERI TERKUNCI (UX Conversion Optimization) --}}
    <div class="modal fade" id="modalLockedMaterial" tabindex="-1" aria-labelledby="modalLockedMaterialLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-primary text-white p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; flex-shrink: 0;">
                            <i class="bi bi-lock-fill fs-4"></i>
                        </div>
                        <div>
                            <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-2.5 py-1 small fw-semibold mb-1">
                                Akses Eksklusif CalonASN.id
                            </span>
                            <h5 class="modal-title fw-bold text-white mb-0" id="modalLockedMaterialLabel">Materi Belajar Terkunci</h5>
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
                                <span>Akses <strong>100% Seluruh Bab & Modul</strong> TWK, TIU, dan TKP</span>
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
                                <span>Ranking Nasional Real-time & Pembahasan Kunci Jawaban Lengkap</span>
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

    @include('partials.scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. AJAX Toggle Progress Belajar
            const btnToggle = document.getElementById('btnToggleProgress');
            if (btnToggle) {
                btnToggle.addEventListener('click', function() {
                    const materialId = this.getAttribute('data-material-id');
                    const icon = document.getElementById('btnCheckIcon');
                    const label = document.getElementById('btnCheckLabel');
                    const hint = document.getElementById('statusSaveHint');
                    const progressBar = document.getElementById('progressBarCategory');
                    const progressSummary = document.getElementById('progressSummary');
                    const sidebarIcon = document.getElementById('icon-materi-' + materialId);

                    btnToggle.disabled = true;

                    fetch(`/materi-belajar/toggle-progress/${materialId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        btnToggle.disabled = false;
                        if (data.status === 'success') {
                            if (data.is_completed) {
                                btnToggle.classList.remove('btn-outline-success');
                                btnToggle.classList.add('btn-success');
                                icon.className = 'bi bi-check-circle-fill';
                                label.textContent = 'Selesai Dibaca';
                                if (hint) hint.textContent = 'Tersimpan di progres';
                                if (sidebarIcon) {
                                    sidebarIcon.className = 'bi bi-check-circle-fill text-success me-2 fs-6';
                                }
                            } else {
                                btnToggle.classList.remove('btn-success');
                                btnToggle.classList.add('btn-outline-success');
                                icon.className = 'bi bi-check-circle';
                                label.textContent = 'Tandai Selesai';
                                if (hint) hint.textContent = 'Klik jika sudah paham';
                                if (sidebarIcon) {
                                    sidebarIcon.className = 'bi bi-play-circle-fill text-primary me-2 fs-6';
                                }
                            }

                            if (progressBar) {
                                progressBar.style.width = data.percentage + '%';
                            }
                            if (progressSummary) {
                                progressSummary.textContent = `${data.completed_count}/${data.total_count} (${data.percentage}%)`;
                            }
                        }
                    })
                    .catch(err => {
                        btnToggle.disabled = false;
                        console.error('Error toggling progress:', err);
                    });
                });
            }

            // 2. Modal Locked Material Title Dynamic Listener
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
