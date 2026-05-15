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
              <div class="card">
                <div class="card-body d-flex flex-column gap-3">
                  <div class="d-flex align-items-center justify-content-between lh-1">
                    <div>
                      <span class="fs-6 text-uppercase fw-semibold ls-md">Total User</span>
                    </div>
                    <div>
                      <span class="fe fe-users fs-3 text-primary"></span>
                    </div>
                  </div>
                  <div class="d-flex flex-column gap-1">
                    <h2 class="fw-bold mb-0">{{ $totalUsers }}</h2>
                    <span class="fw-medium small text-muted">Semua akun terdaftar</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
              <div class="card">
                <div class="card-body d-flex flex-column gap-3">
                  <div class="d-flex align-items-center justify-content-between lh-1">
                    <div>
                      <span class="fs-6 text-uppercase fw-semibold ls-md">Pendapatan Bulan Ini</span>
                    </div>
                    <div>
                      <span class="fe fe-dollar-sign fs-3 text-success"></span>
                    </div>
                  </div>
                  <div class="d-flex flex-column gap-1">
                    <h2 class="fw-bold mb-0">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</h2>
                    <span class="fw-medium small text-muted">Hanya pembayaran lunas</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
              <div class="card">
                <div class="card-body d-flex flex-column gap-3">
                  <div class="d-flex align-items-center justify-content-between lh-1">
                    <div>
                      <span class="fs-6 text-uppercase fw-semibold ls-md">Total Soal</span>
                    </div>
                    <div>
                      <span class="fe fe-file-text fs-3 text-warning"></span>
                    </div>
                  </div>
                  <div class="d-flex flex-column gap-1">
                    <h2 class="fw-bold mb-0">{{ $totalQuestions }}</h2>
                    <span class="fw-medium small text-muted">Semua soal dalam bank soal</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12">
              <div class="card">
                <div class="card-body d-flex flex-column gap-3">
                  <div class="d-flex align-items-center justify-content-between lh-1">
                    <div>
                      <span class="fs-6 text-uppercase fw-semibold ls-md">User Sedang Online</span>
                    </div>
                    <div>
                      <span class="fe fe-circle fs-3 text-info"></span>
                    </div>
                  </div>
                  <div class="d-flex flex-column gap-1">
                    <h2 class="fw-bold mb-0">{{ $onlineUsers }}</h2>
                    <span class="fw-medium small text-muted">Aktif dalam 15 menit terakhir</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="mb-3">Akses Cepat</h5>
                  <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">Kelola Peserta</a>
                    <a href="{{ route('admin.list-bank-soal') }}" class="btn btn-outline-secondary">Bank Soal</a>
                    <a href="{{ route('admin.create-tryout') }}" class="btn btn-outline-warning">Tryout</a>
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-success">Transaksi</a>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-info">Laporan</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>

    @include('partials.scripts')
  </body>
</html>
