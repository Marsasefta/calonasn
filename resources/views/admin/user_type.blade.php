<!doctype html>
<html lang="en">
<head>
    @include('partials.head')
</head>

<body>
    <!-- Wrapper -->
    <div id="db-wrapper">
        <!-- navbar vertical -->
        @include('partials.navbar-vertical')

        <!-- Page Content -->
        <main id="page-content">
            @include('partials.dashboard-header')

            <!-- Page Header -->
            <!-- Container fluid -->
            <section class="container-fluid p-4">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="border-bottom pb-3 mb-3 d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-lg-center">
                            <div>
                                <h1 class="mb-0 h2 fw-bold">Kelola Peserta</h1>
                                <p class="text-muted small mt-1">Atur hak akses dan peran peserta di platform</p>
                            </div>
                            <div class="d-flex gap-3">
                                <div class="input-group">
                                    <input class="form-control" type="text" id="searchInput" placeholder="Cari peserta..." />
                                    <span class="input-group-text"><i class="fe fe-search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik Peserta -->
                <div class="row gy-4 mb-4">
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-column gap-3">
                                <div class="d-flex align-items-center justify-content-between lh-1">
                                    <div>
                                        <span class="fs-6 text-uppercase fw-semibold ls-md">Total Peserta</span>
                                    </div>
                                    <div>
                                        <span class="fe fe-users fs-3 text-primary"></span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    <h2 class="fw-bold mb-0">{{ $users->count() }}</h2>
                                    <span class="fw-medium small text-muted">Semua pengguna terdaftar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-column gap-3">
                                <div class="d-flex align-items-center justify-content-between lh-1">
                                    <div>
                                        <span class="fs-6 text-uppercase fw-semibold ls-md">Admin</span>
                                    </div>
                                    <div>
                                        <span class="fe fe-user-check fs-3 text-danger"></span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    <h2 class="fw-bold mb-0">{{ $users->where('role', 'admin')->count() }}</h2>
                                    <span class="fw-medium small text-muted">Pengguna admin</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-column gap-3">
                                <div class="d-flex align-items-center justify-content-between lh-1">
                                    <div>
                                        <span class="fs-6 text-uppercase fw-semibold ls-md">Peserta</span>
                                    </div>
                                    <div>
                                        <span class="fe fe-user fs-3 text-success"></span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    <h2 class="fw-bold mb-0">{{ $users->where('role', 'user')->count() }}</h2>
                                    <span class="fw-medium small text-muted">Pengguna regular</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-column gap-3">
                                <div class="d-flex align-items-center justify-content-between lh-1">
                                    <div>
                                        <span class="fs-6 text-uppercase fw-semibold ls-md">Terverifikasi</span>
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
                </div>

                <!-- Tabel Peserta -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Telepon</th>
                                            <th>Peran</th>
                                            <th>Status</th>
                                            <th>Terdaftar</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $index => $user)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="avatar avatar-sm rounded-circle bg-primary-light">
                                                            <span class="avatar-initials rounded-circle fw-bold text-primary">
                                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                        <span class="fw-medium">{{ $user->name }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{ $user->email }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{ $user->phone ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <form class="role-form d-inline" data-user-id="{{ $user->id }}">
                                                        @csrf
                                                        <select class="form-select form-select-sm role-select" name="role">
                                                            <option value="user" @selected($user->role == 'user')>Peserta</option>
                                                            <option value="admin" @selected($user->role == 'admin')>Admin</option>
                                                        </select>
                                                    </form>
                                                </td>
                                                <td>
                                                    @if($user->email_verified_at)
                                                        <span class="badge bg-success-light text-success">Terverifikasi</span>
                                                    @else
                                                        <span class="badge bg-warning-light text-warning">Menunggu</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="text-muted small">{{ $user->created_at->format('d M Y') }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-ghost-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="fe fe-more-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#">
                                                                <i class="fe fe-eye me-2"></i>Lihat Detail
                                                            </a>
                                                            <a class="dropdown-item" href="#">
                                                                <i class="fe fe-edit me-2"></i>Edit
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="#">
                                                                <i class="fe fe-trash-2 me-2"></i>Hapus
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="fe fe-inbox fs-3 mb-2 d-block"></i>
                                                        <p>Tidak ada peserta terdaftar</p>
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

    <!-- Modal Edit Peserta -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" id="editUserName">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="editUserEmail">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="editUserPhone">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Peran</label>
                            <select class="form-select" id="editUserRole">
                                <option value="user">Peserta</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveUserBtn">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    @include('partials.scripts')

    <script>
        // Handle role change
        document.querySelectorAll('.role-select').forEach(select => {
            select.addEventListener('change', function() {
                const form = this.closest('.role-form');
                const userId = form.dataset.userId;
                const role = this.value;
                
                // Send AJAX request to update role
                fetch(`/admin/users/${userId}/update-role`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ role: role })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Show success message
                        alert('Peran berhasil diperbarui');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui peran');
                });
            });
        });

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('tbody tr');

        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
