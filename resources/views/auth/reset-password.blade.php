<!doctype html>
<html lang="id">

<head>
    @include('partials.head')
    <title>Atur Ulang Password | CalonASN.id</title>
</head>

<body>
    <main>
        <section class="container d-flex flex-column vh-100">
            <div class="row align-items-center justify-content-center g-0 h-lg-100 py-8">
                <div class="col-lg-5 col-md-8 py-8 py-xl-0">
                    <div class="card shadow">
                        <div class="card-body p-6 d-flex flex-column gap-4">

                            <div>
                                <div class="d-flex flex-column gap-1">
                                    <h1 class="mb-0 fw-bold">Atur Ulang Password</h1>
                                    <span class="text-muted text-sm">
                                        Silakan buat password baru yang kuat untuk mengamankan kembali akun CalonASN.id
                                        Anda.
                                    </span>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('password.store') }}" class="needs-validation"
                                novalidate>
                                @csrf

                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="mb-3">
                                    <label for="email" class="form-label">Alamat Email</label>
                                    <input type="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror bg-light"
                                        name="email" value="{{ old('email', $request->email) }}" required
                                        autocomplete="username" readonly />
                                    @if ($errors->has('email'))
                                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            placeholder="Minimal 8 karakter" required autocomplete="new-password"
                                            autofocus />
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('password', 'icon-pass')">
                                            <i class="fe fe-eye" id="icon-pass"></i>
                                        </button>

                                        @if ($errors->has('password'))
                                            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                        @else
                                            <div class="invalid-feedback">Silakan buat password baru minimal 8 karakter.
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password
                                        Baru</label>
                                    <div class="input-group">
                                        <input type="password" id="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            name="password_confirmation" placeholder="Ulangi password baru" required
                                            autocomplete="new-password" />
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('password_confirmation', 'icon-confirm')">
                                            <i class="fe fe-eye" id="icon-confirm"></i>
                                        </button>

                                        @if ($errors->has('password_confirmation'))
                                            <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}
                                            </div>
                                        @else
                                            <div class="invalid-feedback">Silakan ketik ulang password Anda untuk
                                                konfirmasi.</div>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                            Simpan Password Baru
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
