<!doctype html>
<html lang="id">

<head>
    @include('partials.head')
    <title>Lupa Password | CalonASN.id</title>
</head>

<body>
    <main>
        <section class="container d-flex flex-column vh-100">
            <div class="row align-items-center justify-content-center g-0 h-lg-100 py-8">
                <div class="col-lg-5 col-md-8 py-8 py-xl-0">
                    <div class="card shadow">
                        <div class="card-body p-6 d-flex flex-column gap-4">

                            <div>
                                <a href="{{ url('/') }}"
                                    class="text-muted text-decoration-none small fw-medium transition-all hover-primary">
                                    <i class="fe fe-arrow-left me-1"></i> Kembali ke Beranda
                                </a>
                            </div>

                            <div>
                                <div class="d-flex flex-column gap-1">
                                    <h1 class="mb-0 fw-bold">Lupa Password</h1>
                                    <span>
                                        Ingat password Anda?
                                        <a href="{{ route('login') }}" class="ms-1 fw-medium">Masuk di sini</a>
                                    </span>
                                </div>
                            </div>

                            <div class="text-sm text-muted">
                                Tidak masalah! Masukkan alamat email akun CalonASN.id Anda di bawah ini. Kami akan
                                segera mengirimkan tautan (link) rahasia untuk mengatur ulang dan membuat password baru
                                Anda.
                            </div>

                            @if (session('status'))
                                <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-0 small"
                                    role="alert">
                                    <i class="fe fe-check-circle me-2 fs-4"></i>
                                    <div>{{ session('status') }}</div>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}" class="needs-validation"
                                novalidate>
                                @csrf

                                <div class="mb-4">
                                    <label for="email" class="form-label">Alamat Email Terdaftar</label>
                                    <input type="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" placeholder="Contoh: nama@email.com" required
                                        autofocus />

                                    @if ($errors->has('email'))
                                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                    @else
                                        <div class="invalid-feedback">Silakan masukkan alamat email yang valid.</div>
                                    @endif
                                </div>

                                <div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                            Kirim Link Reset Password
                                        </button>
                                    </div>
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

    @include('partials.scripts')
    <script src="assets/js/vendors/validation.js"></script>
</body>

</html>
