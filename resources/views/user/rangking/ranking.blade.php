<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Peringkat Nasional</title>
</head>

<body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')

    <div class="db-content text-dark">
        <div class="container mb-4">
            <div class="row align-items-center mb-5">
                <div class="col-md-8">
                    <h1 class="h2 mb-0">Peringkat Nasional</h1>
                    <p class="text-muted">Ukur kemampuanmu dibandingkan ribuan peserta lainnya.</p>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Pilih Periode Tryout:</label>
                    <select class="form-select shadow-sm">
                        <option value="batch1">Batch 1 (01 - 05 Juni 2026)</option>
                        <option value="batch2">Batch 2 (06 - 10 Juni 2026)</option>
                        <option value="batch3">Terbaru (Sedang Berjalan)</option>
                    </select>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm text-center bg-light">
                        <div class="card-body">
                            <div class="display-4 text-warning mb-2">🥈</div>
                            <h4 class="mb-0">Ahmad Fauzi</h4>
                            <p class="text-muted small">Skor: 485</p>
                            <span class="badge bg-secondary">Peringkat 2</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-primary border-2 shadow text-center">
                        <div class="card-body py-4">
                            <div class="display-3 mb-2">🥇</div>
                            <h3 class="mb-0 fw-bold">Siti Aminah</h3>
                            <p class="text-muted">Skor: 498</p>
                            <span class="badge bg-warning text-dark">Peringkat 1 (Juara)</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm text-center bg-light">
                        <div class="card-body">
                            <div class="display-4 text-danger mb-2">🥉</div>
                            <h4 class="mb-0">Budi Santoso</h4>
                            <p class="text-muted small">Skor: 472</p>
                            <span class="badge bg-bronze" style="background-color: #cd7f32; color: white;">Peringkat
                                3</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="table-responsive">
                            <table class="table table-hover text-nowrap mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Rank</th>
                                        <th>Nama Peserta</th>
                                        <th>TWK</th>
                                        <th>TIU</th>
                                        <th>TKP</th>
                                        <th>Total Skor</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                @foreach ($rankings as $row)
                                    <tr class="{{ $row['name'] == auth()->user()->name ? 'table-warning' : '' }}">
                                        <td class="fw-bold align-middle">{{ $row['rank'] }}</td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($row['name']) }}&background=random"
                                                        class="rounded-circle" width="30">
                                                </div>
                                                <span>{{ $row['name'] }}
                                                    {{ $row['name'] == auth()->user()->name ? '(Kamu)' : '' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $row['twk'] }}</td>
                                        <td>{{ $row['tiu'] }}</td>
                                        <td>{{ $row['tkp'] }}</td>
                                        <td class="fw-bold text-primary">{{ $row['total'] }}</td>
                                        <td>{{ $row['time'] }}</td>
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
