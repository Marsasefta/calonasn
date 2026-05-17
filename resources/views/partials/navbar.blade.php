<nav class="navbar navbar-expand-lg">
    <div class="container-fluid px-0">
        {{-- <a class="navbar-brand" href="index.php"><img src="/build/assets/images/brand/logo/logo.svg" alt="Geeks" /></a> --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <span class="fs-3 fw-xl-bolder fw-bold text-transparent bg-clip-text bg-gradient-start"
                style="background-image: linear-gradient(45deg, #1e40af, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                CalonASN<span class="text-dark fs-4 fw-medium">.id</span>
            </span>
        </a>
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
