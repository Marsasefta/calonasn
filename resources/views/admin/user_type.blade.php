<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        /* Penyesuaian tampilan agar menyatu dengan tema Bootstrap */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0px !important;
            margin: 0px !important;
        }

        div.dataTables_wrapper div.dataTables_filter {
            text-align: right;
            padding: 1rem;
        }

        div.dataTables_wrapper div.dataTables_length {
            padding: 1rem;
        }

        div.dataTables_wrapper div.dataTables_info {
            padding: 1rem;
        }
    </style>
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
                            <h1 class="mb-1 h2 fw-bold">Manajemen Pengguna</h1>
                            <p class="text-muted mb-0">Kelola data peserta, hak Premium, dan reset password untuk
                                pengguna.</p>
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

                @if (session('success'))
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
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Daftar Peserta</h5>
                                <span class="text-muted small">{{ $users->count() }} peserta</span>
                            </div>
                            <div class="table-responsive">
                                <table id="usersTable" class="table table-hover mb-0" style="width:100%">
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
                                            @php
                                                // --- LOGIKA FOLLOW UP WA ---
                                                $phoneClean = $user->phone ? ltrim($user->phone, "'") : null;
                                                $phoneClean = $phoneClean
                                                    ? preg_replace('/\D+/', '', $phoneClean)
                                                    : null;

                                                if ($phoneClean && substr($phoneClean, 0, 1) === '0') {
                                                    $phoneClean = '62' . substr($phoneClean, 1);
                                                } elseif ($phoneClean && substr($phoneClean, 0, 1) === '8') {
                                                    $phoneClean = '62' . $phoneClean;
                                                }

                                                $hasWhatsappNumber = $phoneClean && strlen($phoneClean) >= 10;
                                                $namaUser = $user->name ?? 'Kak';

                                                // --- TEKS PESAN WA TERBARU ---
                                                $pesanWA =
                                                    "*Kak {$namaUser}, Pesanan Kakak Masih Tersimpan + Ada Voucher Rp9.000!*\n\n" .
                                                    "Halo Kak,\n\n" .
                                                    "Kami melihat akun Kakak di *CalonASN.id* sudah aktif dan siap digunakan untuk latihan.\n\n" .
                                                    "Supaya lebih hemat, Admin telah menambahkan voucher khusus untuk Kakak:\n\n" .
                                                    "*Kode Voucher:* DISKON9000\n" .
                                                    "*Potongan:* Rp9.000\n\n" .
                                                    "Voucher berlaku sampai pukul *23.59 WIB malam ini*.\n\n" .
                                                    "Setelah itu voucher akan otomatis berakhir dan tidak dapat digunakan kembali.\n\n" .
                                                    "*Lanjutkan pesanan Kakak di:*\n" .
                                                    "www.calonasn.id/pilih-paket\n\n" .
                                                    'Jangan sampai voucher Rp9.000 ini hangus ya, Kak.';

                                                $linkWaMe = $hasWhatsappNumber
                                                    ? 'https://wa.me/' . $phoneClean . '?text=' . urlencode($pesanWA)
                                                    : null;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone ?? '-' }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $user->is_premium ? 'success' : 'secondary' }}">
                                                        {{ $user->is_premium ? 'Ya' : 'Tidak' }}
                                                    </span>
                                                </td>
                                                <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group">
                                                        @if ($linkWaMe)
                                                            <a href="{{ $linkWaMe }}" target="_blank"
                                                                rel="noopener" class="btn btn-sm btn-success text-white"
                                                                style="background-color: #25D366; border-color: #25D366;"
                                                                title="Sapa via WA">
                                                                <i class="fe fe-message-circle"></i>
                                                            </a>
                                                        @endif

                                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                                            class="btn btn-sm btn-outline-primary" title="Lihat Profil">
                                                            <i class="fe fe-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                                            class="btn btn-sm btn-outline-secondary"
                                                            title="Edit Peserta">
                                                            <i class="fe fe-edit-2"></i>
                                                        </a>
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Yakin ingin menghapus peserta ini?')"
                                                                title="Hapus">
                                                                <i class="fe fe-trash-2"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-5">
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
                            <input type="text" name="phone" class="form-control"
                                placeholder="Contoh: 08123456789" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Peran</label>
                            <select name="role" class="form-select" required>
                                <option value="user">Peserta</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="is_premium" type="checkbox" id="isPremiumCheckbox"
                                value="1" />
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

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "search": "Cari peserta:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "columnDefs": [{
                        "orderable": false,
                        "targets": 6
                    } // Mematikan fitur sorting pada kolom 'Aksi'
                ]
            });
        });
    </script>
</body>

</html>
