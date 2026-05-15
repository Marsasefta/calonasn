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
      
      <!-- Page Content -->
      <main id="page-content">
        @include('partials.dashboard-header')

        <!-- Page Header -->
        <!-- Container fluid -->
        <section class="container-fluid p-4">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
              <div class="border-bottom pb-3 mb-3 d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-lg-center">
                <div>
                  <h1 class="mb-0 h2 fw-bold">Dashboard Admin</h1>
                </div>
              </div>
            </div>
          </div>

          <!-- Statistik Utama -->
          <div class="row gy-4 mb-4">
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
              <!-- Card -->
              <div class="card">
                <!-- Card body -->
                <div class="card-body d-flex flex-column gap-3">
                  <div class="d-flex align-items-center justify-content-between lh-1">
                    <div>
                      <span class="fs-6 text-uppercase fw-semibold ls-md">Total Revenue</span>
                    </div>
                    <div>
                      <span class="fe fe-shopping-bag fs-3 text-success"></span>
                    </div>
                  </div>
                  <div class="d-flex flex-column gap-1">
                    <h2 class="fw-bold mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                    <div class="d-flex flex-row gap-2">
                      <span class="text-success fw-semibold">
                        <i class="fe fe-trending-up me-1"></i>
                        +15.5%
                      </span>
                      <span class="fw-medium">vs bulan lalu</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
              <!-- Card -->
              <div class="card">
                <!-- Card body -->
                <div class="card-body d-flex flex-column gap-3">
                  <div class="d-flex align-items-center justify-content-between lh-1">
                    <div>
                      <span class="fs-6 text-uppercase fw-semibold ls-md">Pending</span>
                    </div>
                    <div>
                      <span class="fe fe-clock fs-3 text-warning"></span>
                    </div>
                  </div>
                  <div class="d-flex flex-column gap-1">
                    <h2 class="fw-bold mb-0">Rp {{ number_format($pendingRevenue, 0, ',', '.') }}</h2>
                    <div class="d-flex flex-row gap-2">
                      <span class="fw-medium text-warning">Menunggu konfirmasi</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
              <!-- Card -->
              <div class="card">
                <!-- Card body -->
                <div class="card-body d-flex flex-column gap-3">
                  <div class="d-flex align-items-center justify-content-between lh-1">
                    <div>
                      <span class="fs-6 text-uppercase fw-semibold ls-md">Transaksi</span>
                    </div>
                    <div>
                      <span class="fe fe-activity fs-3 text-primary"></span>
                    </div>
                  </div>
                  <div class="d-flex flex-column gap-1">
                    <h2 class="fw-bold mb-0">{{ $totalTransactions }}</h2>
                    <div class="d-flex flex-row gap-2">
                      <span class="text-success fw-semibold">{{ $successfulTransactions }} berhasil</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
              <!-- Card -->
              <div class="card">
                <!-- Card body -->
                <div class="card-body d-flex flex-column gap-3">
                  <div class="d-flex align-items-center justify-content-between lh-1">
                    <div>
                      <span class="fs-6 text-uppercase fw-semibold ls-md">Peserta Aktif</span>
                    </div>
                    <div>
                      <span class="fe fe-users fs-3 text-info"></span>
                    </div>
                  </div>
                  <div class="d-flex flex-column gap-1">
                    <h2 class="fw-bold mb-0">{{ count($leaderboard) }}</h2>
                    <div class="d-flex flex-row gap-1">
                      <span class="fw-medium">Peserta aktif bulan ini</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Leaderboard Section -->
          <div class="row mb-4">
            <div class="col-12">
              <div class="card">
                <div class="card-header bg-light d-flex align-items-center justify-content-between">
                  <h5 class="mb-0 fw-bold">
                    <i class="fe fe-award text-warning me-2"></i>
                    Leaderboard - Top Skor Peserta
                  </h5>
                  <a href="/admin/user_type" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover mb-0">
                    <thead class="table-light">
                      <tr>
                        <th class="text-center" style="width: 50px;">Rank</th>
                        <th>Nama Peserta</th>
                        <th class="text-center">Skor</th>
                        <th class="text-center">Percobaan</th>
                        <th class="text-center">Tanggal</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($leaderboard as $item)
                        <tr>
                          <td class="text-center">
                            @if($item['rank'] == 1)
                              <span class="badge bg-warning text-dark rounded-circle p-2" style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fe fe-award fs-5"></i>
                              </span>
                            @elseif($item['rank'] == 2)
                              <span class="badge bg-secondary rounded-circle p-2" style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;">
                                🥈
                              </span>
                            @elseif($item['rank'] == 3)
                              <span class="badge bg-info rounded-circle p-2" style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;">
                                🥉
                              </span>
                            @else
                              <span class="badge bg-light text-dark">{{ $item['rank'] }}</span>
                            @endif
                          </td>
                          <td>
                            <div class="d-flex align-items-center gap-2">
                              <div class="avatar avatar-sm rounded-circle bg-primary-light">
                                <span class="avatar-initials rounded-circle fw-bold text-primary">
                                  {{ strtoupper(substr($item['name'], 0, 1)) }}
                                </span>
                              </div>
                              <span class="fw-medium">{{ $item['name'] }}</span>
                            </div>
                          </td>
                          <td class="text-center">
                            <span class="badge bg-success">{{ $item['score'] }}</span>
                          </td>
                          <td class="text-center">
                            <span class="text-muted">{{ $item['attempts'] }}x</span>
                          </td>
                          <td class="text-center">
                            <span class="text-muted small">{{ $item['date'] }}</span>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Financial Dashboard Section -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header bg-light d-flex align-items-center justify-content-between">
                  <h5 class="mb-0 fw-bold">
                    <i class="fe fe-credit-card text-primary me-2"></i>
                    Dashboard Finansial - Transaksi Midtrans
                  </h5>
                  <div>
                    <button class="btn btn-sm btn-outline-secondary me-2">Export</button>
                    <button class="btn btn-sm btn-outline-primary">Filter</button>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover mb-0">
                    <thead class="table-light">
                      <tr>
                        <th>ID Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Email</th>
                        <th class="text-end">Jumlah</th>
                        <th class="text-center">Status</th>
                        <th>Metode Pembayaran</th>
                        <th>Tanggal & Waktu</th>
                        <th class="text-end">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($transactions as $txn)
                        <tr>
                          <td>
                            <span class="fw-medium text-primary">{{ $txn['id'] }}</span>
                          </td>
                          <td>{{ $txn['customer'] }}</td>
                          <td>
                            <span class="text-muted small">{{ $txn['email'] }}</span>
                          </td>
                          <td class="text-end">
                            <span class="fw-bold">Rp {{ number_format($txn['amount'], 0, ',', '.') }}</span>
                          </td>
                          <td class="text-center">
                            @if($txn['status'] == 'settlement')
                              <span class="badge bg-success">
                                <i class="fe fe-check-circle me-1"></i>Berhasil
                              </span>
                            @elseif($txn['status'] == 'pending')
                              <span class="badge bg-warning">
                                <i class="fe fe-clock me-1"></i>Menunggu
                              </span>
                            @elseif($txn['status'] == 'expired')
                              <span class="badge bg-danger">
                                <i class="fe fe-x-circle me-1"></i>Expired
                              </span>
                            @else
                              <span class="badge bg-secondary">{{ ucfirst($txn['status']) }}</span>
                            @endif
                          </td>
                          <td>
                            @if($txn['method'] == 'Bank Transfer')
                              <span class="text-muted"><i class="fe fe-dollar-sign me-1"></i>{{ $txn['method'] }}</span>
                            @elseif($txn['method'] == 'Credit Card')
                              <span class="text-muted"><i class="fe fe-credit-card me-1"></i>{{ $txn['method'] }}</span>
                            @elseif($txn['method'] == 'E-Wallet')
                              <span class="text-muted"><i class="fe fe-smartphone me-1"></i>{{ $txn['method'] }}</span>
                            @endif
                          </td>
                          <td>
                            <span class="text-muted small">{{ $txn['date'] }}</span>
                          </td>
                          <td class="text-end">
                            <div class="dropdown">
                              <button class="btn btn-sm btn-ghost-secondary" type="button" data-bs-toggle="dropdown">
                                <i class="fe fe-more-vertical"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">
                                  <i class="fe fe-eye me-2"></i>Detail
                                </a>
                                <a class="dropdown-item" href="#">
                                  <i class="fe fe-download me-2"></i>Invoice
                                </a>
                                @if($txn['status'] != 'settlement')
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item text-danger" href="#">
                                    <i class="fe fe-trash-2 me-2"></i>Batalkan
                                  </a>
                                @endif
                              </div>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="card-footer">
                  <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted small">Menampilkan {{ count($transactions) }} dari {{ count($transactions) }} transaksi</span>
                    <nav aria-label="Page navigation">
                      <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">Selanjutnya</a></li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>

    <!-- Script -->

    @include('partials.scripts')

    <script src="assets/js/vendors/chart.js"></script>
    <script src="assets/js/vendors/flatpickr.js"></script>
  </body>
</html>
