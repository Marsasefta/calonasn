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
<section class="py-xl-8 py-6 bg-light border-top border-bottom">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-md-8 col-12 text-center text-md-start">
                <h1 class="display-5 fw-bold text-dark mb-2">Blog & Info CPNS 2026</h1>
                <p class="text-muted mb-0">Ikuti tips sukses, info regulasi CPNS, dan materi pembelajaran terupdate langsung dari ahlinya.</p>
            </div>
            <div class="col-md-4 col-12 text-center text-md-end d-none d-md-block">
                <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-3">
                    Mulai Tryout Sekarang <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <div class="row gy-4">
            @forelse($posts as $post)
                <div class="col-lg-4 col-md-6 col-12">
                    <article class="blog-card card border-0 shadow-sm h-100 overflow-hidden" style="transition: all 0.3s ease;">
                        
                        <div class="position-relative overflow-hidden bg-light" style="height: 220px;">
                            <a href="{{ route('blog.show', $post->slug) }}">
                                <img src="{{ $post->image_url ?? asset('build/assets/images/course/default-blog.png') }}" 
                                    alt="{{ $post->title }}" 
                                    class="w-100 h-100" 
                                    style="object-fit: cover; object-position: center; transition: transform 0.5s ease;" />
                            </a>
                            <span class="blog-category-badge position-absolute bg-white text-primary fw-bold shadow-sm" 
                                style="top: 1rem; left: 1rem; z-index: 2; font-size: 0.75rem; padding: 6px 14px; border-radius: 30px;">
                                {{ $post->category->name ?? 'Info' }}
                            </span>
                        </div>
                        
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-3 mb-3 text-muted small">
                                    <span class="d-flex align-items-center gap-1">
                                        <i class="far fa-calendar-alt text-secondary"></i> 
                                        {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                                    </span>
                                    <span class="text-secondary opacity-25">|</span>
                                    <span class="d-flex align-items-center gap-1">
                                        <i class="far fa-user text-secondary"></i> 
                                        {{ $post->author->name ?? 'Admin' }}
                                    </span>
                                </div>
                                
                                <h3 class="card-title fw-bold lh-base mb-2 h4">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="blog-title-link text-dark text-decoration-none" 
                                    style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 3rem;">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                
                                <p class="card-text text-muted fs-6 mb-4" 
                                style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                                </p>
                            </div>
                            
                            <div class="pt-3 border-top mt-auto">
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-primary fw-bold text-decoration-none d-flex align-items-center gap-1 fs-6 blog-read-more-btn">
                                    Baca Selengkapnya 
                                    <i class="fas fa-arrow-right fs-7 ms-1 transition-transform" style="transition: transform 0.2s ease;"></i>
                                </a>
                            </div>
                        </div>

                    </article>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted p-5 bg-white rounded-4 shadow-sm border">
                        <i class="far fa-newspaper fa-3x mb-3 text-secondary opacity-50"></i>
                        <h4 class="mb-2 fw-bold text-dark">Belum Ada Artikel</h4>
                        <p class="mb-0 fs-5">Nantikan informasi dan tips menarik seputar CPNS di sini.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($posts->hasPages())
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{-- Gunakan template bootstrap 5 agar rapi --}}
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif

    </div>
</section>
@endsection