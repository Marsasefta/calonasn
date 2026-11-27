@php
    $promoNavbar = (auth()->check() && !request()->routeIs('ujian.mulai', 'demo.ujian', 'checkout', 'checkout.*', 'payment.*'))
        ? auth()->user()->newMemberPromo()
        : null;
    $promoCtaUrl = route('user.pilih-paket');
    if (request()->routeIs('user.pilih-paket')) {
        $promoCtaUrl = '#daftar-paket';
    } elseif (request()->routeIs('demo.selesai')) {
        $promoCtaUrl = '#pilihan-paket';
    }
    $promoUrgentNav = $promoNavbar && ((int) ($promoNavbar['remaining_seconds'] ?? 0) <= 1800);
@endphp

@if ($promoNavbar)
    <style>
        body {
            padding-bottom: 72px !important;
        }
        .btn-scroll-top {
            bottom: 76px !important;
        }
        .promo-sticky-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1035;
            background: linear-gradient(90deg, #0f172a 0%, #1e293b 60%, #7f1d1d 100%) !important;
            border-top: 2px solid #f59e0b !important;
            padding-bottom: calc(0.5rem + env(safe-area-inset-bottom, 0px)) !important;
            box-shadow: 0 -6px 20px rgba(15, 23, 42, 0.28);
            color: #ffffff !important;
        }
        @media (min-width: 992px) {
            .promo-sticky-bar {
                left: 240px !important;
            }
        }
    </style>
@endif

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid px-0">
        {{-- <a class="navbar-brand" href="index.php"><img src="/build/assets/images/brand/logo/logo.svg" alt="Geeks" /></a> --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <span class="fs-3 fw-xl-bolder fw-bold text-transparent bg-clip-text bg-gradient-start"
                style="background-image: linear-gradient(45deg, #1e40af, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                CalonASN<span class="text-dark fs-4 fw-medium">.id</span>
            </span>
        </a>

        @if ($promoNavbar)
            <div class="d-none d-lg-flex align-items-center gap-2 mx-auto order-lg-2 px-3 py-1 rounded-pill shadow-xs promo-global-countdown"
                 data-remaining-seconds="{{ $promoNavbar['remaining_seconds'] }}"
                 style="background: linear-gradient(90deg, #fffbeb 0%, #fef3c7 100%) !important; border: 1.5px solid #f59e0b !important; color: #0f172a !important;">
                <span class="badge bg-danger rounded-pill px-2 py-1 fw-bold promo-urgency-badge {{ $promoUrgentNav ? 'promo-urgent-pulse' : '' }}"
                      data-short-badge="1"
                      style="font-size: 0.68rem; color: #ffffff !important;">
                    {{ $promoUrgentNav ? '⚡ < 30 MENIT' : '🔥 PROMO BARU' }}
                </span>
                <span class="small fw-semibold" style="color: #0f172a !important;">
                    Hemat Rp {{ number_format((int) $promoNavbar['discount_amount'], 0, ',', '.') }}
                    (<span class="font-monospace fw-bold" style="color: #1d4ed8 !important;">{{ $promoNavbar['code'] }}</span>)
                </span>
                <span class="font-monospace fw-bolder px-2 py-0.5 rounded promo-24h-timer"
                      style="background-color: #0f172a !important; color: {{ $promoUrgentNav ? '#fca5a5' : '#fbbf24' }} !important; font-size: 0.85rem; letter-spacing: 0.5px;">--:--:--</span>
                <a href="{{ $promoCtaUrl }}" class="btn btn-danger btn-sm rounded-pill px-3 py-1 fw-bold" style="font-size: 0.75rem; color: #ffffff !important;">
                    Klaim <i class="fe fe-arrow-right ms-1"></i>
                </a>
            </div>
        @endif
        <!-- Mobile view nav wrap -->
        <div class="ms-auto d-flex align-items-center order-lg-3">
            <div class="dropdown">
                <button class="btn btn-light btn-icon rounded-circle d-flex align-items-center" type="button"
                    aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
                    <i class="bi theme-icon-active"></i>
                    <span class="visually-hidden bs-theme-text">Toggle theme</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text">
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center"
                            data-bs-theme-value="light" aria-pressed="false">
                            <i class="bi theme-icon bi-sun-fill"></i>
                            <span class="ms-2">Light</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center"
                            data-bs-theme-value="dark" aria-pressed="false">
                            <i class="bi theme-icon bi-moon-stars-fill"></i>
                            <span class="ms-2">Dark</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center active"
                            data-bs-theme-value="auto" aria-pressed="true">
                            <i class="bi theme-icon bi-circle-half"></i>
                            <span class="ms-2">Auto</span>
                        </button>
                    </li>
                </ul>
            </div>
            {{-- <ul class="navbar-nav navbar-right-wrap ms-2 flex-row d-none d-md-block">--}}
            <ul class="navbar-nav navbar-right-wrap ms-2 flex-row">

                <li class="dropdown ms-2 d-inline-block position-static">
                    <a class="rounded-circle" href="#" data-bs-toggle="dropdown" data-bs-display="static"
                        aria-expanded="false">
                        <div class="avatar avatar-md avatar-indicators avatar-online">
                            <img alt="avatar"
                                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=ffffff&bold=true&rounded=true"
                                class="rounded-circle" />
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end position-absolute mx-3 my-5 shadow">
                        <div class="dropdown-item">
                            <div class="d-flex">
                                <div class="avatar avatar-md avatar-indicators avatar-online">
                                    <img alt="avatar"
                                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=ffffff&bold=true&rounded=true"
                                        class="rounded-circle" />
                                </div>
                                <div class="ms-3 lh-1">
                                    <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                                    <p class="mb-0 text-muted">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <ul class="list-unstyled">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fe fe-user me-2"></i>
                                    Profil Saya
                                </a>
                            </li>
                            {{-- <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fe fe-settings me-2"></i>
                                    Pengaturan Akun
                                </a>
                            </li> --}}
                        </ul>
                        <div class="dropdown-divider"></div>
                        <ul class="list-unstyled">
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item w-100 text-start text-danger fw-medium">
                                        <i class="fe fe-power me-2"></i>
                                        Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
        {{-- <div>
            <!-- Button -->
            <button class="navbar-toggler collapsed ms-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="icon-bar top-bar mt-0"></span>
                <span class="icon-bar middle-bar"></span>
                <span class="icon-bar bottom-bar"></span>
            </button>
        </div> --}}

        {{-- <div class="collapse navbar-collapse" id="navbar-default">

            <ul class="navbar-nav mt-3 mt-lg-0 mx-xxl-auto gap-2">
                <li class="nav-item">
                    <a class="nav-link fw-medium" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium" href="#">Tryout SKD</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium" href="#">Riwayat Nilai</a>
                </li>
            </ul>

        </div> --}}

    </div>
</nav>

@if ($promoNavbar)
    <div class="promo-sticky-bar pt-2 px-2 px-sm-3 promo-global-countdown"
         data-remaining-seconds="{{ $promoNavbar['remaining_seconds'] }}">
        <div class="container-fluid px-1 px-md-2 d-flex align-items-center justify-content-between gap-2">
            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-1 gap-sm-2 min-w-0">
                <div class="d-flex align-items-center gap-1.5">
                    <span class="badge bg-danger rounded-pill px-2 py-0.5 fw-bold flex-shrink-0 promo-urgency-badge {{ $promoUrgentNav ? 'promo-urgent-pulse' : '' }}"
                          data-short-badge="1"
                          style="font-size: 0.64rem; color: #ffffff !important;">
                        {{ $promoUrgentNav ? '⚡ < 30 MENIT' : '🔥 PROMO' }}
                    </span>
                    <span class="fw-bold text-nowrap" style="font-size: 0.78rem; color: #fde68a !important;">
                        Diskon Rp {{ number_format((int) $promoNavbar['discount_amount'], 0, ',', '.') }}
                    </span>
                </div>
                <div class="d-flex align-items-center gap-1" style="font-size: 0.72rem; color: #cbd5e1 !important;">
                    <span class="d-none d-sm-inline">&bull;</span>
                    <span>Kode:</span>
                    <span class="badge font-monospace fw-bold px-1.5 py-0.5" style="background-color: #ffffff !important; color: #1d4ed8 !important; font-size: 0.7rem;">{{ $promoNavbar['code'] }}</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-1.5 gap-sm-2 flex-shrink-0">
                <div class="px-2 py-1 rounded text-center" style="background-color: rgba(15, 23, 42, 0.9) !important; border: 1px solid rgba(251, 191, 36, 0.55) !important;">
                    <span class="font-monospace fw-bolder promo-24h-timer"
                          style="font-size: 0.82rem; letter-spacing: 0.5px; color: {{ $promoUrgentNav ? '#fca5a5' : '#fbbf24' }} !important;">--:--:--</span>
                </div>
                <a href="{{ $promoCtaUrl }}" class="btn btn-warning btn-sm fw-bold rounded-pill px-2.5 px-sm-3 py-1.5 text-nowrap shadow-sm" style="color: #0f172a !important; font-size: 0.76rem;">
                    Klaim <span class="d-none d-sm-inline">Diskon </span>&rarr;
                </a>
            </div>
        </div>
    </div>

    @include('partials.promo-countdown-assets')
@endif
