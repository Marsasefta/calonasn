<!doctype html>
<html lang="id">

<head>
    @include('partials.head')
    <link href="/build/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="/build/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
    <title>Zona Refreshing (Flappy ASN) | Admin CalonASN.id</title>
</head>

<body>
    <div id="db-wrapper">
        @include('partials.navbar-vertical')

        <main id="page-content">
            @include('partials.dashboard-header')

            <section class="container-fluid p-3 p-md-4">
                <div class="row mb-4">
                    <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h1 class="mb-1 h2 fw-bold">🎮 Zona Refreshing (Flappy ASN)</h1>
                            <p class="text-muted mb-0">
                                Pantau skor &amp; aktivitas game refreshing peserta. Trial user gratis: <strong>{{ $trialSeconds }} detik &times; {{ $trialDailyLimit }}x/hari</strong>; peserta berbayar unlimited + masuk leaderboard.
                            </p>
                        </div>

                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <a href="{{ route('game.index') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary btn-sm fw-semibold">
                                <i class="fe fe-external-link me-1"></i> Buka Halaman Game
                            </a>

                            @if ($totalPlayers > 0)
                                <form action="{{ route('admin.game.reset-all') }}" method="POST" id="resetAllGameScoresForm" class="mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm fw-semibold">
                                        <i class="fe fe-trash-2 me-1"></i> Reset Semua Skor
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- 4 Kartu Statistik -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold text-uppercase">Pemain Terdaftar</span>
                                <h3 class="fw-bolder mb-0 mt-1 text-dark">{{ number_format($totalPlayers, 0, ',', '.') }}</h3>
                                <small class="text-muted">Peserta berbayar dengan skor</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold text-uppercase">Total Ronde Dimainkan</span>
                                <h3 class="fw-bolder mb-0 mt-1 text-primary">{{ number_format($totalGamesPlayed, 0, ',', '.') }}</h3>
                                <small class="text-muted">Akumulasi ronde leaderboard</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold text-uppercase">Skor Tertinggi</span>
                                <h3 class="fw-bolder mb-0 mt-1 text-warning">{{ number_format($highestScore, 0, ',', '.') }} <span class="fs-6 fw-normal text-muted">pts</span></h3>
                                <small class="text-muted text-truncate d-block">Pemegang: {{ $topPlayerName }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <span class="text-muted small fw-semibold text-uppercase">Rata-Rata Best Score</span>
                                <h3 class="fw-bolder mb-0 mt-1 text-success">{{ $avgBestScore }} <span class="fs-6 fw-normal text-muted">pts</span></h3>
                                <small class="text-muted">Dari {{ $totalPlayers }} pemain</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Leaderboard & Pantauan -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive p-3">
                            <table class="table table-bordered table-hover table-striped align-middle" id="admin-game-table" style="width: 100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Rank</th>
                                        <th>Peserta</th>
                                        <th>Paket</th>
                                        <th>Skor Terbaik</th>
                                        <th>Total Main</th>
                                        <th>Terakhir Main</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scores as $index => $row)
                                        @php
                                            $user = $row->user;
                                            $rank = $index + 1;
                                        @endphp
                                        <tr>
                                            <td data-order="{{ $rank }}">
                                                @if ($rank === 1)
                                                    <span class="badge bg-warning text-dark rounded-pill px-2.5">🥇 #1</span>
                                                @elseif ($rank === 2)
                                                    <span class="badge bg-secondary text-white rounded-pill px-2.5">🥈 #2</span>
                                                @elseif ($rank === 3)
                                                    <span class="badge bg-danger text-white rounded-pill px-2.5">🥉 #3</span>
                                                @else
                                                    <span class="fw-semibold">#{{ $rank }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $user?->name ?? 'User Terhapus' }}</div>
                                                <div class="small text-muted">
                                                    {{ $user?->email ?? '-' }}
                                                    @if ($user)
                                                        &bull; Tampil: <strong>{{ $user->maskedName() }}</strong>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                    {{ $user?->package_label ?? '-' }}
                                                </span>
                                            </td>
                                            <td data-order="{{ $row->best_score }}">
                                                <span class="badge bg-success-subtle text-success fw-bold px-3 py-2">
                                                    {{ $row->best_score }} pts
                                                </span>
                                            </td>
                                            <td data-order="{{ $row->games_played }}">{{ $row->games_played }}x</td>
                                            <td data-order="{{ $row->updated_at->timestamp }}">{{ $row->updated_at->format('d M Y H:i') }}</td>
                                            <td class="text-end">
                                                <form action="{{ route('admin.game.destroy', $row->id) }}" method="POST" class="delete-game-score-form mb-0 d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger text-nowrap" data-player="{{ $user?->name ?? 'Peserta' }}">
                                                        <i class="fe fe-trash-2 me-1"></i> Hapus
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
    <script src="/build/assets/plugins/datatables.net/js/dataTables.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/build/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.jQuery && $.fn.DataTable) {
                $('#admin-game-table').DataTable({
                    responsive: false,
                    scrollX: true,
                    autoWidth: false,
                    pageLength: 15,
                    columnDefs: [
                        { orderable: false, targets: [6] },
                        { searchable: false, targets: [6] }
                    ],
                    order: [[3, 'desc']],
                    language: {
                        search: 'Cari:',
                        lengthMenu: 'Tampilkan _MENU_ baris',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ pemain',
                        infoEmpty: 'Menampilkan 0 sampai 0 dari 0 pemain',
                        emptyTable: 'Belum ada peserta yang mencatat skor di Zona Refreshing.',
                        zeroRecords: 'Tidak ditemukan data yang sesuai',
                        paginate: { previous: 'Sebelumnya', next: 'Berikutnya' }
                    }
                });
            }

            document.addEventListener('submit', function (e) {
                const singleForm = e.target.closest('.delete-game-score-form');
                if (singleForm) {
                    e.preventDefault();
                    const btn = singleForm.querySelector('button[data-player]');
                    const playerName = btn ? btn.getAttribute('data-player') : 'peserta ini';
                    Swal.fire({
                        title: 'Hapus Skor Peserta?',
                        text: `Skor leaderboard milik ${playerName} akan dihapus permanen.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal'
                    }).then(function (result) {
                        if (result.isConfirmed) singleForm.submit();
                    });
                    return;
                }

                const resetForm = e.target.closest('#resetAllGameScoresForm');
                if (resetForm) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Reset Semua Leaderboard?',
                        text: 'Seluruh data skor Flappy ASN semua peserta akan dihapus permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        confirmButtonText: 'Ya, reset semua',
                        cancelButtonText: 'Batal'
                    }).then(function (result) {
                        if (result.isConfirmed) resetForm.submit();
                    });
                }
            });
        });
    </script>
</body>

</html>
