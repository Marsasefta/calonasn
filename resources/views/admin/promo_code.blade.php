<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body>
    <div id="db-wrapper">
        @include('partials.navbar-vertical')

        <div id="page-content">
            @include('partials.dashboard-header')

            <div class="container-fluid p-4">
                
                <!-- Header Halaman -->
                <div class="row">
                    <div class="col-12">
                        <div class="border-bottom pb-3 mb-4 d-flex justify-content-between align-items-center">
                            <h1 class="mb-0 h2 fw-bold">Kode Promo</h1>
                            <!-- Tombol Pemicu Modal Tambah -->
                            <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalTambahPromo">
                                <i class="fe fe-plus me-2"></i> Tambah Kode Promo
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Notifikasi Sukses / Balasan Simpan -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fe fe-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Notifikasi Gagal / Error Validasi -->
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Tabel Konten Utama (Daftar Kode Promo) -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="table-responsive">
                                <table class="table table-hover align-items-center mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="px-4 py-3" width="60">No</th>
                                            <th class="py-3">Kode Promo</th>
                                            <th class="py-3">Potongan Harga</th>
                                            <th class="py-3">Status</th>
                                            <th class="py-3">Tanggal Dibuat</th>
                                            <th class="py-3 text-end px-4" width="150">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($promoCodes as $index => $promo)
                                        <tr>
                                            <td class="px-4">{{ $index + 1 }}</td>
                                            <td>
                                                <span class="badge bg-light text-primary border px-3 py-2 fs-6 text-uppercase fw-bold">
                                                    {{ $promo->code }}
                                                </span>
                                            </td>
                                            <td class="fw-semibold text-dark">
                                                Rp {{ number_format($promo->discount_amount, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @if($promo->status == 'aktif')
                                                    <span class="badge bg-success-soft text-success px-2 py-1">
                                                        <i class="fe fe-check-circle me-1 small"></i> Aktif
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-soft text-danger px-2 py-1">
                                                        <i class="fe fe-x-circle me-1 small"></i> Non-Aktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-muted">{{ $promo->created_at->format('d M Y, H:i') }} WIB</td>
                                            <td class="text-end px-4">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <!-- Tombol Edit -->
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalEditPromo{{ $promo->id }}">
                                                        <i class="fe fe-edit-2"></i>
                                                    </button>
                                                    
                                                    <!-- Tombol Hapus -->
                                                    <button type="button" class="btn btn-outline-danger btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalHapusPromo{{ $promo->id }}">
                                                        <i class="fe fe-trash-2"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fe fe-percent d-block mb-2 text-muted" style="font-size: 2rem;"></i>
                                                Belum ada kode promo yang dibuat.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 1. SCRIPT PARTIALS DILOAD TERLEBIH DAHULU -->
    @include('partials.scripts')

    <!-- 2. KUMPULAN MODAL DI LETAKKAN DI LUAR STRUKTUR TABEL / DI BAWAH SCRIPT -->
    
    <!-- Modal Tambah Promo -->
    <div class="modal fade" id="modalTambahPromo" tabindex="-1" aria-labelledby="modalTambahPromoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="modalTambahPromoLabel">Buat Kode Promo Baru</h5>
                    <button type="button" class="btn-close" data-bs-close="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.promo.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="code" class="form-label fw-bold">Kode Promo</label>
                            <input type="text" class="form-control text-uppercase fw-bold form-control-lg" id="code" name="code" placeholder="Contoh: TRYOUTCPNS" required maxlength="50" autocomplete="off">
                            <div class="form-text">Gunakan huruf kapital dan tanpa spasi agar mudah digunakan user.</div>
                        </div>
                        <div class="mb-3">
                            <label for="discount_amount" class="form-label fw-bold">Jumlah Potongan Harga (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-medium">Rp</span>
                                <input type="number" class="form-control form-control-lg" id="discount_amount" name="discount_amount" placeholder="5000" min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Status Awal</label>
                            <select class="form-select form-control-lg" id="status" name="status" required>
                                <option value="aktif" selected>Aktif (Langsung bisa digunakan)</option>
                                <option value="non-aktif">Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top-0 px-4 py-3">
                        <button type="button" class="btn btn-outline-secondary" data-bs-close="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan Kode</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Looping Modal Edit & Hapus Agar Terisolasi Sempurna dari Elemen Tabel -->
    @foreach($promoCodes as $promo)
        <!-- MODAL EDIT DATA -->
        <div class="modal fade" id="modalEditPromo{{ $promo->id }}" tabindex="-1" aria-labelledby="modalEditPromoLabel{{ $promo->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold" id="modalEditPromoLabel{{ $promo->id }}">Ubah Kode Promo</h5>
                        <button type="button" class="btn-close" data-bs-close="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.promo.update', $promo->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kode Promo</label>
                                <input type="text" class="form-control text-uppercase fw-bold form-control-lg" name="code" value="{{ $promo->code }}" required maxlength="50" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jumlah Potongan Harga (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-medium">Rp</span>
                                    <input type="number" class="form-control form-control-lg" name="discount_amount" value="{{ intval($promo->discount_amount) }}" min="0" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select class="form-select form-control-lg" name="status" required>
                                    <option value="aktif" {{ $promo->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="non-aktif" {{ $promo->status == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-top-0 px-4 py-3">
                            <button type="button" class="btn btn-outline-secondary" data-bs-close="modal">Batal</button>
                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL CONFIRM HAPUS -->
        <div class="modal fade" id="modalHapusPromo{{ $promo->id }}" tabindex="-1" aria-labelledby="modalHapusPromoLabel{{ $promo->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0 shadow">
                    <div class="modal-body text-center p-4">
                        <i class="fe fe-alert-triangle text-danger d-block mb-3" style="font-size: 3rem;"></i>
                        <h4 class="fw-bold mb-2">Hapus Kode Promo?</h4>
                        <p class="text-muted mb-0">Apakah Anda yakin ingin menghapus kode <span class="fw-bold text-dark">{{ $promo->code }}</span>? Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                    <div class="modal-footer bg-light justify-content-center border-top-0 gap-2 py-3">
                        <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-close="modal">Batal</button>
                        <form action="{{ route('admin.promo.destroy', $promo->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm px-3">Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</body>
</html>