<!doctype html>
<html lang="en">
  <head>
     @include('partials.head')
  </head>

  <body>
    <!-- Wrapper -->
    <div id="db-wrapper">
      <!-- navbar vertical -->
    @include('partials.navbar-vertical')

    <style>
      /* ── Dashboard Override: force content to respect sidebar ── */
      #page-content .container-fluid { max-width: 100%; overflow-x: hidden; }

      /* ── Icon Wrappers ── */
      .dash-icon{width:48px;height:48px;border-radius:12px;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0}
      .dash-icon-sm{width:40px;height:40px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0}
      .ic-blue{background:linear-gradient(135deg,#4f46e5,#06b6d4);color:#fff}
      .ic-green{background:linear-gradient(135deg,#10b981,#34d399);color:#fff}
      .ic-yellow{background:linear-gradient(135deg,#f59e0b,#f97316);color:#fff}
      .ic-teal{background:linear-gradient(135deg,#0ea5a4,#06b6d4);color:#fff}
      .ic-purple{background:linear-gradient(135deg,#8b5cf6,#a78bfa);color:#fff}
      .ic-rose{background:linear-gradient(135deg,#f43f5e,#fb7185);color:#fff}
      .ic-indigo{background:linear-gradient(135deg,#6366f1,#818cf8);color:#fff}
      .ic-cyan{background:linear-gradient(135deg,#06b6d4,#22d3ee);color:#fff}
      .ic-amber{background:linear-gradient(135deg,#d97706,#fbbf24);color:#fff}

      /* ── Stat Cards ── */
      .dash-card{border:none;border-radius:14px;transition:transform .15s ease,box-shadow .15s ease;overflow:hidden}
      .dash-card:hover{transform:translateY(-3px);box-shadow:0 12px 28px rgba(22,28,45,0.08)!important}
      .trend-up{color:#10b981;font-weight:600;font-size:12px}
      .trend-down{color:#ef4444;font-weight:600;font-size:12px}

      /* ── Chart Cards ── */
      .dash-chart{border:none;border-radius:14px;overflow:hidden}

      /* ── Table Cards ── */
      .dash-table{border:none;border-radius:14px;overflow:hidden}
      .dash-table .table{margin-bottom:0}
      .dash-table .table thead th{border-top:none;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:#64748b;font-weight:700;background:#f8fafc;padding:.75rem 1rem}
      .dash-table .table tbody td{padding:.75rem 1rem;vertical-align:middle;font-size:13.5px}

      /* ── Badges ── */
      .badge-status{font-size:11px;font-weight:600;padding:4px 10px;border-radius:6px}
      .badge-success-soft{background:rgba(16,185,129,0.1);color:#10b981}
      .badge-warning-soft{background:rgba(245,158,11,0.1);color:#d97706}
      .badge-danger-soft{background:rgba(239,68,68,0.1);color:#ef4444}
      .badge-info-soft{background:rgba(59,130,246,0.1);color:#3b82f6}

      /* ── Operational Mini Cards ── */
      .dash-op{border:none;border-radius:14px;transition:transform .15s ease,box-shadow .15s ease;overflow:hidden}
      .dash-op:hover{transform:translateY(-3px);box-shadow:0 12px 28px rgba(22,28,45,0.08)!important}
      .dash-op .op-val{font-size:28px;font-weight:800;line-height:1}
      .dash-op .op-lbl{font-size:12px;color:#64748b;text-transform:uppercase;letter-spacing:.5px;font-weight:600}
    </style>

      <!-- Page Content -->
      <main id="page-content">
        @include('partials.dashboard-header')

        <!-- Container fluid -->
        <section class="container-fluid p-4">

          {{-- ── Header ── --}}
          <div class="border-bottom pb-3 mb-4 d-md-flex justify-content-between align-items-center">
            <div>
              <h1 class="mb-0 h2 fw-bold">Dashboard Admin</h1>
              <p class="text-muted mb-0 mt-1">Selamat datang kembali! Berikut ringkasan data terbaru.</p>
            </div>
            <div class="mt-2 mt-md-0">
              <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                <i class="fe fe-calendar me-1"></i> {{ now()->translatedFormat('l, d F Y') }}
              </span>
            </div>
          </div>

          {{-- ══════════════════════════════════════════════ --}}
          {{-- BARIS 1: 4 Stat Cards                          --}}
          {{-- ══════════════════════════════════════════════ --}}
          <div class="row g-3 mb-4">
            {{-- Total User --}}
            <div class="col-sm-6 col-xl-3">
              <div class="card dash-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center p-3">
                  <div class="dash-icon ic-blue me-3">
                    <span class="fe fe-users" style="font-size:20px"></span>
                  </div>
                  <div style="min-width:0">
                    <div class="text-uppercase text-muted text-truncate" style="font-size:.7rem">Total User</div>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalUsers) }}</h4>
                    <div class="text-truncate {{ $userChange >= 0 ? 'trend-up' : 'trend-down' }}">
                      <i class="fe fe-trending-{{ $userChange >= 0 ? 'up' : 'down' }}"></i>
                      {{ $userChange >= 0 ? '+' : '' }}{{ $userChange }}% bln lalu
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- Pendapatan --}}
            <div class="col-sm-6 col-xl-3">
              <div class="card dash-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center p-3">
                  <div class="dash-icon ic-green me-3">
                    <span class="fe fe-dollar-sign" style="font-size:20px"></span>
                  </div>
                  <div style="min-width:0">
                    <div class="text-uppercase text-muted text-truncate" style="font-size:.7rem">Pendapatan Bulan Ini</div>
                    <h4 class="mb-0 fw-bold text-truncate">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</h4>
                    <div class="text-truncate {{ $revenueChange >= 0 ? 'trend-up' : 'trend-down' }}">
                      <i class="fe fe-trending-{{ $revenueChange >= 0 ? 'up' : 'down' }}"></i>
                      {{ $revenueChange >= 0 ? '+' : '' }}{{ $revenueChange }}% bln lalu
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- Total Soal --}}
            <div class="col-sm-6 col-xl-3">
              <div class="card dash-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center p-3">
                  <div class="dash-icon ic-yellow me-3">
                    <span class="fe fe-file-text" style="font-size:20px"></span>
                  </div>
                  <div style="min-width:0">
                    <div class="text-uppercase text-muted text-truncate" style="font-size:.7rem">Total Soal</div>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalQuestions) }}</h4>
                    <div class="text-muted text-truncate" style="font-size:.7rem">Semua bank soal</div>
                  </div>
                </div>
              </div>
            </div>

            {{-- Pendaftar Tryout --}}
            <div class="col-sm-6 col-xl-3">
              <div class="card dash-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center p-3">
                  <div class="dash-icon ic-teal me-3">
                    <span class="fe fe-user-plus" style="font-size:20px"></span>
                  </div>
                  <div style="min-width:0">
                    <div class="text-uppercase text-muted text-truncate" style="font-size:.7rem">Pendaftar Bulan Ini</div>
                    <h4 class="mb-0 fw-bold">{{ number_format($registrationsThisMonth) }}</h4>
                    <div class="text-muted text-truncate" style="font-size:.7rem">Sudah bayar: <strong>{{ $paidRegistrationsThisMonth }}</strong></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- ══════════════════════════════════════════════ --}}
          {{-- BARIS 2: 2 Charts (full width, stacked)        --}}
          {{-- ══════════════════════════════════════════════ --}}
          <div class="row g-3 mb-4">
            {{-- Grafik Pendapatan --}}
            <div class="col-12">
              <div class="card dash-chart shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h5 class="fw-bold mb-0">Pendapatan Bulanan</h5>
                      <small class="text-muted">6 bulan terakhir (transaksi lunas)</small>
                    </div>
                    <div class="dash-icon-sm ic-green">
                      <span class="fe fe-trending-up" style="font-size:16px"></span>
                    </div>
                  </div>
                </div>
                <div class="card-body px-4 pb-4">
                  <canvas id="revenueChart" height="220"></canvas>
                </div>
              </div>
            </div>

            {{-- Grafik User --}}
            <div class="col-12">
              <div class="card dash-chart shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h5 class="fw-bold mb-0">Pertumbuhan User Baru</h5>
                      <small class="text-muted">30 hari terakhir</small>
                    </div>
                    <div class="dash-icon-sm ic-blue">
                      <span class="fe fe-user-plus" style="font-size:16px"></span>
                    </div>
                  </div>
                </div>
                <div class="card-body px-4 pb-4">
                  <canvas id="userChart" height="180"></canvas>
                </div>
              </div>
            </div>
          </div>

          {{-- ══════════════════════════════════════════════ --}}
          {{-- BARIS 3: Transaksi Terbaru (full width)        --}}
          {{-- ══════════════════════════════════════════════ --}}
          <div class="card dash-table shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
              <div>
                <h5 class="fw-bold mb-0">Transaksi Terbaru</h5>
                <small class="text-muted">5 transaksi terakhir masuk</small>
              </div>
              <a href="{{ route('admin.transactions.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                Lihat Semua <i class="fe fe-arrow-right ms-1"></i>
              </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive">
                <table class="table table-hover text-nowrap mb-0">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>Paket</th>
                      <th>Jumlah</th>
                      <th>Status</th>
                      <th>Tanggal</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($latestTransactions as $trx)
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <img src="https://ui-avatars.com/api/?name={{ urlencode($trx->user->name ?? '-') }}&background=random&color=fff&size=32&bold=true&rounded=true" alt="" width="32" height="32" class="rounded-circle">
                          <span class="fw-semibold" style="font-size:13px">{{ $trx->user->name ?? '-' }}</span>
                        </div>
                      </td>
                      <td>{{ $trx->tryout->title ?? '-' }}</td>
                      <td class="fw-semibold">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                      <td>
                        @php
                          $statusClass = match(strtolower($trx->status)) {
                            'success' => 'badge-success-soft',
                            'verifying' => 'badge-warning-soft',
                            'pending' => 'badge-info-soft',
                            default => 'badge-danger-soft',
                          };
                          $statusLabel = match(strtolower($trx->status)) {
                            'success' => 'Lunas',
                            'verifying' => 'Verifikasi',
                            'pending' => 'Pending',
                            default => ucfirst($trx->status),
                          };
                        @endphp
                        <span class="badge badge-status {{ $statusClass }}">{{ $statusLabel }}</span>
                      </td>
                      <td><small class="text-muted">{{ $trx->created_at->format('d M Y') }}</small></td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="5" class="text-center text-muted py-4">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          {{-- ══════════════════════════════════════════════ --}}
          {{-- BARIS 4: User Terbaru (full width)             --}}
          {{-- ══════════════════════════════════════════════ --}}
          <div class="card dash-table shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
              <div>
                <h5 class="fw-bold mb-0">User Terbaru</h5>
                <small class="text-muted">5 pendaftaran terakhir</small>
              </div>
              <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                Lihat Semua <i class="fe fe-arrow-right ms-1"></i>
              </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive">
                <table class="table table-hover text-nowrap mb-0">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>Email</th>
                      <th>Bergabung</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($latestUsers as $u)
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=random&color=fff&size=32&bold=true&rounded=true" alt="" width="32" height="32" class="rounded-circle">
                          <span class="fw-semibold" style="font-size:13px">{{ $u->name }}</span>
                        </div>
                      </td>
                      <td><small class="text-muted">{{ $u->email }}</small></td>
                      <td><small class="text-muted">{{ $u->created_at->diffForHumans() }}</small></td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="3" class="text-center text-muted py-4">Belum ada user</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          {{-- ══════════════════════════════════════════════ --}}
          {{-- BARIS 5: Ringkasan Operasional                 --}}
          {{-- ══════════════════════════════════════════════ --}}
          <div class="mb-3">
            <h6 class="fw-bold text-muted mb-0" style="font-size:13px;letter-spacing:.5px;text-transform:uppercase">
              <i class="fe fe-activity me-1"></i> Ringkasan Operasional
            </h6>
          </div>
          <div class="row g-3 mb-4">
            {{-- Menunggu Verifikasi --}}
            <div class="col-6 col-md-4 col-xl-2">
              <div class="card dash-op shadow-sm h-100">
                <div class="card-body text-center py-4">
                  <div class="dash-icon ic-rose mx-auto mb-3"><span class="fe fe-alert-circle" style="font-size:18px"></span></div>
                  <div class="op-val {{ $pendingVerifications > 0 ? 'text-danger' : '' }}">{{ $pendingVerifications }}</div>
                  <div class="op-lbl mt-1">Verifikasi</div>
                </div>
              </div>
            </div>
            {{-- Tryout Aktif --}}
            <div class="col-6 col-md-4 col-xl-2">
              <div class="card dash-op shadow-sm h-100">
                <div class="card-body text-center py-4">
                  <div class="dash-icon ic-indigo mx-auto mb-3"><span class="fe fe-play-circle" style="font-size:18px"></span></div>
                  <div class="op-val">{{ $activeTryouts }}</div>
                  <div class="op-lbl mt-1">Tryout Aktif</div>
                </div>
              </div>
            </div>
            {{-- User Premium --}}
            <div class="col-6 col-md-4 col-xl-2">
              <div class="card dash-op shadow-sm h-100">
                <div class="card-body text-center py-4">
                  <div class="dash-icon ic-amber mx-auto mb-3"><span class="fe fe-award" style="font-size:18px"></span></div>
                  <div class="op-val">{{ number_format($premiumUsers) }}</div>
                  <div class="op-lbl mt-1">User Premium</div>
                </div>
              </div>
            </div>
            {{-- Sesi Ujian --}}
            <div class="col-6 col-md-4 col-xl-2">
              <div class="card dash-op shadow-sm h-100">
                <div class="card-body text-center py-4">
                  <div class="dash-icon ic-cyan mx-auto mb-3"><span class="fe fe-clipboard" style="font-size:18px"></span></div>
                  <div class="op-val">{{ number_format($totalExamSessions) }}</div>
                  <div class="op-lbl mt-1">Sesi Ujian</div>
                </div>
              </div>
            </div>
            {{-- Artikel --}}
            <div class="col-6 col-md-4 col-xl-2">
              <div class="card dash-op shadow-sm h-100">
                <div class="card-body text-center py-4">
                  <div class="dash-icon ic-purple mx-auto mb-3"><span class="fe fe-edit-3" style="font-size:18px"></span></div>
                  <div class="op-val">{{ $totalPosts }}</div>
                  <div class="op-lbl mt-1">Artikel</div>
                </div>
              </div>
            </div>
            {{-- User Baru --}}
            <div class="col-6 col-md-4 col-xl-2">
              <div class="card dash-op shadow-sm h-100">
                <div class="card-body text-center py-4">
                  <div class="dash-icon ic-teal mx-auto mb-3"><span class="fe fe-user-check" style="font-size:18px"></span></div>
                  <div class="op-val">{{ number_format($newUsersThisMonth) }}</div>
                  <div class="op-lbl mt-1">User Baru</div>
                </div>
              </div>
            </div>
          </div>

        </section>
      </main>
    </div>

    @include('partials.scripts')

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {

      // ─── Grafik Pendapatan Bulanan ───
      const revenueCtx = document.getElementById('revenueChart').getContext('2d');

      new Chart(revenueCtx, {
        type: 'bar',
        data: {
          labels: {!! json_encode($revenueChart->pluck('label')) !!},
          datasets: [{
            label: 'Pendapatan (Rp)',
            data: {!! json_encode($revenueChart->pluck('value')) !!},
            backgroundColor: [
              'rgba(79, 70, 229, 0.15)',
              'rgba(79, 70, 229, 0.2)',
              'rgba(79, 70, 229, 0.25)',
              'rgba(79, 70, 229, 0.35)',
              'rgba(79, 70, 229, 0.5)',
              'rgba(79, 70, 229, 0.85)',
            ],
            borderColor: '#4f46e5',
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              backgroundColor: '#1e293b',
              titleFont: { size: 13 },
              bodyFont: { size: 13 },
              padding: 12,
              cornerRadius: 8,
              callbacks: {
                label: function(ctx) {
                  return 'Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: { color: 'rgba(0,0,0,0.04)' },
              ticks: {
                font: { size: 11 },
                callback: function(v) {
                  if (v >= 1000000) return 'Rp ' + (v/1000000).toFixed(1) + 'jt';
                  if (v >= 1000) return 'Rp ' + (v/1000).toFixed(0) + 'rb';
                  return 'Rp ' + v;
                }
              }
            },
            x: {
              grid: { display: false },
              ticks: { font: { size: 11 } }
            }
          }
        }
      });

      // ─── Grafik User Baru Harian ───
      const userCtx = document.getElementById('userChart').getContext('2d');
      const userGradient = userCtx.createLinearGradient(0, 0, 0, 180);
      userGradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
      userGradient.addColorStop(1, 'rgba(79, 70, 229, 0.01)');

      new Chart(userCtx, {
        type: 'line',
        data: {
          labels: {!! json_encode($userChart->pluck('label')) !!},
          datasets: [{
            label: 'User Baru',
            data: {!! json_encode($userChart->pluck('value')) !!},
            borderColor: '#4f46e5',
            backgroundColor: userGradient,
            borderWidth: 2.5,
            fill: true,
            tension: 0.4,
            pointRadius: 0,
            pointHoverRadius: 6,
            pointHoverBackgroundColor: '#4f46e5',
            pointHoverBorderColor: '#fff',
            pointHoverBorderWidth: 3,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              backgroundColor: '#1e293b',
              titleFont: { size: 13 },
              bodyFont: { size: 13 },
              padding: 12,
              cornerRadius: 8,
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: { color: 'rgba(0,0,0,0.04)' },
              ticks: {
                font: { size: 11 },
                stepSize: 1,
              }
            },
            x: {
              grid: { display: false },
              ticks: {
                font: { size: 10 },
                maxRotation: 0,
                autoSkip: true,
                maxTicksLimit: 10,
              }
            }
          }
        }
      });

    });
    </script>
  </body>
</html>
