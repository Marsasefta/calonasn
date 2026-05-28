<!doctype html>
<html lang="en">

<head>
    @include('partials.head')   
    <title>Dashboard Peserta</title>
</head>

@stack('styles')



<style>
    .hover-card,
    .hover-card-premium {
        transition: all .25s ease;
    }

    .hover-card:hover,
    .hover-card-premium:hover {
        transform: translateY(-5px);
    }

    .hover-card:hover {
        box-shadow: 0 1rem 2rem rgba(37, 99, 235, .12) !important;
    }

    .hover-card-premium:hover {
        box-shadow: 0 1.2rem 2.5rem rgba(34, 197, 94, .18) !important;
    }
</style>

<body>
    @include('partials.navbar')
    @include('partials.navbar-student')

    <div class="db-content text-dark">
        <div class="container-fluid py-4">

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm" style="background: linear-gradient(45deg, #0d6efd, #0dcaf0);">
                        <div
                            class="card-body p-4 p-md-5 d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <div class="mb-3 mb-md-0">
                                <h2 class="text-white fw-bold mb-2">Halo, {{ auth()->user()->name ?? 'Pejuang NIP' }}!
                                    👋
                                </h2>
                                <p class="text-white-50 mb-0 fs-5">Waktu terus berjalan. Apa rencanamu hari ini?</p>
                            </div>
                            {{-- <div class="text-center text-md-end bg-white p-3 rounded shadow-sm">
                                <h6 class="text-muted text-uppercase fw-bold mb-1">Menuju Ujian SKD 2026</h6>
                                <div class="display-5 text-primary fw-bold" id="countdown-timer">Menghitung...</div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">

                <!-- CARD GRATIS -->
                <div class="col-lg-6 col-12">

                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden position-relative hover-card">

                        <div class="card-body p-4 p-xl-5 d-flex flex-column">

                            <div class="d-flex align-items-center mb-4">

                                <div class="bg-primary text-white rounded-circle
                        d-flex align-items-center justify-content-center
                        flex-shrink-0 me-3 shadow-sm"
                                    style="width:60px;height:60px;">

                                    <i class="bi bi-lightbulb-fill fs-3"></i>

                                </div>
                                <div>
                                    <span class="badge bg-primary-subtle text-primary fw-semibold mb-2">
                                        GRATIS
                                    </span>

                                    <h3 class="fw-bold mb-0">
                                        Cek Kemampuan Dulu
                                    </h3>
                                </div>

                            </div>

                            <p class="text-muted fs-5 mb-4">

                                Masih ragu dengan kemampuanmu?
                                Coba <strong>10 soal ujicoba gratis</strong> untuk mengukur kesiapan awal sebelum
                                menghadapi simulasi CAT sesungguhnya.

                            </p>

                            <div class="mt-auto">

                                <a href="{{ route('demo.index') }}"
                                    class="btn btn-outline-primary btn-lg rounded-pill
                        fw-bold px-4 w-100 py-3">

                                    Mulai Ujicoba Gratis
                                    <i class="fe fe-arrow-right ms-2"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- CARD PREMIUM -->
                <div class="col-lg-6 col-12">

                    <div
                        class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden
            position-relative hover-card-premium">

                        <!-- Badge -->
                        <div class="position-absolute top-0 end-0">

                            <div class="bg-danger text-white fw-bold px-4 py-2 shadow-sm"
                                style="border-bottom-left-radius:16px;">

                                🔥 PALING LARIS

                            </div>

                        </div>

                        <div class="card-body p-4 p-xl-5 d-flex flex-column">

                            <div class="d-flex align-items-center mb-4">

                                <div class="bg-success text-white rounded-circle
                        d-flex align-items-center justify-content-center
                        flex-shrink-0 me-3 shadow-sm"
                                    style="width:60px;height:60px;">

                                    <i class="bi bi-award-fill fs-3"></i>

                                </div>

                                <div>

                                    <span class="badge bg-success-subtle text-success fw-semibold mb-2">
                                        PREMIUM HOTS
                                    </span>

                                    <h3 class="fw-bold mb-0 text-success">
                                        Langsung Tempur!
                                    </h3>

                                </div>

                            </div>

                            <p class="text-dark fs-5 mb-4">

                                Akses <strong>110 soal HOTS terbaru</strong>,
                                pembahasan lengkap, dan simulasi CAT paling mirip ujian asli BKN.

                            </p>

                            <!-- Promo -->
                            <div
                                class="alert alert-warning border-0 rounded-4
                    d-inline-flex flex-wrap align-items-center gap-2
                    py-2 px-3 mb-4 shadow-sm">

                                <span class="fw-semibold">
                                    Gunakan kode
                                </span>

                                <span
                                    class="bg-white border border-warning
                        rounded px-3 py-1 fw-bold text-dark shadow-sm"
                                    style="letter-spacing:1px;">

                                    ASN2026

                                </span>

                                <span>
                                    hemat <strong>Rp 7.000</strong>
                                </span>

                            </div>

                            <div class="mt-auto">

                                <a href="{{ route('checkout') }}"
                                    class="btn btn-success btn-lg rounded-pill
                        fw-bold px-4 py-3 shadow-sm w-100">

                                    Beli Paket Premium
                                    <i class="fe fe-zap ms-2"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="d-flex align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0 me-2">Analisis & Peringkat Nasional</h5>
                <span class="badge bg-secondary rounded-pill">Terkunci</span>
            </div>

            <div class="position-relative">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center rounded-4"
                    style="background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(4px); z-index: 10;">
                    <div class="bg-white p-4 rounded-4 shadow-lg text-center border" style="max-width: 400px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#6c757d"
                            class="mb-3" viewBox="0 0 16 16">
                            <path
                                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1" />
                        </svg>
                        <h4 class="fw-bold text-dark">Data Belum Tersedia</h4>
                        <p class="text-muted mb-0">Kerjakan Tryout Premium pertamamu untuk membuka grafik analisis
                            kompetensi dan melihat posisimu di peringkat nasional.</p>
                    </div>
                </div>

                <div style="opacity: 0.4; pointer-events: none; user-select: none;">

                    <div class="row mb-4">
                        <div class="col-xl-3 col-lg-6 col-md-12 mb-3 mb-xl-0">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="text-muted mb-0">Total Tryout</h6>
                                        <div class="icon-shape icon-sm bg-light-primary text-primary rounded-circle"><i
                                                class="fe fe-file-text"></i></div>
                                    </div>
                                    <h2 class="fw-bold mb-0">0 <span class="fs-6 text-muted fw-normal">Sesi</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12 mb-3 mb-xl-0">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="text-muted mb-0">Skor Tertinggi</h6>
                                        <div class="icon-shape icon-sm bg-light-success text-success rounded-circle"><i
                                                class="fe fe-trending-up"></i></div>
                                    </div>
                                    <h2 class="fw-bold mb-0 text-success">0 <span
                                            class="fs-6 text-muted fw-normal">Poin</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12 mb-3 mb-xl-0">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="text-muted mb-0">Rasio Kelulusan</h6>
                                        <div class="icon-shape icon-sm bg-light-warning text-warning rounded-circle"><i
                                                class="fe fe-pie-chart"></i></div>
                                    </div>
                                    <h2 class="fw-bold mb-0">0% <span class="fs-6 text-muted fw-normal">Lulus PG</span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12 mb-3 mb-xl-0">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="text-muted mb-0">Peringkat Rata-rata</h6>
                                        <div class="icon-shape icon-sm bg-light-info text-info rounded-circle"><i
                                                class="fe fe-award"></i></div>
                                    </div>
                                    <h2 class="fw-bold mb-0">-</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-8 col-lg-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <h5 class="mb-0 fw-bold">Grafik Perkembangan Skor</h5>
                                </div>
                                <div class="card-body">
                                    <div id="chartProgress"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-12">
                            <div class="card border-0 shadow-sm mb-4">
                                <div
                                    class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 fw-bold">Top 3 Nasional</h5>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex align-items-center p-3">
                                            <h4 class="mb-0 me-3 text-warning">🥇</h4>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Siti Aminah</h6>
                                                <small class="text-muted">Skor: 498</small>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center p-3">
                                            <h4 class="mb-0 me-3 text-secondary">🥈</h4>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Ahmad Fauzi</h6>
                                                <small class="text-muted">Skor: 485</small>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {{-- <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold">Pengumuman</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <div class="icon-shape icon-xs bg-light-primary text-primary rounded mt-1 me-3"><i
                                        class="fe fe-bell"></i></div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Tryout Akbar Batch 2</h6>
                                    <p class="mb-0 small text-muted">Pendaftaran dibuka tanggal 15 Juni 2026. Kuota
                                        terbatas 1000 peserta!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Script Countdown Timer
        const targetDate = new Date("September 1, 2026 00:00:00").getTime();
        const countdownElement = document.getElementById("countdown-timer");
        const timer = setInterval(function() {
            const now = new Date().getTime();
            const distance = targetDate - now;
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            if (distance < 0) {
                clearInterval(timer);
                countdownElement.innerHTML = "HARI H UJIAN!";
            } else {
                countdownElement.innerHTML = days + " Hari";
            }
        }, 1000);

        // Script Grafik
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                series: [{
                    name: 'Total Skor',
                    data: [350, 380, 375, 420, 415, 450, 480]
                }],
                chart: {
                    height: 300,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                    fontFamily: 'inherit'
                },
                colors: ['#0d6efd'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                xaxis: {
                    categories: ['TO 1', 'TO 2', 'TO 3', 'TO 4', 'TO 5', 'TO 6', 'TO 7'],
                    tooltip: {
                        enabled: false
                    }
                },
                yaxis: {
                    min: 300,
                    max: 550,
                    tickAmount: 5
                }
            };
            var chart = new ApexCharts(document.querySelector("#chartProgress"), options);
            chart.render();
        });
    </script>

    @include('partials.btn-scroll-top')
    @include('partials.scripts')
    <script src="assets/js/vendors/tnsSlider.js"></script>
    <script src="assets/js/vendors/chart.js"></script>
    <script src="assets/js/vendors/navbar-nav.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('login_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil!',
                text: "{{ session('login_success') }}",
                timer: 2500,
                showConfirmButton: false,
                timerProgressBar: true
            });
        </script>
    @endif
</body>

</html>
