<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <title>Sign up | CalonASN.id</title>
</head>

<body>
    <!-- Page content -->
    <main>
        <section class="container d-flex flex-column min-vh-100">
            <div class="row align-items-center justify-content-center g-0 h-lg-100 py-8">
                <div class="col-lg-5 col-md-8 py-8 py-xl-0">
                    <!-- Card -->
                    <div class="card shadow">
                        <!-- Card body -->
                        <div class="card-body p-6 d-flex flex-column gap-4">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center gap-2">
                                    <img src="{{ asset('image/logoasn-icon.png') }}" alt="Logo CalonASN" width="34" height="34" class="rounded-circle shadow-xs">
                                    <span class="fs-4 fw-bold text-dark">
                                        CalonASN<span class="text-primary">.id</span>
                                    </span>
                                </a>
                                <a href="{{ url('/') }}"
                                    class="text-muted text-decoration-none small fw-medium transition-all hover-primary">
                                    <i class="fe fe-arrow-left me-1"></i> Beranda
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

                                {{-- Honeypot anti-bot trap (Tersembunyi dari manusia, otomatis diisi oleh bot spam) --}}
                                <div class="d-none" style="display: none !important; position: absolute !important; left: -9999px !important;" aria-hidden="true">
                                    <label for="middle_name_check">Abaikan kolom ini</label>
                                    <input type="text" name="middle_name_check" id="middle_name_check" tabindex="-1" autocomplete="off" value="" />
                                </div>

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
                                        <input type="checkbox"
                                            class="form-check-input @error('terms') is-invalid @enderror"
                                            id="agreeCheck" name="terms" value="1"
                                            {{ old('terms') ? 'checked' : '' }} required />
                                        <label class="form-check-label" for="agreeCheck">
                                            <span>
                                                Saya menyetujui
                                                <a href="{{ route('legal.terms') }}" data-bs-toggle="modal" data-bs-target="#termsModal">Syarat &amp; Ketentuan</a>
                                                dan
                                                <a href="{{ route('legal.privacy') }}" data-bs-toggle="modal" data-bs-target="#privacyModal">Kebijakan Privasi</a> CalonASN.id.
                                            </span>
                                        </label>
                                        @if ($errors->has('terms'))
                                            <div class="invalid-feedback d-block">{{ $errors->first('terms') }}</div>
                                        @else
                                            <div class="invalid-feedback">Anda harus menyetujui Syarat &amp; Ketentuan dan Kebijakan Privasi sebelum mendaftar.</div>
                                        @endif
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
                                    <a href="{{ route('auth.google') }}" id="btn-google"
                                        class="btn btn-light btn-lg border shadow-sm d-flex align-items-center justify-content-center gap-3 fw-semibold text-dark">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 48 48">
                                            <path fill="#FFC107"
                                                d="M43.6 20.5H42V20H24v8h11.3C33.7 32.7 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3 0 5.7 1.1 7.8 3l5.7-5.7C34.1 6.1 29.4 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-3.5z" />
                                            <path fill="#FF3D00"
                                                d="M6.3 14.7l6.6 4.8C14.7 15.1 19 12 24 12c3 0 5.7 1.1 7.8 3l5.7-5.7C34.1 6.1 29.4 4 24 4 16.3 4 9.7 8.3 6.3 14.7z" />
                                            <path fill="#4CAF50"
                                                d="M24 44c5.2 0 9.9-2 13.5-5.3l-6.2-5.2C29.2 35.1 26.7 36 24 36c-5.3 0-9.7-3.3-11.3-8l-6.5 5C9.5 39.5 16.2 44 24 44z" />
                                            <path fill="#1976D2"
                                                d="M43.6 20.5H42V20H24v8h11.3c-1.1 3-3.4 5.4-6.5 6.9l6.2 5.2C39.5 36.5 44 30.8 44 24c0-1.3-.1-2.7-.4-3.5z" />
                                        </svg>

                                        Daftar dengan Google
                                    </a>
                                </div>
                            </form>

                            <!-- Bantuan WhatsApp di Footer Card -->
                            <div class="text-center pt-3 border-top">
                                <span class="text-muted small">Butuh bantuan pendaftaran?</span>
                                <a href="https://wa.me/6285113655806?text={{ urlencode('Halo Admin CalonASN, saya butuh bantuan saat mendaftar akun...') }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="d-inline-flex align-items-center gap-1 text-success fw-semibold small text-decoration-none ms-1">
                                    <i class="bi bi-whatsapp"></i> Chat WhatsApp Bantuan
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Info Bawah -->
                    <div class="text-center mt-3 text-muted small">
                        <span>© {{ date('Y') }} CalonASN.id</span>
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
    <!-- Modal Syarat & Ketentuan -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="termsModalLabel">Syarat &amp; Ketentuan CalonASN.id</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4">
                    @include('partials.legal.terms-content')
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="{{ route('legal.terms') }}" target="_blank" rel="noopener noreferrer" class="small text-decoration-none">
                        Buka di tab baru <i class="fe fe-external-link ms-1"></i>
                    </a>
                    <button type="button" class="btn btn-primary rounded-pill px-4 fw-semibold js-accept-legal" data-bs-dismiss="modal">
                        Saya Mengerti &amp; Setuju
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Kebijakan Privasi -->
    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="privacyModalLabel">Kebijakan Privasi CalonASN.id</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4">
                    @include('partials.legal.privacy-content')
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="{{ route('legal.privacy') }}" target="_blank" rel="noopener noreferrer" class="small text-decoration-none">
                        Buka di tab baru <i class="fe fe-external-link ms-1"></i>
                    </a>
                    <button type="button" class="btn btn-primary rounded-pill px-4 fw-semibold js-accept-legal" data-bs-dismiss="modal">
                        Saya Mengerti &amp; Setuju
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @include('partials.scripts')

    <script src="{{ asset('build/assets/js/vendors/validation.js') }}"></script>

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

        document.getElementById('agreeCheck').addEventListener('change', function() {
            if (this.checked) {
                this.classList.remove('is-invalid');
            }
        });

        document.querySelectorAll('.js-accept-legal').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const agreeEl = document.getElementById('agreeCheck');
                if (agreeEl) {
                    agreeEl.checked = true;
                    agreeEl.classList.remove('is-invalid');
                }
            });
        });

        document.querySelector('form.needs-validation').addEventListener('submit', function() {
            const firstInvalid = this.querySelector(':invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus({ preventScroll: true });
            }
        });

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
