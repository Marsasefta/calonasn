<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Peringkat Nasional CAT CPNS | CalonASN.id</title>
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
                <div class="col-md-8 col-12 mb-2 mb-md-0">
                    <h1 class="h2 mb-1 fw-bold text-dark"><i class="fe fe-award text-warning me-2"></i>Peringkat Nasional CAT CPNS</h1>
                    <p class="text-muted small mb-0">Leaderboard resmi sesuai standar penilaian & urutan kelulusan BKN (TKP &gt; TIU &gt; TWK).</p>
                </div>
                <div class="col-md-4 col-12 text-md-end text-start">
                    <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill fw-bold border border-primary-subtle" style="font-size: 0.82rem;">
                        <i class="fe fe-users me-1"></i> {{ $totalParticipants }} Peserta Berpartisipasi
                    </span>
                </div>
            </div>

            <!-- Banner Posisi Peringkat Akun Sendiri (Sangat Membantu di Mobile) -->
            @if ($myRank)
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">
                    <div class="card-body p-3 p-md-4 text-white">
                        <div class="row align-items-center g-3">
                            <div class="col-auto text-center">
                                <div class="d-inline-flex align-items-center justify-content-center bg-white text-primary rounded-circle shadow-sm" style="width: 52px; height: 52px;">
                                    <span class="fs-4 fw-bolder">#{{ $myRank['rank'] }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <span class="badge px-2 py-0.5 rounded-pill small mb-1 fw-bold" style="background: rgba(255,255,255,0.2); font-size: 0.68rem; letter-spacing: 0.5px;">
                                    POSISI SAYA
                                </span>
                                <h5 class="fw-bold mb-0 text-white">{{ $myRank['name'] }} <span class="small fw-normal opacity-75">(Kamu)</span></h5>
                                <span class="opacity-75 small" style="font-size: 0.78rem;">
                                    Peringkat <strong>#{{ $myRank['rank'] }}</strong> dari <strong>{{ $totalParticipants }}</strong> peserta ujian
                                </span>
                            </div>
                            <div class="col-12 col-md-auto d-flex flex-wrap justify-content-start justify-content-md-end gap-2">
                                <div class="bg-white rounded-3 px-3 py-1.5 text-dark shadow-xs text-center flex-fill flex-md-grow-0" style="min-width: 90px;">
                                    <span class="small text-muted d-block" style="font-size: 0.68rem;">TOTAL SKOR</span>
                                    <strong class="fs-5 text-primary lh-1">{{ $myRank['total'] }}</strong>
                                </div>
                                <div class="bg-white rounded-3 px-3 py-1.5 text-dark shadow-xs text-center flex-fill flex-md-grow-0" style="min-width: 100px;">
                                    <span class="small text-muted d-block" style="font-size: 0.68rem;">STATUS SKD</span>
                                    @if ($myRank['is_passed'])
                                        <span class="badge bg-success text-white fw-bold small px-2 py-0.5">Lolos PG</span>
                                    @else
                                        <span class="badge bg-danger text-white fw-bold small px-2 py-0.5">Tidak Lolos</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info border-0 shadow-sm rounded-4 d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4 p-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fe fe-info fs-4 text-info flex-shrink-0"></i>
                        <span class="small">Anda belum memiliki riwayat ujian yang selesai. Ikuti tryout untuk melihat posisi peringkat nasional Anda!</span>
                    </div>
                    <a href="{{ route('ujian.persiapan', 1) }}" class="btn btn-sm btn-primary rounded-pill px-3 py-1.5 fw-bold shadow-xs">
                        Mulai Tryout Sekarang <i class="fe fe-arrow-right ms-1"></i>
                    </a>
                </div>
            @endif

            <!-- 3 Podium Juara Teratas -->
            @php
                $topRankings = array_slice($rankings, 0, 3);
            @endphp
            <div class="row g-3 mb-4">
                @foreach ($topRankings as $index => $item)
                    @php
                        $isFirst = $index === 0;
                        $isSecond = $index === 1;
                        $isThird = $index === 2;
                    @endphp
                    <div class="col-md-4 col-12">
                        <div class="card h-100 rounded-4 {{ $isFirst ? 'border-primary border-2 shadow' : 'border-0 shadow-sm bg-white' }} text-center">
                            <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="display-5 mb-2">{{ $isFirst ? '🥇' : ($isSecond ? '🥈' : '🥉') }}</div>
                                    <h5 class="mb-1 text-dark {{ $isFirst ? 'fw-bold' : 'fw-semibold' }}">{{ $item['name'] }}</h5>
                                    <div class="mb-2">
                                        <span class="fs-4 fw-bolder text-primary">{{ $item['total'] }}</span>
                                        <span class="text-muted small">Poin</span>
                                    </div>
                                    <div class="d-flex justify-content-center gap-2 small text-muted mb-3" style="font-size: 0.76rem;">
                                        <span>TWK: <strong>{{ $item['twk'] }}</strong></span>
                                        <span>•</span>
                                        <span>TIU: <strong>{{ $item['tiu'] }}</strong></span>
                                        <span>•</span>
                                        <span>TKP: <strong>{{ $item['tkp'] }}</strong></span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-1.5 flex-wrap">
                                    @if ($isFirst)
                                        <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill fw-bold small">Juara 1</span>
                                    @elseif ($isSecond)
                                        <span class="badge bg-secondary text-white px-2.5 py-1 rounded-pill fw-bold small">Peringkat 2</span>
                                    @else
                                        <span class="badge text-white px-2.5 py-1 rounded-pill fw-bold small" style="background-color: #cd7f32;">Peringkat 3</span>
                                    @endif

                                    @if ($item['is_passed'])
                                        <span class="badge bg-success-subtle text-success border border-success rounded-pill px-2 py-1 small fw-bold">Lolos PG</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger rounded-pill px-2 py-1 small fw-bold">Belum PG</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if (count($topRankings) === 0)
                    <div class="col-12">
                        <div class="alert alert-light border shadow-sm text-center py-4 mb-0 rounded-4">
                            <i class="fe fe-inbox fs-2 text-muted d-block mb-2"></i>
                            <span class="text-muted">Belum ada peserta yang menyelesaikan simulasi tryout ini.</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Tabel Peringkat Lengkap -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-white">
                        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 fw-bold text-dark"><i class="fe fe-list text-primary me-2"></i>Daftar Peringkat Lengkap</h5>
                            <span class="text-muted small">Passing Grade: TWK 65 | TIU 80 | TKP 166</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3 py-3" style="width: 70px;">Rank</th>
                                        <th class="py-3">Nama Peserta</th>
                                        <th class="text-center py-3">TWK</th>
                                        <th class="text-center py-3">TIU</th>
                                        <th class="text-center py-3">TKP</th>
                                        <th class="text-center py-3">Total Skor</th>
                                        <th class="text-center py-3">Status SKD</th>
                                        <th class="text-center pe-3 py-3">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($rankings as $row)
                                        @php
                                            $isMe = ($row['user_id'] === auth()->id());
                                        @endphp
                                        <tr class="{{ $isMe ? 'table-warning fw-medium' : '' }}">
                                            <td class="ps-3 fw-bold">
                                                @if ($row['rank'] === 1)
                                                    <span class="badge bg-warning text-dark rounded-circle p-2">🥇 1</span>
                                                @elseif ($row['rank'] === 2)
                                                    <span class="badge bg-secondary text-white rounded-circle p-2">🥈 2</span>
                                                @elseif ($row['rank'] === 3)
                                                    <span class="badge text-white rounded-circle p-2" style="background-color: #cd7f32;">🥉 3</span>
                                                @else
                                                    <span class="text-muted ms-1">#{{ $row['rank'] }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($row['name']) }}&background=1e40af&color=fff&size=64"
                                                            class="rounded-circle" width="32" height="32" alt="{{ $row['name'] }}">
                                                    </div>
                                                    <div>
                                                        <span class="text-dark fw-bold">{{ $row['name'] }}</span>
                                                        @if ($isMe)
                                                            <span class="badge bg-primary text-white rounded-pill px-2 py-0.5 ms-1 small">Kamu</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="{{ $row['twk'] >= 65 ? 'text-success fw-bold' : 'text-danger' }}">
                                                    {{ $row['twk'] }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="{{ $row['tiu'] >= 80 ? 'text-success fw-bold' : 'text-danger' }}">
                                                    {{ $row['tiu'] }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="{{ $row['tkp'] >= 166 ? 'text-success fw-bold' : 'text-danger' }}">
                                                    {{ $row['tkp'] }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="fs-6 fw-bolder text-primary">{{ $row['total'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if ($row['is_passed'])
                                                    <span class="badge bg-success-subtle text-success border border-success rounded-pill px-2.5 py-1 small fw-bold">
                                                        <i class="fe fe-check-circle me-1"></i>Lolos PG
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger border border-danger rounded-pill px-2.5 py-1 small fw-bold">
                                                        <i class="fe fe-x-circle me-1"></i>Tidak Lolos
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center pe-3 text-muted small">
                                                <i class="fe fe-clock me-1"></i>{{ $row['time'] }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">
                                                Belum ada data peringkat yang tersedia saat ini.
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

    <!-- Scroll top -->
    @include('partials.btn-scroll-top')
    <!-- Scripts -->
    @include('partials.scripts')
    <script src="assets/js/vendors/tnsSlider.js"></script>
    <script src="assets/js/vendors/chart.js"></script>
    <script src="assets/js/vendors/navbar-nav.js"></script>
</body>

</html>
