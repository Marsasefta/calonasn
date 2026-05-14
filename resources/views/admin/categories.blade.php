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
                        <div class="border-bottom pb-3 mb-3">
                            <div class="mb-2 mb-lg-0">
                                <h1 class="mb-0 h2 fw-bold">Kelola Kategori Soal</h1>
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
                    <div class="col-lg-6 col-12">
                        <form action="{{ route('admin.categories.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Kategori</label>
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Contoh: Matematika" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nilai Ambang Lulus</label>
                                        <input type="number" name="passing_grade_score" value="{{ old('passing_grade_score', 0) }}" class="form-control" min="0" />
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 class="mb-3">Daftar Kategori</h4>
                                @if($categories->isEmpty())
                                    <p class="text-muted">Belum ada kategori soal. Tambahkan kategori sebelum membuat bank soal.</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Passing Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($categories as $category)
                                                    <tr>
                                                        <td>{{ $category->name }}</td>
                                                        <td>{{ $category->passing_grade_score }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
