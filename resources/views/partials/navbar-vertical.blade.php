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
          Master Data
        </a>
        <div id="navDashboard" class="collapse @@if (context.page_group === 'dashboard') { show }" data-bs-parent="#sideNavbar">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link @@if (context.page === 'dashboard') { active }" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @@if (context.page === 'create-bank-soal') { active }" href="{{ route('admin.create-bank-soal') }}">Bank Soal</a>
            </li>
             <li class="nav-item">
                <a class="nav-link @@if (context.page === 'categories.index') { active }" href="{{ route('admin.categories.index') }}">Kategori Soal</a>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
              <a class="nav-link @@if (context.page === 'create-tryout') { active }" href="{{ route('admin.create-tryout') }}">Ujian Tryout</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @@if (context.page === 'user_type') { active }" href="{{ route('admin.user_type') }}">Pengguna</a>
            </li>
          </ul>
        </div>
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <div class="nav-divider"></div>
      </li>
      <!-- Nav item -->

  </div>
</nav>
