<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Tryout Gratis</title>
</head>

<body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')

    <div class="db-content text-center py-5">
        <div class="container">
            <div class="display-1 text-primary mb-3">🎉</div>
            <h1 class="fw-bold">Ujicoba Demo Selesai!</h1>
            <div class="row justify-content-center mt-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm p-4">
                        <h3>Skor Kamu: <span class="text-success">{{ $score }}</span></h3>
                        <p class="text-muted">Benar: {{ $correct }} | Salah: {{ $totalSoal - $correct }}</p>

                        <hr>
                        {{-- <div class="mt-4 text-start">
                            <h5 class="fw-bold">Analisis Jawaban (Debug):</h5>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pilihan Kamu</th>
                                        <th>Kunci di Sistem</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detailHasil as $res)
                                        <tr class="{{ $res['status'] ? 'table-success' : 'table-danger' }}">
                                            <td>{{ $res['no'] }}</td>
                                            <td>{{ $res['user'] ?? '(Kosong)' }}</td>
                                            <td>{{ $res['kunci'] }}</td>
                                            <td>{{ $res['status'] ? 'BENAR' : 'SALAH' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> --}}

                        <h5 class="text-danger fw-bold">Mau Lihat Pembahasan Detail?</h5>
                        <p>Maaf, fitur pembahasan detail per soal dan tips trik hanya tersedia untuk member **Premium**.
                        </p>

                        <div class="d-grid gap-2 mt-3">
                            <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg">
                                Beli Paket Sekarang (Cuma Rp 20rb)
                            </a>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                Kembali ke Dashboard
                            </a>
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
