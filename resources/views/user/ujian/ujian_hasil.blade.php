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
        @php
            $lulus = true; // Set awal true, lalu uji dengan perulangan di bawah
            foreach ($hasilPerKategori as $hasil) {
                if (($hasil['skor'] ?? 0) < ($hasil['passing_grade'] ?? 0)) {
                    $lulus = false; // Ketemu 1 kategori saja yang tidak lolos? Langsung GAGAL.
                    break; // Hentikan pengecekan karena sudah pasti tidak lulus
                }
            }
        @endphp
        <div class="container py-5">
            <div class="text-center mb-5">
                @if ($lulus)
                    <div class="display-1 mb-3">🎉</div>
                    <h1 class="fw-bold text-success">SELAMAT! ANDA LULUS</h1>
                    <p class="lead text-muted">Skor Anda telah memenuhi dan melampaui ambang batas (Passing Grade) di
                        semua kategori.</p>
                @else
                    <div class="display-1 mb-3">😟</div>
                    <h1 class="fw-bold text-danger">TIDAK LULUS</h1>
                    <p class="lead text-muted">Maaf, nilai Anda pada salah satu atau lebih kategori masih di bawah ambang
                        batas minimal.</p>
                @endif
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10">

                    <div class="row g-3 mb-4">
                        @foreach ($hasilPerKategori as $hasil)
                            <div class="col-md-3 col-6">
                                <div class="card border-0 shadow-sm text-center p-3">
                                    <h6 class="text-muted small text-uppercase">Skor {{ $hasil['name'] }}</h6>
                                    <h2
                                        class="fw-bold mb-1 {{ $hasil['skor'] >= $hasil['passing_grade'] ? 'text-success' : 'text-danger' }}">
                                        {{ $hasil['skor'] }}
                                    </h2>
                                    <small class="text-muted">Min: {{ $hasil['passing_grade'] }}</small>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-md-3 col-6">
                            <div class="card bg-primary text-white shadow-sm text-center p-3">
                                <h6 class="text-white small text-uppercase opacity-75">Total Skor</h6>
                                <h2 class="fw-bold mb-1"
                                    style="color: #ffffff; text-shadow: 1px 1px 3px rgba(0,0,0,0.3);">
                                    {{ $totalSkor }}
                                </h2>
                                <small class="opacity-75">Akumulasi</small>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3"><i class="fe fe-activity text-primary me-2"></i>Analisis Kemampuan
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Materi</th>
                                            <th>Keterangan Kategori</th>
                                            <th class="text-center" style="width: 15%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hasilPerKategori as $hasil)
                                            @php
                                                $deskripsi = 'Evaluasi kemampuan materi ' . $hasil['name'];
                                                if (strtoupper($hasil['name']) == 'TWK') {
                                                    $deskripsi =
                                                        'Kemampuan penguasaan pengetahuan dan kemampuan mengimplementasikan nilai-nilai pilar kebangsaan.';
                                                } elseif (strtoupper($hasil['name']) == 'TIU') {
                                                    $deskripsi =
                                                        'Kemampuan komponen verbal, numerik, logika analitis, dan figural.';
                                                } elseif (strtoupper($hasil['name']) == 'TKP') {
                                                    $deskripsi =
                                                        'Kemampuan dalam aspek pelayanan publik, jejaring kerja, sosial budaya, dan profesionalisme.';
                                                }
                                            @endphp
                                            <tr>
                                                <td class="fw-bold text-dark">{{ $hasil['name'] }}</td>
                                                <td class="text-muted small">{{ $deskripsi }}</td>
                                                <td class="text-center">
                                                    @if ($hasil['skor'] >= $hasil['passing_grade'])
                                                        <span class="badge bg-success-soft text-success px-3 py-2">Lolos
                                                            PG</span>
                                                    @else
                                                        <span class="badge bg-danger-soft text-danger px-3 py-2">Di
                                                            Bawah PG</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="text-center d-flex flex-wrap gap-2 justify-content-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fe fe-home me-1"></i> Ke Dashboard
                        </a>

                        <a href="{{ route('ujian.pembahasan', $id) }}" class="btn btn-warning">
                            <i class="fe fe-book-open me-1"></i> Lihat Pembahasan
                        </a>

                        @if ($lulus)
                            <a href="{{ route('ujian.sertifikat', $id) }}" target="_blank"
                                class="btn btn-success shadow-sm">
                                <i class="fe fe-award me-1"></i> Unduh Sertifikat
                            </a>
                        @else
                            <button type="button" class="btn btn-secondary text-white" disabled
                                title="Capai Passing Grade di semua kategori untuk membuka sertifikat"
                                style="cursor: not-allowed; opacity: 0.65;">
                                <i class="fe fe-lock me-1"></i> Sertifikat Terkunci
                            </button>
                        @endif

                        <a href="{{ route('ranking') }}" class="btn btn-primary">
                            <i class="fe fe-trending-up me-1"></i> Lihat Ranking Nasional
                        </a>
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
