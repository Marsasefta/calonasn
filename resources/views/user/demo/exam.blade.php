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
        <div class="container py-4">
            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('demo.selesai') }}" method="POST" id="examForm">
                        @csrf
                        @foreach ($questions as $index => $q)
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <span class="badge bg-primary mb-2">{{ $q['type'] }}</span>
                                    <h5>{{ $index + 1 }}. {{ $q['q'] }}</h5>
                                    <div class="mt-3">
                                        @foreach ($q['options'] as $opt)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio"
                                                    name="answers[{{ $q['id'] }}]" value="{{ $opt }}"
                                                    id="q{{ $q['id'] }}{{ $loop->index }}">
                                                <label class="form-check-label"
                                                    for="q{{ $q['id'] }}{{ $loop->index }}">
                                                    {{ $opt }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-success btn-lg w-100">Kirim Jawaban</button>
                    </form>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Sisa Waktu</h6>
                            <h2 id="timer" class="fw-bold text-danger">10:00</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Timer Sederhana 10 Menit
        let time = 600;
        setInterval(() => {
            let mins = Math.floor(time / 60);
            let secs = time % 60;
            document.getElementById('timer').innerHTML = `${mins}:${secs < 10 ? '0' : ''}${secs}`;
            if (time <= 0) document.getElementById('examForm').submit();
            time--;
        }, 1000);
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
