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
      .icon-wrapper{width:56px;height:56px;border-radius:12px;display:inline-flex;align-items:center;justify-content:center;box-shadow:0 6px 18px rgba(22,28,45,0.06)}
      .icon-bg-blue{background:linear-gradient(135deg,#4f46e5,#06b6d4);color:#fff}
      .icon-bg-green{background:linear-gradient(135deg,#10b981,#34d399);color:#fff}
      .icon-bg-yellow{background:linear-gradient(135deg,#f59e0b,#f97316);color:#fff}
      .icon-bg-teal{background:linear-gradient(135deg,#0ea5a4,#06b6d4);color:#fff}
      .stat-card .card-body{padding:1rem 1.25rem}
      .quick-btn{border-radius:999px}
      .quick-action{display:inline-flex;align-items:center;gap:0.75rem;padding:0.6rem 0.9rem;border:1px solid rgba(0,0,0,0.06);border-radius:12px;background:#fff;transition:transform .12s ease,box-shadow .12s ease}
      .quick-action:hover{transform:translateY(-4px);box-shadow:0 12px 30px rgba(22,28,45,0.06);text-decoration:none}
      .quick-action .icon-wrapper{width:44px;height:44px;border-radius:10px;box-shadow:none}
    </style>
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

          <!-- Statistik Utama (tampilan diperbarui) -->
          <div class="row gy-4 mb-4">
            <div class="col-xl-3 col-lg-6 col-md-12 mb-3">
              <div class="card stat-card shadow-sm h-100">
                <div class="card-body d-flex gap-3 align-items-center">
                  <div class="icon-wrapper icon-bg-blue">
                    <span class="fe fe-users fs-4"></span>
                  </div>
                  <div>
                    <small class="text-uppercase text-muted">Total User</small>
                    <h3 class="mb-0 fw-bold">{{ $totalUsers }}</h3>
                    <small class="text-muted">Semua akun terdaftar</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 mb-3">
              <div class="card stat-card shadow-sm h-100">
                <div class="card-body d-flex gap-3 align-items-center">
                  <div class="icon-wrapper icon-bg-green">
                    <span class="fe fe-dollar-sign fs-4"></span>
                  </div>
                  <div>
                    <small class="text-uppercase text-muted">Pendapatan Bulan Ini</small>
                    <h3 class="mb-0 fw-bold">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</h3>
                    <small class="text-muted">Hanya pembayaran lunas</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 mb-3">
              <div class="card stat-card shadow-sm h-100">
                <div class="card-body d-flex gap-3 align-items-center">
                  <div class="icon-wrapper icon-bg-yellow">
                    <span class="fe fe-file-text fs-4"></span>
                  </div>
                  <div>
                    <small class="text-uppercase text-muted">Total Soal</small>
                    <h3 class="mb-0 fw-bold">{{ $totalQuestions }}</h3>
                    <small class="text-muted">Semua soal dalam bank soal</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 mb-3">
              <div class="card stat-card shadow-sm h-100">
                <div class="card-body d-flex gap-3 align-items-center">
                  <div class="icon-wrapper icon-bg-teal">
                    <span class="fe fe-circle fs-4"></span>
                  </div>
                  <div>
                    <small class="text-uppercase text-muted">User Sedang Online</small>
                    <h3 class="mb-0 fw-bold">{{ $onlineUsers }}</h3>
                    <small class="text-muted">Aktif dalam 15 menit terakhir</small>
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
