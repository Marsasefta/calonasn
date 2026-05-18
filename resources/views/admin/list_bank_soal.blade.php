<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <link href="/build/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="/build/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
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

                <div class="row mb-3">
                    <div class="col-lg-12 col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-0">Gunakan kolom pencarian di tabel untuk menemukan soal berdasarkan teks, tryout, atau kategori.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-12">
                        @if($questions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped nowrap" id="questions-table" style="width:100%">
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
                                                <td>{{ $loop->iteration }}</td>
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
    <script src="/build/assets/plugins/datatables.net/js/dataTables.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
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

            if (window.jQuery && $.fn.DataTable) {
                $('#questions-table').DataTable({
                    responsive: true,
                    autoWidth: false,
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                    columnDefs: [
                        { orderable: false, targets: [0, 5] }
                    ],
                    language: {
                        search: 'Cari:',
                        lengthMenu: 'Tampilkan _MENU_ baris',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ soal',
                        infoEmpty: 'Menampilkan 0 sampai 0 dari 0 soal',
                        infoFiltered: '(disaring dari _MAX_ total soal)',
                        zeroRecords: 'Tidak ditemukan data yang sesuai',
                        paginate: {
                            previous: 'Sebelumnya',
                            next: 'Berikutnya'
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
