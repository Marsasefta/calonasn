<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
</head>

<body>
    <div id="db-wrapper">
        @include('partials.navbar-vertical')

        <div id="page-content">
            @include('partials.dashboard-header')

            <div class="container-fluid p-4">
                <div class="row">
                    <div class="col-12">
                        <div class="border-bottom pb-3 mb-4">
                            <h1 class="mb-0 h2 fw-bold">Tambah Artikel Baru</h1>
                        </div>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Judul Artikel</label>
                                        <input type="text" name="title" class="form-control form-control-lg" placeholder="Masukkan judul artikel..." required value="{{ old('title') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Isi Artikel</label>
                                        <textarea name="content" id="editor" rows="12" class="form-control">{{ old('content') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4 border-start border-3 border-success">
                                <div class="card-header bg-white">
                                    <h4 class="mb-0 text-success fw-bold">🔍 Ringkasan / Meta Description SEO</h4>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Excerpt (Deskripsi Singkat)</label>
                                        <textarea name="excerpt" rows="3" class="form-control" placeholder="Tulis ringkasan konten untuk cuplikan Google... (Max 160 karakter)">{{ old('excerpt') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-12">
                            <div class="card mb-4">
                                <div class="card-header bg-white">
                                    <h4 class="mb-0 fw-bold">Penerbitan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Status Tayang</label>
                                        <select name="status" class="form-select">
                                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published (Publik)</option>
                                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Simpan Internal)</option>
                                        </select>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary btn-sm">Batal</a>
                                        <button type="submit" class="btn btn-primary btn-sm">Simpan Artikel</button>
                                    </div>
                                </div>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="card mb-4">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0 fw-bold">Kategori Artikel</h4>
                                    <button type="button" class="btn btn-sm btn-link p-0 text-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                        + Kategori Baru
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Pilih Kategori</label>
                                        <select name="blog_category_id" class="form-select" required>
                                            <option value="" disabled selected>-- Pilih Kategori --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('blog_category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header bg-white">
                                    <h4 class="mb-0 fw-bold">Gambar Utama</h4>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Pilih Gambar</label>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                        <small class="text-muted">Maksimal resolusi ideal 1200x675px (Maks 2MB).</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('partials.scripts')

    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.blog-categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori Artikel Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Tips & Trik" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>