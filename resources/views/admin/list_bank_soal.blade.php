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
                        <div class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="mb-0 h2 fw-bold">Daftar Bank Soal</h1>
                            </div>
                            <div>
                                <a href="{{ route('admin.create-bank-soal') }}" class="btn btn-primary me-2">
                                    <i class="fe fe-plus"></i> Tambah Soal
                                </a>
                                <a href="{{ route('admin.import-bank-soal') }}" class="btn btn-success">
                                    <i class="fe fe-upload"></i> Import Soal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-12 col-12">
                        @if($questions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 80px;">No</th>
                                            <th>Pertanyaan</th>
                                            <th style="width: 120px;">Tryout</th>
                                            <th style="width: 100px;">Kategori</th>
                                            <th style="width: 80px;">Opsi</th>
                                            <th style="width: 120px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($questions as $index => $question)
                                            <tr>
                                                <td>{{ ($questions->currentPage() - 1) * $questions->perPage() + $loop->iteration }}</td>
                                                <td>
                                                    <small>{{ Str::limit($question->question_text, 100) }}</small>
                                                </td>
                                                <td>
                                                    <small class="badge bg-info">{{ $question->tryout->title ?? '-' }}</small>
                                                </td>
                                                <td>
                                                    <small class="badge bg-secondary">{{ $question->category->name ?? '-' }}</small>
                                                </td>
                                                <td>
                                                    <small>
                                                        <span class="badge bg-success">
                                                            {{ $question->options->count() }} opsi
                                                        </span>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="{{ route('admin.edit-bank-soal', $question->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                            <i class="fe fe-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.delete-bank-soal', $question->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus soal ini?')" title="Hapus">
                                                                <i class="fe fe-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="text-muted small">
                                    Menampilkan {{ $questions->firstItem() }} sampai {{ $questions->lastItem() }} dari {{ $questions->total() }} soal
                                </div>
                                <div>
                                    {{ $questions->links() }}
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <p class="mb-0">Belum ada soal. <a href="{{ route('admin.create-bank-soal') }}">Tambahkan soal</a> atau <a href="{{ route('admin.import-bank-soal') }}">import dari file</a>.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.scripts')
    <script>
        // Bootstrap alert auto-dismiss
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>

</html>
