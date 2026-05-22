<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <style>
        .article-body {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #2D3748;
        }
        .article-body p {
            margin-bottom: 1.25rem;
        }
        .article-body img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div id="db-wrapper">
        @include('partials.navbar-vertical')

        <div id="page-content">
            @include('partials.dashboard-header')

            <div class="container-fluid p-4">
                <!-- Header Navigasi Balik -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
                            <div>
                                <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                                    <i class="fe fe-arrow-left me-1"></i> Kembali
                                </a>
                                <span class="text-muted">Preview Artikel</span>
                            </div>
                            <div>
                                <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fe fe-edit me-1"></i> Edit Artikel Ini
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Sisi Kiri: Preview Konten Utama -->
                    <div class="col-lg-8 col-12">
                        <div class="card mb-4 shadow-sm border-0">
                            <div class="card-body p-5">
                                <!-- Status Badge & Kategori -->
                                <div class="d-flex gap-2 mb-3">
                                    <span class="badge bg-primary-soft text-primary">{{ $post->category->name }}</span>
                                    <span class="badge {{ $post->status == 'published' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </div>

                                <!-- Judul Artikel -->
                                <h1 class="fw-bold text-dark display-6 mb-3">{{ $post->title }}</h1>

                                <!-- Meta Info -->
                                <div class="d-flex align-items-center gap-3 text-muted small mb-4 pb-3 border-bottom">
                                    <span><i class="fe fe-calendar me-1"></i> {{ $post->created_at->format('d M Y H:i') }}</span>
                                    <span>•</span>
                                    <span><i class="fe fe-user me-1"></i> Penulis: {{ $post->author->name ?? 'Admin' }}</span>
                                </div>

                                <!-- Gambar Utama -->
                                @if($post->image_url)
                                    <div class="mb-4 rounded overflow-hidden shadow-sm text-center bg-light">
                                        <img src="{{ $post->image_url }}" alt="" class="img-fluid" style="max-height: 400px; object-fit: cover; width: 100%;">
                                    </div>
                                @endif

                                <!-- Isi Konten CKEditor -->
                                <div class="article-body">
                                    {!! $post->content !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Panel Info Metadata SEO & Data Teknis -->
                    <div class="col-lg-4 col-12">
                        <div class="card mb-4 border-0 shadow-sm border-start border-3 border-info">
                            <div class="card-header bg-white py-3">
                                <h4 class="mb-0 fw-bold text-info"><i class="fe fe-search me-1"></i> Info SEO & URL</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted small mb-1">Slug URL</label>
                                    <div class="p-2 bg-light rounded text-break">
                                        <code>/blog/{{ $post->slug }}</code>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted small mb-1">Excerpt (Meta Description)</label>
                                    <p class="text-dark bg-light p-2 rounded small mb-0">
                                        {{ $post->excerpt ?? 'Tidak ada ringkasan khusus (Otomatis memotong isi artikel).' }}
                                    </p>
                                </div>
                                <hr class="my-3">
                                <div class="mb-2 d-flex justify-content-between small">
                                    <span class="text-muted">Tanggal Dibuat:</span>
                                    <span class="fw-bold text-dark">{{ $post->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">Jadwal Publish:</span>
                                    <span class="fw-bold text-dark">{{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : 'Belum Publish' }}</span>
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