<!-- Sidebar -->
<div class="position-relative">
    <nav class="navbar navbar-expand-lg sidenav sidenav-navbar">
        <!-- Menu -->
        <a class="d-xl-none d-lg-none d-block text-inherit fw-bold" href="#">Menu</a>
        <!-- Button -->

        <button class="navbar-toggler d-lg-none icon-shape icon-sm rounded bg-primary text-light" type="button"
            data-bs-toggle="collapse" data-bs-target="#sidenavNavbar" aria-controls="sidenavNavbar" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="fe fe-menu"></span>
        </button>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenavNavbar">
            <div class="navbar-nav flex-column mt-4 mt-lg-0 d-flex flex-column gap-3">

                <ul class="list-unstyled mb-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="fe fe-home nav-icon"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('materi*') ? 'active' : '' }}"
                            href="{{ url('/materi-belajar') }}">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="d-flex align-items-center">
                                    <i class="fe fe-book-open nav-icon me-2"></i>
                                    <span class="nav-link-text">Materi Belajar</span>
                                </div>
                                <span class="badge bg-danger rounded-pill shadow-sm"
                                    style="font-size: 0.65rem;">GRATIS</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('demo.*') ? 'active' : '' }}"
                            href="{{ route('demo.index') }}">
                            <i class="fe fe-unlock nav-icon"></i> Ujicoba Gratis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ujian.*') ? 'active' : '' }}"
                            href="{{ route('ujian.persiapan', 1) }}">
                            <i class="fe fe-edit nav-icon"></i> Mulai Tryout
                        </a>
                    </li>
                </ul>

                <div class="d-flex flex-column gap-1 mt-2">
                    <span class="navbar-header text-muted small fw-bold text-uppercase px-4">Evaluasi</span>
                    <ul class="list-unstyled mb-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('ranking') ? 'active' : '' }}"
                                href="{{ route('ranking') }}">
                                <i class="fe fe-bar-chart-2 nav-icon"></i> Ranking Nasional
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('sertifikat.riwayat') ? 'active' : '' }}"
                                href="{{ route('sertifikat.riwayat') }}">
                                <i class="fe fe-award nav-icon"></i> Riwayat Tryout
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="d-flex flex-column gap-1 mt-2">
                    <span class="navbar-header text-muted small fw-bold text-uppercase px-4">Transaksi</span>
                    <ul class="list-unstyled mb-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('checkout') ? 'active' : '' }}"
                                href="{{ route('checkout') }}">
                                <i class="fe fe-shopping-cart nav-icon"></i> Beli Paket Premium
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('riwayat') ? 'active' : '' }}"
                                href="{{ route('riwayat') }}">
                                <i class="fe fe-clock nav-icon"></i> Riwayat Transaksi
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="d-flex flex-column gap-1 mt-2">
                    <span class="navbar-header text-muted small fw-bold text-uppercase px-4">Pengaturan</span>
                    <ul class="list-unstyled mb-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                                href="{{ route('profile.edit') }}">
                                <i class="fe fe-user nav-icon"></i> Edit Profil
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>
</div>
