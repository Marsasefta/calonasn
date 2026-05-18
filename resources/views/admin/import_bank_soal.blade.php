<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body>
    <!-- Wrapper -->
    <div id="db-wrapper">
        @include('partials.navbar-vertical')

        <div id="page-content">
            @include('partials.dashboard-header')

            <div class="container-fluid p-4">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="border-bottom pb-3 mb-3">
                            <div class="mb-2 mb-lg-0">
                                <h1 class="mb-0 h2 fw-bold">Import Bank Soal</h1>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('warnings') && is_array(session('warnings')))
                    <div class="alert alert-warning">
                        <strong>Peringatan saat import:</strong>
                        <ul class="mb-0">
                            @foreach(session('warnings') as $warning)
                                <li>{{ $warning }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-8 col-12">
                        <form action="{{ route('admin.import-bank-soal-process') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf

                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Pilih Sesi Tryout</label>
                                        <select name="tryout_id" class="form-select" required>
                                            <option value="">Pilih tryout</option>
                                            @foreach($tryouts as $tryout)
                                                <option value="{{ $tryout->id }}" {{ old('tryout_id') == $tryout->id ? 'selected' : '' }}>
                                                    {{ $tryout->title }} @if($tryout->schedule_at) ({{ date('d M Y', strtotime($tryout->schedule_at)) }}) @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Pilih Kategori Soal</label>
                                        <select name="category_id" class="form-select" required>
                                            <option value="">Pilih kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Upload File (CSV atau Excel)</label>
                                        <input type="file" name="file" class="form-control" accept=".csv,.txt,.xlsx,.xls" required />
                                        <small class="form-text text-muted">Format: CSV, TXT, atau Excel (XLSX, XLS)</small>
                                    </div>

                                    <button type="submit" class="btn btn-primary" @if($tryouts->isEmpty() || $categories->isEmpty()) disabled @endif>Import Soal</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4 col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Format File</h5>
                            </div>
                            <div class="card-body">
                                <p class="small mb-2"><strong>Struktur CSV/Excel harus memiliki kolom berikut (urutan penting):</strong></p>
                                <ol class="small">
                                    <li><strong>Pertanyaan</strong> - Teks pertanyaan</li>
                                    <li><strong>Pilihan A</strong> - Teks pilihan A</li>
                                    <li><strong>Pilihan B</strong> - Teks pilihan B</li>
                                    <li><strong>Pilihan C</strong> - Teks pilihan C</li>
                                    <li><strong>Pilihan D</strong> - Teks pilihan D</li>
                                    <li><strong>Point A</strong> - Poin untuk pilihan A (0-5). Untuk kategori TKP gunakan 1-5</li>
                                    <li><strong>Point B</strong> - Poin untuk pilihan B (0-5). Untuk kategori TKP gunakan 1-5</li>
                                    <li><strong>Point C</strong> - Poin untuk pilihan C (0-5). Untuk kategori TKP gunakan 1-5</li>
                                    <li><strong>Point D</strong> - Poin untuk pilihan D (0-5). Untuk kategori TKP gunakan 1-5</li>
                                    <li><strong>Pembahasan</strong> (opsional) - Penjelasan jawaban</li>
                                </ol>

                                <hr>

                                <p class="small mb-2"><strong>Contoh CSV:</strong></p>
                                <div class="bg-light p-2 small" style="overflow-x: auto;">
                                    <code>Berapakah hasil 2+2?,Empat,Lima,Tiga,Dua,5,0,0,0,Jawabannya adalah 4
Siapa presiden Indonesia?,Joko Widodo,Prabowo,Megawati,Habibie,5,0,0,0,Joko Widodo adalah presiden ke-7</code>
                                </div>

                                <hr>

                                <p class="small text-muted mb-0"><strong>Tips:</strong> Gunakan spreadsheet editor seperti Excel, Google Sheets, atau LibreOffice Calc untuk membuat file. Pastikan tidak ada baris kosong di pertengahan data.</p>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('admin.create-bank-soal') }}" class="btn btn-sm btn-outline-primary w-100 mb-2">
                                    <i class="fe fe-plus"></i> Tambah Soal Manual
                                </a>
                                <a href="{{ route('admin.list-bank-soal') }}" class="btn btn-sm btn-outline-secondary w-100">
                                    <i class="fe fe-list"></i> Lihat Daftar Soal
                                </a>
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
