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
                        <h1 class="mb-1 h2 fw-bold">Edit Peserta</h1>
                        <p class="text-muted mb-0">Perbarui data akun, peran, dan akses Premium peserta.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-secondary">
                            <i class="fe fe-eye me-1"></i> Lihat Profil
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fe fe-arrow-left me-1"></i> Kembali ke Data Peserta
                        </a>
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <div class="fw-semibold mb-1">Data belum bisa disimpan.</div>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-xl-8 col-lg-10 col-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Informasi Peserta</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label" for="name">Nama</label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        required
                                    />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        required
                                    />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="phone">Telepon</label>
                                    <input
                                        type="text"
                                        id="phone"
                                        name="phone"
                                        value="{{ old('phone', $user->phone) }}"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="Contoh: 08123456789"
                                    />
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="role">Peran</label>
                                    <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Peserta</option>
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-check mb-4">
                                    <input
                                        class="form-check-input"
                                        name="is_premium"
                                        type="checkbox"
                                        id="isPremiumCheckbox"
                                        value="1"
                                        {{ old('is_premium', $user->is_premium) ? 'checked' : '' }}
                                    />
                                    <label class="form-check-label" for="isPremiumCheckbox">Akses Premium aktif</label>
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fe fe-save me-1"></i> Simpan Perubahan
                                    </button>
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-secondary">
                                        Batal
                                    </a>
                                </div>
                            </form>
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
