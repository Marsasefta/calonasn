<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Pengaturan Akun</title>
</head>

<body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')

    <div class="db-content text-dark">
        <div class="container mb-4">
            <div class="row mb-5">
                <div class="col-12">
                    <h1 class="h2 mb-0">Pengaturan Profil</h1>
                    <p class="text-muted">Kelola informasi akun dan keamanan kamu.</p>
                </div>
            </div>

            @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center text-dark">
                        <i class="fe fe-check-circle me-2 fs-4"></i>
                        <div>
                            <strong>Berhasil!</strong>
                            {{ session('status') === 'password-updated' ? 'Password kamu telah diperbarui.' : 'Informasi profil berhasil disimpan.' }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h4 class="mb-0">Informasi Profil</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('profile.update') }}">
                                @csrf
                                @method('patch')

                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $user->name) }}" required autofocus>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nomor HP</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', $user->phone) }}" placeholder="08xxxx">
                                    @error('phone')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 text-dark">
                            <h4 class="mb-0">Ubah Password</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('password.update') }}">
                                @csrf
                                @method('put')

                                <div class="mb-3">
                                    <label class="form-label">Password Saat Ini</label>
                                    <div class="input-group">
                                        <input type="password" name="current_password"
                                            class="form-control @if ($errors->updatePassword->has('current_password')) is-invalid @endif"
                                            id="current_password">
                                        <button class="btn btn-outline-secondary toggle-password" type="button"
                                            data-target="current_password">
                                            <i class="fe fe-eye"></i>
                                        </button>
                                    </div>
                                    @foreach ($errors->updatePassword->get('current_password') as $message)
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @endforeach
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" name="password"
                                            class="form-control @if ($errors->updatePassword->has('password')) is-invalid @endif"
                                            id="password">
                                        <button class="btn btn-outline-secondary toggle-password" type="button"
                                            data-target="password">
                                            <i class="fe fe-eye"></i>
                                        </button>
                                    </div>
                                    @foreach ($errors->updatePassword->get('password') as $message)
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @endforeach
                                </div>

                                <div class="mb-3 text-dark">
                                    <label class="form-label">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="password_confirmation">
                                        <button class="btn btn-outline-secondary toggle-password" type="button"
                                            data-target="password_confirmation">
                                            <i class="fe fe-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-outline-primary text-dark">Update
                                    Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll top -->
    @include('partials.btn-scroll-top')
    <!-- Scripts -->
    @include('partials.scripts')
    <script src="assets/js/vendors/tnsSlider.js"></script>
    <script src="assets/js/vendors/chart.js"></script>
    <script src="assets/js/vendors/navbar-nav.js"></script>

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

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
