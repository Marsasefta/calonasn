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
                                <h1 class="mb-0 h2 fw-bold">Edit Bank Soal</h1>
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
                        <form action="{{ route('admin.update-bank-soal', $question->id) }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Pilih Sesi Tryout</label>
                                        <select name="tryout_id" class="form-select" required>
                                            <option value="">Pilih tryout</option>
                                            @foreach($tryouts as $tryout)
                                                <option value="{{ $tryout->id }}" {{ $question->tryout_id == $tryout->id ? 'selected' : '' }}>
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
                                                <option value="{{ $category->id }}" {{ $question->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Pertanyaan</label>
                                        <textarea name="question_text" class="form-control" rows="4" placeholder="Tulis pertanyaan" required>{{ $question->question_text }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Pembahasan / Penjelasan</label>
                                        <textarea name="discussion" class="form-control" rows="3" placeholder="Pembahasan jawaban (opsional)">{{ $question->discussion }}</textarea>
                                    </div>

                                    @php
                                        $options = $question->options()->orderBy('id')->get();
                                        $optionLetters = ['A', 'B', 'C', 'D'];
                                    @endphp

                                    @foreach($optionLetters as $index => $letter)
                                        @php
                                            $option = $options[$index] ?? null;
                                        @endphp
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Pilihan {{ $letter }}</label>
                                                <input type="text" name="option_{{ strtolower($letter) }}" class="form-control" 
                                                    value="{{ $option->option_text ?? '' }}" required />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Point {{ $letter }}</label>
                                                <input type="number" name="point_{{ strtolower($letter) }}" class="form-control" 
                                                    value="{{ $option->point ?? 0 }}" min="0" max="5" required />
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary">Perbarui Bank Soal</button>
                                        <a href="{{ route('admin.list-bank-soal') }}" class="btn btn-secondary">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4 col-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="mb-3">Informasi</h5>
                                <p class="text-muted">Edit pertanyaan dan pilihan jawaban untuk soal ini. Pastikan semua data sudah benar sebelum menyimpan.</p>
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
