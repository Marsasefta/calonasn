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
        <div id="page-content">
            @include('partials.dashboard-header')

            <!-- Container fluid -->
            <div class="container-fluid p-4">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="border-bottom pb-3 mb-3">
                            <div class="mb-2 mb-lg-0">
                                <h1 class="mb-0 h2 fw-bold">Tambahkan Sesi Tryout</h1>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-6 col-12">
                        <form action="{{ route('admin.store-tryout') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Tryout</label>
                                        <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="Masukkan nama tryout" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="description" class="form-control" rows="4" placeholder="Deskripsi singkat tryout">{{ old('description') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jadwal Tryout</label>
                                        <input type="datetime-local" name="schedule_at" value="{{ old('schedule_at') }}" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Durasi (menit)</label>
                                        <input type="number" name="duration_minutes" value="{{ old('duration_minutes') }}" class="form-control" placeholder="Durasi ujian dalam menit" min="1" />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Harga Tryout</label>
                                        <input type="number" name="price" value="{{ old('price', 0) }}" class="form-control" placeholder="Masukkan harga dalam rupiah" min="0" />
                                    </div>

                                    <div class="mb-3 form-check form-switch">
                                        <input type="hidden" name="is_active" value="0">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Aktifkan Tryout</label>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Simpan Sesi Tryout</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 class="mb-3">Daftar Sesi Tryout</h4>

                                @if($tryouts->isEmpty())
                                    <p class="text-muted">Belum ada sesi tryout. Buat sesi terlebih dahulu.</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Jadwal</th>
                                                    <th>Durasi</th>
                                                    <th>Harga</th>
                                                    <th>Aktif</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($tryouts as $tryout)
                                                    <tr>
                                                        <td>{{ $tryout->title }}</td>
                                                        <td>{{ $tryout->schedule_at ? date('d M Y H:i', strtotime($tryout->schedule_at)) : '-' }}</td>
                                                        <td>{{ $tryout->duration_minutes ? $tryout->duration_minutes . ' menit' : '-' }}</td>
                                                        <td>Rp {{ number_format($tryout->price ?? 0, 0, ',', '.') }}</td>
                                                        <td>{{ $tryout->is_active ? 'Ya' : 'Tidak' }}</td>
                                                        <td>{{ ucfirst($tryout->status) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.scripts')
</body>

</html>