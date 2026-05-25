<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <title>Sign up | CalonASN.id</title>
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
                            <div>
                                <a href="{{ url('/') }}"
                                    class="text-muted text-decoration-none small fw-medium transition-all hover-primary">
                                    <i class="fe fe-arrow-left me-1"></i> Kembali ke Beranda
                                </a>
                            </div>

                            <div>
                                <div class="d-flex flex-column gap-1">
                                    <h1 class="mb-0 fw-bold">Daftar Akun</h1>
                                    <span>
                                        Sudah punya akun?
                                        <a href="{{ route('login') }}" class="ms-1 fw-medium">Masuk di sini</a>
                                    </span>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" id="name"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda" required />
                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                    @else
                                        <div class="invalid-feedback">Silakan masukkan nama lengkap Anda.</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Alamat Email</label>
                                    <input type="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" placeholder="nama@email.com" required />
                                    @if ($errors->has('email'))
                                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                    @else
                                        <div class="invalid-feedback">Silakan masukkan alamat email aktif Anda.</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor WhatsApp / Telepon</label>
                                    <input type="tel" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone') }}" placeholder="Contoh: 081234567890" required />
                                    @if ($errors->has('phone'))
                                        <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                                    @else
                                        <div class="invalid-feedback">Silakan masukkan nomor telepon yang valid.</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            placeholder="Min. 8 karakter" required />
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('password', 'icon-pass')">
                                            <i class="fe fe-eye" id="icon-pass"></i>
                                        </button>
                                        @if ($errors->has('password'))
                                            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                        @else
                                            <div class="invalid-feedback">Silakan buat password minimal 8 karakter.
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password_confirmation" class="form-control"
                                            name="password_confirmation" placeholder="Ulangi password" required />
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('password_confirmation', 'icon-confirm')">
                                            <i class="fe fe-eye" id="icon-confirm"></i>
                                        </button>
                                        <div class="invalid-feedback">Silakan ketik ulang password Anda untuk
                                            konfirmasi.</div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="agreeCheck" required />
                                        <label class="form-check-label" for="agreeCheck">
                                            <span>
                                                Saya menyetujui
                                                <a href="#">Syarat & Ketentuan</a>
                                                dan
                                                <a href="#">Kebijakan Privasi</a> CalonASN.id.
                                            </span>
                                        </label>
                                        <div class="invalid-feedback">Anda harus menyetujui ketentuan di atas sebelum
                                            mendaftar.</div>
                                    </div>
                                </div>

                                <div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg fw-bold">Daftar Akun
                                            Gratis</button>
                                    </div>
                                </div>

                                <div class="text-center my-3">
                                    <span class="text-muted small">atau daftar dengan</span>
                                </div>

                                <div class="d-grid">
                                    <a href="{{ route('auth.google') }}" id="btn-google" class="btn btn-outline-warning btn-lg d-flex align-items-center justify-content-center gap-2 small fw-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 488 512">
                                            <path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/>
                                        </svg>
                                        Daftar dengan Google
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
                // Ubah tipe input jadi text (terlihat)
                inputField.type = 'text';
                // Ganti ikon mata menjadi mata dicoret
                iconField.classList.remove('fe-eye');
                iconField.classList.add('fe-eye-off');
            } else {
                // Kembalikan tipe input jadi password (tersembunyi)
                inputField.type = 'password';
                // Ganti ikon kembali jadi mata normal
                iconField.classList.remove('fe-eye-off');
                iconField.classList.add('fe-eye');
            }
        }

        document.getElementById('btn-google').addEventListener('click', function(e) {
            // Menampilkan loading SweetAlert2 sebelum pindah halaman
            Swal.fire({
                title: 'Menghubungkan ke Google...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
