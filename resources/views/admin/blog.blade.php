<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body>
    <div id="db-wrapper">
        @include('partials.navbar-vertical')

        <div id="page-content">
            @include('partials.dashboard-header')

            <div class="container-fluid p-4">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center">
                            <div class="mb-2 mb-lg-0">
                                <h1 class="mb-0 h2 fw-bold">Kelola Artikel & Berita</h1>
                            </div>
                            <div>
                                <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">Tambah Artikel Baru</a>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>Gambar</th>
                                                <th>Judul</th>
                                                <th>Kategori</th>
                                                <th>Status</th>
                                                <th>Tanggal di-Publish</th>
                                                <th class="text-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($posts as $post)
                                                <tr>
                                                    <td>
                                                        @if($post->image_url)
                                                            <img src="{{ $post->image_url }}" alt="" class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                                                        @else
                                                            <span class="badge bg-secondary">No Image</span>
                                                        @endif
                                                    </td>
                                                    <td class="fw-bold text-dark">{{ $post->title }}</td>
                                                    <td><span class="badge bg-info-soft text-info">{{ $post->category->name }}</span></td>
                                                    <td>
                                                        <span class="badge {{ $post->status == 'published' ? 'bg-success' : 'bg-warning' }}">
                                                            {{ ucfirst($post->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $post->published_at ? $post->published_at->format('d M Y H:i') : '-' }}</td>
                                                    <td class="text-end">
                                                        <a href="{{ route('admin.blog.show', $post->id) }}" class="btn btn-sm btn-outline-warning me-1">Lihat</a>
                                                        <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                                        <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-4 text-muted">
                                                        Belum ada artikel. Klik "Tambah Artikel Baru" untuk memulai optimasi SEO website Anda.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    {{ $posts->links() }}
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