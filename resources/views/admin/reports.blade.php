<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <link href="/build/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="/build/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
    <title>Laporan &amp; Peringkat | Admin CalonASN.id</title>
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

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive p-3">
                            <table class="table table-bordered table-hover table-striped align-middle mb-0" id="reports-table" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Peserta</th>
                                        <th>Tryout</th>
                                        <th>TWK <br> (PG: 65)</th>
                                        <th>TIU <br> (PG: 80)</th>
                                        <th>TKP <br> (PG: 166)</th>
                                        <th>Total Skor</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                        <th>Durasi</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $report)
                                        @php
                                            $isFinished = !is_null($report->end_time);

                                            // Ambil nilai masing-masing pilar
                                            $twk = $report->score_twk ?? 0;
                                            $tiu = $report->score_tiu ?? 0;
                                            $tkp = $report->score_tkp ?? 0;

                                            // Cek apakah ada nilai yang di bawah Passing Grade
                                            $isTwkFailed = $isFinished && $twk < 65;
                                            $isTiuFailed = $isFinished && $tiu < 80;
                                            $isTkpFailed = $isFinished && $tkp < 166;

                                            // Jika salah satu saja gagal, maka status kelulusan total adalah gagal (merah)
                                            $isTotalFailed = $isTwkFailed || $isTiuFailed || $isTkpFailed;

                                            $totalSeconds = ($report->start_time && $report->end_time)
                                                ? \Carbon\Carbon::parse($report->start_time)->diffInSeconds(\Carbon\Carbon::parse($report->end_time))
                                                : null;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $report->user->name ?? '-' }}</td>
                                            <td>{{ $report->tryout->title ?? '-' }}</td>

                                            {{-- Kolom Pecahan Skor SKD dengan validasi warna komponen merah jika di bawah PG --}}
                                            <td class="{{ $isTwkFailed ? 'text-danger fw-bold' : '' }}" data-order="{{ $isFinished ? $twk : -1 }}">{{ $isFinished ? $twk : '-' }}</td>
                                            <td class="{{ $isTiuFailed ? 'text-danger fw-bold' : '' }}" data-order="{{ $isFinished ? $tiu : -1 }}">{{ $isFinished ? $tiu : '-' }}</td>
                                            <td class="{{ $isTkpFailed ? 'text-danger fw-bold' : '' }}" data-order="{{ $isFinished ? $tkp : -1 }}">{{ $isFinished ? $tkp : '-' }}</td>

                                            {{-- Total skor atau status Sedang Ujian --}}
                                            <td data-order="{{ $isFinished ? ($report->total_score ?? 0) : -1 }}">
                                                @if (!$isFinished)
                                                    <span class="badge bg-warning text-dark">Sedang Ujian</span>
                                                @else
                                                    <span class="fw-bold {{ $isTotalFailed ? 'text-danger' : 'text-success' }}">
                                                        {{ $report->total_score }}
                                                        <small class="d-block fw-normal" style="font-size: 0.75rem;">
                                                            {{ $isTotalFailed ? '(TL)' : '(L)' }}
                                                        </small>
                                                    </span>
                                                @endif
                                            </td>

                                            <td data-order="{{ $report->start_time ? $report->start_time->timestamp : 0 }}">{{ $report->start_time ? $report->start_time->locale('id')->isoFormat('DD MMMM YYYY HH:mm:ss') : '-' }}</td>
                                            <td data-order="{{ $report->end_time ? $report->end_time->timestamp : 0 }}">{{ $report->end_time ? $report->end_time->locale('id')->isoFormat('DD MMMM YYYY HH:mm:ss') : '-' }}</td>

                                            <td data-order="{{ $totalSeconds ?? -1 }}">
                                                @if (!is_null($totalSeconds))
                                                    @php
                                                        $minutes = floor($totalSeconds / 60);
                                                        $seconds = $totalSeconds % 60;
                                                    @endphp

                                                    {{-- Output rapi Menit:Detik --}}
                                                    {{ $minutes }}:{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" class="delete-report-form mb-0 d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger text-nowrap" data-player="{{ $report->user->name ?? 'Peserta' }}">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    @include('partials.scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/build/assets/plugins/datatables.net/js/dataTables.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            var t = $('#reports-table').DataTable({
                responsive: false,
                scrollX: true,
                autoWidth: false,
                order: [[6, 'desc']],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    zeroRecords: "Belum ada data laporan.",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                },
                columnDefs: [
                    { orderable: false, searchable: false, targets: [0, 10] }
                ]
            });

            t.on('order.dt search.dt', function () {
                let i = 1;
                t.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                    this.data(i++);
                });
            }).draw();
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('submit', function (e) {
                const delForm = e.target.closest('.delete-report-form');
                if (!delForm) return;
                e.preventDefault();
                const btn = delForm.querySelector('button[data-player]');
                const name = btn ? btn.getAttribute('data-player') : 'peserta ini';

                if (window.Swal) {
                    Swal.fire({
                        title: 'Hapus Data Laporan?',
                        text: `Data sesi ujian milik ${name} akan dihapus permanen.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal'
                    }).then(function (result) {
                        if (result.isConfirmed) delForm.submit();
                    });
                } else {
                    delForm.submit();
                }
            });
        });
    </script>
</body>

</html>