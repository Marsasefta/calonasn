<!-- Sidebar -->
<nav class="navbar-vertical navbar shadow-sm">
  <div class="vh-100 d-flex flex-column" data-simplebar>

    <!-- Logo -->
    <div class="border-bottom text-center">
      <a class="navbar-brand m-0" href="#">
        <img
          src="/build/assets/images/logoasn2.png"
          alt="Logo"
          class="img-fluid"
          style="
            max-width: 150px;
            height: auto;
            filter: brightness(0) invert(1);
            object-fit: contain;
          "
        />
      </a>
    </div>

    <!-- Menu -->
    <div class="flex-grow-1 py-3">
      <ul class="navbar-nav px-3" id="sideNavbar">

        <!-- Section -->
        <li class="nav-item mb-2">
          <span
            class="text-uppercase text-light opacity-50 fw-bold"
            style="font-size: 11px; letter-spacing: 1px;"
          >
            Main Menu
          </span>
        </li>

        <!-- Dropdown Menu -->
        <li class="nav-item">

          <a
            class="nav-link d-flex align-items-center justify-content-between rounded px-3 py-2 @@if (context.page_group !== 'dashboard') { collapsed }"
            href="#"
            data-bs-toggle="collapse"
            data-bs-target="#navDashboard"
            aria-expanded="true"
            aria-controls="navDashboard"
            style="
              background: rgba(255,255,255,0.06);
              transition: all .2s ease;
            "
          >
            <div class="d-flex align-items-center">
              <i class="nav-icon fe fe-grid me-2"></i>
              <span class="fw-semibold">Admin Panel</span>
            </div>

            <i class="fe fe-chevron-down fs-6"></i>
          </a>

          <!-- Sub Menu -->
          <div
            id="navDashboard"
            class="collapse show @@if (context.page_group === 'dashboard') { show }"
            data-bs-parent="#sideNavbar"
          >

            <ul class="nav flex-column mt-2 gap-1">

              <li class="nav-item">
                <a
                  class="nav-link rounded px-3 py-2 @@if (context.page === 'dashboard') { active }"
                  href="{{ route('admin.dashboard') }}"
                >
                  <i class="fe fe-home me-2"></i>
                  Dashboard Utama
                </a>
              </li>

              <li class="nav-item">
                <a
                  class="nav-link rounded px-3 py-2 @@if (context.page === 'users.index') { active }"
                  href="{{ route('admin.users.index') }}"
                >
                  <i class="fe fe-users me-2"></i>
                  Data Peserta
                </a>
              </li>

              <li class="nav-item">
                <a
                  class="nav-link rounded px-3 py-2 @@if (context.page === 'list-bank-soal') { active }"
                  href="{{ route('admin.list-bank-soal') }}"
                >
                  <i class="fe fe-file-text me-2"></i>
                  Bank Soal
                </a>
              </li>

              <li class="nav-item">
                <a
                  class="nav-link rounded px-3 py-2 @@if (context.page === 'categories.index') { active }"
                  href="{{ route('admin.categories.index') }}"
                >
                  <i class="fe fe-tag me-2"></i>
                  Kategori Soal
                </a>
              </li>

              <li class="nav-item">
                <a
                  class="nav-link rounded px-3 py-2 @@if (context.page === 'create-tryout') { active }"
                  href="{{ route('admin.create-tryout') }}"
                >
                  <i class="fe fe-calendar me-2"></i>
                  Manajemen Tryout
                </a>
              </li>

              <li class="nav-item">
                <a
                  class="nav-link rounded px-3 py-2 @@if (context.page === 'transactions.index') { active }"
                  href="{{ route('admin.transactions.index') }}"
                >
                  <i class="fe fe-credit-card me-2"></i>
                  Transaksi & Pembayaran
                </a>
              </li>

              <li class="nav-item">
                <a
                  class="nav-link rounded px-3 py-2 @@if (context.page === 'reports.index') { active }"
                  href="{{ route('admin.reports.index') }}"
                >
                  <i class="fe fe-award me-2"></i>
                  Laporan & Peringkat
                </a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link rounded px-3 py-2 @@if (context.page === 'blog.index') { active }"
                  href="{{ route('admin.blog.index') }}"
                >
                  <i class="fe fe-paperclip me-2"></i>
                  Artikel & Berita
                </a>
              </li>

            </ul>
          </div>
        </li>

      </ul>
    </div>

  </div>
</nav>

<!-- Tambahan CSS -->
<style>
  .navbar-vertical {
    background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
    width: 280px;
  }

  .navbar-vertical .nav-link {
    color: rgba(255,255,255,0.8);
    font-size: 14px;
    transition: all .2s ease;
  }

  .navbar-vertical .nav-link:hover {
    background: rgba(255,255,255,0.08);
    color: #fff;
    transform: translateX(3px);
  }

  .navbar-vertical .nav-link.active {
    background: #2563eb;
    color: #fff !important;
    box-shadow: 0 4px 10px rgba(37, 99, 235, 0.35);
  }

  .navbar-vertical .nav-icon,
  .navbar-vertical i {
    font-size: 16px;
  }

  .nav-divider {
    height: 1px;
    background: rgba(255,255,255,0.08);
    margin: 15px 0;
  }

  .collapse .nav-link {
    margin-left: 8px;
  }
</style>