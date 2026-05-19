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
                        <form action="{{ route('admin.store-bank-soal') }}" method="POST" class="needs-validation" novalidate>
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
                                        <label class="form-label">Pertanyaan</label>
                                        <textarea name="question_text" class="form-control" rows="4" placeholder="Tulis pertanyaan" required>{{ old('question_text') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Pembahasan / Penjelasan</label>
                                        <textarea name="discussion" class="form-control" rows="3" placeholder="Pembahasan jawaban (opsional)">{{ old('discussion') }}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Pilihan A</label>
                                            <input type="text" name="option_a" class="form-control" value="{{ old('option_a') }}" required />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Point A</label>
                                            <input type="number" name="point_a" class="form-control" value="{{ old('point_a', 0) }}" min="0" max="5" required />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Pilihan B</label>
                                            <input type="text" name="option_b" class="form-control" value="{{ old('option_b') }}" required />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Point B</label>
                                            <input type="number" name="point_b" class="form-control" value="{{ old('point_b', 0) }}" min="0" max="5" required />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Pilihan C</label>
                                            <input type="text" name="option_c" class="form-control" value="{{ old('option_c') }}" required />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Point C</label>
                                            <input type="number" name="point_c" class="form-control" value="{{ old('point_c', 0) }}" min="0" max="5" required />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Pilihan D</label>
                                            <input type="text" name="option_d" class="form-control" value="{{ old('option_d') }}" required />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Point D</label>
                                            <input type="number" name="point_d" class="form-control" value="{{ old('point_d', 0) }}" min="0" max="5" required />
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary" @if($tryouts->isEmpty() || $categories->isEmpty()) disabled @endif>Simpan Bank Soal</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4 col-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="mb-3">Petunjuk</h5>
                                <p class="text-muted">Pilih sesi tryout dan kategori soal terlebih dahulu, lalu masukkan pertanyaan, jawaban pilihan ganda, dan poin untuk setiap opsi.</p>
                                @if($tryouts->isEmpty())
                                    <div class="alert alert-warning">
                                        Belum ada sesi tryout. <a href="{{ route('admin.create-tryout') }}">Buat sesi tryout</a> terlebih dahulu.
                                    </div>
                                @endif
                                @if($categories->isEmpty())
                                    <div class="alert alert-warning mt-3">
                                        Belum ada kategori soal. <a href="{{ route('admin.categories.index') }}">Buat kategori</a> terlebih dahulu.
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