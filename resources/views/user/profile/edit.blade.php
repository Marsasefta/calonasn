<!doctype html>
<html lang="id">

<head>
    @include('partials.head')
    <title>Pengaturan Akun | CalonASN.id</title>
    <style>
        .profile-shell {
            max-width: 1060px;
            margin: 0 auto;
        }

        .profile-avatar {
            width: 68px;
            height: 68px;
            border-radius: 999px;
            background: linear-gradient(135deg, #1e40af 0%, #0ea5e9 100%);
            color: #ffffff;
            font-size: 1.65rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
        }
    </style>
</head>

<body>
    @include('partials.navbar')
    @include('partials.navbar-student')

    <div class="db-content">
        <div class="container-fluid py-3 py-md-4">
            <div class="profile-shell">

                <div class="mb-4">
                    <h1 class="h2 fw-bold mb-1">Pengaturan Akun</h1>
                    <p class="text-muted small mb-0">Kelola informasi profil, nomor WhatsApp aktif, dan keamanan password akun kamu.</p>
                </div>

                @if (session('status') === 'profile-updated' || session('status') === 'password-updated' || session('status') === 'verification-link-sent')
                    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fe fe-check-circle fs-4 flex-shrink-0"></i>
                            <div class="small fw-medium">
                                <strong>Berhasil!</strong>
                                @if (session('status') === 'password-updated')
                                    Password kamu telah diperbarui.
                                @elseif (session('status') === 'verification-link-sent')
                                    Link verifikasi baru telah dikirim ke alamat email kamu.
                                @else
                                    Informasi profil berhasil disimpan.
                                @endif
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                <div class="row g-4 align-items-start">
                    {{-- KARTU RINGKASAN AKUN (Atas di HP, Kanan di Desktop) --}}
                    <div class="col-12 col-lg-4 order-1 order-lg-2">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 text-center">
                                <div class="profile-avatar mb-3">
                                    {{ strtoupper(mb_substr(trim($user->name ?? 'P'), 0, 1, 'UTF-8')) }}
                                </div>
                                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                                <div class="text-muted small mb-2 text-break">{{ $user->email }}</div>

                                <div class="d-flex flex-wrap justify-content-center gap-1.5 mb-3">
                                    <span class="badge {{ ($packageStatus ?? 'free') !== 'free' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary-emphasis border' }} rounded-pill px-3 py-1 fw-semibold">
                                        {{ $packageLabel ?? 'Paket Gratis' }}
                                    </span>
                                    @if (!empty($isGoogleAccount))
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fw-semibold">
                                            Login Google
                                        </span>
                                    @endif
                                </div>

                                <div class="row g-2 text-center mb-3">
                                    <div class="col-6">
                                        <div class="p-2.5 rounded-3 border">
                                            <div class="small text-muted">Tryout Selesai</div>
                                            <div class="fs-5 fw-bold text-primary">{{ $completedExamsCount ?? 0 }}x</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-2.5 rounded-3 border">
                                            <div class="small text-muted">Skor Tertinggi</div>
                                            <div class="fs-5 fw-bold text-success">{{ $highestScore ?? 0 }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="small text-muted mb-3">
                                    Nama tampil di publik/leaderboard: <strong>{{ $user->maskedName() }}</strong><br>
                                    Bergabung: {{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-' }}
                                </div>

                                <div class="d-grid gap-2">
                                    @if (($packageStatus ?? 'free') === 'free')
                                        <a href="{{ route('user.pilih-paket') }}" class="btn btn-warning text-dark rounded-pill fw-bold">
                                            <i class="fe fe-zap me-1"></i> Upgrade Paket Premium
                                        </a>
                                    @else
                                        <a href="{{ route('ujian.persiapan', 1) }}" class="btn btn-primary rounded-pill fw-bold">
                                            <i class="fe fe-edit me-1"></i> Mulai Simulasi CAT
                                        </a>
                                    @endif
                                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                                        Kembali ke Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM FORM PROFIL & PASSWORD --}}
                    <div class="col-12 col-lg-8 order-2 order-lg-1">
                        <!-- Form Informasi Profil -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-transparent border-bottom py-3 px-4">
                                <h5 class="mb-0 fw-bold"><i class="fe fe-user text-primary me-2"></i>Informasi Profil</h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="post" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('patch')

                                    <div class="mb-3">
                                        <label for="profileName" class="form-label fw-semibold">Nama Lengkap</label>
                                        <input type="text" id="profileName" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="profileEmail" class="form-label fw-semibold">Alamat Email</label>
                                        <input type="email" id="profileEmail" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                            <div class="mt-2 p-2.5 rounded-3 bg-warning-subtle text-dark small">
                                                Email Anda belum terverifikasi.
                                                <button form="send-verification" class="btn btn-link btn-sm p-0 fw-bold align-baseline">
                                                    Klik di sini untuk kirim ulang link verifikasi.
                                                </button>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-4">
                                        <label for="profilePhone" class="form-label fw-semibold">Nomor WhatsApp / HP</label>
                                        <input type="tel" id="profilePhone" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890">
                                        <div class="form-text">Digunakan untuk konfirmasi transaksi dan info penting tryout.</div>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                                        <i class="fe fe-save me-1"></i> Simpan Perubahan
                                    </button>
                                </form>

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                        @csrf
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Form Ubah Password -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-transparent border-bottom py-3 px-4">
                                <h5 class="mb-0 fw-bold"><i class="fe fe-lock text-primary me-2"></i>Keamanan &amp; Ubah Password</h5>
                            </div>
                            <div class="card-body p-4">
                                @if (!empty($isGoogleAccount))
                                    <div class="alert alert-info border-0 rounded-3 small mb-3">
                                        <i class="fe fe-info me-1"></i>
                                        Akun Anda terdaftar melalui <strong>Google</strong>. Jika belum pernah membuat password manual dan ingin mengaturnya, silakan keluar sebentar atau gunakan fitur <strong>Lupa Password</strong> di halaman login.
                                    </div>
                                @endif

                                <form method="post" action="{{ route('password.update') }}">
                                    @csrf
                                    @method('put')

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label fw-semibold">Password Saat Ini</label>
                                        <div class="input-group">
                                            <input type="password" name="current_password"
                                                class="form-control @if ($errors->updatePassword->has('current_password')) is-invalid @endif"
                                                id="current_password" autocomplete="current-password">
                                            <button class="btn btn-outline-secondary toggle-password" type="button"
                                                data-target="current_password" aria-label="Lihat password">
                                                <i class="fe fe-eye"></i>
                                            </button>
                                        </div>
                                        @foreach ($errors->updatePassword->get('current_password') as $message)
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @endforeach
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label fw-semibold">Password Baru</label>
                                        <div class="input-group">
                                            <input type="password" name="password"
                                                class="form-control @if ($errors->updatePassword->has('password')) is-invalid @endif"
                                                id="password" autocomplete="new-password" placeholder="Min. 8 karakter">
                                            <button class="btn btn-outline-secondary toggle-password" type="button"
                                                data-target="password" aria-label="Lihat password">
                                                <i class="fe fe-eye"></i>
                                            </button>
                                        </div>
                                        @foreach ($errors->updatePassword->get('password') as $message)
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @endforeach
                                    </div>

                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" class="form-control"
                                                id="password_confirmation" autocomplete="new-password" placeholder="Ulangi password baru">
                                            <button class="btn btn-outline-secondary toggle-password" type="button"
                                                data-target="password_confirmation" aria-label="Lihat password">
                                                <i class="fe fe-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                                        <i class="fe fe-shield me-1"></i> Update Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('partials.btn-scroll-top')
    @include('partials.scripts')
    <script src="/build/assets/js/vendors/navbar-nav.js"></script>
    <script>
        document.querySelectorAll('.toggle-password').forEach(function(button) {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                if (!input || !icon) return;

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fe-eye', 'fe-eye-off');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fe-eye-off', 'fe-eye');
                }
            });
        });
    </script>
</body>

</html>
