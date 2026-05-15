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

            @if(session('success'))
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
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td>{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}</td>
                                        <td>{{ $transaction->order_id }}</td>
                                        <td>{{ $transaction->user->name ?? '-' }}</td>
                                        <td>{{ $transaction->tryout->title ?? '-' }}</td>
                                        <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $transaction->status === 'settlement' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('admin.transactions.update-status', $transaction->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <select name="status" class="form-select form-select-sm d-inline w-auto me-2">
                                                    <option value="pending" @selected($transaction->status === 'pending')>Pending</option>
                                                    <option value="settlement" @selected($transaction->status === 'settlement')>Lunas</option>
                                                    <option value="failed" @selected($transaction->status === 'failed')>Gagal</option>
                                                    <option value="expired" @selected($transaction->status === 'expired')>Expired</option>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
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
</body>
</html>
