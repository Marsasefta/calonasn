<nav class="navbar-vertical navbar shadow-sm">
  <div class="vh-100 d-flex flex-column w-100" data-simplebar>

    <div class="border-bottom border-dark-subtle text-center ">
      <a class="navbar-brand m-0" href="#">
        <img
          src="/build/assets/images/logoasn2.png"
          alt="Logo"
          class="img-fluid"
          style="
            max-width: 100px;
            height: auto;
            filter: brightness(0) invert(1);
            object-fit: contain;
          "
        />
      </a>
    </div>

    <div class="flex-grow-1 py-3 overflow-y-auto">
      <ul class="navbar-nav px-3 gap-1" id="sideNavbar">

        <li class="nav-item mt-2 mb-1 px-3">
          <span class="section-heading-text text-light">Utama</span>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="fe fe-home me-2"></i>
            <span>Dashboard Utama</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
            <i class="fe fe-users me-2"></i>
            <span>Data Peserta</span>
          </a>
        </li>

        <li class="nav-item mt-3 mb-1 px-3">
          <span class="section-heading-text">Manajemen Tryout</span>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
            <i class="fe fe-layers me-2"></i>
            <span>Kategori Soal</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.list-bank-soal') ? 'active' : '' }}" href="{{ route('admin.list-bank-soal') }}">
            <i class="fe fe-file-text me-2"></i>
            <span>Bank Soal</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.create-tryout') ? 'active' : '' }}" href="{{ route('admin.create-tryout') }}">
            <i class="fe fe-sliders me-2"></i>
            <span>Paket Ujian Tryout</span>
          </a>
        </li>

        <li class="nav-item mt-3 mb-1 px-3">
          <span class="section-heading-text">Pemasaran & SEO</span>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.blog.*') ? 'active' : '' }}" href="{{ route('admin.blog.index') }}">
            <i class="fe fe-edit-3 me-2"></i>
            <span>Artikel & Berita</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.transactions.*') ? 'active' : '' }}" href="{{ route('admin.transactions.index') }}">
            <i class="fe fe-credit-card me-2"></i>
            <span>Transaksi & Keuangan</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
            <i class="fe fe-bar-chart-2 me-2"></i>
            <span>Laporan & Peringkat</span>
          </a>
        </li>

      </ul>
    </div>

  </div>
</nav>

<style>
  .navbar-vertical {
    background: #0f172a; /* Warna dark solid kelas enterprise */
    width: 260px;
    border-right: 1px solid rgba(255, 255, 255, 0.05);
  }

  /* Styling khusus label pemisah kategori menu */
  .section-heading-text {
    text-uppercase: uppercase;
    color: #64748b !important; /* Slate muted color */
    font-weight: 700;
    font-size: 10px;
    letter-spacing: 1.2px;
    display: block;
  }

  .navbar-vertical .nav-link {
    color: #94a3b8; /* Kontras warna teks default yang pas */
    font-size: 13.5px;
    font-weight: 500;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    margin: 2px 0;
  }

  /* Efek Hover modern */
  .navbar-vertical .nav-link:hover {
    background: rgba(255, 255, 255, 0.04);
    color: #f8fafc;
    padding-left: 1.25rem !important; /* Geser halus ke kanan */
  }

  /* Menu Aktif super clean */
  .navbar-vertical .nav-link.active {
    background: #2563eb !important;
    color: #ffffff !important;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
  }

  .navbar-vertical .nav-link.active i {
    color: #ffffff !important;
  }

  .navbar-vertical .nav-link i {
    font-size: 15px;
    color: #64748b; /* Warna ikon default sebelum aktif */
    transition: color 0.2s ease;
  }

  .navbar-vertical .nav-link:hover i {
    color: #cbd5e1;
  }

  /* Kustomisasi scrollbar halus di dalam sidebar */
  [data-simplebar] {
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,0.1) transparent;
  }
</style>