<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Simulasi Ujian</title>
</head>

<body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')

    <div class="db-content text-dark">
        <div class="container-fluid mb-4">
            <div class="row align-items-center mb-4 bg-white p-3 shadow-sm rounded">
                <div class="col-md-6">
                    <h4 class="mb-0 fw-bold text-primary">{{ $tryout->title }}</h4>
                    <p class="mb-0 text-muted small">Persiapan Simulasi CAT CPNS</p>
                </div>
                <div class="col-md-6 text-end">
                    <h3 class="mb-0 fw-bold text-dark">{{ $tryout->duration_minutes }} Menit</h3>
                    <span class="small text-muted">Durasi Pengerjaan</span>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body p-5 text-center">

                            @if ($access['status'] == 'unlocked')
                                <div class="mb-4">
                                    <div class="display-4 text-success mb-3">
                                        <i class="fe fe-unlock"></i>
                                    </div>
                                    <h3 class="fw-bold">Akses Terbuka!</h3>
                                    <p class="text-muted">Pembayaran berhasil diverifikasi. Anda memiliki satu
                                        kesempatan untuk mengerjakan tryout ini sekarang.</p>
                                </div>

                                <div class="alert alert-info border-0 shadow-sm mb-4">
                                    <ul class="text-start mb-0 small">
                                        <li>Pastikan koneksi internet stabil.</li>
                                        <li>Ujian akan otomatis berhenti jika waktu habis.</li>
                                        <li>Satu kali klik "Selesai", akses akan terkunci kembali.</li>
                                    </ul>
                                </div>

                                <a href="{{ route('ujian.mulai', $tryout->id) }}"
                                    class="btn btn-primary btn-lg w-100 shadow-sm">
                                    <i class="fe fe-play me-2"></i> Mulai Ujian Sekarang
                                </a>
                            @else
                                <div class="mb-4">
                                    <div class="display-4 text-warning mb-3">
                                        <i class="fe fe-lock"></i>
                                    </div>
                                    <h3 class="fw-bold">Akses Terkunci</h3>
                                    <p class="text-muted">{{ $access['message'] }}</p>
                                </div>

                                @if (str_contains($access['message'], 'beli'))
                                    <div class="bg-light p-3 rounded mb-4">
                                        <span class="text-muted d-block small">Harga Paket:</span>
                                        <h4 class="fw-bold text-primary mb-0">Rp
                                            {{ number_format($tryout->price, 0, ',', '.') }}</h4>
                                    </div>

                                    <a href="{{ route('checkout', $tryout->id) }}"
                                        class="btn btn-primary btn-lg w-100 shadow-sm">
                                        <i class="fe fe-shopping-cart me-2"></i> Beli Akses Sekarang
                                    </a>
                                @else
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('checkout', $tryout->id) }}" class="btn btn-outline-primary">
                                            Beli Lagi untuk Mengulang
                                        </a>
                                        <a href="{{ route('dashboard') }}" class="btn btn-link text-muted">
                                            Kembali ke Dashboard
                                        </a>
                                    </div>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll top -->
    @include('partials.btn-scroll-top')
    <!-- Scripts -->
    @include('partials.scripts')
    <script src="assets/js/vendors/tnsSlider.js"></script>
    <script src="assets/js/vendors/chart.js"></script>
    <script src="assets/js/vendors/navbar-nav.js"></script>
</body>

</html>
