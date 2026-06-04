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

            <div class="row g-4">

                <div class="col-lg-3">
                    <div class="sidebar-sticky">
                        <div class="accordion" id="accordionChapters">
                            @foreach ($chapters as $chapter)
                                {{-- Cek apakah bab ini adalah bab yang sedang aktif --}}
                                @php
                                    $isActiveChapter = $chapter->id == $currentMaterial->learning_chapter_id;
                                @endphp

                                <div class="accordion-item border-0 mb-2 shadow-sm rounded-3">
                                    <h2 class="accordion-header">
                                        {{-- Hapus class 'collapsed' jika bab aktif --}}
                                        <button
                                            class="accordion-button fw-bold {{ $isActiveChapter ? '' : 'collapsed' }}"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $chapter->id }}"
                                            aria-expanded="{{ $isActiveChapter ? 'true' : 'false' }}">
                                            {{ $chapter->title }}
                                        </button>
                                    </h2>

                                    {{-- Tambahkan class 'show' jika bab aktif --}}
                                    <div id="collapse{{ $chapter->id }}"
                                        class="accordion-collapse collapse {{ $isActiveChapter ? 'show' : '' }}"
                                        data-bs-parent="#accordionChapters">

                                        <div class="accordion-body p-2">
                                            @foreach ($chapter->materials as $materi)
                                                <a href="{{ $materi->is_locked ? '#' : route('materi.show', [$category->slug, $materi->slug]) }}"
                                                    class="materi-link {{ $currentMaterial->id == $materi->id ? 'active' : '' }}">

                                                    <i
                                                        class="bi {{ $materi->is_locked ? 'bi-lock-fill lock-icon' : ($currentMaterial->id == $materi->id ? 'bi-play-circle-fill' : 'bi-circle') }} me-2 fs-6"></i>
                                                    <span class="small">{{ $materi->title }}</span>
                                                </a>
                                            @endforeach
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
                            <div class="reading-area">
                                {!! $currentMaterial->content !!}
                            </div>

                            <hr class="my-5">

                            <div
                                class="d-flex justify-content-between align-items-center bg-light p-3 rounded-4 border">
                                <span class="fw-medium text-muted">Selesai membaca?</span>
                                {{-- <div class="alert alert-info">
                                    Debug:
                                    {{ $nextMaterial ? 'Materi berikutnya adalah: ' . $nextMaterial->title : 'Tidak ada materi berikutnya (NULL)' }}
                                </div> --}}
                                @if ($nextMaterial)
                                    <a href="{{ route('materi.show', [$category->slug, $nextMaterial->slug]) }}"
                                        class="btn btn-primary rounded-pill px-4 fw-bold">
                                        Lanjut Materi Berikutnya <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                @else
                                    <button class="btn btn-success rounded-pill px-4 fw-bold" disabled>
                                        Materi Selesai <i class="bi bi-check-circle ms-1"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="sidebar-sticky">
                        <div class="card bg-white border border-warning border-2 rounded-4 shadow-sm text-center">
                            <div class="card-body p-4">
                                <div class="bg-warning text-dark rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm"
                                    style="width: 60px; height: 60px;">
                                    <i class="bi bi-hourglass-split fs-2"></i>

                                </div>
                                <h5 class="fw-bold text-dark mb-3">Tantang Dirimu!</h5>
                                <p class="text-muted small mb-4">Materi {{ $category->name }} butuh pemahaman mendalam.
                                    Uji instingmu dengan Tryout Premium!</p>
                                <a href="{{ route('checkout', 1) }}"
                                    class="btn btn-warning text-dark w-100 rounded-pill fw-bold shadow-sm mb-3">Beli
                                    Paket Premium</a>
                                <div class="bg-light rounded p-2 border border-dashed">
                                    <span class="d-block text-muted" style="font-size: 0.75rem;">Gunakan kode
                                        diskon:</span>
                                    <strong class="text-danger fs-5">ASN2026</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('partials.scripts')
</body>

</html>
