<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <title>Generate Tryout Gratis | Admin</title>
</head>

<body>
    <!-- Wrapper -->
    <div id="db-wrapper">
        @include('partials.navbar-vertical')

        <div id="page-content">
            @include('partials.dashboard-header')

            <div class="container-fluid p-4">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="mb-0 h2 fw-bold">Program Tryout Gratis</h1>
                                <p class="mb-0 text-muted">Generate akun dan kode redeem untuk tryout gratis</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-12 col-12 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white pb-0 pt-4 border-0">
                                <h4 class="mb-0">Generate Kode Baru</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.free-tryout.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Berlaku Dari</label>
                                        <input type="date" class="form-control" name="valid_from" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Berlaku Sampai</label>
                                        <input type="date" class="form-control" name="valid_until" value="{{ date('Y-m-d', strtotime('+3 days')) }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fe fe-plus me-1"></i> Generate
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8 col-lg-7 col-md-12 col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white pb-0 pt-4 border-0">
                                <h4 class="mb-0">Daftar Kode Redeem</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 text-nowrap">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Redeem</th>
                                                <th>Email Akun</th>
                                                <th>Masa Berlaku</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($codes as $index => $c)
                                                <tr>
                                                    <td>{{ $codes->firstItem() + $index }}</td>
                                                    <td><span class="badge bg-primary fs-6">{{ $c->code }}</span></td>
                                                    <td>{{ $c->user->email ?? '-' }}</td>
                                                    <td>
                                                        {{ $c->valid_from->format('d M Y') }} - {{ $c->valid_until->format('d M Y') }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">Belum ada kode di-generate.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    {{ $codes->links('pagination::bootstrap-5') }}
                                </div>
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
