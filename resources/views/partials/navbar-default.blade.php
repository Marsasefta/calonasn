<nav class="navbar navbar-expand-lg sticky-top bg-white bg-opacity-95 backdrop-blur shadow-xs border-bottom border-light-subtle py-3" style="backdrop-filter: blur(10px); z-index: 1030;">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            <div class="bg-primary bg-gradient text-white rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                <i class="fe fe-award fs-4"></i>
            </div>
            <span class="fs-4 fw-bold text-dark">
                CalonASN<span class="text-primary">.id</span>
            </span>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler border-0 shadow-none p-2 rounded-3" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links & Actions -->
        <div class="collapse navbar-collapse" id="navbar-default">
            <!-- Center Menu Links -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1 gap-lg-3 py-2 py-lg-0 fw-medium">
                <li class="nav-item">
                    <a class="nav-link text-dark px-3 py-2 rounded-pill hover-bg-light transition" href="{{ url('/') }}#paket">
                        Paket Tryout
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark px-3 py-2 rounded-pill hover-bg-light transition" href="{{ url('/') }}#keunggulan">
                        Keunggulan CAT
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill hover-bg-light transition {{ request()->routeIs('demo.*') ? 'text-primary fw-bold active' : 'text-dark' }}" href="{{ route('demo.cat') }}">
                        <span class="badge bg-danger-soft text-danger me-1">Demo</span> Simulasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill hover-bg-light transition {{ request()->routeIs('blog.*') ? 'text-primary fw-bold active' : 'text-dark' }}" href="{{ route('blog.index') }}">
                        Info & Tips
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark px-3 py-2 rounded-pill hover-bg-light transition" href="{{ url('/') }}#faq">
                        FAQ
                    </a>
                </li>
            </ul>

            <!-- Right Buttons (Auth) -->
            <div class="d-flex align-items-center gap-2 pt-2 pt-lg-0">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" 
                       class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="fe fe-grid"></i>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-pill px-3 py-2 fw-semibold">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                        Daftar Gratis <i class="fe fe-arrow-right ms-1"></i>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
