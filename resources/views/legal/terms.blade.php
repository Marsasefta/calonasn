<!doctype html>
<html lang="id">

<head>
    @include('partials.head')
    <title>Syarat &amp; Ketentuan | CalonASN.id</title>
</head>

<body>
    <main class="py-5">
        <div class="container" style="max-width: 820px;">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center gap-2">
                    <img src="{{ asset('image/logoasn-icon.png') }}" alt="Logo CalonASN" width="34" height="34" class="rounded-circle">
                    <span class="fs-4 fw-bold text-dark">CalonASN<span class="text-primary">.id</span></span>
                </a>
                <div class="d-flex gap-2">
                    <a href="{{ route('legal.privacy') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Kebijakan Privasi</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-pill px-3">Daftar Akun</a>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h3 fw-bold mb-3">Syarat &amp; Ketentuan CalonASN.id</h1>
                    @include('partials.legal.terms-content')
                </div>
            </div>
        </div>
    </main>
    @include('partials.scripts')
</body>

</html>
