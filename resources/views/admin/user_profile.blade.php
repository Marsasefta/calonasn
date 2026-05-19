<!doctype html>
<html lang="en">
<head>
    @include('partials.head')
</head>

<body>
<div id="db-wrapper">
    @include('partials.navbar-vertical')

    <main id="page-content">
        @include('partials.dashboard-header')

        <section class="container-fluid p-4">
            <div class="row mb-4">
                <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                    <div>
                        <h1 class="mb-1 h2 fw-bold">Profil Peserta</h1>
                        <p class="text-muted mb-0">Detail lengkap data peserta, status Premium, dan informasi kontak.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <form action="{{ route('admin.users.toggle-premium', $user->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="is_premium" value="{{ $user->is_premium ? 0 : 1 }}" />
                            <button type="submit" class="btn btn-{{ $user->is_premium ? 'warning' : 'success' }}">
                                <i class="fe fe-star me-1"></i> {{ $user->is_premium ? 'Cabut Premium' : 'Berikan Premium' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="fe fe-refresh-cw me-1"></i> Reset Password
                            </button>
                        </form>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fe fe-arrow-left me-1"></i> Kembali ke Data Peserta
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-12">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="avatar avatar-xl rounded-pill bg-primary-light mb-3">
                                <span class="avatar-initials text-primary fs-2 fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                            <p class="text-muted mb-2">{{ ucfirst($user->role) }}</p>
                            <span class="badge bg-{{ $user->is_premium ? 'success' : 'secondary' }}">
                                {{ $user->is_premium ? 'Premium' : 'Reguler' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Informasi Akun</h5>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">Nama lengkap</dt>
                                <dd class="col-sm-8">{{ $user->name }}</dd>

                                <dt class="col-sm-4">Email</dt>
                                <dd class="col-sm-8">{{ $user->email }}</dd>

                                <dt class="col-sm-4">Nomor HP</dt>
                                <dd class="col-sm-8">{{ $user->phone ?? '-' }}</dd>

                                <dt class="col-sm-4">Peran</dt>
                                <dd class="col-sm-8">{{ ucfirst($user->role) }}</dd>

                                <dt class="col-sm-4">Status Verifikasi</dt>
                                <dd class="col-sm-8">{{ $user->email_verified_at ? 'Terverifikasi' : 'Belum terverifikasi' }}</dd>

                                <dt class="col-sm-4">Terdaftar</dt>
                                <dd class="col-sm-8">{{ $user->created_at->format('d M Y H:i') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

@include('partials.scripts')
</body>
</html>
