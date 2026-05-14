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
                    <!-- Nav item -->

                    <li class="nav-item">
                        <a class="nav-link" href="dashboard-student.php">
                            <i class="fe fe-home nav-icon"></i>
                            Dashboard
                        </a>
                    </li>
                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fe fe-unlock nav-icon"></i>
                            Ujicoba (Demo)
                        </a>
                    </li>
                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('checkout') ? 'active' : '' }}"
                            href="{{ route('checkout') }}">
                            <i class="fe fe-credit-card nav-icon"></i>
                            Payment
                        </a>
                    </li>
                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link" href="project-blank.php">
                            <i class="fe fe-edit nav-icon"></i>
                            Soal ujian
                        </a>
                    </li>
                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link" href="project-blank.php">
                            <i class="fe fe-trending-up nav-icon"></i>
                            Rangking
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="project-blank.php">
                            <i class="fe fe-clock nav-icon"></i>
                            Riwayat
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="project-blank.php">
                            <i class="fe fe-award nav-icon"></i>
                            Sertifikat
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link" href="project-blank.php">
                            <i class="fe fe-user nav-icon"></i>
                            Akun
                        </a>
                    </li>   --}}
                </ul>
                <!-- Navbar header -->
                <div class="d-flex flex-column gap-1">
                    <span class="navbar-header">Account Settings</span>
                    <ul class="list-unstyled mb-0">
                        <!-- Nav item -->
                        <li class="nav-item">
                            <a class="nav-link" href="profile-edit.php">
                                <i class="fe fe-user nav-icon"></i>
                                Edit Profil
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
