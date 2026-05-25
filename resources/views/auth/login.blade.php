<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <title>Sign in | CalonASN.id</title>
</head>

<body>
    <!-- Page content -->
    <main>
        <section class="container d-flex flex-column vh-100">
            <div class="row align-items-center justify-content-center g-0 h-lg-100 py-8">
                <div class="col-lg-5 col-md-8 py-8 py-xl-0">
                    <!-- Card -->
                    <div class="card shadow">
                        <!-- Card body -->
                        <div class="card-body p-6 d-flex flex-column gap-4">
                            <div >
                                <a href="{{ url('/') }}"
                                    class="text-muted text-decoration-none small fw-medium transition-all hover-primary">
                                    <i class="fe fe-arrow-left me-1"></i> Kembali ke Beranda
                                </a>
                            </div>

                            <div>
                                <div class="d-flex flex-column gap-1">
                                    <h1 class="mb-0 fw-bold">Masuk Akun</h1>
                                    <span>
                                        Belum punya akun?
                                        <a href="{{ route('register') }}" class="ms-1 fw-medium">Daftar di sini</a>
                                    </span>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                                @csrf

                                <div class="mb-3">
                                    <label for="login" class="form-label">Username atau Email</label>
                                    <input type="text" id="login"
                                        class="form-control @error('login') is-invalid @enderror" name="login"
                                        value="{{ old('login') }}" placeholder="Masukkan username atau email"
                                        required />
                                    @if ($errors->has('login'))
                                        <div class="invalid-feedback">{{ $errors->first('login') }}</div>
                                    @else
                                        <div class="invalid-feedback">Silakan masukkan username atau email yang valid.
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            placeholder="**************" required />
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('password', 'icon-pass')">
                                            <i class="fe fe-eye" id="icon-pass"></i>
                                        </button>
                                        @if ($errors->has('password'))
                                            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                        @else
                                            <div class="invalid-feedback">Silakan masukkan password Anda dengan benar.
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-lg-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember"
                                            name="remember" />
                                        <label class="form-check-label" for="remember">Ingat saya</label>
                                    </div>
                                    <div>
                                        <a href="{{ route('password.request') }}" class="small fw-medium">Lupa
                                            password?</a>
                                    </div>
                                </div>

                                <div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg fw-bold">Masuk Sekarang</button>
                                    </div>
                                </div>

                                <!-- Tambahan Tombol Google -->
                                <div class="text-center my-3">
                                    <span class="text-muted small">atau masuk dengan</span>
                                </div>

                                <div class="d-grid">
                                    <a href="{{ route('auth.google') }}" class="btn btn-outline-warning btn-lg d-flex align-items-center justify-content-center gap-2 small fw-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 488 512">
                                            <path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/>
                                        </svg>
                                        Masuk dengan Google
                                    </a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="position-absolute bottom-0 m-4">
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
        </div>
    </main>
    <!-- Scripts -->
    @include('partials.scripts')

    <script src="assets/js/vendors/validation.js"></script>

    <script>
        function togglePassword(inputId, iconId) {
            const inputField = document.getElementById(inputId);
            const iconField = document.getElementById(iconId);

            if (inputField.type === 'password') {
                inputField.type = 'text';
                iconField.classList.remove('fe-eye');
                iconField.classList.add('fe-eye-off');
            } else {
                inputField.type = 'password';
                iconField.classList.remove('fe-eye-off');
                iconField.classList.add('fe-eye');
            }
        }
    </script>

</body>

</html>
