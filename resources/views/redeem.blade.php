<!doctype html>
<html lang="en">
<head>
    @include('partials.head')
    <title>Klaim Tryout Gratis | CalonASN.id</title>
</head>
<body>
    <main>
        <section class="container d-flex flex-column vh-100">
            <div class="row align-items-center justify-content-center g-0 h-lg-100 py-8">
                <div class="col-lg-5 col-md-8 py-8 py-xl-0">
                    <div class="card shadow">
                        <div class="card-body p-6 d-flex flex-column gap-4">
                            <div>
                                <a href="{{ url('/') }}" class="text-muted text-decoration-none small fw-medium transition-all hover-primary">
                                    <i class="fe fe-arrow-left me-1"></i> Kembali ke Beranda
                                </a>
                            </div>

                            <div>
                                <div class="d-flex flex-column gap-1">
                                    <h1 class="mb-0 fw-bold">Klaim Tryout Gratis</h1>
                                    <span class="text-muted small">
                                        Masukkan kode redeem yang Anda dapatkan dari Admin untuk langsung masuk ke akun tryout gratis Anda.
                                    </span>
                                </div>
                            </div>

                            @if(session('error'))
                                <div class="alert alert-danger mb-0">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if(session('success'))
                                <div class="alert alert-success mb-0">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('redeem.process') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="code" class="form-label">Kode Redeem</label>
                                    <input type="text" id="code" class="form-control form-control-lg text-uppercase" name="code" value="{{ old('code') }}" placeholder="Contoh: TO-ABC1234" required />
                                </div>
                                <div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg fw-bold">Masuk Sekarang</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('partials.scripts')
</body>
</html>
