<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Student Dashboard | Geeks - Bootstrap 5 Template</title>
</head>

<body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')

    <div class="db-content">
        <div class="container mb-4">
            <div class="row mb-5">
                <div class="col-12">
                    <h1 class="h2 mb-0">Riwayat Pembayaran</h1>
                    <p class="text-muted">Daftar transaksi dan status aktivasi paket tryout kamu.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="table-responsive">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <table class="table text-nowrap mb-0 table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Order ID</th>
                                        <th>Paket</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $trx)
                                        <tr>
                                            <td class="align-middle">
                                                {{ $trx->created_at->format('d M Y, H:i') }}
                                            </td>
                                            <td class="align-middle">{{ $trx->order_id }}</td>
                                            <td class="align-middle">
                                                <h5 class="mb-0 text-dark">{{ $trx->tryout->title ?? 'Paket Tryout' }}
                                                </h5>
                                            </td>
                                            <td class="align-middle">
                                                Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                            </td>
                                            <td class="align-middle">
                                                @if ($trx->status == 'pending')
                                                    <span class="badge bg-warning-soft text-warning">
                                                        <i class="fe fe-clock me-1"></i> PENDING
                                                    </span>
                                                @elseif($trx->status == 'success')
                                                    <span class="badge bg-success-soft text-success">
                                                        <i class="fe fe-check-circle me-1"></i> SUCCESS
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-soft text-danger">FAILED</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-end">
                                                @if ($trx->status == 'pending')
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('payment.pending') }}"
                                                            class="btn btn-sm btn-primary me-2">
                                                            <i class="fe fe-credit-card"></i> Bayar
                                                        </a>
                                                    </div>
                                                @elseif($trx->status == 'success')
                                                    <a href="{{ route('invoice', $trx->order_id) }}"
                                                        class="btn btn-sm btn-outline-secondary me-1" target="_blank">
                                                        <i class="fe fe-file-text"></i> Invoice
                                                    </a>
                                                    {{-- <a href="{{ route('ujian.persiapan', $trx->tryout_id) }}"
                                                        class="btn btn-sm btn-success">
                                                        <i class="fe fe-play-circle"></i> Mulai Ujian
                                                    </a> --}}
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll top -->
    @include('partials.btn-scroll-top')
    <!-- Scripts -->
    @include('partials.scripts')
    <script src="assets/js/vendors/tnsSlider.js"></script>
    <script src="assets/js/vendors/chart.js"></script>
    <script src="assets/js/vendors/navbar-nav.js"></script>
</body>

</html>
