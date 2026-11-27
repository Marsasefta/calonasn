<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Riwayat Nilai & Sertifikat | CalonASN.id</title>
</head>

<body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')

    <div class="db-content text-dark">
        <div class="container mb-4">
            <!-- Header Halaman -->
            <div class="row align-items-center mb-4">
                <div class="col-12">
                    <h1 class="h2 mb-1 fw-bold text-dark"><i class="fe fe-award text-primary me-2"></i>Riwayat Nilai & Sertifikat</h1>
                    <p class="text-muted small mb-0">Pantau progres pengerjaan simulasi CAT CPNS Anda dan unduh sertifikat resmi kelulusan SKD.</p>
                </div>
            </div>

            <!-- Flash Message Alert -->
            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-4 d-flex align-items-center gap-2 mb-4 p-3" role="alert">
                    <i class="fe fe-alert-circle fs-4 text-danger flex-shrink-0"></i>
                    <span class="small">{{ session('error') }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center gap-2 mb-4 p-3" role="alert">
                    <i class="fe fe-check-circle fs-4 text-success flex-shrink-0"></i>
                    <span class="small">{{ session('success') }}</span>
                </div>
            @endif

            <!-- 3 Kartu Statistik Ringkas Pengguna -->
            <div class="row g-3 mb-4">
                <div class="col-md-4 col-12">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary-soft text-primary p-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                                <i class="fe fe-file-text fs-3"></i>
                            </div>
                            <div>
                                <span class="text-muted small fw-medium d-block text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">TOTAL SIMULASI</span>
                                <h3 class="fw-bolder text-dark mb-0 lh-1">{{ $totalTryout ?? count($riwayatUjian) }} <span class="fs-6 text-muted fw-normal">Sesi</span></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-success-soft text-success p-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                                <i class="fe fe-trending-up fs-3"></i>
                            </div>
                            <div>
                                <span class="text-muted small fw-medium d-block text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">SKOR TERTINGGI SAYA</span>
                                <h3 class="fw-bolder text-success mb-0 lh-1">{{ $skorTertinggi ?? 0 }} <span class="fs-6 text-muted fw-normal">Poin</span></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-warning-soft text-warning p-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                                <i class="fe fe-award fs-3"></i>
                            </div>
                            <div>
                                <span class="text-muted small fw-medium d-block text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">SERTIFIKAT KELULUSAN</span>
                                <h3 class="fw-bolder text-dark mb-0 lh-1">{{ $totalLulus ?? 0 }} <span class="fs-6 text-muted fw-normal">Sertifikat</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Riwayat Ujian & Sertifikat -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-white">
                        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <h5 class="mb-0 fw-bold text-dark"><i class="fe fe-clock text-primary me-2"></i>Daftar Riwayat Ujian</h5>
                            <span class="text-muted small">Passing Grade Resmi: TWK 65 | TIU 80 | TKP 166</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3 py-3">Tanggal & Waktu</th>
                                        <th class="py-3">Nama Paket Tryout</th>
                                        <th class="text-center py-3">TWK</th>
                                        <th class="text-center py-3">TIU</th>
                                        <th class="text-center py-3">TKP</th>
                                        <th class="text-center py-3">Total Skor</th>
                                        <th class="text-center py-3">Status SKD</th>
                                        <th class="text-end pe-4 py-3" style="width: 320px; min-width: 310px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($riwayatUjian as $item)
                                        @php
                                            // 1. Cek apakah baris ini adalah percobaan terbaru
                                            $isTerbaru = in_array($item->id, $sessionTerbaruPerTryout);

                                            // 2. Standar kelulusan Passing Grade BKN (harus lulus semua kategori)
                                            $passTWK = ($item->score_twk ?? 0) >= 65;
                                            $passTIU = ($item->score_tiu ?? 0) >= 80;
                                            $passTKP = ($item->score_tkp ?? 0) >= 166;
                                            $isLulus = $passTWK && $passTIU && $passTKP;
                                        @endphp

                                        <tr>
                                            <td class="ps-3 text-muted small">
                                                <i class="fe fe-calendar me-1"></i>{{ $item->end_time ? $item->end_time->format('d M Y, H:i') : '-' }}
                                                @if ($isTerbaru)
                                                    <span class="badge bg-primary ms-1" style="font-size: 10px;">Terbaru</span>
                                                @endif
                                            </td>
                                            <td>
                                                <h6 class="mb-0 text-dark fw-bold">{{ $item->tryout->title ?? 'Simulasi CAT CPNS' }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <span class="{{ $passTWK ? 'text-success fw-bold' : 'text-danger' }}">
                                                    {{ $item->score_twk ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="{{ $passTIU ? 'text-success fw-bold' : 'text-danger' }}">
                                                    {{ $item->score_tiu ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="{{ $passTKP ? 'text-success fw-bold' : 'text-danger' }}">
                                                    {{ $item->score_tkp ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="text-center fw-bolder fs-6 text-primary">
                                                {{ $item->total_score ?? '-' }}
                                            </td>
                                            <td class="text-center">
                                                @if ($isLulus)
                                                    <span class="badge bg-success-subtle text-success border border-success rounded-pill px-2.5 py-1 small fw-bold">
                                                        <i class="fe fe-check-circle me-1"></i>LULUS PG
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger border border-danger rounded-pill px-2.5 py-1 small fw-bold">
                                                        <i class="fe fe-x-circle me-1"></i>TIDAK LULUS
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="d-inline-flex align-items-center gap-1.5 flex-nowrap justify-content-end">
                                                    {{-- TOMBOL LANGSUNG: RAPOR & PEMBAHASAN --}}
                                                    @if ($isTerbaru)
                                                        <a href="{{ route('ujian.hasil', $item->id) }}"
                                                            class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-1 text-nowrap fw-medium"
                                                            title="Lihat Rapor Detail Nilai">
                                                            <i class="fe fe-bar-chart-2 me-1"></i>Rapor
                                                        </a>
                                                        <a href="{{ route('ujian.pembahasan', $item->id) }}"
                                                            class="btn btn-sm btn-outline-success rounded-pill px-2.5 py-1 text-nowrap fw-medium"
                                                            title="Buka Pembahasan Soal">
                                                            <i class="fe fe-book-open me-1"></i>Pembahasan
                                                        </a>
                                                        @if (!empty($hasSubmittedFeedback))
                                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 text-nowrap" style="font-size: 11px;">
                                                                <i class="fe fe-check me-1"></i>Diulas
                                                            </span>
                                                        @else
                                                            <a href="{{ route('ujian.hasil', $item->id) }}#feedback-card"
                                                                class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1 text-nowrap fw-medium"
                                                                title="Beri Penilaian &amp; Saran">
                                                                <i class="fe fe-message-square me-1"></i>Ulas
                                                            </a>
                                                        @endif
                                                    @else
                                                        <span class="badge rounded-pill px-2.5 py-1 text-nowrap fw-semibold d-inline-flex align-items-center"
                                                            style="background-color: #e2e8f0 !important; color: #334155 !important; border: 1px solid #cbd5e1 !important; font-size: 12px;"
                                                            title="Rapor & Pembahasan hanya tersedia untuk sesi terbaru">
                                                            <i class="fe fe-lock me-1 text-secondary"></i>Terkunci
                                                        </span>
                                                    @endif

                                                    {{-- TOMBOL LANGSUNG: SERTIFIKAT (JIKA LULUS) --}}
                                                    @if ($isLulus)
                                                        <a href="{{ route('ujian.sertifikat', $item->id) }}"
                                                            target="_blank"
                                                            class="btn btn-sm btn-warning text-dark fw-bold rounded-pill px-2.5 py-1 shadow-xs text-nowrap"
                                                            title="Buka & Cetak Sertifikat Kelulusan Resmi">
                                                            <i class="fe fe-award me-1"></i>Sertifikat
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="py-4">
                                                    <div class="rounded-circle bg-light d-inline-flex p-3 mb-3">
                                                        <i class="fe fe-database fs-1 text-muted"></i>
                                                    </div>
                                                    <h5 class="fw-bold text-dark mb-1">Belum Ada Riwayat Ujian</h5>
                                                    <p class="text-muted small mb-3">Mulai simulasi CAT pertama Anda sekarang untuk menguji kemampuan dan raih sertifikat resmi kelulusan!</p>
                                                    <a href="{{ route('ujian.persiapan', 1) }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                                                        <i class="fe fe-play me-2"></i>Mulai Tryout Sekarang
                                                    </a>
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
    <script src="/build/assets/js/vendors/tnsSlider.js"></script>
    <script src="/build/assets/js/vendors/chart.js"></script>
    <script src="/build/assets/js/vendors/navbar-nav.js"></script>
</body>

</html>
