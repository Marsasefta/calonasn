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
        <div class="container py-5">
            <div class="text-center mb-5">
                @if ($lulus)
                    <div class="display-1 text-success mb-3">🎉</div>
                    <h1 class="fw-bold text-success">SELAMAT! ANDA LULUS</h1>
                    <p class="lead">Skor Anda telah melampaui ambang batas (Passing Grade).</p>
                @else
                    <div class="display-1 text-danger mb-3">😟</div>
                    <h1 class="fw-bold text-danger">TIDAK LULUS</h1>
                    <p class="lead">Maaf, skor Anda masih di bawah ambang batas minimal.</p>
                @endif
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm text-center p-3">
                                <h6 class="text-muted small uppercase">Skor TWK</h6>
                                <h2 class="fw-bold {{ $skor['TWK'] >= 65 ? 'text-success' : 'text-danger' }}">
                                    {{ $skor['TWK'] }}
                                </h2>
                                <small class="text-muted">Min: 65</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm text-center p-3">
                                <h6 class="text-muted small uppercase">Skor TIU</h6>
                                <h2 class="fw-bold {{ $skor['TIU'] >= 80 ? 'text-success' : 'text-danger' }}">
                                    {{ $skor['TIU'] }}
                                </h2>
                                <small class="text-muted">Min: 80</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm text-center p-3">
                                <h6 class="text-muted small uppercase">Skor TKP</h6>
                                <h2 class="fw-bold {{ $skor['TKP'] >= 166 ? 'text-success' : 'text-danger' }}">
                                    {{ $skor['TKP'] }}
                                </h2>
                                <small class="text-muted">Min: 166</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-primary text-white shadow-sm text-center p-3">
                                <h6 class="text-white-50 small uppercase">Total Skor</h6>
                                <h2 class="fw-bold mb-0">{{ $skor['TOTAL'] }}</h2>
                                <small>Akumulasi</small>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Analisis Kemampuan</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Materi</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>TWK (Wawasan Kebangsaan)</td>
                                            <td>Kemampuan penguasaan pengetahuan dan kemampuan mengimplementasikan
                                                nilai-nilai pilar kebangsaan.</td>
                                            <td>{!! $skor['TWK'] >= 65
                                                ? '<span class="badge bg-success">Lulus</span>'
                                                : '<span class="badge bg-danger">Tidak Lulus</span>' !!}</td>
                                        </tr>
                                        <tr>
                                            <td>TIU (Intelegensia Umum)</td>
                                            <td>Kemampuan verbal, numerik, dan figural.</td>
                                            <td>{!! $skor['TIU'] >= 80
                                                ? '<span class="badge bg-success">Lulus</span>'
                                                : '<span class="badge bg-danger">Tidak Lulus</span>' !!}</td>
                                        </tr>
                                        <tr>
                                            <td>TKP (Karakteristik Pribadi)</td>
                                            <td>Kemampuan dalam pelayanan publik, jejaring kerja, dan profesionalisme.
                                            </td>
                                            <td>{!! $skor['TKP'] >= 166
                                                ? '<span class="badge bg-success">Lulus</span>'
                                                : '<span class="badge bg-danger">Tidak Lulus</span>' !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary me-2">Ke Dashboard</a>
                        <a href="{{ route('ujian.pembahasan', $id) }}" class="btn btn-warning me-2">
                            <i class="fe fe-book-open"></i> Lihat Pembahasan
                        </a>
                        @if ($lulus)
                            <a href="{{ route('ujian.sertifikat', $id) }}" target="_blank"
                                class="btn btn-success me-2 shadow-sm">
                                <i class="fe fe-award"></i> Unduh Sertifikat
                            </a>
                        @else
                            <button type="button" class="btn btn-secondary me-2 text-white" disabled
                                title="Capai Passing Grade untuk membuka sertifikat"
                                style="cursor: not-allowed; opacity: 0.7;">
                                <i class="fe fe-lock"></i> Sertifikat Terkunci
                            </button>
                        @endif
                        <a href="{{ route('ranking') }}" class="btn btn-primary">Lihat Ranking Nasional</a>
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
