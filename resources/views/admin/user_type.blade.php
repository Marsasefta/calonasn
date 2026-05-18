<!doctype html>
<html lang="en">
<head>
    @include('partials.head')
</head>

<body>
    <!-- Wrapper -->
    <div id="db-wrapper">
        @include('partials.navbar-vertical')

        <!-- Page Content -->
        <main id="page-content">
            @include('partials.dashboard-header')

            <section class="container-fluid p-4">
                <div class="row mb-4">
                    <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                        <div>
                            <h1 class="mb-1 h2 fw-bold">Manajemen Pengguna</h1>
                            <p class="text-muted mb-0">Kelola data peserta, hak Premium, dan reset password untuk pengguna.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                                <i class="fe fe-plus me-1"></i> Tambah Peserta
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-refresh-cw me-1"></i> Refresh
                            </a>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row gy-4 mb-4">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-column gap-3">
                                <div class="d-flex align-items-center justify-content-between lh-1">
                                    <div>
                                        <span class="fs-6 text-uppercase fw-semibold ls-md">Total User</span>
                                    </div>
                                    <div>
                                        <span class="fe fe-users fs-3 text-primary"></span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    <h2 class="fw-bold mb-0">{{ $users->count() }}</h2>
                                    <span class="fw-medium small text-muted">Total peserta terdaftar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-column gap-3">
                                <div class="d-flex align-items-center justify-content-between lh-1">
                                    <div>
                                        <span class="fs-6 text-uppercase fw-semibold ls-md">Premium</span>
                                    </div>
                                    <div>
                                        <span class="fe fe-star fs-3 text-warning"></span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    <h2 class="fw-bold mb-0">{{ $users->where('is_premium', true)->count() }}</h2>
                                    <span class="fw-medium small text-muted">Akses Premium aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-column gap-3">
                                <div class="d-flex align-items-center justify-content-between lh-1">
                                    <div>
                                        <span class="fs-6 text-uppercase fw-semibold ls-md">Verifikasi</span>
                                    </div>
                                    <div>
                                        <span class="fe fe-check-circle fs-3 text-info"></span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    <h2 class="fw-bold mb-0">{{ $users->whereNotNull('email_verified_at')->count() }}</h2>
                                    <span class="fw-medium small text-muted">Email terverifikasi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-column gap-3">
                                <div class="d-flex align-items-center justify-content-between lh-1">
                                    <div>
                                        <span class="fs-6 text-uppercase fw-semibold ls-md">Export HP</span>
                                    </div>
                                    <div>
                                        <span class="fe fe-download fs-3 text-success"></span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    <p class="mb-0 small text-muted">Untuk Excel gunakan tanda kutip tunggal di depan angka.</p>
                                    <code class="small">'0812xxxxxxxx</code>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Daftar Peserta</h5>
                                <span class="text-muted small">{{ $users->count() }} peserta</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Telepon</th>
                                            <th>Premium</th>
                                            <th>Terdaftar</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone ?? '-' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $user->is_premium ? 'success' : 'secondary' }}">
                                                        {{ $user->is_premium ? 'Ya' : 'Tidak' }}
                                                    </span>
                                                </td>
                                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Profil">
                                                            <i class="fe fe-eye"></i>
                                                        </a>
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus peserta ini?')" title="Hapus">
                                                                <i class="fe fe-trash-2"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="fe fe-inbox fs-3 mb-2 d-block"></i>
                                                        Tidak ada peserta terdaftar.
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Modal Tambah Peserta -->
    <div class="modal fade" id="createUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Peserta Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="phone" class="form-control" placeholder="Contoh: '08123456789" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Peran</label>
                            <select name="role" class="form-select" required>
                                <option value="user">Peserta</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="is_premium" type="checkbox" id="isPremiumCheckbox" value="1" />
                            <label class="form-check-label" for="isPremiumCheckbox">Berikan akses Premium</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Peserta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('partials.scripts')
</body>
</html>
