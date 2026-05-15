<!-- Sidebar -->
<nav class="navbar-vertical navbar">
  <div class="vh-100" data-simplebar>
    <!-- Brand logo -->
    <a class="navbar-brand d-flex justify-content-center align-items-center" href="#" style="width: 100%;">
        <img src="/build/assets/images/logoasn2.png" 
            alt="Logo" 
            class="navbar-brand-img white" 
            style="filter: brightness(0) invert(1); 
                    max-width: 150px; 
                    height: auto; 
                    display: block;
                    object-fit: contain;" />
    </a>
    <!-- Navbar nav -->
    <ul class="navbar-nav flex-column" id="sideNavbar">
      <li class="nav-item">
        <a
          class="nav-link @@if (context.page_group !== 'dashboard') { collapsed }"
          href="#"
          data-bs-toggle="collapse"
          data-bs-target="#navDashboard"
          aria-expanded="false"
          aria-controls="navDashboard">
          <i class="nav-icon fe fe-home me-2"></i>
          Admin Panel
        </a>
        <div id="navDashboard" class="collapse @@if (context.page_group === 'dashboard') { show }" data-bs-parent="#sideNavbar">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link @@if (context.page === 'dashboard') { active }" href="{{ route('admin.dashboard') }}">
                <i class="nav-icon fe fe-bar-chart-2 me-1"></i> Dashboard Utama
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @@if (context.page === 'users.index') { active }" href="{{ route('admin.users.index') }}">
                <i class="nav-icon fe fe-users me-1"></i> Data Peserta
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @@if (context.page === 'list-bank-soal') { active }" href="{{ route('admin.list-bank-soal') }}">
                <i class="nav-icon fe fe-file-text me-1"></i> Bank Soal
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @@if (context.page === 'create-tryout') { active }" href="{{ route('admin.create-tryout') }}">
                <i class="nav-icon fe fe-calendar me-1"></i> Manajemen Tryout
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @@if (context.page === 'transactions.index') { active }" href="{{ route('admin.transactions.index') }}">
                <i class="nav-icon fe fe-credit-card me-1"></i> Transaksi & Pembayaran
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @@if (context.page === 'reports.index') { active }" href="{{ route('admin.reports.index') }}">
                <i class="nav-icon fe fe-file-text me-1"></i> Laporan & Peringkat
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @@if (context.page === 'categories.index') { active }" href="{{ route('admin.categories.index') }}">
                <i class="nav-icon fe fe-tag me-1"></i> Kategori Soal
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <div class="nav-divider"></div>
      </li>
    </ul>
  </div>
</nav>
