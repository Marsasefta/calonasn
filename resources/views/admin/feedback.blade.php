<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <link href="/build/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="/build/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
    <title>Feedback &amp; Testimoni Peserta | Admin CalonASN.id</title>
</head>

<body>
    <div id="db-wrapper">
        @include('partials.navbar-vertical')

        <main id="page-content">
            @include('partials.dashboard-header')

            <section class="container-fluid p-3 p-md-4">
                <div class="row mb-4">
                    <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h1 class="mb-1 h2 fw-bold">Feedback &amp; Testimoni Peserta</h1>
                            <p class="text-muted mb-0">Pantau kepuasan tryout, tingkat rekomendasi, kritik/saran, dan pilih testimoni yang ditayangkan di halaman depan.</p>
                        </div>
                        <a href="{{ url('/#testimoni') }}" target="_blank" class="btn btn-outline-primary btn-sm fw-semibold">
                            <i class="fe fe-external-link me-1"></i> Lihat Halaman Depan
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- 4 Kartu Ringkasan Statistik -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold text-uppercase">Total Masukan</span>
                                <h3 class="fw-bolder mb-0 mt-1 text-dark">{{ $totalFeedback }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold text-uppercase">Rata-Rata Rating</span>
                                <h3 class="fw-bolder mb-0 mt-1 text-warning">
                                    ★ {{ number_format($avgRating, 1) }} <span class="fs-6 text-muted fw-normal">/ 5.0</span>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold text-uppercase">Mau Merekomendasikan</span>
                                <h3 class="fw-bolder mb-0 mt-1 text-success">
                                    {{ $recommendRate }}% <span class="fs-6 text-muted fw-normal">({{ $recommendYesCount }}/{{ $totalFeedback }})</span>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold text-uppercase">Tayang di Depan</span>
                                <h3 class="fw-bolder mb-0 mt-1 text-primary">{{ $publishedCount }} <span class="fs-6 text-muted fw-normal">Testimoni</span></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Cepat -->
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold fb-filter-btn active" data-filter="all">
                        Semua ({{ $totalFeedback }})
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold fb-filter-btn" data-filter="unpublished">
                        Belum Tayang ({{ $totalFeedback - $publishedCount }})
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold fb-filter-btn" data-filter="published">
                        Tayang di Depan ({{ $publishedCount }})
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-warning text-dark rounded-pill px-3 fw-semibold fb-filter-btn" data-filter="attention">
                        Perlu Perhatian (Mungkin/Belum)
                    </button>
                </div>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive p-3">
                            <table class="table table-bordered table-hover table-striped align-middle" id="feedback-table" style="width:100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Peserta</th>
                                        <th>Rating</th>
                                        <th>Rekomendasi</th>
                                        <th>Testimoni / Kritik &amp; Saran</th>
                                        <th>Status Depan</th>
                                        <th>Tanggal</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($feedbacks as $fb)
                                        <tr data-published="{{ $fb->is_published ? '1' : '0' }}" data-rec="{{ $fb->recommendation }}">
                                            <td></td>
                                            <td>
                                                <div class="fw-semibold">{{ $fb->user->name ?? '-' }}</div>
                                                <div class="small text-muted">
                                                    Depan: <span class="fw-medium">{{ $fb->maskedAuthorName() }}</span>
                                                    @if (!is_null($fb->total_score))
                                                        &bull; Skor {{ $fb->total_score }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td data-order="{{ $fb->rating }}">
                                                <span class="text-warning fw-bold text-nowrap">{{ str_repeat('★', $fb->rating) }}{{ str_repeat('☆', max(0, 5 - $fb->rating)) }}</span>
                                            </td>
                                            <td>
                                                @if ($fb->recommendation === 'yes')
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle">👍 Ya, Pasti</span>
                                                @elseif ($fb->recommendation === 'maybe')
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">🤔 Mungkin</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">👎 Belum</span>
                                                @endif
                                            </td>
                                            <td style="min-width: 260px; white-space: normal;">
                                                {{ $fb->message }}
                                            </td>
                                            <td>
                                                @if ($fb->is_published)
                                                    <span class="badge bg-primary">Tayang</span>
                                                @else
                                                    <span class="badge bg-secondary">Internal</span>
                                                @endif
                                            </td>
                                            <td data-order="{{ $fb->created_at->timestamp }}">{{ $fb->created_at->format('d M Y H:i') }}</td>
                                            <td class="text-end">
                                                <div class="d-flex justify-content-end align-items-center gap-2 flex-nowrap">
                                                    <form action="{{ route('admin.feedback.toggle-publish', $fb->id) }}" method="POST" class="mb-0">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm {{ $fb->is_published ? 'btn-outline-secondary' : 'btn-success' }} text-nowrap">
                                                            {{ $fb->is_published ? 'Sembunyikan' : 'Tayangkan' }}
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.feedback.destroy', $fb->id) }}" method="POST" class="delete-feedback-form mb-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    @include('partials.scripts')
    <script src="/build/assets/plugins/datatables.net/js/dataTables.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let activeFilter = 'all';
            let table = null;

            if (window.jQuery && $.fn.DataTable) {
                $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                    if (settings.nTable.id !== 'feedback-table' || activeFilter === 'all') {
                        return true;
                    }
                    const node = table ? table.row(dataIndex).node() : null;
                    if (!node) return true;
                    const pub = node.getAttribute('data-published');
                    const rec = node.getAttribute('data-rec');
                    if (activeFilter === 'published') return pub === '1';
                    if (activeFilter === 'unpublished') return pub === '0';
                    if (activeFilter === 'attention') return rec !== 'yes';
                    return true;
                });

                table = $('#feedback-table').DataTable({
                    responsive: false,
                    scrollX: true,
                    autoWidth: false,
                    pageLength: 10,
                    columnDefs: [
                        { orderable: false, targets: [0, 7] },
                        { searchable: false, targets: [0, 7] }
                    ],
                    order: [[6, 'desc']],
                    language: {
                        search: 'Cari:',
                        lengthMenu: 'Tampilkan _MENU_ baris',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ feedback',
                        infoEmpty: 'Menampilkan 0 sampai 0 dari 0 feedback',
                        emptyTable: 'Belum ada feedback dari peserta tryout.',
                        zeroRecords: 'Tidak ditemukan data yang sesuai',
                        paginate: { previous: 'Sebelumnya', next: 'Berikutnya' }
                    }
                });

                table.on('order.dt search.dt', function () {
                    let i = 1;
                    table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function () {
                        this.data(i++);
                    });
                }).draw(false);
            }

            document.querySelectorAll('.fb-filter-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    activeFilter = btn.dataset.filter || 'all';
                    document.querySelectorAll('.fb-filter-btn').forEach(function (b) {
                        b.classList.remove('active', 'btn-primary');
                        if (b.dataset.filter === 'published') b.classList.add('btn-outline-success');
                        else if (b.dataset.filter === 'attention') b.classList.add('btn-outline-warning', 'text-dark');
                        else if (b.dataset.filter === 'unpublished') b.classList.add('btn-outline-secondary');
                        else b.classList.add('btn-outline-primary');
                    });
                    btn.classList.remove('btn-outline-primary', 'btn-outline-secondary', 'btn-outline-success', 'btn-outline-warning', 'text-dark');
                    btn.classList.add('btn-primary', 'active');
                    if (table) table.draw();
                });
            });

            document.addEventListener('submit', function (e) {
                const delForm = e.target.closest('.delete-feedback-form');
                if (!delForm) return;
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Feedback',
                    text: 'Feedback ini akan dihapus permanen.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then(function (result) {
                    if (result.isConfirmed) delForm.submit();
                });
            });
        });
    </script>
</body>

</html>
