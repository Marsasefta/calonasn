<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <link href="/build/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="/build/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
</head>

<body>
    <div id="db-wrapper">
        @include('partials.navbar-vertical')

        <main id="page-content">
            @include('partials.dashboard-header')

            <section class="container-fluid p-4">
                <div class="row mb-4">
                    <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                        <div>
                            <h1 class="mb-1 h2 fw-bold">Transaksi & Pembayaran</h1>
                            <p class="text-muted mb-0">Kelola invoice masuk dan validasi pembayaran manual pengguna.</p>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive p-3"> 
                            <table class="table table-bordered table-hover table-striped" id="transactions-table" style="width:100%;">
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
                                            $user = $transaction->user;
                                            $phoneClean = $user?->phone ? ltrim($user->phone, "'") : null;
                                            $phoneClean = $phoneClean ? preg_replace('/\D+/', '', $phoneClean) : null;

                                            if ($phoneClean && substr($phoneClean, 0, 1) === '0') {
                                                $phoneClean = '62' . substr($phoneClean, 1);
                                            } elseif ($phoneClean && substr($phoneClean, 0, 1) === '8') {
                                                $phoneClean = '62' . $phoneClean;
                                            }

                                            $hasWhatsappNumber = $phoneClean && strlen($phoneClean) >= 10;
                                            $namaUser = $user?->name ?? 'Kak';
                                            $linkBayar = $transaction->invoice_number
                                                ? route('payment.qris', $transaction->invoice_number)
                                                : url('/payment-pending');

                                            $pesanWA = "*Kak {$namaUser}, Admin Tambahkan Voucher Rp9.000 untuk Pesanan Kakak!*\n\n"
                                                . "Halo Kak,\n"
                                                . "Pesanan Kakak di *CalonASN.id* masih tersimpan dan belum diselesaikan.\n\n"
                                                . "Agar lebih hemat, Admin memberikan voucher khusus:\n"
                                                . "*DISKON9000*\n\n"
                                                . "Potongan langsung Rp9.000 untuk paket yang Kakak pilih.\n"
                                                . "Berlaku sampai 23.59 WIB malam ini.\n"
                                                . "Setelah itu voucher akan otomatis berakhir dan tidak dapat digunakan kembali.\n\n"
                                                . "Lanjutkan pembayaran:\n"
                                                . "{$linkBayar}\n\n"
                                                . "Jangan sampai voucher Rp9.000 ini hangus ya, Kak. 😊";

                                            $linkWaMe = $hasWhatsappNumber
                                                ? 'https://wa.me/' . $phoneClean . '?text=' . urlencode($pesanWA)
                                                : null;
                                        @endphp
                                        <tr>
                                            <td></td>
                                            <td>{{ $transaction->order_id }}</td>
                                            <td>{{ $transaction->user->name ?? '-' }}</td>
                                            <td>{{ $transaction->tryout->title ?? '-' }}</td>
                                            <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
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
                                                <span class="badge bg-{{ $transaction->status === 'success' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                            <td class="text-end">
                                                <div class="d-flex justify-content-end align-items-center gap-2">
                                                    @if ($transaction->status === 'pending')
                                                        @if ($linkWaMe)
                                                            <a href="{{ $linkWaMe }}"
                                                                target="_blank"
                                                                rel="noopener"
                                                                class="btn btn-sm btn-success text-white"
                                                                style="background-color: #25D366; border-color: #25D366;"
                                                                title="Follow up via WhatsApp">
                                                                <i class="fe fe-message-circle me-1"></i> Follow Up WA
                                                            </a>
                                                        @endif
                                                        <form action="{{ route('admin.transactions.update-status', $transaction->id) }}"
                                                            method="POST" class="confirm-payment-form mb-0">
                                                            @csrf
                                                            <input type="hidden" name="status" value="success">
                                                            <button type="submit" class="btn btn-sm btn-primary">Konfirmasi</button>
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
            if (window.jQuery && $.fn.DataTable) {
                
                // Inisialisasi DataTables
                var table = $('#transactions-table').DataTable({
                    responsive: false,
                    scrollX: true,
                    autoWidth: false,
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                    columnDefs: [
                        { orderable: false, targets: [0, 5, 6, 8] }, // Kolom #, Bukti, Status, Aksi tidak bisa di-sort
                        { searchable: false, targets: [0, 5, 6, 8] }
                    ],
                    // MEMAKSA URUTAN: Kolom indeks ke-7 (Tanggal) diurutkan secara DESCENDING (terbaru di atas)
                    order: [[7, 'desc']], 
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

                // Menghitung nomor urut secara dinamis tanpa merusak susunan sorting tanggal terbaru
                table.on('order.dt search.dt', function () {
                    let i = 1;
                    table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                        this.data(i++);
                    });
                }).draw(false); // Perubahan di sini: menggunakan 'false' agar default order [[7, 'desc']] di atas tidak tertimpa
            }

            // Handler SweetAlert2 untuk Konfirmasi Pembayaran
            document.querySelectorAll('.confirm-payment-form').forEach(function(form) {
                form.addEventListener('submit', function(event) {
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
                            form.submit();
                        }
                    });
                });
            });

            // Handler SweetAlert2 untuk Hapus Transaksi
            document.querySelectorAll('.delete-transaction-form').forEach(function(form) {
                form.addEventListener('submit', function(event) {
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
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>
