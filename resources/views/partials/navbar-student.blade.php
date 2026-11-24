<!-- Sidebar -->
<style>
    @media (min-width: 992px) {
        .sidenav.sidenav-navbar {
            position: fixed !important;
            top: 70px !important;
            left: 0 !important;
            bottom: 0 !important;
            width: 240px !important;
            height: calc(100vh - 70px) !important;
            max-height: calc(100vh - 70px) !important;
            padding-top: 1.25rem !important;
            padding-bottom: 5rem !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            box-sizing: border-box !important;
            z-index: 100 !important;
            scrollbar-width: thin;
            scrollbar-color: rgba(148, 163, 184, 0.45) transparent;
        }

        .sidenav.sidenav-navbar::-webkit-scrollbar {
            width: 6px;
        }

        .sidenav.sidenav-navbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidenav.sidenav-navbar::-webkit-scrollbar-thumb {
            background-color: rgba(148, 163, 184, 0.4);
            border-radius: 4px;
        }

        .sidenav.sidenav-navbar::-webkit-scrollbar-thumb:hover {
            background-color: rgba(100, 116, 139, 0.7);
        }
    }

    @media (max-width: 991.98px) {
        .sidenav.sidenav-navbar {
            padding-bottom: 3rem !important;
        }
    }
</style>
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
            <div class="navbar-nav flex-column mt-4 mt-lg-0 d-flex flex-column gap-3 pb-4">

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
                                <span class="badge bg-warning text-dark rounded-pill shadow-sm"
                                    style="font-size: 0.65rem;">FREE TRIAL</span>
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
                            <a class="nav-link {{ request()->routeIs('user.pilih-paket') ? 'active' : '' }}"
                                href="{{ route('user.pilih-paket') }}">
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

                <div class="d-flex flex-column gap-1 mt-2">
                    <span class="navbar-header text-muted small fw-bold text-uppercase px-4">Bantuan</span>
                    <ul class="list-unstyled mb-0">
                        <li class="nav-item">
                            @php
                                $waSidebarMsg = urlencode('Halo Admin CalonASN, saya ' . (auth()->user()->name ?? 'Peserta') . ' ingin bertanya terkait akun/materi tryout.');
                            @endphp
                            <a class="nav-link text-success fw-semibold"
                                href="https://wa.me/6285113655806?text={{ $waSidebarMsg }}"
                                target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-whatsapp nav-icon text-success"></i> Tanya Admin (WA)
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>
</div>


