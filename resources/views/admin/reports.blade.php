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
                                    <th>Total Skor</th>
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th>Durasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $report)
                                    <tr>
                                        <td>{{ $loop->iteration + ($reports->currentPage() - 1) * $reports->perPage() }}
                                        </td>
                                        <td>{{ $report->user->name ?? '-' }}</td>
                                        <td>{{ $report->tryout->title ?? '-' }}</td>
                                        <td>{{ $report->total_score }}</td>
                                        <td>{{ $report->start_time?->format('d M Y H:i') ?? '-' }}</td>
                                        <td>{{ $report->end_time?->format('d M Y H:i') ?? '-' }}</td>
                                        <td>
                                            @if ($report->start_time && $report->end_time)
                                                @php
                                                    // Menghitung selisih waktu
                                                    $diff = $report->start_time->diff($report->end_time);
                                                @endphp

                                                {{-- Tampilkan Jam jika ada, Menit, dan Detik --}}
                                                {{ $diff->h > 0 ? $diff->h . ' jam ' : '' }}
                                                {{ $diff->i }}:{{ $diff->s }} 
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
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
