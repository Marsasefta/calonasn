<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
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
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
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
                                        <tr>
                                            <td>{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}
                                            </td>
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
                                                <span
                                                    class="badge bg-{{ $transaction->status === 'success' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                            </td>
                                            {{-- <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>                                             --}}
                                            <td class="text-end">
                                                @if ($transaction->status === 'pending')
                                                    <form
                                                        action="{{ route('admin.transactions.update-status', $transaction->id) }}"
                                                        method="POST"
                                                        class="confirm-payment-form d-flex justify-content-end align-items-center gap-2 mb-0">
                                                        @csrf
                                                        <input type="hidden" name="status" value="success">
                                                        <button type="submit"
                                                            class="btn btn-sm btn-primary">Konfirmasi</button>
                                                    </form>
                                                @elseif($transaction->status === 'success')
                                                    <span class="badge bg-success"><i
                                                            class="fas fa-check-circle me-1"></i> Selesai</span>
                                                @endif
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

                <div class="mt-3">
                    {{ $transactions->links() }}
                </div>
            </section>
        </main>
    </div>

    @include('partials.scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</body>

</html>