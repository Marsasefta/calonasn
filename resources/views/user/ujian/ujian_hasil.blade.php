<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Simulasi Ujian</title>
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

                        @foreach ($hasilPerKategori as $hasil)
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm text-center p-3">
                                    <h6 class="text-muted small uppercase">Skor {{ $hasil['name'] }}</h6>

                                    <h2
                                        class="fw-bold {{ $hasil['skor'] >= $hasil['passing_grade'] ? 'text-success' : 'text-danger' }}">
                                        {{ $hasil['skor'] }}
                                    </h2>

                                    <small class="text-muted">Min: {{ $hasil['passing_grade'] }}</small>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-md-3">
                            <div class="card bg-primary text-white shadow-sm text-center p-3">
                                <h6 class="text-white small uppercase">Total Skor</h6>
                                <h2 class="fw-bold mb-1"
                                    style="color: #ffffff; text-shadow: 1px 1px 3px rgba(0,0,0,0.3);">
                                    {{ $totalSkor }}</h2>
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
                                        @foreach ($hasilPerKategori as $hasil)
                                            @php
                                                // Pemetaan deskripsi karena di DB belum ada kolom keterangan
                                                $deskripsi = 'Evaluasi kemampuan materi ' . $hasil['name'];
                                                if (strtoupper($hasil['name']) == 'TWK') {
                                                    $deskripsi =
                                                        'Kemampuan penguasaan pengetahuan dan kemampuan mengimplementasikan nilai-nilai pilar kebangsaan.';
                                                } elseif (strtoupper($hasil['name']) == 'TIU') {
                                                    $deskripsi = 'Kemampuan verbal, numerik, dan figural.';
                                                } elseif (strtoupper($hasil['name']) == 'TKP') {
                                                    $deskripsi =
                                                        'Kemampuan dalam pelayanan publik, jejaring kerja, dan profesionalisme.';
                                                }
                                            @endphp
                                            <tr>
                                                <td class="fw-bold">{{ $hasil['name'] }}</td>
                                                <td>{{ $deskripsi }}</td>
                                                <td>
                                                    @if ($hasil['skor'] >= $hasil['passing_grade'])
                                                        <span class="badge bg-success">Lulus</span>
                                                    @else
                                                        <span class="badge bg-danger">Tidak Lulus</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
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
