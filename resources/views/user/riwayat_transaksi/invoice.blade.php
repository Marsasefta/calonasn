<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $transaction->invoice_number ?? $transaction->order_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.css">
    <style>
        /* Sembunyikan tombol print saat dicetak ke PDF/Kertas */
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body class="bg-light pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">

                <div class="d-flex justify-content-between mb-3 no-print">
                    <a href="{{ route('riwayat') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left"></i> Kembali
                    </a>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fe fe-printer"></i> Cetak Invoice
                    </button>
                </div>

                <div class="card shadow-sm border-0 p-5 rounded-4 bg-white">
                    <div class="row mb-4 border-bottom pb-4">
                        <div class="col-sm-6">
                            <h2 class="fw-bold text-primary mb-1">CALONASN.ID</h2>
                            <p class="text-muted mb-0">Platform Tryout CPNS Terbaik</p>
                        </div>
                        <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                            <h3 class="text-dark mb-1">INVOICE</h3>
                            <p class="text-muted mb-0">#{{ $transaction->invoice_number ?? $transaction->order_id }}</p>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-sm-6">
                            <h6 class="text-muted text-uppercase fw-bold mb-2">Ditagihkan Kepada:</h6>
                            <h5 class="mb-1 text-dark">{{ auth()->user()->name }}</h5>
                            <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                            <h6 class="text-muted text-uppercase fw-bold mb-2">Detail Transaksi:</h6>
                            <p class="mb-1"><span class="text-muted">Tanggal:</span>
                                {{ $transaction->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                            <p class="mb-0"><span class="text-muted">Status:</span> 
                                <span class="badge bg-success">LUNAS / SUCCESS</span>
                            </p>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table border-bottom">
                            <thead class="table-light">
                                <tr>
                                    <th>Deskripsi Paket</th>
                                    <th class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-3">
                                        <h6 class="mb-1">{{ $transaction->tryout->title ?? 'Paket Tryout CPNS Premium' }}</h6>
                                        <small class="text-muted">Akses Penuh ke Simulasi Ujian & Pembahasan</small>
                                    </td>
                                    <td class="text-end py-3 text-dark fw-medium">
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-6 text-end">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal Harga Paket</span>
                                <span class="text-dark">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Kode Unik Transfer</span>
                                <span class="text-success">+ Rp {{ number_format($transaction->unique_code ?? 0, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-between border-top pt-3">
                                <h4 class="fw-bold mb-0">Total Bayar</h4>
                                <h4 class="fw-bold text-primary mb-0">
                                    Rp {{ number_format($transaction->total_amount ?? $transaction->amount, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>