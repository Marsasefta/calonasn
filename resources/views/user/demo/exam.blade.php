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
        <div class="container-fluid mb-4">
            <div class="row align-items-center mb-4 bg-white p-3 shadow-sm rounded">
                <div class="col-md-6">
                    <h4 class="mb-0 fw-bold text-primary">Ujicoba Gratis CalonASN.id</h4>
                    <p class="mb-0 text-muted small">Total: {{ count($questions) }} Soal (TWK, TIU, TKP)</p>
                </div>
                <div class="col-md-6 text-end">
                    <h3 id="timerDisplay" class="mb-0 fw-bold text-danger">00:00</h3>
                    <span class="small text-muted">Sisa Waktu</span>
                </div>
            </div>

            <form action="{{ route('demo.selesai') }}" method="POST" id="formUjian">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body p-4" style="min-height: 400px;">

                                @foreach ($questions as $index => $q)
                                    <div class="soal-container" id="soal-{{ $q['id'] }}"
                                        style="{{ $index == 0 ? 'display:block;' : 'display:none;' }}">
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="badge bg-primary fs-6">{{ $q['kategori'] }}</span>
                                            <span class="fw-bold">Soal Ke-{{ $q['id'] }}</span>
                                        </div>
                                        <h5 class="mb-4 lh-base">{{ $q['pertanyaan'] }}</h5>

                                        <div class="options">
                                            @foreach ($q['opsi'] as $optIndex => $opt)
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input opsi-radio" type="radio"
                                                        name="jawaban[{{ $q['id'] }}]" value="{{ $opt }}"
                                                        id="opt-{{ $q['id'] }}-{{ $optIndex }}"
                                                        data-soal-id="{{ $q['id'] }}">
                                                    <label class="form-check-label w-100 p-2 border rounded"
                                                        for="opt-{{ $q['id'] }}-{{ $optIndex }}">
                                                        {{ chr(65 + $optIndex) }}. {{ $opt }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <div
                                class="card-footer bg-white border-top p-3 d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-outline-secondary" id="btnPrev"
                                    onclick="gantiSoal('prev')">
                                    <i class="fe fe-arrow-left"></i> Sebelumnya
                                </button>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="checkRagu"
                                        onchange="tandaiRagu()">
                                    <label class="form-check-label fw-bold text-warning"
                                        for="checkRagu">Ragu-ragu</label>
                                </div>

                                <button type="button" class="btn btn-primary" id="btnNext"
                                    onclick="gantiSoal('next')">
                                    Selanjutnya <i class="fe fe-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                            <div class="card-header bg-white py-3 d-flex justify-content-between">
                                <h5 class="mb-0">Navigasi Soal</h5>
                            </div>
                            <div class="card-body p-2" style="max-height: 400px; overflow-y: auto;">
                                <div class="d-flex flex-wrap gap-2 justify-content-center">
                                    @foreach ($questions as $q)
                                        <button type="button"
                                            class="btn btn-outline-secondary p-0 d-flex justify-content-center align-items-center"
                                            id="nav-btn-{{ $q['id'] }}"
                                            style="width: 45px; height: 45px; font-size: 14px; font-weight: 600;"
                                            onclick="lompatKeSoal({{ $q['id'] }})">
                                            {{ $q['id'] }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer bg-light p-3">
                                <div class="d-flex justify-content-between small mb-3">
                                    <span><span class="badge bg-success">&nbsp;</span> Dijawab</span>
                                    <span><span class="badge bg-warning">&nbsp;</span> Ragu</span>
                                    <span><span class="badge border text-dark">&nbsp;</span> Kosong</span>
                                </div>
                                <button type="button" class="btn btn-danger w-100" onclick="selesaiUjian()">
                                    Selesai Ujicoba
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentSoalId = 1;
        const totalSoal = {{ count($questions) }};

        function gantiSoal(arah) {
            if (arah === 'next' && currentSoalId < totalSoal) {
                lompatKeSoal(currentSoalId + 1);
            } else if (arah === 'prev' && currentSoalId > 1) {
                lompatKeSoal(currentSoalId - 1);
            }
        }

        function lompatKeSoal(id) {
            document.getElementById('soal-' + currentSoalId).style.display = 'none';
            document.getElementById('nav-btn-' + currentSoalId).classList.remove('border-primary', 'border-3');
            currentSoalId = id;
            document.getElementById('soal-' + currentSoalId).style.display = 'block';
            document.getElementById('nav-btn-' + currentSoalId).classList.add('border-primary', 'border-3');
            document.getElementById('btnPrev').disabled = (currentSoalId === 1);
            document.getElementById('btnNext').disabled = (currentSoalId === totalSoal);

            let btnNav = document.getElementById('nav-btn-' + currentSoalId);
            document.getElementById('checkRagu').checked = btnNav.classList.contains('btn-warning');
        }

        document.querySelectorAll('.opsi-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                let soalId = this.getAttribute('data-soal-id');
                let btnNav = document.getElementById('nav-btn-' + soalId);
                if (!btnNav.classList.contains('btn-warning')) {
                    btnNav.classList.remove('btn-outline-secondary');
                    btnNav.classList.add('btn-success', 'text-white');
                }
            });
        });

        function tandaiRagu() {
            let isChecked = document.getElementById('checkRagu').checked;
            let btnNav = document.getElementById('nav-btn-' + currentSoalId);
            if (isChecked) {
                btnNav.classList.remove('btn-success', 'btn-outline-secondary');
                btnNav.classList.add('btn-warning', 'text-dark');
            } else {
                btnNav.classList.remove('btn-warning', 'text-dark');
                let isAnswered = document.querySelector(`input[name="jawaban[${currentSoalId}]"]:checked`);
                if (isAnswered) {
                    btnNav.classList.add('btn-success', 'text-white');
                } else {
                    btnNav.classList.add('btn-outline-secondary');
                }
            }
        }

        function selesaiUjian() {
            if (confirm('Yakin ingin mengakhiri ujicoba?')) {
                document.getElementById('formUjian').submit();
            }
        }

        // Timer 10 Menit untuk Demo
        let time = 600;
        let timerDisplay = document.getElementById('timerDisplay');
        let timerInterval = setInterval(() => {
            let minutes = Math.floor(time / 60);
            let seconds = time % 60;
            timerDisplay.innerHTML = `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            if (time <= 60) timerDisplay.classList.add('animate__animated', 'animate__flash', 'animate__infinite');
            if (time <= 0) {
                clearInterval(timerInterval);
                document.getElementById('formUjian').submit();
            }
            time--;
        }, 1000);

        lompatKeSoal(1);
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
