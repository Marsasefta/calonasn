<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Rapor Hasil Ujian | CalonASN.id</title>
</head>

<body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')

    <div class="db-content text-dark">
        @php
            $lulus = true;
            foreach ($hasilPerKategori as $hasil) {
                if (($hasil['skor'] ?? 0) < ($hasil['passing_grade'] ?? 0)) {
                    $lulus = false;
                    break;
                }
            }
        @endphp

        <div class="container py-4 py-md-5">
            <!-- Header Status Kelulusan -->
            <div class="text-center mb-4 mb-md-5">
                @if ($lulus)
                    <div class="display-3 display-md-1 mb-2">🎉</div>
                    <h1 class="fw-bold text-success fs-2 fs-md-1 mb-2">SELAMAT! ANDA LULUS</h1>
                    <p class="lead text-muted small fs-md-5">Skor Anda telah memenuhi dan melampaui ambang batas (Passing Grade) di semua subtes SKD.</p>
                @else
                    <div class="display-3 display-md-1 mb-2">😟</div>
                    <h1 class="fw-bold text-danger fs-2 fs-md-1 mb-2">TIDAK LULUS</h1>
                    <p class="lead text-muted small fs-md-5">Maaf, nilai Anda pada salah satu atau lebih subtes masih di bawah ambang batas minimal.</p>
                @endif
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10 col-12">

                    <!-- 4 Kartu Skor Subtes & Total (Grid 2x2 di Mobile, 4 Kolom di Desktop) -->
                    <div class="row g-3 mb-4">
                        @foreach ($hasilPerKategori as $hasil)
                            <div class="col-md-3 col-6">
                                <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100 bg-white">
                                    <h6 class="text-muted small text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">Skor {{ $hasil['name'] }}</h6>
                                    <h2 class="fw-bolder mb-1 {{ $hasil['skor'] >= $hasil['passing_grade'] ? 'text-success' : 'text-danger' }}">
                                        {{ $hasil['skor'] }}
                                    </h2>
                                    <small class="text-muted" style="font-size: 0.74rem;">Min: <strong>{{ $hasil['passing_grade'] }}</strong></small>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-md-3 col-6">
                            <div class="card shadow-sm rounded-4 text-center p-3 h-100 text-white" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;">
                                <h6 class="text-white small text-uppercase opacity-75" style="font-size: 0.72rem; letter-spacing: 0.5px;">Total Skor</h6>
                                <h2 class="fw-bolder mb-1 text-white">
                                    {{ $totalSkor }}
                                </h2>
                                <small class="text-white opacity-75" style="font-size: 0.74rem;">Akumulasi 3 Subtes</small>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Rincian Analisis Kemampuan -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden bg-white">
                        <div class="card-body p-3 p-md-4">
                            <h5 class="fw-bold mb-3 text-dark"><i class="fe fe-activity text-primary me-2"></i>Analisis Kemampuan Kategori</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="py-2.5">Materi</th>
                                            <th class="py-2.5">Keterangan Subtes</th>
                                            <th class="text-center py-2.5" style="width: 20%;">Status Kelulusan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hasilPerKategori as $hasil)
                                            @php
                                                $deskripsi = 'Evaluasi kemampuan materi ' . $hasil['name'];
                                                if (strtoupper($hasil['name']) == 'TWK') {
                                                    $deskripsi = 'Penguasaan wawasan kebangsaan, pilar negara, integritas, dan bela negara.';
                                                } elseif (strtoupper($hasil['name']) == 'TIU') {
                                                    $deskripsi = 'Komponen kemampuan verbal, numerik berhitung, logika silogisme, dan figural.';
                                                } elseif (strtoupper($hasil['name']) == 'TKP') {
                                                    $deskripsi = 'Aspek pelayanan publik, jejaring kerja, sosial budaya, TIK, dan profesionalisme.';
                                                }
                                            @endphp
                                            <tr>
                                                <td class="fw-bold text-dark">{{ $hasil['name'] }}</td>
                                                <td class="text-muted small">{{ $deskripsi }}</td>
                                                <td class="text-center">
                                                    @if ($hasil['skor'] >= $hasil['passing_grade'])
                                                        <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-1.5 fw-bold small">
                                                            <i class="fe fe-check-circle me-1"></i>Lolos PG
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger-subtle text-danger border border-danger rounded-pill px-3 py-1.5 fw-bold small">
                                                            <i class="fe fe-x-circle me-1"></i>Di Bawah PG
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi Bawah (Responsif, Mudah Diklik di HP & Desktop) -->
                    <div class="text-center d-flex flex-wrap gap-2 justify-content-center pt-2">
                        <a href="{{ route('sertifikat.riwayat') }}" class="btn btn-outline-secondary rounded-pill px-3.5 py-2 fw-medium shadow-xs">
                            <i class="fe fe-arrow-left me-1"></i> Riwayat Ujian
                        </a>

                        <a href="{{ route('ujian.pembahasan', $id) }}" class="btn btn-warning text-dark fw-bold rounded-pill px-3.5 py-2 shadow-xs">
                            <i class="fe fe-book-open me-1"></i> Buka Pembahasan Soal
                        </a>

                        @if ($lulus)
                            <a href="{{ route('ujian.sertifikat', $id) }}" target="_blank"
                                class="btn btn-success fw-bold rounded-pill px-4 py-2 shadow-sm">
                                <i class="fe fe-award me-1"></i> Unduh Sertifikat Resmi
                            </a>
                        @else
                            <button type="button" class="btn btn-secondary text-white rounded-pill px-3.5 py-2" disabled
                                title="Capai Passing Grade di semua kategori untuk membuka sertifikat"
                                style="cursor: not-allowed; opacity: 0.65;">
                                <i class="fe fe-lock me-1"></i> Sertifikat Terkunci
                            </button>
                        @endif

                        <a href="{{ route('ranking') }}" class="btn btn-primary rounded-pill px-3.5 py-2 fw-medium shadow-xs">
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
