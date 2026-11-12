<!doctype html>
<html lang="id">

<head>
    @include('partials.head')
    <title>Manajemen Pengguna | CalonASN Admin</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        /* Modern DataTables Styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0 !important;
            margin: 0 !important;
        }

        div.dataTables_wrapper div.dataTables_filter {
            text-align: right;
            padding: 1.25rem 1.5rem;
        }

        div.dataTables_wrapper div.dataTables_filter input {
            border-radius: 9999px;
            padding: 0.45rem 1rem;
            border: 1px solid #cbd5e1;
            outline: none;
            transition: all 0.2s ease;
        }

        div.dataTables_wrapper div.dataTables_filter input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        div.dataTables_wrapper div.dataTables_length {
            padding: 1.25rem 1.5rem;
        }

        div.dataTables_wrapper div.dataTables_info {
            padding: 1.25rem 1.5rem;
            color: #64748b;
            font-size: 0.875rem;
        }

        div.dataTables_wrapper div.dataTables_paginate {
            padding: 1.25rem 1.5rem;
        }

        /* Avatar Inisial */
        .user-avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.88rem;
            letter-spacing: 0.5px;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.08);
        }

        /* Quick Filter Pill Buttons */
        .filter-pill-btn {
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.4rem 1rem;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .filter-pill-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #cbd5e1;
        }

        .filter-pill-btn.active {
            background: #2563eb !important;
            color: #ffffff !important;
            border-color: #2563eb !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        /* Modern Table Card */
        .table-modern-card {
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            overflow: hidden;
        }

        /* Action Buttons Hover */
        .btn-action-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.15s ease-in-out;
        }

        .btn-action-icon:hover {
            transform: translateY(-2px);
        }

        /* Switch Custom Toggle */
        .form-switch .form-check-input {
            width: 2.25em;
            height: 1.2em;
            cursor: pointer;
        }

        /* High Contrast Custom Badges (Override Theme White-Text Bug) */
        .badge-count-dark {
            background-color: #e2e8f0 !important;
            color: #0f172a !important;
            font-weight: 700 !important;
            border: 1px solid #cbd5e1 !important;
        }

        .badge-registered-count {
            background-color: #eff6ff !important;
            color: #1d4ed8 !important;
            font-weight: 700 !important;
            border: 1px solid #bfdbfe !important;
        }

        .badge-status-premium {
            background-color: #fef3c7 !important;
            color: #78350f !important;
            font-weight: 700 !important;
            border: 1px solid #f59e0b !important;
            box-shadow: 0 1px 2px rgba(245, 158, 11, 0.15) !important;
        }

        .badge-status-free {
            background-color: #f1f5f9 !important;
            color: #1e293b !important;
            font-weight: 600 !important;
            border: 1px solid #cbd5e1 !important;
        }

        .badge-role-admin {
            background-color: #ede9fe !important;
            color: #4c1d95 !important;
            font-weight: 700 !important;
            border: 1px solid #c4b5fd !important;
        }

        .badge-role-user {
            background-color: #f8fafc !important;
            color: #334155 !important;
            font-weight: 600 !important;
            border: 1px solid #cbd5e1 !important;
        }

        .badge-admin-tag {
            background-color: #4338ca !important;
            color: #ffffff !important;
            font-weight: 800 !important;
            letter-spacing: 0.5px;
        }
    </style>
</head>

<body>
    <div id="db-wrapper">
        @include('partials.navbar-vertical')

        <main id="page-content">
            @include('partials.dashboard-header')

            <section class="container-fluid p-4">
                <!-- Page Header -->
                <div class="row mb-4">
                    <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h1 class="h2 fw-bold text-dark mb-0">Manajemen Pengguna</h1>
                                <span class="badge badge-registered-count px-3 py-1.5 rounded-pill">
                                    {{ $users->count() }} Terdaftar
                                </span>
                            </div>
                            <p class="text-muted mb-0 small">
                                Kelola direktori peserta, status langganan Premium, dan follow-up WhatsApp marketing.
                            </p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-primary d-inline-flex align-items-center gap-1.5 shadow-sm rounded-pill px-3.5 py-2 fw-semibold" 
                                    data-bs-toggle="modal" data-bs-target="#createUserModal">
                                <i class="fe fe-plus fs-5"></i>
                                <span>Tambah Peserta</span>
                            </button>
                            <a href="{{ route('admin.users.index') }}" 
                               class="btn btn-outline-secondary d-inline-flex align-items-center gap-1.5 rounded-pill px-3 py-2 fw-medium"
                               title="Segarkan Data">
                                <i class="fe fe-refresh-cw"></i>
                                <span class="d-none d-sm-inline">Refresh</span>
                            </a>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2" role="alert">
                        <i class="fe fe-check-circle fs-4 text-success"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- KPI / Summary Metric Cards -->
                <div class="row g-3 mb-4">
                    <!-- Total User -->
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm rounded-4 h-100 p-1" style="border: 1px solid #e2e8f0 !important;">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" 
                                     style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                                    <i class="fe fe-users fs-3"></i>
                                </div>
                                <div>
                                    <span class="d-block text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Total Peserta</span>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $users->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Premium -->
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm rounded-4 h-100 p-1" style="border: 1px solid #e2e8f0 !important;">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" 
                                     style="width: 48px; height: 48px; background: rgba(245, 158, 11, 0.15); color: #d97706;">
                                    <i class="fe fe-award fs-3"></i>
                                </div>
                                <div>
                                    <span class="d-block text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Akun Premium</span>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $users->where('is_premium', true)->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Gratis / Free -->
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm rounded-4 h-100 p-1" style="border: 1px solid #e2e8f0 !important;">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" 
                                     style="width: 48px; height: 48px; background: rgba(100, 116, 139, 0.1); color: #475569;">
                                    <i class="fe fe-user fs-3"></i>
                                </div>
                                <div>
                                    <span class="d-block text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Akun Gratis</span>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $users->where('is_premium', false)->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak WA Siap Follow Up -->
                    @php
                        $totalWithPhone = $users->filter(function($u) {
                            $p = preg_replace('/\D+/', '', (string)$u->phone);
                            return strlen($p) >= 10;
                        })->count();
                    @endphp
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm rounded-4 h-100 p-1" style="border: 1px solid #e2e8f0 !important;">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" 
                                     style="width: 48px; height: 48px; background: rgba(16, 185, 129, 0.15); color: #059669;">
                                    <i class="fe fe-message-circle fs-3"></i>
                                </div>
                                <div>
                                    <span class="d-block text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.5px;">No. WA Valid</span>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $totalWithPhone }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modern Table Card with Quick Filters -->
                <div class="table-modern-card shadow-sm">
                    <!-- Card Header & Quick Filter Pills -->
                    <div class="p-3.5 px-4 border-bottom bg-white d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold text-dark fs-5">Daftar Pengguna</span>
                            <span class="badge badge-count-dark px-2.5 py-1 rounded-pill">
                                {{ $users->count() }} data
                            </span>
                        </div>

                        <!-- Filter Tab Pills -->
                        <div class="d-flex flex-wrap align-items-center gap-1.5" id="quickFilterPills">
                            <button type="button" class="filter-pill-btn active" data-filter="all">
                                Semua ({{ $users->count() }})
                            </button>
                            <button type="button" class="filter-pill-btn" data-filter="premium">
                                👑 Premium ({{ $users->where('is_premium', true)->count() }})
                            </button>
                            <button type="button" class="filter-pill-btn" data-filter="free">
                                Free ({{ $users->where('is_premium', false)->count() }})
                            </button>
                            <button type="button" class="filter-pill-btn" data-filter="whatsapp">
                                💬 Punya WA ({{ $totalWithPhone }})
                            </button>
                            <button type="button" class="filter-pill-btn" data-filter="admin">
                                🛡️ Admin ({{ $users->where('role', 'admin')->count() }})
                            </button>
                        </div>
                    </div>

                    <!-- Responsive Table -->
                    <div class="table-responsive">
                        <table id="usersTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead class="table-light">
                                <tr class="text-uppercase small fw-bold text-muted" style="letter-spacing: 0.5px; font-size: 0.75rem;">
                                    <th class="ps-4" style="width: 50px;">#</th>
                                    <th>Peserta</th>
                                    <th>Peran</th>
                                    <th>Status Paket</th>
                                    <th>Kontak WhatsApp</th>
                                    <th>Terdaftar</th>
                                    <th class="text-end pe-4" style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    @php
                                        // Bersihkan nomor WhatsApp
                                        $phoneClean = $user->phone ? ltrim($user->phone, "'") : null;
                                        $phoneClean = $phoneClean ? preg_replace('/\D+/', '', $phoneClean) : null;

                                        if ($phoneClean && substr($phoneClean, 0, 1) === '0') {
                                            $phoneClean = '62' . substr($phoneClean, 1);
                                        } elseif ($phoneClean && substr($phoneClean, 0, 1) === '8') {
                                            $phoneClean = '62' . $phoneClean;
                                        }

                                        $hasWhatsappNumber = $phoneClean && strlen($phoneClean) >= 10;
                                        $namaUser = $user->name ?? 'Kak';

                                        // Inisial Nama & Warna Avatar Pastel Konsisten
                                        $nameParts = explode(' ', trim($user->name));
                                        $initials = '';
                                        foreach (array_slice($nameParts, 0, 2) as $part) {
                                            $initials .= mb_substr($part, 0, 1);
                                        }
                                        $initials = strtoupper($initials) ?: 'U';

                                        $avatarColors = [
                                            ['bg' => '#e0e7ff', 'text' => '#4338ca'],
                                            ['bg' => '#dbeafe', 'text' => '#1d4ed8'],
                                            ['bg' => '#dcfce7', 'text' => '#15803d'],
                                            ['bg' => '#fef3c7', 'text' => '#b45309'],
                                            ['bg' => '#fce7f3', 'text' => '#be185d'],
                                            ['bg' => '#f3e8ff', 'text' => '#7e22ce'],
                                            ['bg' => '#ffedd5', 'text' => '#c2410c'],
                                        ];
                                        $avatarStyle = $avatarColors[$user->id % count($avatarColors)];

                                        // Template Pesan WA Follow-up Marketing
                                        $pesanWA =
                                            "🔥 *Kak {$namaUser}, Pesanan Kakak Masih Tersimpan + Ada Voucher Rp9.000!*\n\n" .
                                            "Halo Kak,\n\n" .
                                            "Kami melihat akun Kakak di *CalonASN.id* sudah aktif dan siap digunakan untuk latihan CAT SKD CPNS 2026. 📚\n\n" .
                                            "Supaya lebih hemat, Admin telah menambahkan voucher khusus untuk Kakak:\n\n" .
                                            "🎁 *Kode Voucher:* DISKON9000\n" .
                                            "💰 *Potongan:* Rp9.000\n\n" .
                                            "⏰ Voucher berlaku sampai pukul *23.59 WIB malam ini*.\n" .
                                            "Setelah itu voucher akan otomatis berakhir dan tidak dapat digunakan kembali.\n\n" .
                                            "👉 *Lanjutkan pesanan Kakak di:*\n" .
                                            "https://calonasn.id/pilih-paket\n\n" .
                                            '⚠️ Jangan sampai voucher Rp9.000 ini hangus ya, Kak. Semangat belajarnya! 😊';

                                        $urlWhatsAppDirect = $hasWhatsappNumber ? "https://wa.me/{$phoneClean}?text=" . rawurlencode($pesanWA) : null;
                                    @endphp
                                    <tr>
                                        <!-- Index -->
                                        <td class="ps-4 text-muted small fw-semibold">{{ $loop->iteration }}</td>

                                        <!-- Peserta (Avatar + Nama + Email) -->
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="user-avatar-circle" style="background-color: {{ $avatarStyle['bg'] }}; color: {{ $avatarStyle['text'] }};">
                                                    {{ $initials }}
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <a href="{{ route('admin.users.show', $user->id) }}" class="fw-bold text-dark text-decoration-none hover-primary">
                                                            {{ $user->name }}
                                                        </a>
                                                        @if ($user->role === 'admin')
                                                            <span class="badge badge-admin-tag rounded-pill px-2 py-0.5" style="font-size: 0.65rem;">
                                                                ADMIN
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <span class="text-muted small d-inline-flex align-items-center gap-1">
                                                        <i class="fe fe-mail text-secondary" style="font-size: 0.75rem;"></i>
                                                        <span>{{ $user->email }}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Role / Peran -->
                                        <td>
                                            @if ($user->role === 'admin')
                                                <span class="badge badge-role-admin px-2.5 py-1.5 rounded-pill d-inline-flex align-items-center gap-1">
                                                    <i class="fe fe-shield" style="color: #6d28d9 !important;"></i>
                                                    <span>Administrator</span>
                                                </span>
                                            @else
                                                <span class="badge badge-role-user px-2.5 py-1.5 rounded-pill d-inline-flex align-items-center gap-1">
                                                    <i class="fe fe-user" style="color: #64748b !important;"></i>
                                                    <span>Peserta</span>
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Status Paket & Quick Toggle -->
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($user->is_premium)
                                                    <span class="badge badge-status-premium px-2.5 py-1.5 rounded-pill d-inline-flex align-items-center gap-1">
                                                        <i class="fe fe-award" style="color: #d97706 !important;"></i>
                                                        <span>PRO Premium</span>
                                                    </span>
                                                @else
                                                    <span class="badge badge-status-free px-2.5 py-1.5 rounded-pill d-inline-flex align-items-center gap-1">
                                                        <i class="fe fe-user" style="color: #64748b !important;"></i>
                                                        <span>Free User</span>
                                                    </span>
                                                @endif

                                                <!-- Quick Toggle Switch -->
                                                <div class="form-check form-switch mb-0 ms-1" title="Klik untuk ubah status Premium instan">
                                                    <input class="form-check-input premium-toggle-switch" type="checkbox" role="switch"
                                                           data-user-id="{{ $user->id }}"
                                                           {{ $user->is_premium ? 'checked' : '' }} />
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Kontak WhatsApp -->
                                        <td>
                                            @if ($hasWhatsappNumber)
                                                <div class="d-flex align-items-center gap-2">
                                                    <a href="{{ $urlWhatsAppDirect }}" target="_blank" 
                                                       class="badge rounded-pill text-decoration-none px-2.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5 shadow-sm"
                                                       style="background: #25D366; color: #ffffff;"
                                                       title="Langsung chat di WhatsApp">
                                                        <i class="fe fe-message-circle"></i>
                                                        <span>{{ $user->phone }}</span>
                                                        <i class="fe fe-arrow-up-right" style="font-size: 0.7rem;"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-secondary btn-action-icon rounded-circle"
                                                            title="Salin template teks pesan WA"
                                                            data-bs-toggle="modal" data-bs-target="#waModal"
                                                            data-nama="{{ $namaUser }}"
                                                            data-phone="{{ $phoneClean }}"
                                                            data-pesan="{{ $pesanWA }}"
                                                            data-walink="{{ $urlWhatsAppDirect }}">
                                                        <i class="fe fe-copy" style="font-size: 0.8rem;"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <span class="text-muted small fst-italic">
                                                    {{ $user->phone ? $user->phone : 'Belum ada nomor' }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Terdaftar -->
                                        <td>
                                            <span class="d-block fw-semibold text-dark small">
                                                {{ $user->created_at->diffForHumans() }}
                                            </span>
                                            <span class="text-muted" style="font-size: 0.75rem;">
                                                {{ $user->created_at->format('d M Y, H:i') }}
                                            </span>
                                        </td>

                                        <!-- Aksi -->
                                        <td class="text-end pe-4">
                                            <div class="d-inline-flex align-items-center gap-1">
                                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                                   class="btn btn-sm btn-outline-primary btn-action-icon" 
                                                   title="Lihat Detail Profil">
                                                    <i class="fe fe-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                                   class="btn btn-sm btn-outline-secondary btn-action-icon" 
                                                   title="Edit Peserta">
                                                    <i class="fe fe-edit-2"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-warning btn-action-icon btn-reset-password"
                                                        data-user-id="{{ $user->id }}"
                                                        data-user-name="{{ $user->name }}"
                                                        title="Reset Password (Pass1234!)">
                                                    <i class="fe fe-key"></i>
                                                </button>
                                                <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger btn-action-icon btn-delete-user"
                                                            data-user-id="{{ $user->id }}"
                                                            data-user-name="{{ $user->name }}"
                                                            title="Hapus Akun">
                                                        <i class="fe fe-trash-2"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fe fe-users fs-1 d-block mb-2 text-secondary"></i>
                                            Belum ada data peserta terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Hidden Form for Reset Password -->
    <form id="resetPasswordForm" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Modal Tambah Peserta Baru -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-bottom p-4">
                        <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" id="createUserModalLabel">
                            <i class="fe fe-user-plus text-primary"></i>
                            <span>Tambah Peserta Baru</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control rounded-3" placeholder="Contoh: Muhammad Ihsan" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Alamat Email</label>
                            <input type="email" name="email" class="form-control rounded-3" placeholder="nama@email.com" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Nomor WhatsApp / Telepon</label>
                            <input type="text" name="phone" class="form-control rounded-3" placeholder="Contoh: 08123456789" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Peran (Role)</label>
                            <select name="role" class="form-select rounded-3" required>
                                <option value="user" selected>Peserta Ujian</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                        <div class="form-check form-switch p-3 bg-light rounded-3 d-flex align-items-center justify-content-between mb-0">
                            <div>
                                <label class="form-check-label fw-bold text-dark d-block" for="isPremiumCheckbox">Akses Langganan Premium</label>
                                <span class="text-muted small">Beri akses tryout premium langsung</span>
                            </div>
                            <input class="form-check-input ms-0" name="is_premium" type="checkbox" id="isPremiumCheckbox" value="1" />
                        </div>
                    </div>
                    <div class="modal-footer border-top p-3 px-4 bg-light">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan Peserta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal WhatsApp Follow-up Marketing -->
    <div class="modal fade" id="waModal" tabindex="-1" aria-labelledby="waModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom p-4 bg-light">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" id="waModalLabel">
                        <i class="fe fe-message-circle text-success fs-4"></i>
                        <span>Kirim Pesan Promo WhatsApp</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="d-flex align-items-center justify-content-between p-2.5 px-3 rounded-3 mb-3" style="background: rgba(37, 211, 102, 0.1);">
                        <span class="small text-muted">Nomor Tujuan:</span>
                        <strong id="waModalPhone" class="text-dark font-monospace fs-6">-</strong>
                    </div>

                    <label class="form-label fw-semibold text-dark small mb-1">Pratinjau Pesan yang Akan Dikirim:</label>
                    <textarea id="waModalText" class="form-control rounded-3 font-monospace small bg-light" rows="10" readonly></textarea>
                </div>
                <div class="modal-footer border-top p-3 px-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Tutup</button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-3" id="btnCopyWa">
                            <i class="fe fe-copy me-1"></i> Salin Teks
                        </button>
                        <a href="#" target="_blank" class="btn btn-success rounded-pill px-3.5 fw-bold d-inline-flex align-items-center gap-1.5" id="btnOpenWaDirect" style="background: #25D366; border-color: #25D366;">
                            <i class="fe fe-send"></i>
                            <span>Buka WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.scripts')

    <!-- Scripts CDN: jQuery, DataTables & SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            const dataTable = $('#usersTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "pageLength": 15,
                "lengthMenu": [10, 15, 25, 50, 100],
                "language": {
                    "search": "",
                    "searchPlaceholder": "Cari nama, email, telp...",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "zeroRecords": "Tidak ada data peserta yang cocok",
                    "info": "Menampilkan _START_ - _END_ dari _TOTAL_ peserta",
                    "infoEmpty": "0 peserta tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "paginate": {
                        "first": "«",
                        "last": "»",
                        "next": "›",
                        "previous": "‹"
                    }
                },
                "columnDefs": [
                    { "orderable": false, "targets": [6] } // Matikan sorting pada kolom Aksi
                ]
            });

            // Quick Filter Pills Handler
            $('#quickFilterPills .filter-pill-btn').on('click', function() {
                $('#quickFilterPills .filter-pill-btn').removeClass('active');
                $(this).addClass('active');

                const filter = $(this).data('filter');

                if (filter === 'all') {
                    dataTable.search('').columns().search('').draw();
                } else if (filter === 'premium') {
                    dataTable.column(3).search('PRO Premium').draw();
                } else if (filter === 'free') {
                    dataTable.column(3).search('Free User').draw();
                } else if (filter === 'whatsapp') {
                    dataTable.column(4).search('62|08', true, false).draw();
                } else if (filter === 'admin') {
                    dataTable.column(2).search('Administrator').draw();
                }
            });

            // AJAX Toggle Premium Langsung dari Tabel
            $(document).on('change', '.premium-toggle-switch', function() {
                const checkbox = $(this);
                const userId = checkbox.data('user-id');
                const isPremium = checkbox.is(':checked') ? 1 : 0;

                checkbox.prop('disabled', true);

                $.ajax({
                    url: `/admin/users/${userId}/toggle-premium`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_premium: isPremium
                    },
                    success: function(response) {
                        checkbox.prop('disabled', false);
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: response.message || 'Status Premium berhasil diubah!'
                        });

                        // Reload data table agar badge terupdate
                        setTimeout(() => location.reload(), 900);
                    },
                    error: function(xhr) {
                        checkbox.prop('disabled', false);
                        checkbox.prop('checked', !isPremium);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Memperbarui',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan sistem.'
                        });
                    }
                });
            });

            // SweetAlert2 Konfirmasi Hapus Akun
            $(document).on('click', '.btn-delete-user', function() {
                const userId = $(this).data('user-id');
                const userName = $(this).data('user-name');

                Swal.fire({
                    title: 'Hapus Peserta Ini?',
                    html: `Anda akan menghapus akun <strong>${userName}</strong> secara permanen. Tindakan ini tidak dapat dibatalkan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fe fe-trash-2 me-1"></i> Ya, Hapus Akun',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn btn-danger rounded-pill px-4',
                        cancelButton: 'btn btn-secondary rounded-pill px-4'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${userId}`).submit();
                    }
                });
            });

            // SweetAlert2 Konfirmasi Reset Password
            $(document).on('click', '.btn-reset-password', function() {
                const userId = $(this).data('user-id');
                const userName = $(this).data('user-name');

                Swal.fire({
                    title: 'Reset Password Peserta?',
                    html: `Password untuk <strong>${userName}</strong> akan direset menjadi: <br><kbd class="fs-6 mt-2 d-inline-block px-3 py-1 bg-dark text-warning">Pass1234!</kbd>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fe fe-key me-1"></i> Ya, Reset Password',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn btn-primary rounded-pill px-4',
                        cancelButton: 'btn btn-secondary rounded-pill px-4'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('resetPasswordForm');
                        form.action = `/admin/users/${userId}/reset-password`;
                        form.submit();
                    }
                });
            });
        });

        // Script Modal WhatsApp
        document.addEventListener('DOMContentLoaded', function() {
            const waModal = document.getElementById('waModal');
            if (waModal) {
                waModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const pesan = button.getAttribute('data-pesan');
                    const phone = button.getAttribute('data-phone');
                    const waLink = button.getAttribute('data-walink');

                    document.getElementById('waModalPhone').textContent = '+' + phone;
                    document.getElementById('waModalText').value = pesan;
                    document.getElementById('btnOpenWaDirect').setAttribute('href', waLink || '#');

                    const copyBtn = document.getElementById('btnCopyWa');
                    copyBtn.innerHTML = '<i class="fe fe-copy me-1"></i> Salin Teks';
                    copyBtn.className = 'btn btn-outline-secondary rounded-pill px-3';
                });

                document.getElementById('btnCopyWa').addEventListener('click', function() {
                    const textToCopy = document.getElementById('waModalText');
                    navigator.clipboard.writeText(textToCopy.value).then(() => {
                        this.innerHTML = '<i class="fe fe-check me-1"></i> Tersalin!';
                        this.className = 'btn btn-success rounded-pill px-3';
                        setTimeout(() => {
                            this.innerHTML = '<i class="fe fe-copy me-1"></i> Salin Teks';
                            this.className = 'btn btn-outline-secondary rounded-pill px-3';
                        }, 2500);
                    }).catch(err => {
                        console.error('Gagal menyalin:', err);
                    });
                });
            }
        });
    </script>
</body>

</html>
