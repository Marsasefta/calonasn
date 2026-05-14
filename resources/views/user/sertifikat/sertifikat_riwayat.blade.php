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

    <div class="db-content text-dark">
        <div class="container py-4">
            <div class="row mb-4">
                <div class="col-md-12">
                    <h2 class="fw-bold mb-1">Riwayat & Sertifikat</h2>
                    <p class="text-muted">Kumpulan hasil tryout dan sertifikat kelulusan Anda di CalonASN.id</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tryout</th>
                                        <th>Tanggal</th>
                                        <th class="text-center">TWK</th>
                                        <th class="text-center">TIU</th>
                                        <th class="text-center">TKP</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riwayat as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="icon-shape icon-sm bg-light-primary text-primary rounded me-2">
                                                        <i class="fe fe-file-text"></i>
                                                    </div>
                                                    <span class="fw-bold">{{ $item['nama_tryout'] }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $item['tanggal'] }}</td>
                                            <td class="text-center">{{ $item['twk'] }}</td>
                                            <td class="text-center">{{ $item['tiu'] }}</td>
                                            <td class="text-center">{{ $item['tkp'] }}</td>
                                            <td class="text-center fw-bold text-primary">{{ $item['total'] }}</td>
                                            <td class="text-center">
                                                @if ($item['status'] == 'Lulus')
                                                    <span class="badge bg-light-success text-success">Lulus</span>
                                                @else
                                                    <span class="badge bg-light-danger text-danger">Tidak Lulus</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if ($item['status'] == 'Lulus')
                                                    <a href="{{ route('ujian.sertifikat') }}" target="_blank"
                                                        class="btn btn-sm btn-success">
                                                        <i class="fe fe-download me-1"></i> Sertifikat
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-secondary" disabled
                                                        title="Tidak memenuhi passing grade">
                                                        <i class="fe fe-lock me-1"></i> Terkunci
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
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
