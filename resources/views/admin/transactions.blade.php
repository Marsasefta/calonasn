<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <link href="/build/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="/build/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
    <style>
        .tx-filter-pill.active {
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        .btn-wa-followup {
            background-color: #16a34a !important;
            border-color: #16a34a !important;
            color: #ffffff !important;
        }
        .btn-wa-followup:hover {
            background-color: #15803d !important;
            border-color: #15803d !important;
            color: #ffffff !important;
        }
    </style>
</head>

<body>
    <div id="db-wrapper">
        @include('partials.navbar-vertical')

        <main id="page-content">
            @include('partials.dashboard-header')

            <section class="container-fluid p-3 p-md-4">
                <div class="row mb-3">
                    <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h1 class="mb-1 h2 fw-bold">Transaksi &amp; Pembayaran</h1>
                            <p class="text-muted mb-0">Kelola invoice masuk, follow-up WhatsApp pending, dan validasi pembayaran.</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('admin.whatsapp-blast.index') }}" class="btn btn-outline-success btn-sm fw-semibold">
                                <i class="bi bi-whatsapp me-1"></i> Blast WA Massal
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Status Cepat (Berguna di HP & Desktop) -->
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold tx-filter-pill active" data-filter="all">
                        Semua ({{ $transactions->count() }})
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-warning text-dark rounded-pill px-3 fw-semibold tx-filter-pill" data-filter="pending">
                        <i class="bi bi-clock-history me-1"></i> Pending ({{ $pendingCount ?? 0 }})
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold tx-filter-pill" data-filter="success">
                        <i class="bi bi-check-circle me-1"></i> Success ({{ $successCount ?? 0 }})
                    </button>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- TAMPILAN MOBILE (Tanpa Scroll Horizontal, Tombol WA Langsung Terlihat) -->
                <div class="d-md-none d-flex flex-column gap-3 mb-4" id="mobileTxList">
                    @forelse($transactions as $transaction)
                        @php
                            $isPending = in_array($transaction->status, ['pending', 'verifying'], true);
                            $invoiceLabel = $transaction->invoice_number ?? $transaction->order_id ?? ('#TRX-' . $transaction->id);
                        @endphp
                        <div class="card border-0 shadow-sm rounded-3 mobile-tx-card" data-status="{{ $transaction->status }}">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <div class="min-w-0">
                                        <div class="fw-bold text-dark text-truncate">{{ $transaction->user->name ?? '-' }}</div>
                                        <div class="small text-muted font-monospace">{{ $invoiceLabel }}</div>
                                    </div>
                                    <span class="badge bg-{{ $transaction->status === 'success' ? 'success' : ($isPending ? 'warning text-dark' : 'danger') }} rounded-pill flex-shrink-0">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </div>

                                <div class="small text-muted mb-1">{{ $transaction->tryout->title ?? '-' }}</div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bolder fs-5 text-primary">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                    <span class="small text-muted">{{ $transaction->created_at->format('d M Y H:i') }}</span>
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    @if ($isPending)
                                        @if (!empty($transaction->wa_url))
                                            <a href="{{ $transaction->wa_url }}" target="_blank" rel="noopener noreferrer"
                                               class="btn btn-sm btn-wa-followup fw-bold flex-grow-1">
                                                <i class="bi bi-whatsapp me-1"></i> Chat WA ({{ $transaction->user->phone }})
                                            </a>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-secondary flex-grow-1" disabled>
                                                <i class="bi bi-whatsapp me-1"></i> No. WA Kosong
                                            </button>
                                        @endif
                                    @endif

                                    @if (!empty($transaction->payment_proof))
                                        <a href="{{ asset('storage/' . $transaction->payment_proof) }}" target="_blank"
                                           class="btn btn-sm btn-outline-info">
                                            <i class="fe fe-image me-1"></i> Bukti
                                        </a>
                                    @endif

                                    @if ($isPending)
                                        <form action="{{ route('admin.transactions.update-status', $transaction->id) }}"
                                              method="POST" class="confirm-payment-form mb-0 flex-grow-1">
                                            @csrf
                                            <input type="hidden" name="status" value="success">
                                            <button type="submit" class="btn btn-sm btn-primary w-100 fw-semibold">
                                                <i class="fe fe-check me-1"></i> Konfirmasi
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.transactions.destroy', $transaction->id) }}"
                                          method="POST" class="delete-transaction-form mb-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fe fe-trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card border-0 shadow-sm p-4 text-center text-muted">
                            Belum ada transaksi.
                        </div>
                    @endforelse
                </div>

                <!-- TAMPILAN DESKTOP (DataTable) -->
                <div class="card d-none d-md-block">
                    <div class="card-body p-0">
                        <div class="table-responsive p-3">
                            <table class="table table-bordered table-hover table-striped align-middle" id="transactions-table"
                                style="width:100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice</th>
                                        <th>Peserta</th>
                                        <th>Tryout</th>
                                        <th>Jumlah</th>
                                        <th>Bukti Bayar</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $transaction)
                                        @php
                                            $isPending = in_array($transaction->status, ['pending', 'verifying'], true);
                                            $invoiceLabel = $transaction->invoice_number ?? $transaction->order_id ?? ('#TRX-' . $transaction->id);
                                        @endphp
                                        <tr data-status="{{ $transaction->status }}">
                                            <td></td>
                                            <td class="font-monospace small">{{ $invoiceLabel }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ $transaction->user->name ?? '-' }}</div>
                                                @if (!empty($transaction->user->phone))
                                                    <div class="small text-muted">{{ $transaction->user->phone }}</div>
                                                @endif
                                            </td>
                                            <td>{{ $transaction->tryout->title ?? '-' }}</td>
                                            <td class="fw-semibold">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                            <td>
                                                @if (!empty($transaction->payment_proof))
                                                    <a href="{{ asset('storage/' . $transaction->payment_proof) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-info">
                                                        Lihat Bukti
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $transaction->status === 'success' ? 'success' : ($isPending ? 'warning text-dark' : 'danger') }}">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                            </td>
                                            <td data-order="{{ $transaction->created_at->timestamp }}">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                            <td class="text-end">
                                                <div class="d-flex justify-content-end align-items-center gap-2 flex-nowrap">
                                                    @if ($isPending)
                                                        @if (!empty($transaction->wa_url))
                                                            <a href="{{ $transaction->wa_url }}"
                                                                target="_blank" rel="noopener noreferrer"
                                                                class="btn btn-sm btn-wa-followup fw-semibold text-nowrap"
                                                                title="Follow-up via WhatsApp">
                                                                <i class="bi bi-whatsapp me-1"></i> WA
                                                            </a>
                                                        @else
                                                            <button type="button" class="btn btn-sm btn-outline-secondary text-nowrap" disabled title="Peserta belum mengisi nomor HP">
                                                                <i class="bi bi-whatsapp me-1"></i> -
                                                            </button>
                                                        @endif

                                                        <form
                                                            action="{{ route('admin.transactions.update-status', $transaction->id) }}"
                                                            method="POST" class="confirm-payment-form mb-0">
                                                            @csrf
                                                            <input type="hidden" name="status" value="success">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-primary text-nowrap">Konfirmasi</button>
                                                        </form>
                                                    @elseif($transaction->status === 'success')
                                                        <span class="badge bg-success"><i
                                                                class="fas fa-check-circle me-1"></i> Selesai</span>
                                                    @endif

                                                    <form
                                                        action="{{ route('admin.transactions.destroy', $transaction->id) }}"
                                                        method="POST" class="delete-transaction-form mb-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fe fe-inbox fs-3 mb-2 d-block"></i>
                                                    Belum ada transaksi.
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
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
        document.addEventListener('DOMContentLoaded', function() {
            var activeFilter = 'all';
            var table = null;

            if (window.jQuery && $.fn.DataTable) {
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    if (settings.nTable.id !== 'transactions-table' || activeFilter === 'all') {
                        return true;
                    }
                    var rowNode = table ? table.row(dataIndex).node() : null;
                    var rowStatus = rowNode ? rowNode.getAttribute('data-status') : '';
                    if (activeFilter === 'pending') {
                        return rowStatus === 'pending' || rowStatus === 'verifying';
                    }
                    return rowStatus === activeFilter;
                });

                table = $('#transactions-table').DataTable({
                    responsive: false,
                    scrollX: true,
                    autoWidth: false,
                    pageLength: 10,
                    lengthMenu: [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    columnDefs: [{
                            orderable: false,
                            targets: [0, 5, 6, 8]
                        },
                        {
                            searchable: false,
                            targets: [0, 5, 6, 8]
                        }
                    ],
                    order: [
                        [7, 'desc']
                    ],
                    language: {
                        search: 'Cari:',
                        lengthMenu: 'Tampilkan _MENU_ baris',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ transaksi',
                        infoEmpty: 'Menampilkan 0 sampai 0 dari 0 transaksi',
                        infoFiltered: '(disaring dari _MAX_ total transaksi)',
                        zeroRecords: 'Tidak ditemukan data yang sesuai',
                        paginate: {
                            previous: 'Sebelumnya',
                            next: 'Berikutnya'
                        }
                    }
                });

                table.on('order.dt search.dt', function() {
                    let i = 1;
                    table.cells(null, 0, {
                        search: 'applied',
                        order: 'applied'
                    }).every(function(cell) {
                        this.data(i++);
                    });
                }).draw(false);
            }

            // Filter cepat untuk mobile cards & desktop table
            document.querySelectorAll('.tx-filter-pill').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    activeFilter = btn.getAttribute('data-filter') || 'all';

                    document.querySelectorAll('.tx-filter-pill').forEach(function(p) {
                        p.classList.remove('active', 'btn-primary');
                        if (p.dataset.filter === 'pending') {
                            p.classList.add('btn-outline-warning', 'text-dark');
                        } else if (p.dataset.filter === 'success') {
                            p.classList.add('btn-outline-success');
                        } else {
                            p.classList.add('btn-outline-primary');
                        }
                    });

                    btn.classList.remove('btn-outline-primary', 'btn-outline-warning', 'btn-outline-success', 'text-dark');
                    btn.classList.add('btn-primary', 'active');

                    document.querySelectorAll('.mobile-tx-card').forEach(function(card) {
                        var st = card.getAttribute('data-status') || '';
                        var match = activeFilter === 'all'
                            || (activeFilter === 'pending' && (st === 'pending' || st === 'verifying'))
                            || st === activeFilter;
                        card.style.display = match ? '' : 'none';
                    });

                    if (table) {
                        table.draw();
                    }
                });
            });

            // Delegated SweetAlert2 handlers (bekerja untuk mobile cards & semua halaman DataTables)
            document.addEventListener('submit', function(event) {
                const confirmForm = event.target.closest('.confirm-payment-form');
                if (confirmForm) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi Pembayaran',
                        text: 'Apakah pembayaran ini sudah sesuai?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, sesuai',
                        cancelButtonText: 'Batal',
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            confirmForm.submit();
                        }
                    });
                    return;
                }

                const deleteForm = event.target.closest('.delete-transaction-form');
                if (deleteForm) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Hapus Transaksi',
                        text: 'Apakah Anda yakin ingin menghapus transaksi ini? Tindakan ini tidak dapat dikembalikan.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            deleteForm.submit();
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
