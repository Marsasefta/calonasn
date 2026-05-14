<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Student Dashboard | Geeks - Bootstrap 5 Template</title>
</head>

<body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')

    <div class="db-content text-dark">
        <div class="container-fluid py-4">

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm" style="background: linear-gradient(45deg, #0d6efd, #0dcaf0);">
                        <div
                            class="card-body p-4 p-md-5 d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <div class="mb-3 mb-md-0">
                                <h2 class="text-white fw-bold mb-2">Halo, {{ auth()->user()->name ?? 'Pejuang NIP' }}! 👋
                                </h2>
                                <p class="text-white-50 mb-0 fs-5">Waktu terus berjalan. Sudah sejauh mana persiapan
                                    SKD-mu hari ini?</p>
                            </div>
                            <div class="text-center text-md-end bg-white p-3 rounded shadow-sm">
                                <h6 class="text-muted text-uppercase fw-bold mb-1">Menuju Ujian SKD 2026</h6>
                                <div class="display-5 text-primary fw-bold" id="countdown-timer">110 Hari</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xl-3 col-lg-6 col-md-12 mb-3 mb-xl-0">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-muted mb-0">Total Tryout</h6>
                                <div class="icon-shape icon-sm bg-light-primary text-primary rounded-circle"><i
                                        class="fe fe-file-text"></i></div>
                            </div>
                            <h2 class="fw-bold mb-0">10 <span class="fs-6 text-muted fw-normal">Sesi</span></h2>
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
                            <h2 class="fw-bold mb-0 text-success">480 <span
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
                            <h2 class="fw-bold mb-0">70% <span class="fs-6 text-muted fw-normal">Lulus PG</span></h2>
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
                            <h2 class="fw-bold mb-0">Top 15%</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8 col-lg-12 mb-4">

                    <div class="card border-0 shadow-sm mb-4 bg-light-warning border-start border-warning border-4">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">🔥 Promo Khusus Hari Ini!</h5>
                                <p class="mb-0 text-muted small">Buka kunci 5.000+ soal, pembahasan lengkap, dan ranking
                                    nasional.</p>
                            </div>
                            <a href="#" class="btn btn-warning fw-bold">Upgrade Premium</a>
                        </div>
                    </div>

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
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Top 3 Nasional</h5>
                            <a href="{{ route('ranking') }}" class="small text-decoration-none">Lihat Semua</a>
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
                                <li class="list-group-item d-flex align-items-center p-3">
                                    <h4 class="mb-0 me-3" style="color: #cd7f32;">🥉</h4>
                                    <div>
                                        <h6 class="mb-0 fw-bold">Budi Santoso</h6>
                                        <small class="text-muted">Skor: 472</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

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
                            <div class="d-flex">
                                <div class="icon-shape icon-xs bg-light-info text-info rounded mt-1 me-3"><i
                                        class="fe fe-refresh-cw"></i></div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Update Bank Soal</h6>
                                    <p class="mb-0 small text-muted">Penambahan 500 soal TKP penalaran baru sesuai
                                        kisi-kisi BKN 2026.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // 1. Script Countdown Timer Dummy (Target: 1 September 2026)
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

        // 2. Script Grafik Perkembangan Skor (Dummy Data)
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



    <!-- Scroll top -->
    @include('partials.btn-scroll-top')
    <!-- Scripts -->
    @include('partials.scripts')
    <script src="assets/js/vendors/tnsSlider.js"></script>
    <script src="assets/js/vendors/chart.js"></script>
    <script src="assets/js/vendors/navbar-nav.js"></script>
</body>

</html>
