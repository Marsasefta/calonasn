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
                    <h1 class="h2 mb-0">Riwayat Nilai & Sertifikat</h1>
                    <p class="text-muted">Pantau progres belajar kamu dan unduh sertifikat kelulusan.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Tryout</th>
                                        <th class="text-center">TWK</th>
                                        <th class="text-center">TIU</th>
                                        <th class="text-center">TKP</th>
                                        <th class="text-center">Total</th>
                                        <th>Status</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($riwayatUjian as $item)
                                        <tr>
                                            <td class="align-middle">
                                                {{ $item->end_time->format('d M Y') }}
                                            </td>
                                            <td class="align-middle">
                                                <h5 class="mb-0 text-dark">{{ $item->tryout->title }}</h5>
                                            </td>
                                            <td class="align-middle text-center">{{ $item->score_twk ?? '-' }}</td>
                                            <td class="align-middle text-center">{{ $item->score_tiu ?? '-' }}</td>
                                            <td class="align-middle text-center">{{ $item->score_tkp ?? '-' }}</td>
                                            <td class="align-middle text-center fw-bold text-primary">
                                                {{ $item->total_score }}
                                            </td>
                                            <td class="align-middle">
                                                @if ($item->total_score >= 311)
                                                    {{-- Contoh standar kelulusan --}}
                                                    <span class="badge bg-success-soft text-success">LULUS</span>
                                                @else
                                                    <span class="badge bg-danger-soft text-danger">TIDAK LULUS</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-end">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        href="#" role="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        Opsi
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('ujian.hasil', $item->tryout_id) }}">
                                                                <i class="fe fe-bar-chart-2 me-2"></i>Lihat Detail
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('ujian.pembahasan', $item->tryout_id) }}">
                                                                <i class="fe fe-book-open me-2"></i>Pembahasan
                                                            </a>
                                                        </li>
                                                        @if ($item->total_score >= 311)
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-primary"
                                                                    href="{{ route('ujian.sertifikat', $item->tryout_id) }}">
                                                                    <i class="fe fe-award me-2"></i>Unduh Sertifikat
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="fe fe-database fs-1 d-block mb-2"></i>
                                                    Belum ada riwayat ujian.
                                                </div>
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
