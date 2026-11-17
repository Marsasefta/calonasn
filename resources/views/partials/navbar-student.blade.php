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

{{-- Floating WhatsApp Pill (Pusat Bantuan) --}}
@unless (request()->routeIs('ujian.mulai'))
    @php
        $waFloatingMsg = urlencode('Halo Admin CalonASN, saya ' . (auth()->user()->name ?? 'Peserta') . ' butuh bantuan/konsultasi terkait CalonASN.');
    @endphp
    <a href="https://wa.me/6285113655806?text={{ $waFloatingMsg }}"
       target="_blank"
       rel="noopener noreferrer"
       class="floating-wa-pill shadow-lg"
       title="Hubungi Admin CalonASN di WhatsApp (085113655806)">
        <span class="floating-wa-icon-box">
            <i class="bi bi-whatsapp"></i>
            <span class="floating-wa-pulse"></span>
        </span>
        <span class="floating-wa-label">Pusat Bantuan</span>
    </a>

    <style>
        .floating-wa-pill {
            position: fixed;
            bottom: 85px;
            right: 24px;
            z-index: 1040;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            color: #ffffff !important;
            padding: 11px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.2px;
            text-decoration: none !important;
            box-shadow: 0 4px 18px rgba(18, 140, 126, 0.4);
            transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 2px solid rgba(255, 255, 255, 0.25);
        }
        .floating-wa-pill:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 8px 25px rgba(18, 140, 126, 0.55);
            color: #ffffff !important;
        }
        .floating-wa-icon-box {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            line-height: 1;
        }
        .floating-wa-pulse {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 8px;
            height: 8px;
            background-color: #ffffff;
            border-radius: 50%;
            box-shadow: 0 0 0 rgba(255, 255, 255, 0.7);
            animation: pulse-wa-white 1.8s infinite;
        }
        @keyframes pulse-wa-white {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
            }
            70% {
                box-shadow: 0 0 0 6px rgba(255, 255, 255, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
            }
        }
        @media (max-width: 576px) {
            .floating-wa-pill {
                bottom: 80px;
                right: 16px;
                padding: 10px 16px;
                font-size: 13px;
            }
        }
    </style>
@endunless
