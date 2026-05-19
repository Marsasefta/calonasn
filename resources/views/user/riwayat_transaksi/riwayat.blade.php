<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Riwayat Transaksi</title>
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
                                <div class="alert alert-success alert-dismissible fade show m-3 border-0 shadow-sm"
                                    role="alert">
                                    <i class="fe fe-check-circle me-2"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show m-3 border-0 shadow-sm"
                                    role="alert">
                                    <i class="fe fe-x-circle me-2"></i> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <table class="table text-nowrap mb-0 table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>No. Invoice</th>
                                        <th>Paket</th>
                                        <th>Total Tagihan</th>
                                        <th>Status</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $trx)
                                        @php
                                            // Bersihkan status dari spasi dan paksa jadi huruf kecil semua
                                            $statusClean = strtolower(trim($trx->status));
                                        @endphp
                                        <tr>
                                            <td class="align-middle">
                                                {{ $trx->created_at->format('d M Y, H:i') }}
                                            </td>
                                            <td class="align-middle fw-medium text-dark">
                                                {{ $trx->invoice_number ?? $trx->order_id }}
                                            </td>
                                            <td class="align-middle">
                                                <h5 class="mb-0 text-dark">{{ $trx->tryout->title ?? 'Paket Tryout' }}</h5>
                                            </td>
                                            <td class="align-middle fw-bold text-dark">
                                                Rp {{ number_format($trx->total_amount ?? $trx->amount, 0, ',', '.') }}
                                            </td>

                                            {{-- SEKARANG SUDAH MENGGUNAKAN @elseif YANG BENAR --}}
                                            <td class="align-middle">
                                                @if ($statusClean == 'pending' && empty($trx->payment_proof))
                                                    <span class="badge bg-warning-soft text-warning px-2 py-1">
                                                        <i class="fe fe-clock me-1"></i> BELUM BAYAR
                                                    </span>
                                                @elseif ($statusClean == 'pending' && !empty($trx->payment_proof))
                                                    <span class="badge bg-info-soft text-info px-2 py-1">
                                                        <i class="fe fe-refresh-cw me-1 align-middle"></i> MENUNGGU VERIFIKASI
                                                    </span>
                                                @elseif (in_array($statusClean, ['success', 'paid']))
                                                    <span class="badge bg-success-soft text-success px-2 py-1">
                                                        <i class="fe fe-check-circle me-1"></i> SUKSES
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-soft text-danger px-2 py-1">
                                                        <i class="fe fe-x-circle me-1"></i> GAGAL ({{ $trx->status }})
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- KOLOM AKSI JUGA SUDAH DIPERBAIKI MENJADI @elseif --}}
                                            <td class="align-middle text-end">
                                                @if ($statusClean == 'pending' && empty($trx->payment_proof))
                                                    <a href="{{ route('payment.qris', $trx->invoice_number) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fe fe-credit-card me-1"></i> Bayar Sekarang
                                                    </a>
                                                @elseif ($statusClean == 'pending' && !empty($trx->payment_proof))
                                                    <a href="{{ route('payment.qris', $trx->invoice_number) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="fe fe-eye me-1"></i> Cek Bukti
                                                    </a>
                                                @elseif (in_array($statusClean, ['success', 'paid']))
                                                    <a href="{{ route('invoice', $trx->invoice_number ?? $trx->order_id) }}"
                                                        class="btn btn-sm btn-outline-secondary" target="_blank">
                                                        <i class="fe fe-file-text me-1"></i> Invoice
                                                    </a>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fe fe-shopping-bag fs-1 d-block mb-2"></i>
                                                Belum ada riwayat transaksi pembayaran.
                                            </td>
                                        </tr>
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
