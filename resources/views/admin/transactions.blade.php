<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <link href="/build/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="/build/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
    <style>
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
        .tx-nav-tabs .nav-link {
            font-weight: 600;
            color: #475569;
        }
        .tx-nav-tabs .nav-link.active {
            color: #1d4ed8;
            border-bottom: 2px solid #1d4ed8;
        }
        [data-bs-theme="dark"] .tx-nav-tabs .nav-link {
            color: #94a3b8;
        }
        [data-bs-theme="dark"] .tx-nav-tabs .nav-link.active {
            color: #60a5fa;
            border-bottom-color: #60a5fa;
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
                            <p class="text-muted mb-0">Dipisah antara transaksi berbukti/selesai dan pesanan yang belum upload bukti agar mudah follow-up WA.</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('admin.whatsapp-blast.index') }}" class="btn btn-outline-success btn-sm fw-semibold">
                                <i class="bi bi-whatsapp me-1"></i> Blast WA Massal
                            </a>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Tab Pemisah: Transaksi & Verifikasi vs Belum Upload Bukti -->
                <ul class="nav nav-tabs tx-nav-tabs mb-3" id="txTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active d-flex align-items-center gap-2" id="tab-verified-btn"
                                data-bs-toggle="tab" data-bs-target="#tab-verified" type="button" role="tab">
                            <span>Transaksi &amp; Verifikasi</span>
                            <span class="badge bg-primary rounded-pill">{{ $verifiedOrCompletedTransactions->count() }}</span>
                            @if ($needVerifyCount > 0)
                                <span class="badge bg-info text-dark rounded-pill">{{ $needVerifyCount }} Cek Bukti</span>
                            @endif
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center gap-2" id="tab-unpaid-btn"
                                data-bs-toggle="tab" data-bs-target="#tab-unpaid" type="button" role="tab">
                            <span>Belum Upload Bukti</span>
                            <span class="badge bg-warning text-dark rounded-pill">{{ $unpaidNoProofTransactions->count() }}</span>
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="txTabsContent">
                    <!-- TAB 1: TRANSAKSI SUDAH UPLOAD BUKTI & SELESAI -->
                    <div class="tab-pane fade show active" id="tab-verified" role="tabpanel">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive p-3">
                                    <table class="table table-bordered table-hover table-striped align-middle" id="transactions-table" style="width:100%;">
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
                                            @foreach($verifiedOrCompletedTransactions as $transaction)
                                                @php
                                                    $isPending = in_array($transaction->status, ['pending', 'verifying'], true);
                                                    $invoiceLabel = $transaction->invoice_number ?? $transaction->order_id ?? ('#TRX-' . $transaction->id);
                                                @endphp
                                                <tr>
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
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-info text-nowrap js-preview-proof"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#proofPreviewModal"
                                                                data-proof-url="{{ asset('storage/' . $transaction->payment_proof) }}"
                                                                data-invoice="{{ $invoiceLabel }}"
                                                                data-user="{{ $transaction->user->name ?? '-' }}"
                                                                data-amount="Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}">
                                                                <i class="fe fe-image me-1"></i> Lihat Bukti
                                                            </button>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($transaction->status === 'success')
                                                            <span class="badge bg-success">Success</span>
                                                        @elseif ($isPending)
                                                            <span class="badge bg-info text-dark">Cek Bukti</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ ucfirst($transaction->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td data-order="{{ $transaction->created_at->timestamp }}">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                                    <td class="text-end">
                                                        <div class="d-flex justify-content-end align-items-center gap-2 flex-nowrap">
                                                            @if ($isPending)
                                                                <form action="{{ route('admin.transactions.update-status', $transaction->id) }}"
                                                                      method="POST" class="confirm-payment-form mb-0">
                                                                    @csrf
                                                                    <input type="hidden" name="status" value="success">
                                                                    <button type="submit" class="btn btn-sm btn-primary text-nowrap">Konfirmasi</button>
                                                                </form>
                                                            @elseif($transaction->status === 'success')
                                                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Selesai</span>
                                                            @endif

                                                            <form action="{{ route('admin.transactions.destroy', $transaction->id) }}"
                                                                  method="POST" class="delete-transaction-form mb-0">
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
                    </div>

                    <!-- TAB 2: KHUSUS BELUM UPLOAD BUKTI (FOLLOW-UP WA) -->
                    <div class="tab-pane fade" id="tab-unpaid" role="tabpanel">
                        <div class="alert alert-warning border-0 shadow-xs mb-3 py-2.5 small">
                            <i class="bi bi-info-circle-fill me-1"></i>
                            Daftar di bawah ini adalah pesanan <strong>pending yang belum upload bukti transfer</strong>. Klik tombol hijau <strong>WA</strong> untuk follow-up langsung dari HP.
                        </div>
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive p-3">
                                    <table class="table table-bordered table-hover table-striped align-middle" id="unpaid-transactions-table" style="width:100%;">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Peserta</th>
                                                <th>Follow-Up WA</th>
                                                <th>Tryout</th>
                                                <th>Jumlah</th>
                                                <th>Invoice</th>
                                                <th>Tanggal</th>
                                                <th class="text-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($unpaidNoProofTransactions as $transaction)
                                                @php
                                                    $invoiceLabel = $transaction->invoice_number ?? $transaction->order_id ?? ('#TRX-' . $transaction->id);
                                                @endphp
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <div class="fw-semibold">{{ $transaction->user->name ?? '-' }}</div>
                                                        <div class="small text-muted">{{ $transaction->user->phone ?? 'Tanpa No. HP' }}</div>
                                                    </td>
                                                    <td>
                                                        @if (!empty($transaction->wa_url))
                                                            <a href="{{ $transaction->wa_url }}"
                                                               target="_blank" rel="noopener noreferrer"
                                                               class="btn btn-sm btn-wa-followup fw-semibold text-nowrap">
                                                                <i class="bi bi-whatsapp me-1"></i> Chat WA
                                                            </a>
                                                        @else
                                                            <button type="button" class="btn btn-sm btn-outline-secondary text-nowrap" disabled>
                                                                <i class="bi bi-whatsapp me-1"></i> No. WA Kosong
                                                            </button>
                                                        @endif
                                                    </td>
                                                    <td>{{ $transaction->tryout->title ?? '-' }}</td>
                                                    <td class="fw-semibold text-primary">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                                    <td class="font-monospace small">{{ $invoiceLabel }}</td>
                                                    <td data-order="{{ $transaction->created_at->timestamp }}">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                                    <td class="text-end">
                                                        <div class="d-flex justify-content-end align-items-center gap-2 flex-nowrap">
                                                            <form action="{{ route('admin.transactions.update-status', $transaction->id) }}"
                                                                  method="POST" class="confirm-payment-form mb-0">
                                                                @csrf
                                                                <input type="hidden" name="status" value="success">
                                                                <button type="submit" class="btn btn-sm btn-primary text-nowrap">Konfirmasi</button>
                                                            </form>

                                                            <form action="{{ route('admin.transactions.destroy', $transaction->id) }}"
                                                                  method="POST" class="delete-transaction-form mb-0">
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
                    </div>
                </div>

            </section>
        </main>
    </div>

    <!-- Modal Pratinjau Bukti Transfer -->
    <div class="modal fade" id="proofPreviewModal" tabindex="-1" aria-labelledby="proofPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-bottom">
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="proofPreviewModalLabel">Bukti Transfer Peserta</h5>
                        <div class="small text-muted" id="proofModalMeta">-</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-3 p-md-4 text-center">
                    <div id="proofModalLoading" class="py-4 text-muted small">
                        <div class="spinner-border spinner-border-sm text-primary me-1" role="status"></div>
                        Memuat gambar bukti transfer...
                    </div>
                    <img id="proofModalImg" src="" alt="Bukti Transfer" class="img-fluid rounded-3 border shadow-sm d-none" style="max-height: 70vh; object-fit: contain;">
                    <div id="proofModalError" class="alert alert-warning border-0 rounded-3 small mb-0 d-none">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        Gambar bukti transfer gagal dimuat atau file rusak/tidak lengkap. Silakan hubungi peserta melalui WhatsApp untuk kirim ulang.
                    </div>
                </div>
                <div class="modal-footer border-top justify-content-between">
                    <a id="proofModalOpenTab" href="#" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        <i class="fe fe-external-link me-1"></i> Buka di Tab Baru
                    </a>
                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const dtLang = {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ baris',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ transaksi',
                infoEmpty: 'Menampilkan 0 sampai 0 dari 0 transaksi',
                infoFiltered: '(disaring dari _MAX_ total transaksi)',
                emptyTable: 'Tidak ada data pada kategori ini.',
                zeroRecords: 'Tidak ditemukan data yang sesuai',
                paginate: {
                    previous: 'Sebelumnya',
                    next: 'Berikutnya'
                }
            };

            function initTxTable(selector, dateColIdx, nonOrderTargets) {
                if (!(window.jQuery && $.fn.DataTable)) return null;
                var tbl = $(selector).DataTable({
                    responsive: false,
                    scrollX: true,
                    autoWidth: false,
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                    columnDefs: [
                        { orderable: false, targets: nonOrderTargets },
                        { searchable: false, targets: nonOrderTargets }
                    ],
                    order: [[dateColIdx, 'desc']],
                    language: dtLang
                });

                tbl.on('order.dt search.dt', function() {
                    let i = 1;
                    tbl.cells(null, 0, { search: 'applied', order: 'applied' }).every(function() {
                        this.data(i++);
                    });
                }).draw(false);

                return tbl;
            }

            var verifiedTable = initTxTable('#transactions-table', 7, [0, 5, 6, 8]);
            var unpaidTable = initTxTable('#unpaid-transactions-table', 6, [0, 2, 7]);

            document.querySelectorAll('#txTabs button[data-bs-toggle="tab"]').forEach(function(tabBtn) {
                tabBtn.addEventListener('shown.bs.tab', function() {
                    if (verifiedTable) verifiedTable.columns.adjust();
                    if (unpaidTable) unpaidTable.columns.adjust();
                });
            });

            document.addEventListener('click', function(event) {
                const previewBtn = event.target.closest('.js-preview-proof');
                if (!previewBtn) return;

                const url = previewBtn.getAttribute('data-proof-url') || '';
                const invoice = previewBtn.getAttribute('data-invoice') || '-';
                const user = previewBtn.getAttribute('data-user') || '-';
                const amount = previewBtn.getAttribute('data-amount') || '-';

                const metaEl = document.getElementById('proofModalMeta');
                const imgEl = document.getElementById('proofModalImg');
                const loadingEl = document.getElementById('proofModalLoading');
                const errorEl = document.getElementById('proofModalError');
                const openTabEl = document.getElementById('proofModalOpenTab');

                if (metaEl) metaEl.textContent = `${user} • ${invoice} • ${amount}`;
                if (openTabEl) openTabEl.setAttribute('href', url);

                if (loadingEl) loadingEl.classList.remove('d-none');
                if (errorEl) errorEl.classList.add('d-none');
                if (imgEl) {
                    imgEl.classList.add('d-none');
                    imgEl.onload = function() {
                        if (loadingEl) loadingEl.classList.add('d-none');
                        imgEl.classList.remove('d-none');
                    };
                    imgEl.onerror = function() {
                        if (loadingEl) loadingEl.classList.add('d-none');
                        if (errorEl) errorEl.classList.remove('d-none');
                    };
                    imgEl.src = url;
                }
            });

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
