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
                    <h1 class="mb-0 h2 fw-bold">Tambahkan Bank Soal</h1>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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
            <form action="{{ route('admin.store-bank-soal') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Pilih Sesi Tryout <span class="text-danger">*</span></label>
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
                            <label class="form-label">Pilih Kategori Soal <span class="text-danger">*</span></label>
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
                            <label class="form-label">Teks Pertanyaan <span class="text-danger">*</span></label>
                            <textarea name="question_text" class="form-control" rows="4" placeholder="Tulis pertanyaan (wajib)" required>{{ old('question_text') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Gambar Soal <span class="badge bg-secondary">Opsional</span></label>
                            <input type="file" name="question_image" class="form-control" accept="image/jpeg,image/png,image/jpg">
                            <small class="text-muted d-block mt-1">Format: JPG, PNG. Maksimal 2MB. Kosongkan jika tidak butuh gambar.</small>
                        </div>

                        <div class="mb-4 pb-4 border-bottom">
                            <label class="form-label">Pembahasan / Penjelasan</label>
                            <textarea name="discussion" class="form-control" rows="3" placeholder="Pembahasan jawaban (opsional)">{{ old('discussion') }}</textarea>
                        </div>

                        <h5 class="mb-3">Opsi Jawaban</h5>
                        <p class="small text-muted mb-4">Isi teks atau gambar, atau keduanya untuk masing-masing pilihan.</p>

                        <div class="border p-3 rounded mb-3 bg-light">
                            <h6 class="fw-bold mb-3">Pilihan A</h6>
                            <div class="mb-2">
                                <label class="form-label small">Teks Pilihan A</label>
                                <input type="text" name="option_a" class="form-control" value="{{ old('option_a') }}" placeholder="Kosongkan jika hanya memakai gambar" />
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <label class="form-label small">Gambar Pilihan A</label>
                                    <input type="file" name="image_a" class="form-control" accept="image/jpeg,image/png,image/jpg">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label small">Point A <span class="text-danger">*</span></label>
                                    <input type="number" name="point_a" class="form-control" value="{{ old('point_a', 0) }}" min="0" max="5" required />
                                </div>
                            </div>
                        </div>

                        <div class="border p-3 rounded mb-3 bg-light">
                            <h6 class="fw-bold mb-3">Pilihan B</h6>
                            <div class="mb-2">
                                <label class="form-label small">Teks Pilihan B</label>
                                <input type="text" name="option_b" class="form-control" value="{{ old('option_b') }}" placeholder="Kosongkan jika hanya memakai gambar" />
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <label class="form-label small">Gambar Pilihan B</label>
                                    <input type="file" name="image_b" class="form-control" accept="image/jpeg,image/png,image/jpg">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label small">Point B <span class="text-danger">*</span></label>
                                    <input type="number" name="point_b" class="form-control" value="{{ old('point_b', 0) }}" min="0" max="5" required />
                                </div>
                            </div>
                        </div>

                        <div class="border p-3 rounded mb-3 bg-light">
                            <h6 class="fw-bold mb-3">Pilihan C</h6>
                            <div class="mb-2">
                                <label class="form-label small">Teks Pilihan C</label>
                                <input type="text" name="option_c" class="form-control" value="{{ old('option_c') }}" placeholder="Kosongkan jika hanya memakai gambar" />
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <label class="form-label small">Gambar Pilihan C</label>
                                    <input type="file" name="image_c" class="form-control" accept="image/jpeg,image/png,image/jpg">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label small">Point C <span class="text-danger">*</span></label>
                                    <input type="number" name="point_c" class="form-control" value="{{ old('point_c', 0) }}" min="0" max="5" required />
                                </div>
                            </div>
                        </div>

                        <div class="border p-3 rounded mb-3 bg-light">
                            <h6 class="fw-bold mb-3">Pilihan D</h6>
                            <div class="mb-2">
                                <label class="form-label small">Teks Pilihan D</label>
                                <input type="text" name="option_d" class="form-control" value="{{ old('option_d') }}" placeholder="Kosongkan jika hanya memakai gambar" />
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <label class="form-label small">Gambar Pilihan D</label>
                                    <input type="file" name="image_d" class="form-control" accept="image/jpeg,image/png,image/jpg">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label small">Point D <span class="text-danger">*</span></label>
                                    <input type="number" name="point_d" class="form-control" value="{{ old('point_d', 0) }}" min="0" max="5" required />
                                </div>
                            </div>
                        </div>

                        <div class="border p-3 rounded mb-4 bg-light">
                            <h6 class="fw-bold mb-3">Pilihan E</h6>
                            <div class="mb-2">
                                <label class="form-label small">Teks Pilihan E</label>
                                <input type="text" name="option_e" class="form-control" value="{{ old('option_e') }}" placeholder="Kosongkan jika hanya memakai gambar" />
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <label class="form-label small">Gambar Pilihan E</label>
                                    <input type="file" name="image_e" class="form-control" accept="image/jpeg,image/png,image/jpg">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label small">Point E <span class="text-danger">*</span></label>
                                    <input type="number" name="point_e" class="form-control" value="{{ old('point_e', 0) }}" min="0" max="5" required />
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100" @if($tryouts->isEmpty() || $categories->isEmpty()) disabled @endif>
                            <i class="bi bi-save me-1"></i> Simpan Bank Soal
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4 col-12">
            <div class="card mb-4 position-sticky" style="top: 20px;">
                <div class="card-body">
                    <h5 class="mb-3">Petunjuk Upload Gambar</h5>
                    <ul class="text-muted small">
                        <li class="mb-2">Pastikan format gambar adalah <strong>JPG atau PNG</strong>.</li>
                        <li class="mb-2">Ukuran file maksimal per gambar disarankan <strong>dibawah 2MB</strong> agar akses tryout peserta tidak lambat.</li>
                        <li class="mb-2">Kamu bisa memasukkan teks saja, gambar saja, atau keduanya (teks + gambar) untuk soal maupun jawaban.</li>
                    </ul>
                    
                    @if($tryouts->isEmpty())
                        <div class="alert alert-warning mt-3">
                            Belum ada sesi tryout. <a href="{{ route('admin.create-tryout') }}" class="alert-link">Buat sesi tryout</a> terlebih dahulu.
                        </div>
                    @endif
                    @if($categories->isEmpty())
                        <div class="alert alert-warning mt-3">
                            Belum ada kategori soal. <a href="{{ route('admin.categories.index') }}" class="alert-link">Buat kategori</a> terlebih dahulu.
                        </div>
                    @endif
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