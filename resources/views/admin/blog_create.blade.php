<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <!-- PENTING: Memakai CDN CKEditor 5 Standar Resmi Terbaru -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <style>
        /* Mengunci tinggi box editor agar seragam ala WordPress */
        .ck-editor__editable_inline {
            min-height: 350px !important;
            max-height: 600px !important;
            text-align: left;
        }
    </style>
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
                                        <!-- ID editor dipastikan unik untuk dicari oleh JS -->
                                        <textarea name="content" id="editor" class="form-control d-none">{{ old('content') }}</textarea>
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

    <!-- 1. SCRIPT PARTIALS DILOAD TERLEBIH DAHULU -->
    @include('partials.scripts')

    <!-- 2. MODAL DI LETAKKAN DI BAWAH -->
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

    <!-- 3. INITIALIZATION SCRIPT UTAMA DI TARUH PADA POSISI PALING AKHIR -->
    <script>
        window.addEventListener('load', function() {
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    // Konfigurasi Toolbar Lengkap ala WordPress / CMS Modern
                    toolbar: {
                        items: [
                            'heading', 
                            '|', 
                            'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript',
                            '|', 
                            'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent', 
                            '|', 
                            'alignment', // Mengatur rata kiri, kanan, tengah, dan justify
                            '|', 
                            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 
                            '|', 
                            'link', 'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', 'code', 'codeBlock',
                            '|', 
                            'undo', 'redo',
                            '|',
                            'findAndReplace', 'selectAll', 'removeFormat'
                        ],
                        shouldNotGroupWhenFull: true // Membuat toolbar otomatis turun ke baris baru jika layar admin kekecilan (sangat responsif)
                    },
                    // Pengaturan tambahan untuk navigasi peletakan gambar & tabel
                    table: {
                        contentToolbar: [
                            'tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties'
                        ]
                    },
                    image: {
                        toolbar: [
                            'imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|',
                            'toggleImageCaption', 'imageTextAlternative'
                        ]
                    }
                })
                .then(editor => {
                    console.log('CKEditor 5 dengan Toolbar Lengkap berhasil dimuat!');
                })
                .catch(error => {
                    console.error('Kendala load CKEditor:', error);
                });
        });
    </script>
</body>
</html>