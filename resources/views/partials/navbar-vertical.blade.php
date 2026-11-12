<!-- Top Loading Progress Bar (Feedback Instan Saat Klik Menu) -->
<div id="adminTopProgressBar"></div>

<nav class="navbar-vertical navbar shadow-sm" id="adminSidebar">
  <div class="vh-100 d-flex flex-column w-100">

    <!-- Brand Logo -->
    <div class="border-bottom border-dark-subtle text-center py-3 px-2">
      <a class="navbar-brand m-0 d-inline-block transition-transform hover-scale" href="{{ route('admin.dashboard') }}" title="Ke Dashboard Utama">
        <img
          src="/build/assets/images/logoasn2.png"
          alt="CalonASN Logo"
          class="img-fluid"
          style="
            max-width: 105px;
            height: auto;
            filter: brightness(0) invert(1);
            object-fit: contain;
          "
        />
      </a>
    </div>

    <!-- Menu List (Dengan scroll position memory) -->
    <div class="flex-grow-1 py-3 overflow-y-auto" id="sidebarMenuScroll">
      <ul class="navbar-nav px-3 gap-1" id="sideNavbar">

        <!-- KELOMPOK UTAMA -->
        <li class="nav-item mt-1 mb-1 px-3">
          <span class="section-heading-text">Utama</span>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="fe fe-home me-2.5"></i>
            <span>Dashboard Utama</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
            <i class="fe fe-users me-2.5"></i>
            <span>Data Peserta</span>
          </a>
        </li>

        <!-- KELOMPOK TRYOUT -->
        <li class="nav-item mt-3 mb-1 px-3">
          <span class="section-heading-text">Manajemen Tryout</span>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
            <i class="fe fe-layers me-2.5"></i>
            <span>Kategori Soal</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.list-bank-soal') ? 'active' : '' }}" href="{{ route('admin.list-bank-soal') }}">
            <i class="fe fe-file-text me-2.5"></i>
            <span>Bank Soal</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.create-tryout') ? 'active' : '' }}" href="{{ route('admin.create-tryout') }}">
            <i class="fe fe-sliders me-2.5"></i>
            <span>Paket Ujian Tryout</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.free-tryout.*') ? 'active' : '' }}" href="{{ route('admin.free-tryout.index') }}">
            <i class="fe fe-gift me-2.5"></i>
            <span>Tryout Gratis</span>
          </a>
        </li>

        <!-- KELOMPOK PEMASARAN -->
        <li class="nav-item mt-3 mb-1 px-3">
          <span class="section-heading-text">Pemasaran & Konten</span>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.blog.*') ? 'active' : '' }}" href="{{ route('admin.blog.index') }}">
            <i class="fe fe-edit-3 me-2.5"></i>
            <span>Artikel & Berita</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.learning.*') ? 'active' : '' }}" href="{{ route('admin.learning.index') }}">
            <i class="fe fe-book-open me-2.5"></i>
            <span>Materi Pembelajaran</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.transactions.*') ? 'active' : '' }}" href="{{ route('admin.transactions.index') }}">
            <i class="fe fe-credit-card me-2.5"></i>
            <span>Transaksi & Keuangan</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.promo.*') ? 'active' : '' }}" href="{{ route('admin.promo.index') }}">
            <i class="fe fe-percent me-2.5"></i>
            <span>Kode Promo</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.whatsapp-blast.*') ? 'active' : '' }}" href="{{ route('admin.whatsapp-blast.index') }}">
            <i class="fe fe-message-circle me-2.5"></i>
            <span>Blast WhatsApp</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
            <i class="fe fe-bar-chart-2 me-2.5"></i>
            <span>Laporan & Peringkat</span>
          </a>
        </li>

        <!-- KELOMPOK SISTEM -->
        <li class="nav-item mt-3 mb-1 px-3">
          <span class="section-heading-text">Sistem & Debug</span>
        </li>

        <li class="nav-item">
          <a class="nav-link rounded px-3 py-2.5 d-flex align-items-center {{ Request::is('log-viewer*') ? 'active' : '' }}" href="/log-viewer" target="_blank">
            <i class="fe fe-activity me-2.5"></i>
            <span>Log Aplikasi</span>
            <i class="fe fe-external-link ms-auto small text-muted" style="font-size: 0.72rem;"></i>
          </a>
        </li>

      </ul>
    </div>

  </div>
</nav>

<style>
  /* Progress Bar Loading di Atas Halaman */
  #adminTopProgressBar {
    position: fixed;
    top: 0;
    left: 0;
    height: 3px;
    width: 0%;
    background: linear-gradient(90deg, #2563eb, #60a5fa, #93c5fd);
    z-index: 999999;
    transition: width 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease;
    box-shadow: 0 0 10px rgba(37, 99, 235, 0.8);
    pointer-events: none;
    opacity: 0;
  }

  #adminTopProgressBar.active {
    opacity: 1;
    width: 75%;
  }

  /* Sidebar Container */
  .navbar-vertical {
    background: #0f172a !important;
    width: 260px;
    border-right: 1px solid rgba(255, 255, 255, 0.06);
    flex-shrink: 0;
    contain: layout style;
  }

  /* Scrollbar Halus & Stabil */
  #sidebarMenuScroll {
    scrollbar-gutter: stable;
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.15) transparent;
  }

  #sidebarMenuScroll::-webkit-scrollbar {
    width: 4px;
  }

  #sidebarMenuScroll::-webkit-scrollbar-track {
    background: transparent;
  }

  #sidebarMenuScroll::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 9999px;
  }

  #sidebarMenuScroll::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
  }

  /* Heading Kategori Menu */
  .section-heading-text {
    text-transform: uppercase;
    color: #64748b !important;
    font-weight: 700;
    font-size: 10.5px;
    letter-spacing: 1.1px;
    display: block;
    user-select: none;
  }

  /* Nav Links (GPU-accelerated, Tidak Geser Padding) */
  .navbar-vertical .nav-link {
    color: #94a3b8;
    font-size: 13.5px;
    font-weight: 500;
    transition: background-color 0.15s ease, color 0.15s ease, transform 0.15s ease;
    margin: 2px 0;
    position: relative;
    border-radius: 8px;
    will-change: transform;
  }

  .navbar-vertical .nav-link i {
    font-size: 15px;
    color: #64748b;
    transition: color 0.15s ease;
  }

  /* Efek Hover Halus Tanpa Layout Shift */
  .navbar-vertical .nav-link:hover {
    background: rgba(255, 255, 255, 0.05);
    color: #f8fafc;
    transform: translateX(4px); /* Menggeser mulus via GPU tanpa merusak padding */
  }

  .navbar-vertical .nav-link:hover i {
    color: #cbd5e1;
  }

  /* Menu Aktif Modern */
  .navbar-vertical .nav-link.active {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
    color: #ffffff !important;
    font-weight: 600;
    box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
    transform: none !important;
  }

  .navbar-vertical .nav-link.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 20%;
    bottom: 20%;
    width: 3.5px;
    background: #60a5fa;
    border-radius: 0 4px 4px 0;
  }

  .navbar-vertical .nav-link.active i {
    color: #ffffff !important;
  }

  /* Transisi Toggler Collapse */
  #db-wrapper {
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  }
</style>

<script>
  (function() {
    // 1. Ingat & Kembalikan Posisi Scroll Sidebar Saat Pindah Halaman
    const scrollContainer = document.getElementById('sidebarMenuScroll');
    if (scrollContainer) {
      const savedScrollPos = sessionStorage.getItem('admin_sidebar_scroll_pos');
      if (savedScrollPos !== null) {
        scrollContainer.scrollTop = parseInt(savedScrollPos, 10);
      }

      scrollContainer.addEventListener('scroll', function() {
        sessionStorage.setItem('admin_sidebar_scroll_pos', scrollContainer.scrollTop);
      }, { passive: true });
    }

    // 2. Ingat Status Sidebar Toggled (Buka/Tutup) di LocalStorage
    const dbWrapper = document.getElementById('db-wrapper');
    if (dbWrapper) {
      const isToggled = localStorage.getItem('admin_sidebar_toggled') === 'true';
      if (isToggled) {
        dbWrapper.classList.add('toggled');
      }

      // Deteksi klik pada tombol toggle navbar
      document.addEventListener('click', function(e) {
        const toggleBtn = e.target.closest('#nav-toggle');
        if (toggleBtn) {
          setTimeout(() => {
            localStorage.setItem('admin_sidebar_toggled', dbWrapper.classList.contains('toggled'));
          }, 60);
        }
      });
    }

    // 3. Animasi Bar Progress di Atas Saat Klik Menu (Feedback Instan)
    const progressBar = document.getElementById('adminTopProgressBar');
    if (progressBar) {
      const sidebarLinks = document.querySelectorAll('#sideNavbar .nav-link');
      sidebarLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
          const href = this.getAttribute('href');
          const isTargetBlank = this.getAttribute('target') === '_blank';

          if (href && href !== '#' && !href.startsWith('javascript') && !isTargetBlank) {
            progressBar.classList.add('active');
          }
        });
      });
    }
  })();
</script>
