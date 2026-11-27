<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <link href="/build/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="/build/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
    <title>Pengeluaran &amp; Biaya Iklan | Admin CalonASN.id</title>
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
                            <h1 class="mb-1 h2 fw-bold">Catatan Pengeluaran</h1>
                            <p class="text-muted mb-0">Catat biaya iklan FB/TikTok, server, dan operasional harian beserta rekapnya.</p>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- 4 Kartu Rekap Pengeluaran -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 border-start border-4 border-danger">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold text-uppercase">Hari Ini</span>
                                <h4 class="fw-bolder mb-0 mt-1 text-danger">Rp {{ number_format($todayTotal, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold text-uppercase">Bulan Ini</span>
                                <h4 class="fw-bolder mb-0 mt-1 text-dark">Rp {{ number_format($monthTotal, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold text-uppercase">Total Biaya Iklan</span>
                                <h4 class="fw-bolder mb-0 mt-1 text-primary">Rp {{ number_format($adsTotal, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 border-start border-4 border-secondary">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold text-uppercase">Total Semua Waktu</span>
                                <h4 class="fw-bolder mb-0 mt-1 text-dark">Rp {{ number_format($allTimeTotal, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Tambah Pengeluaran Cepat -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fe fe-plus-circle text-primary me-2"></i>Catat Pengeluaran Baru</h5>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <form action="{{ route('admin.expenses.store') }}" method="POST">
                            @csrf
                            <div class="row g-3 align-items-end">
                                <div class="col-md-2 col-6">
                                    <label for="expense_date" class="form-label small fw-semibold">Tanggal</label>
                                    <input type="date" name="expense_date" id="expense_date" class="form-control"
                                           value="{{ old('expense_date', now()->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-3 col-6">
                                    <label for="expense_name" class="form-label small fw-semibold">Nama Pengeluaran</label>
                                    <input type="text" name="name" id="expense_name" class="form-control"
                                           placeholder="Contoh: Iklan FB" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-2 col-6">
                                    <label for="expense_category" class="form-label small fw-semibold">Kategori</label>
                                    <select name="category" id="expense_category" class="form-select" required>
                                        @foreach ($categories as $key => $label)
                                            <option value="{{ $key }}" @selected(old('category', 'iklan') === $key)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-6">
                                    <label for="expense_amount" class="form-label small fw-semibold">Nominal (Rp)</label>
                                    <input type="text" inputmode="numeric" name="amount" id="expense_amount" class="form-control"
                                           placeholder="100000" value="{{ old('amount') }}" required>
                                </div>
                                <div class="col-md-2 col-12">
                                    <label for="expense_notes" class="form-label small fw-semibold">Catatan (Opsional)</label>
                                    <input type="text" name="notes" id="expense_notes" class="form-control"
                                           placeholder="Keterangan..." value="{{ old('notes') }}">
                                </div>
                                <div class="col-md-1 col-12 d-grid">
                                    <button type="submit" class="btn btn-primary fw-bold">
                                        <i class="fe fe-save me-1 d-md-none"></i>Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Rekap Per Bulan -->
                @if ($monthlyRecap->isNotEmpty())
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-3">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
                                <span class="small fw-bold text-uppercase text-muted">Rekap Pengeluaran Per Bulan</span>
                                @if ($monthFilter !== '' || $categoryFilter !== '')
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1">
                                        Total Filter: Rp {{ number_format($filteredTotal, 0, ',', '.') }} ({{ $expenses->count() }} item)
                                    </span>
                                @endif
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($monthlyRecap as $rec)
                                    <a href="{{ route('admin.expenses.index', ['month' => $rec->ym, 'category' => $categoryFilter ?: null]) }}"
                                       class="btn btn-sm rounded-3 text-start border {{ $monthFilter === $rec->ym ? 'btn-primary text-white' : 'btn-light text-dark' }}">
                                        <div class="fw-bold" style="font-size: 0.78rem;">{{ $rec->label }}</div>
                                        <div style="font-size: 0.75rem;">
                                            Rp {{ number_format((int) $rec->total_amount, 0, ',', '.') }}
                                            <span class="opacity-75">({{ $rec->total_items }}x)</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Filter & Tabel Pengeluaran -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <h5 class="mb-0 fw-bold text-dark">Riwayat Pengeluaran</h5>
                        <form action="{{ route('admin.expenses.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2 mb-0">
                            <input type="month" name="month" class="form-control form-control-sm" style="width: auto;" value="{{ $monthFilter }}">
                            <select name="category" class="form-select form-select-sm" style="width: auto;">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $key => $label)
                                    <option value="{{ $key }}" @selected($categoryFilter === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                            @if ($monthFilter !== '' || $categoryFilter !== '')
                                <a href="{{ route('admin.expenses.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                            @endif
                        </form>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive p-3">
                            <table class="table table-bordered table-hover table-striped align-middle" id="expenses-table" style="width:100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Nama Pengeluaran</th>
                                        <th>Kategori</th>
                                        <th>Nominal</th>
                                        <th>Catatan</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expenses as $expense)
                                        <tr>
                                            <td></td>
                                            <td data-order="{{ $expense->expense_date->format('Y-m-d') }}" class="text-nowrap">
                                                {{ $expense->expense_date->format('d M Y') }}
                                            </td>
                                            <td class="fw-semibold">{{ $expense->name }}</td>
                                            <td>
                                                <span class="badge {{ $expense->category === 'iklan' ? 'bg-primary-subtle text-primary border border-primary-subtle' : ($expense->category === 'server' ? 'bg-info-subtle text-info border border-info-subtle' : 'bg-secondary-subtle text-secondary border border-secondary-subtle') }}">
                                                    {{ $expense->categoryLabel() }}
                                                </span>
                                            </td>
                                            <td data-order="{{ $expense->amount }}" class="fw-bold text-danger text-nowrap">
                                                Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                            </td>
                                            <td style="min-width: 180px; white-space: normal;">{{ $expense->notes ?: '-' }}</td>
                                            <td class="text-end">
                                                <div class="d-flex justify-content-end align-items-center gap-2 flex-nowrap">
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-primary btn-edit-expense"
                                                            data-action="{{ route('admin.expenses.update', $expense->id) }}"
                                                            data-date="{{ $expense->expense_date->format('Y-m-d') }}"
                                                            data-name="{{ $expense->name }}"
                                                            data-category="{{ $expense->category }}"
                                                            data-amount="{{ $expense->amount }}"
                                                            data-notes="{{ $expense->notes ?? '' }}">
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" class="delete-expense-form mb-0">
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

    <!-- Modal Edit Pengeluaran -->
    <div class="modal fade" id="editExpenseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editExpenseForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Edit Pengeluaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_expense_date" class="form-label fw-semibold small">Tanggal</label>
                            <input type="date" name="expense_date" id="edit_expense_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_expense_name" class="form-label fw-semibold small">Nama Pengeluaran</label>
                            <input type="text" name="name" id="edit_expense_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_expense_category" class="form-label fw-semibold small">Kategori</label>
                            <select name="category" id="edit_expense_category" class="form-select" required>
                                @foreach ($categories as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_expense_amount" class="form-label fw-semibold small">Nominal (Rp)</label>
                            <input type="text" inputmode="numeric" name="amount" id="edit_expense_amount" class="form-control" required>
                        </div>
                        <div class="mb-0">
                            <label for="edit_expense_notes" class="form-label fw-semibold small">Catatan (Opsional)</label>
                            <textarea name="notes" id="edit_expense_notes" rows="2" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('partials.scripts')
    <script src="/build/assets/plugins/datatables.net/js/dataTables.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.jQuery && $.fn.DataTable) {
                const table = $('#expenses-table').DataTable({
                    responsive: false,
                    scrollX: true,
                    autoWidth: false,
                    pageLength: 10,
                    columnDefs: [
                        { orderable: false, targets: [0, 6] },
                        { searchable: false, targets: [0, 6] }
                    ],
                    order: [[1, 'desc']],
                    language: {
                        search: 'Cari:',
                        lengthMenu: 'Tampilkan _MENU_ baris',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ pengeluaran',
                        infoEmpty: 'Menampilkan 0 sampai 0 dari 0 pengeluaran',
                        emptyTable: 'Belum ada catatan pengeluaran.',
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

            const editModalEl = document.getElementById('editExpenseModal');
            const editModal = editModalEl && window.bootstrap ? new bootstrap.Modal(editModalEl) : null;
            const editForm = document.getElementById('editExpenseForm');

            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.btn-edit-expense');
                if (!btn || !editForm) return;
                editForm.action = btn.dataset.action || '';
                document.getElementById('edit_expense_date').value = btn.dataset.date || '';
                document.getElementById('edit_expense_name').value = btn.dataset.name || '';
                document.getElementById('edit_expense_category').value = btn.dataset.category || 'iklan';
                document.getElementById('edit_expense_amount').value = btn.dataset.amount || '';
                document.getElementById('edit_expense_notes').value = btn.dataset.notes || '';
                if (editModal) editModal.show();
            });

            document.addEventListener('submit', function (e) {
                const delForm = e.target.closest('.delete-expense-form');
                if (!delForm) return;
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Pengeluaran',
                    text: 'Catatan pengeluaran ini akan dihapus permanen.',
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
