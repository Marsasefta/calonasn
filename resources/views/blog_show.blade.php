@extends('layouts.landing')

@section('title', $post->title . ' | CalonASN.id')

@section('meta_tags')
    <!-- Meta Google -->
    <meta name="description" content="{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}" />

    <!-- Meta Facebook/WhatsApp (Open Graph) -->
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="{{ $post->title }}" />
    <meta property="og:description" content="{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}" />
    <meta property="og:image" content="{{ url($post->image_url ?? '/build/assets/images/course/default-blog.png') }}" />

    <!-- Meta Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:description" content="{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}">
    <meta name="twitter:image" content="{{ url($post->image_url ?? '/build/assets/images/course/default-blog.png') }}">
@endsection

@push('styles')
    <style>
        .blog-post-content {
            font-size: 1.125rem;
            line-height: 1.85;
            color: #334155;
        }

        .blog-post-content p {
            margin-bottom: 1.5rem;
        }

        /* Menghindari gambar dari CKEditor pecah atau keluar jalur */
        .blog-post-content img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 1.5rem 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .sidebar-sticky {
            position: sticky;
            top: 2rem;
        }

        .text-justify {
            text-align: justify;
        }

        /* Styling Daftar Isi Interaktif Anda yang Sangat Bagus */
        #toc-list a {
            display: block;
            padding: 5px 10px;
            border-radius: 8px;
            transition: all .2s ease;
            line-height: 1.35;
        }

        #toc-list a:hover {
            background-color: #eff6ff;
            color: #2563eb !important;
            transform: translateX(3px);
        }

        #toc-list a.active {
            background-color: #dbeafe;
            color: #1d4ed8 !important;
            font-weight: 700;
        }

        #toc-list li.toc-h2 a {
            font-weight: 700;
            color: #0f172a;
        }

        #toc-list li.toc-h3 {
            padding-left: 16px;
        }

        #toc-list li.toc-h3 a {
            font-size: 0.95rem;
            color: #475569;
        }

        #toc-list li.toc-h4 {
            padding-left: 32px;
        }

        #toc-list li.toc-h4 a {
            font-size: 0.88rem;
            color: #64748b;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
@endpush

@section('content')
    <main class="py-8 bg-white border-top">
        <div class="container">

            <div class="row mb-3">
                <div class="col-lg-8 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2" style="font-size: 14px;">
                            <li class="breadcrumb-item">
                                <a href="/" class="text-decoration-none text-muted">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('blog.index') }}" class="text-decoration-none text-muted">Blog</a>
                            </li>
                            <li class="breadcrumb-item active text-primary d-inline-block text-truncate" aria-current="page"
                                style="max-width: 250px;">
                                {{ $post->title }}
                            </li>
                        </ol>
                    </nav>
                    <span class="badge bg-primary-soft text-primary fw-bold px-3 py-2 rounded-pill mb-2"
                        style="font-size: 0.85rem; background-color: #e0f2fe;">
                        <i class="fe fe-tag me-1"></i> {{ $post->category->name }}
                    </span>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-8 col-12">
                    <h1 class="fw-extrabolder text-dark lh-sm mb-3" style="font-size: 2.5rem; font-weight: 800;">
                        {{ $post->title }}
                    </h1>

                    <div class="d-flex align-items-center gap-3 text-muted pb-3 border-bottom small">
                        <span class="d-flex align-items-center gap-1">
                            <i class="fe fe-calendar"></i>
                            {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                        </span>
                        <span class="text-secondary opacity-25">|</span>
                        <span class="d-flex align-items-center gap-1">
                            <i class="fe fe-user"></i> Oleh: <strong
                                class="text-dark">{{ $post->author->name ?? 'Admin' }}</strong>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row g-5">
                <div class="col-lg-8 col-12">
                    @if ($post->image_url)
                        <div class="mb-4 rounded-4 overflow-hidden shadow-sm" style="max-height: 420px; width: 100%;">
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-100 h-100"
                                style="object-fit: contain; object-position: center;">
                        </div>
                    @endif

                    <div class="card shadow-sm mb-4 rounded-4 overflow-hidden border-0" id="toc-container"
                        style="display:none; background:#eff6ff; border:1px solid #dbeafe;">
                        <div class="card-header border-0 py-3" style="background:#dbeafe;">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0 d-flex align-items-center gap-2 text-primary">
                                    <i class="fe fe-list"></i> Daftar Isi
                                </h5>
                                <button id="toc-toggle" class="btn btn-sm btn-light rounded-circle border-0 shadow-sm"
                                    type="button" style="width:32px; height:32px;">
                                    <span id="toc-icon" class="fw-bold fs-5">−</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-3 p-lg-4" id="toc-body">
                            <ul id="toc-list" class="list-unstyled mb-0 d-flex flex-column gap-1">
                            </ul>
                        </div>
                    </div>

                    <div class="blog-post-content text-justify" id="article-body">
                        {!! $post->content !!}
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="sidebar-sticky">

                        <div class="card border-0 bg-light p-4 rounded-4 mb-4 shadow-sm">
                            <h4 class="fw-bold text-dark mb-4" style="font-size: 1.15rem;">Baca Artikel Lainnya</h4>
                            <div class="d-flex flex-column gap-3">
                                @forelse($relatedPosts as $related)
                                    <a href="{{ route('blog.show', $related->slug) }}"
                                        class="d-flex align-items-center gap-3 text-decoration-none group text-dark">
                                        <div style="width: 80px; height: 60px; flex-shrink: 0;"
                                            class="bg-secondary rounded-3 overflow-hidden shadow-sm">
                                            <img src="{{ $related->image_url ?? '/build/assets/images/course/default-blog.png' }}"
                                                alt="" class="w-100 h-100" style="object-fit: cover;">
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1 lh-base text-dark"
                                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: 0.9rem;">
                                                {{ $related->title }}
                                            </h6>
                                            <small class="text-muted"
                                                style="font-size: 0.75rem;">{{ $related->created_at->format('d M Y') }}</small>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-muted small mb-0">Belum ada artikel rekomendasi.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="card border-0 text-white p-4 rounded-4 text-center shadow-sm"
                            style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">
                            <div class="mb-3">
                                <i class="fe fe-zap text-warning display-4"></i>
                            </div>
                            <h4 class="text-white fw-bold mb-2">Mau Lulus Ujian ASN?</h4>
                            <p class="small text-white-50 mb-4">Jangan cuma belajar teori! Latih mental bertarungmu dengan
                                simulasi CAT BKN terakurat sekarang.</p>
                            <a href="{{ route('register') }}"
                                class="btn btn-white text-primary fw-bold w-100 rounded-3 py-2.5 bg-white border-0 shadow">
                                Daftar Akun Gratis
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const articleBody = document.getElementById('article-body');
            const tocContainer = document.getElementById('toc-container');
            const tocList = document.getElementById('toc-list');

            if (!articleBody || !tocContainer || !tocList) return;

            // Diperbaiki agar mendeteksi huruf kapital dari CKEditor yang bandel
            const headings = articleBody.querySelectorAll('h2, h3, h4, H2, H3, H4');

            if (headings.length === 0) return;

            tocContainer.style.display = 'block';

            headings.forEach((heading, index) => {
                const text = heading.innerText.trim();
                if (!text) return;

                let id = text.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
                if (!id) id = 'section-' + index;

                heading.id = id;

                const li = document.createElement('li');
                // class dinamis mengikuti jenis heading
                li.classList.add('toc-' + heading.tagName.toLowerCase());

                const a = document.createElement('a');
                a.href = '#' + id;
                a.innerText = text;
                a.className = 'text-decoration-none';

                li.appendChild(a);
                tocList.appendChild(li);
            });

            // Active heading on scroll (Canggih!)
            const tocLinks = tocList.querySelectorAll('a');

            window.addEventListener('scroll', () => {
                let current = '';

                headings.forEach((heading) => {
                    const sectionTop = heading.offsetTop - 140; // Offset untuk jarak navbar header
                    if (window.scrollY >= sectionTop) {
                        current = heading.id;
                    }
                });

                tocLinks.forEach((link) => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });
            });

        });
    </script>

    <script>
        // Logika Buka Tutup (Toggle) Daftar Isi
        const tocToggle = document.getElementById('toc-toggle');
        const tocBody = document.getElementById('toc-body');
        const tocIcon = document.getElementById('toc-icon');

        if (tocToggle && tocBody && tocIcon) {
            tocToggle.addEventListener('click', function() {
                if (tocBody.style.display === 'none') {
                    tocBody.style.display = 'block';
                    tocIcon.innerText = '−'; // Simbol Minus
                } else {
                    tocBody.style.display = 'none';
                    tocIcon.innerText = '+'; // Simbol Plus
                }
            });
        }
    </script>
@endpush
