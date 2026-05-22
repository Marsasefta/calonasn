@extends('layouts.landing')

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
            shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .sidebar-sticky {
            position: sticky;
            top: 2rem;
        }
        .text-justify {
            text-align: justify;
        }
    </style>
@endpush

@section('content')
<main class="py-8 bg-white border-top">
    <div class="container">
        
        <!-- Breadcrumb Navigasi -->
        <div class="row mb-3">
            <div class="col-lg-8 col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2" style="font-size: 14px;">
                        <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Home</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Artikel</li>
                    </ol>
                </nav>
                <!-- Badge Kategori -->
                <span class="badge bg-primary-soft text-primary fw-bold px-3 py-2 rounded-pill mb-2" style="font-size: 0.85rem; background-color: #e0f2fe;">
                    <i class="fe fe-tag me-1"></i> {{ $post->category->name }}
                </span>
            </div>
        </div>

        <!-- Judul Artikel (Tag H1 Mutlak untuk SEO Google) -->
        <div class="row mb-4">
            <div class="col-lg-8 col-12">
                <h1 class="fw-extrabolder text-dark lh-sm mb-3" style="font-size: 2.5rem; font-weight: 800;">
                    {{ $post->title }}
                </h1>
                
                <!-- Info Penulis & Tanggal -->
                <div class="d-flex align-items-center gap-3 text-muted pb-3 border-bottom small">
                    <span class="d-flex align-items-center gap-1">
                        <i class="fe fe-calendar"></i> 
                        {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                    </span>
                    <span class="text-secondary opacity-25">|</span>
                    <span class="d-flex align-items-center gap-1">
                        <i class="fe fe-user"></i> Oleh: <strong class="text-dark">{{ $post->author->name ?? 'Admin' }}</strong>
                    </span>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <!-- KOLOM KIRI: ISI ARTIKEL UTAMA -->
            <div class="col-lg-8 col-12">
                <!-- Gambar Utama (Featured Image) -->
                @if($post->image_url)
                    <div class="mb-4 rounded-4 overflow-hidden shadow-sm" style="max-height: 420px; width: 100%;">
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-100 h-100" style="object-fit: contain; object-position: center;">
                    </div>
                @endif

                <!-- Render Konten CKEditor Secara Aman -->
                <div class="blog-post-content text-justify">
                    {!! $post->content !!}
                </div>
            </div>

            <!-- KOLOM KANAN: SIDEBAR REKOMENDASI -->
            <div class="col-lg-4 col-12">
                <div class="sidebar-sticky">
                    
                    <!-- Card Rekomendasi Tulisan Lain -->
                    <div class="card border-0 bg-light p-4 rounded-4 mb-4 shadow-sm">
                        <h4 class="fw-bold text-dark mb-4" style="font-size: 1.15rem;">Baca Artikel Lainnya</h4>
                        <div class="d-flex flex-column gap-3">
                            @forelse($relatedPosts as $related)
                                <a href="{{ route('blog.show', $related->slug) }}" class="d-flex align-items-center gap-3 text-decoration-none group text-dark">
                                    <div style="width: 80px; height: 60px; flex-shrink: 0;" class="bg-secondary rounded-3 overflow-hidden shadow-sm">
                                        <img src="{{ $related->image_url ?? '/build/assets/images/course/default-blog.png' }}" alt="" class="w-100 h-100" style="object-fit: cover;">
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 lh-base text-dark" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: 0.9rem;">
                                            {{ $related->title }}
                                        </h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ $related->created_at->format('d M Y') }}</small>
                                    </div>
                                </a>
                            @empty
                                <p class="text-muted small mb-0">Belum ada artikel rekomendasi.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Card Banner Promosi Tryout (Call to Action) -->
                    <div class="card border-0 text-white p-4 rounded-4 text-center shadow-sm" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">
                        <div class="mb-3">
                            <i class="fe fe-zap text-warning display-4"></i>
                        </div>
                        <h4 class="text-white fw-bold mb-2">Mau Lulus Ujian ASN?</h4>
                        <p class="small text-white-50 mb-4">Jangan cuma belajar teori! Latih mental bertarungmu dengan simulasi CAT BKN terakurat sekarang.</p>
                        <a href="{{ route('register') }}" class="btn btn-white text-primary fw-bold w-100 rounded-3 py-2.5 bg-white border-0 shadow">
                            Daftar Akun Gratis
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</main>
@endsection