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
                            <h1 class="mb-1 h2 fw-bold">Laporan & Peringkat</h1>
                            <p class="text-muted mb-0">Lihat rekap nilai peserta dan export laporan ke file spreadsheet
                                untuk pengumuman.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.reports.export') }}" class="btn btn-success">
                                <i class="fe fe-download me-1"></i> Export CSV
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Peserta</th>
                                    <th>Tryout</th>
                                    <th>TWK</th>
                                    <th>TIU</th>
                                    <th>TKP</th>
                                    <th>Total Skor</th>
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th>Durasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $report)
                                    <tr>
                                        <td>{{ $loop->iteration + ($reports->currentPage() - 1) * $reports->perPage() }}</td>
                                        <td>{{ $report->user->name ?? '-' }}</td>
                                        <td>{{ $report->tryout->title ?? '-' }}</td>
                                        
                                        {{-- Kolom Pecahan Skor SKD --}}
                                        <td>{{ $report->score_twk ?? 0 }}</td>
                                        <td>{{ $report->score_tiu ?? 0 }}</td>
                                        <td>{{ $report->score_tkp ?? 0 }}</td>
                                        
                                        <td><span class="fw-bold text-dark">{{ $report->total_score }}</span></td>
                                        
                                        {{-- Menggunakan locale('id') dan isoFormat agar bulan otomatis berbahasa Indonesia --}}
                                        <td>{{ $report->start_time ? $report->start_time->locale('id')->isoFormat('DD MMMM YYYY HH:mm:ss') : '-' }}</td>
                                        <td>{{ $report->end_time ? $report->end_time->locale('id')->isoFormat('DD MMMM YYYY HH:mm:ss') : '-' }}</td>
                                        
                                        <td>
                                            @if ($report->start_time && $report->end_time)
                                                @php
                                                    $start = \Carbon\Carbon::parse($report->start_time);
                                                    $end = \Carbon\Carbon::parse($report->end_time);

                                                    // Hitung total detik keseluruhan
                                                    $totalSeconds = $start->diffInSeconds($end);

                                                    // Konversi ke format akumulasi menit dan sisa detik
                                                    $minutes = floor($totalSeconds / 60);
                                                    $seconds = $totalSeconds % 60;
                                                @endphp

                                                {{-- Output rapi Menit:Detik (misal 76:31 atau 2:14) --}}
                                                {{ $minutes }}:{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        {{-- Colspan disesuaikan menjadi 10 karena jumlah kolom bertambah --}}
                                        <td colspan="10" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-inbox fs-3 mb-2 d-block"></i>
                                                Belum ada data laporan.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-3">
                    {{ $reports->links() }}
                </div>
            </section>
        </main>
    </div>

    @include('partials.scripts')
</body>

</html>