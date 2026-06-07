<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <title>{{ $currentMaterial->title }} - CalonASN.id</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .reading-area {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }

        .sidebar-sticky {
            position: sticky;
            top: 85px;
        }

        .materi-link {
            display: flex;
            align-items: center;
            padding: 10px 15px;
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

        .lock-icon {
            color: #dc3545;
        }
    </style>
</head>

<body>
    @include('partials.navbar')
    @include('partials.navbar-student')

    <div class="db-content text-dark">
        <div class="container-fluid py-4">
            <span
                class="badge bg-{{ $category->color_theme ?? 'primary' }}-soft text-{{ $category->color_theme ?? 'primary' }} border border-{{ $category->color_theme ?? 'primary' }} px-3 py-2 rounded-pill mb-3 fw-bold">
                <i class="bi bi-journal-bookmark-fill me-1"></i> Materi {{ $category->name }}
            </span>

            <div class="row g-4">

                <div class="col-lg-3">
                    <div class="sidebar-sticky">
                        <div class="accordion" id="accordionChapters">
                            @foreach ($chapters as $chapter)
                                @php
                                    $isActiveChapter = $chapter->id == $currentMaterial->learning_chapter_id;
                                @endphp

                                <div class="accordion-item border-0 mb-2 shadow-sm rounded-3">
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
                                                    // LOGIKA UTAMA:
                                                    // Materi bisa diakses JIKA User punya Full Access (Paket 2) ATAU Materi memang diset Gratis (is_locked == 0)
                                                    // Asumsi $hasFullAccess dikirim dari Controller
                                                    $canAccess =
                                                        (isset($hasFullAccess) && $hasFullAccess) ||
                                                        !$materi->is_locked;
                                                @endphp

                                                <a href="{{ $canAccess ? route('materi.show', [$category->slug, $materi->slug]) : '#' }}"
                                                    class="materi-link d-flex align-items-center justify-content-between p-2 rounded text-decoration-none {{ $currentMaterial->id == $materi->id ? 'bg-primary-soft text-primary fw-bold' : 'text-dark' }} {{ !$canAccess ? 'opacity-75' : '' }}">

                                                    <div class="d-flex align-items-center">
                                                        @if (!$canAccess)
                                                            <i class="bi bi-lock-fill text-danger me-2 fs-6"></i>
                                                        @else
                                                            <i
                                                                class="bi {{ $currentMaterial->id == $materi->id ? 'bi-play-circle-fill' : 'bi-check-circle' }} me-2 fs-6"></i>
                                                        @endif
                                                        <span class="small">{{ $materi->title }}</span>
                                                    </div>

                                                    @if (!$canAccess)
                                                        <span class="badge bg-danger text-white rounded-pill"
                                                            style="font-size: 0.6rem;">PRO</span>
                                                    @endif
                                                </a>
                                            @endforeach

                                            @php
                                                $hasLockedItems =
                                                    $chapter->materials->where('is_locked', 1)->count() > 0;
                                            @endphp
                                            @if ($hasLockedItems && (!isset($hasFullAccess) || !$hasFullAccess))
                                                <div
                                                    class="mt-3 p-3 bg-danger-soft border border-danger border-opacity-25 rounded-3 text-center">
                                                    <p class="small text-danger fw-bold mb-2">
                                                        <i class="bi bi-lock-fill me-1"></i> Ada Materi Premium Terkunci
                                                    </p>

                                                    <a href="{{ $upgradeRoute ?? route('checkout', 2) }}"
                                                        class="btn btn-sm btn-danger rounded-pill w-100 shadow-sm fw-bold hover-lift">
                                                        <i class="bi bi-key-fill me-1"></i>
                                                        {{ $upgradeLabel ?? 'Beli Paket Lengkap (Rp 49.000)' }}
                                                    </a>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4 p-md-5">

                            <h2 class="fw-bold mb-4">{{ $currentMaterial->title }}</h2>
                            <div class="reading-area lh-lg">
                                {!! $currentMaterial->content !!}
                            </div>

                            <hr class="my-5">

                            <div
                                class="d-flex justify-content-between align-items-center bg-light p-3 rounded-4 border">
                                <span class="fw-medium text-muted">Selesai membaca?</span>

                                @if ($nextMaterial)
                                    @php
                                        // Cek apakah materi selanjutnya dikunci
                                        $canAccessNext =
                                            (isset($hasFullAccess) && $hasFullAccess) || !$nextMaterial->is_locked;
                                    @endphp

                                    @if ($canAccessNext)
                                        <a href="{{ route('materi.show', [$category->slug, $nextMaterial->slug]) }}"
                                            class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                            Lanjut Materi Berikutnya <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    @else
                                        <a href="{{ $upgradeRoute ?? route('checkout', 2) }}"
                                            class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm animate__animated animate__pulse animate__infinite hover-lift">
                                            <i class="bi bi-lock-fill me-1"></i> Buka Bab Berikutnya:
                                            {{ $upgradeLabel ?? 'Beli Paket (Rp 49.000)' }}
                                        </a>
                                    @endif
                                @else
                                    <button class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" disabled>
                                        Materi Selesai <i class="bi bi-check-circle-fill ms-1"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="sidebar-sticky">
                        @if (!isset($hasFullAccess) || !$hasFullAccess)
                            <div
                                class="card bg-white border border-primary border-2 rounded-4 shadow-sm text-center mb-4 overflow-hidden">
                                <div class="bg-primary text-white py-1 small fw-bold tracking-wider">REKOMENDASI</div>
                                <div class="card-body p-4">
                                    <div class="bg-primary-soft text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm"
                                        style="width: 60px; height: 60px;">
                                        <i class="bi bi-file-earmark-pdf-fill fs-2"></i>
                                    </div>

                                    <h5 class="fw-bold text-dark mb-2">Ingin Lulus Lebih Cepat?</h5>

                                    {{-- Deskripsi dinamis --}}
                                    <p class="text-muted small mb-4">
                                        Dapatkan akses ke SEMUA materi PRO + Tryout Premium
                                        untuk memaksimalkan nilaimu.
                                    </p>

                                    {{-- Tombol Pintar: Otomatis berubah dari 49rb ke 29rb tergantung status --}}
                                    <a href="{{ $upgradeRoute ?? route('checkout', 2) }}"
                                        class="btn btn-primary text-white w-100 rounded-pill fw-bold shadow-sm">
                                        {{ $upgradeLabel ?? 'Beli Paket Lengkap (Rp 49.000)' }}
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

                                    <h5 class="fw-bold text-dark mb-3">Tantang Dirimu!</h5>
                                    <p class="text-muted small mb-4">Materi sudah paham? Uji instingmu dengan Tryout
                                        Premium CAT BKN sekarang.</p>

                                    <a href="{{ route('ujian.persiapan', $tryout->id ?? 2) }}"
                                        class="btn btn-warning text-dark w-100 rounded-pill fw-bold shadow-sm">
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

    @include('partials.scripts')
</body>

</html>
