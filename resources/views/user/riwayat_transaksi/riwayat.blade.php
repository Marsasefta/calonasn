<!doctype html>
<html lang="id">

<head>
    @include('partials.head')
    <title>Riwayat Transaksi | CalonASN.id</title>
    <style>
        .riwayat-shell {
            max-width: 1120px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    @include('partials.navbar')
    @include('partials.navbar-student')

    <div class="db-content">
        <div class="container-fluid py-3 py-md-4">
            <div class="riwayat-shell">

                <!-- Header -->
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                    <div>
                        <h1 class="h2 fw-bold mb-1">Riwayat Transaksi</h1>
                        <p class="text-muted small mb-0">Daftar tagihan, status aktivasi paket tryout, dan invoice resmi kamu.</p>
                    </div>
                    <div>
                        <a href="{{ route('user.pilih-paket') }}" class="btn btn-primary btn-sm rounded-pill px-3 py-2 fw-bold shadow-xs">
                            <i class="fe fe-shopping-cart me-1"></i> Lihat Paket Tryout
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                        <i class="fe fe-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                        <i class="fe fe-x-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                <!-- 3 Kartu Ringkasan -->
                <div class="row g-3 mb-4">
                    <div class="col-4 col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold d-block">Total</span>
                                <h3 class="fw-bolder mb-0 mt-1 text-dark">{{ $totalCount ?? $transactions->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold d-block">Sukses</span>
                                <h3 class="fw-bolder mb-0 mt-1 text-success">{{ $successCount ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold d-block">Pending</span>
                                <h3 class="fw-bolder mb-0 mt-1 text-warning">{{ $pendingCount ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $preparedTx = $transactions->map(function ($trx) {
                        $statusClean = strtolower(trim((string) $trx->status));
                        $refCode = $trx->invoice_number ?? $trx->order_id;
                        $isUnpaid = $statusClean === 'pending' && empty($trx->payment_proof);
                        $isVerifying = $statusClean === 'pending' && !empty($trx->payment_proof);
                        $isSuccess = in_array($statusClean, ['success', 'paid'], true);
                        $waMsg = urlencode('Halo Admin CalonASN, saya ingin konfirmasi pembayaran untuk invoice ' . $refCode . ' atas nama ' . (auth()->user()->name ?? 'Peserta') . '.');

                        return [
                            'model' => $trx,
                            'statusClean' => $statusClean,
                            'refCode' => $refCode,
                            'packageTitle' => $trx->tryout->title ?? 'Paket Tryout',
                            'totalText' => 'Rp ' . number_format($trx->total_amount ?? $trx->amount, 0, ',', '.'),
                            'dateText' => $trx->created_at ? $trx->created_at->format('d M Y, H:i') : '-',
                            'expiredText' => ($isUnpaid && $trx->expired_at) ? \Illuminate\Support\Carbon::parse($trx->expired_at)->format('d M Y, H:i') : null,
                            'isUnpaid' => $isUnpaid,
                            'isVerifying' => $isVerifying,
                            'isSuccess' => $isSuccess,
                            'waUrl' => 'https://wa.me/6285113655806?text=' . $waMsg,
                        ];
                    });
                @endphp

                @if ($preparedTx->isEmpty())
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-5 text-center">
                            <div class="rounded-circle bg-primary-soft text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fe fe-shopping-bag fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-1">Belum Ada Riwayat Transaksi</h5>
                            <p class="text-muted small mb-3">Pilih paket belajar &amp; tryout CAT CPNS untuk mulai berlatih maksimal.</p>
                            <a href="{{ route('user.pilih-paket') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-xs">
                                <i class="fe fe-zap me-1"></i> Pilih Paket Tryout Sekarang
                            </a>
                        </div>
                    </div>
                @else
                    <!-- TAMPILAN MOBILE (< md): CARD STACK BEBAS SCROLL SAMPING -->
                    <div class="d-md-none d-flex flex-column gap-3">
                        @foreach ($preparedTx as $item)
                            @php $trx = $item['model']; @endphp
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                        <div class="min-w-0">
                                            <div class="small text-muted">{{ $item['dateText'] }}</div>
                                            <h6 class="fw-bold mb-0 text-truncate">{{ $item['packageTitle'] }}</h6>
                                        </div>
                                        @if ($item['isUnpaid'])
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle flex-shrink-0">BELUM BAYAR</span>
                                        @elseif ($item['isVerifying'])
                                            <span class="badge bg-info-subtle text-info border border-info-subtle flex-shrink-0">VERIFIKASI</span>
                                        @elseif ($item['isSuccess'])
                                            <span class="badge bg-success-subtle text-success border border-success-subtle flex-shrink-0">SUKSES</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle flex-shrink-0">GAGAL</span>
                                        @endif
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center py-2 border-top border-bottom my-2">
                                        <div>
                                            <div class="small text-muted">No. Invoice</div>
                                            <div class="small fw-semibold">{{ $item['refCode'] }}</div>
                                        </div>
                                        <div class="text-end">
                                            <div class="small text-muted">Total</div>
                                            <div class="fw-bold text-primary">{{ $item['totalText'] }}</div>
                                        </div>
                                    </div>

                                    @if ($item['expiredText'])
                                        <div class="small text-warning fw-semibold mb-2">
                                            <i class="fe fe-clock me-1"></i> Batas bayar: {{ $item['expiredText'] }}
                                        </div>
                                    @endif

                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        @if ($item['isUnpaid'])
                                            <a href="{{ route('payment.qris', $item['refCode']) }}" class="btn btn-sm btn-primary rounded-pill fw-bold flex-grow-1">
                                                <i class="fe fe-credit-card me-1"></i> Bayar Sekarang
                                            </a>
                                            <form action="{{ route('riwayat.destroy', $trx->id) }}" method="POST" class="cancel-order-form mb-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold" data-invoice="{{ $item['refCode'] }}">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @elseif ($item['isVerifying'])
                                            <a href="{{ route('payment.qris', $item['refCode']) }}" class="btn btn-sm btn-outline-info rounded-pill fw-semibold flex-grow-1">
                                                <i class="fe fe-eye me-1"></i> Cek Bukti
                                            </a>
                                            <a href="{{ $item['waUrl'] }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-success rounded-pill fw-semibold flex-grow-1">
                                                <i class="bi bi-whatsapp me-1"></i> Konfirmasi WA
                                            </a>
                                        @elseif ($item['isSuccess'])
                                            <a href="{{ route('invoice', $item['refCode']) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill fw-semibold w-100">
                                                <i class="fe fe-file-text me-1"></i> Lihat Invoice Resmi
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- TAMPILAN TABLET & DESKTOP (>= md): TABEL RAPI -->
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-md-block">
                        <div class="table-responsive">
                            <table class="table mb-0 table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Tanggal</th>
                                        <th>No. Invoice</th>
                                        <th>Paket</th>
                                        <th>Total Tagihan</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($preparedTx as $item)
                                        @php $trx = $item['model']; @endphp
                                        <tr>
                                            <td class="text-nowrap ps-4">
                                                <div>{{ $item['dateText'] }}</div>
                                                @if ($item['expiredText'])
                                                    <small class="text-warning fw-semibold">Exp: {{ $item['expiredText'] }}</small>
                                                @endif
                                            </td>
                                            <td class="fw-medium text-nowrap">{{ $item['refCode'] }}</td>
                                            <td>
                                                <span class="fw-bold">{{ $item['packageTitle'] }}</span>
                                            </td>
                                            <td class="fw-bold text-nowrap">{{ $item['totalText'] }}</td>
                                            <td class="text-nowrap">
                                                @if ($item['isUnpaid'])
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1">
                                                        <i class="fe fe-clock me-1"></i> BELUM BAYAR
                                                    </span>
                                                @elseif ($item['isVerifying'])
                                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-2.5 py-1">
                                                        <i class="fe fe-refresh-cw me-1"></i> MENUNGGU VERIFIKASI
                                                    </span>
                                                @elseif ($item['isSuccess'])
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1">
                                                        <i class="fe fe-check-circle me-1"></i> SUKSES
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1">
                                                        <i class="fe fe-x-circle me-1"></i> GAGAL ({{ $trx->status }})
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4 text-nowrap">
                                                <div class="d-inline-flex align-items-center gap-2 justify-content-end">
                                                    @if ($item['isUnpaid'])
                                                        <a href="{{ route('payment.qris', $item['refCode']) }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold">
                                                            <i class="fe fe-credit-card me-1"></i> Bayar Sekarang
                                                        </a>
                                                        <form action="{{ route('riwayat.destroy', $trx->id) }}" method="POST" class="cancel-order-form mb-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold" data-invoice="{{ $item['refCode'] }}">
                                                                Batalkan
                                                            </button>
                                                        </form>
                                                    @elseif ($item['isVerifying'])
                                                        <a href="{{ route('payment.qris', $item['refCode']) }}" class="btn btn-sm btn-outline-info rounded-pill px-3 fw-semibold">
                                                            <i class="fe fe-eye me-1"></i> Cek Bukti
                                                        </a>
                                                        <a href="{{ $item['waUrl'] }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold">
                                                            <i class="bi bi-whatsapp me-1"></i> Chat Admin
                                                        </a>
                                                    @elseif ($item['isSuccess'])
                                                        <a href="{{ route('invoice', $item['refCode']) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold">
                                                            <i class="fe fe-file-text me-1"></i> Invoice
                                                        </a>
                                                    @else
                                                        <span class="text-muted small">-</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('partials.btn-scroll-top')
    @include('partials.scripts')
    <script src="/build/assets/js/vendors/navbar-nav.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('submit', function (e) {
                const form = e.target.closest('.cancel-order-form');
                if (!form) return;
                e.preventDefault();

                const btn = form.querySelector('button[data-invoice]');
                const inv = btn ? btn.getAttribute('data-invoice') : '';

                if (window.Swal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Batalkan Pesanan?',
                        text: `Pesanan ${inv} yang belum dibayar akan dibatalkan.`,
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        confirmButtonText: 'Ya, batalkan',
                        cancelButtonText: 'Kembali'
                    }).then(function (result) {
                        if (result.isConfirmed) form.submit();
                    });
                } else {
                    form.submit();
                }
            });
        });
    </script>
</body>

</html>
