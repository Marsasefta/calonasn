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
                    <h4 class="mb-0 fw-bold text-primary">Simulasi CAT CPNS 2026</h4>
                    <p class="mb-0 text-muted small">Total: 110 Soal (TWK, TIU, TKP)</p>
                </div>
                <div class="col-md-6 text-end">
                    @php
                        $initMinutes = floor($durationInSeconds / 60);
                        $initSeconds = $durationInSeconds % 60;
                    @endphp
                    <h3 id="timerDisplay" class="mb-0 fw-bold text-danger">
                        {{ sprintf('%02d:%02d', $initMinutes, $initSeconds) }}
                    </h3>
                    <span class="small text-muted">Sisa Waktu</span>
                </div>
            </div>

            <form action="{{ route('ujian.selesai', $tryout->id) }}" method="POST" id="formUjian">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body p-4" style="min-height: 400px;">

                                @foreach ($questions as $index => $q)
                                    @php $nomor = $index + 1; @endphp
                                    <div class="soal-container" id="soal-{{ $nomor }}"
                                        style="{{ $index == 0 ? 'display:block;' : 'display:none;' }}">
                                        <div class="d-flex justify-content-between mb-3">
                                            <span
                                                class="badge bg-primary fs-6">{{ $q->category->name ?? 'Kategori' }}</span>
                                            <span class="fw-bold">Soal Ke-{{ $nomor }}</span>
                                        </div>

                                        <h5 class="mb-4 lh-base">{{ $q->question_text }}</h5>

                                        <div class="options">
                                            @foreach ($q->options as $optIndex => $opt)
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input opsi-radio" type="radio"
                                                        name="jawaban[{{ $q->id }}]" value="{{ $opt->id }}"
                                                        id="opt-{{ $q->id }}-{{ $opt->id }}"
                                                        data-ui-nomor="{{ $nomor }}"
                                                        data-db-id="{{ $q->id }}"
                                                        {{ isset($tempAnswers[$q->id]) && $tempAnswers[$q->id] == $opt->id ? 'checked' : '' }}>
                                                    <label class="form-check-label w-100 p-2 border rounded"
                                                        style="cursor: pointer;"
                                                        for="opt-{{ $q->id }}-{{ $opt->id }}">
                                                        {{ chr(65 + $optIndex) }}. {{ $opt->option_text }}
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

                                    @foreach ($questions as $index => $q)
                                        @php
                                            $nomor = $index + 1;
                                            $isRagu = isset($tempRagu[$q->id]) && $tempRagu[$q->id] == '1';
                                            $isAnswered = isset($tempAnswers[$q->id]);

                                            if ($isRagu) {
                                                $btnClass = 'btn-warning text-dark';
                                            } elseif ($isAnswered) {
                                                $btnClass = 'btn-success text-white';
                                            } else {
                                                $btnClass = 'btn-outline-secondary';
                                            }
                                        @endphp

                                        <button type="button"
                                            class="btn {{ $btnClass }} p-0 d-flex justify-content-center align-items-center"
                                            id="nav-btn-{{ $nomor }}" data-db-id="{{ $q->id }}"
                                            style="width: 45px; height: 45px; font-size: 14px; font-weight: 600;"
                                            onclick="lompatKeSoal({{ $nomor }})">
                                            {{ $nomor }}
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
                                    Selesai Ujian
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // 1. Variabel Global Server
        let currentSoalId = 1;
        const totalSoal = {{ $questions->count() }};
        let timeInSeconds = {{ $durationInSeconds }};
        const tryoutId = {{ $tryout->id }};

        // 2. Fungsi Navigasi Tombol Prev & Next
        function gantiSoal(arah) {
            if (arah === 'next' && currentSoalId < totalSoal) {
                lompatKeSoal(currentSoalId + 1);
            } else if (arah === 'prev' && currentSoalId > 1) {
                lompatKeSoal(currentSoalId - 1);
            }
        }

        // 3. Fungsi Lompat ke Nomor Spesifik (1-110)
        function lompatKeSoal(id) {
            // Sembunyikan soal lama
            let currentElement = document.getElementById('soal-' + currentSoalId);
            if (currentElement) currentElement.style.display = 'none';

            // Hapus border aktif di navigasi kanan
            let prevNavBtn = document.getElementById('nav-btn-' + currentSoalId);
            if (prevNavBtn) prevNavBtn.classList.remove('border-primary', 'border-3');

            // Update ID
            currentSoalId = id;

            // Tampilkan soal baru
            let newElement = document.getElementById('soal-' + currentSoalId);
            if (newElement) newElement.style.display = 'block';

            // Beri border aktif di navigasi kanan
            let newNavBtn = document.getElementById('nav-btn-' + currentSoalId);
            if (newNavBtn) newNavBtn.classList.add('border-primary', 'border-3');

            // Matikan tombol jika mentok di awal/akhir
            document.getElementById('btnPrev').disabled = (currentSoalId === 1);
            document.getElementById('btnNext').disabled = (currentSoalId === totalSoal);

            // Sinkronkan status switch Ragu-ragu
            document.getElementById('checkRagu').checked = newNavBtn.classList.contains('btn-warning');
        }

        // 4. Fungsi Ragu-Ragu
        function tandaiRagu() {
            let isChecked = document.getElementById('checkRagu').checked;
            let btnNav = document.getElementById('nav-btn-' + currentSoalId);
            let dbId = btnNav.getAttribute('data-db-id');

            if (isChecked) {
                btnNav.classList.remove('btn-success', 'btn-outline-secondary');
                btnNav.classList.add('btn-warning', 'text-dark');
            } else {
                btnNav.classList.remove('btn-warning', 'text-dark');
                let isAnswered = document.querySelector(`input[data-ui-nomor="${currentSoalId}"]:checked`);
                if (isAnswered) {
                    btnNav.classList.add('btn-success', 'text-white');
                } else {
                    btnNav.classList.add('btn-outline-secondary');
                }
            }

            // AJAX Kirim ke Redis
            fetch('{{ route('ujian.simpan_ragu') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    tryout_id: tryoutId,
                    question_id: dbId,
                    is_ragu: isChecked ? 1 : 0
                })
            });
        }

        // 5. Fungsi Mengakhiri Ujian
        function selesaiUjian() {
            if (confirm('Yakin ingin mengakhiri ujian? Pastikan semua soal telah terjawab.')) {
                document.getElementById('formUjian').submit();
            }
        }

        // 6. Timer & Sinkronisasi Redis
        let timerDisplay = document.getElementById('timerDisplay');
        let timerInterval = setInterval(() => {
            if (timeInSeconds <= 0) {
                clearInterval(timerInterval);
                timerDisplay.innerHTML = "00:00";
                alert('Waktu Habis! Jawaban Anda akan otomatis dikirim.');
                document.getElementById('formUjian').submit();
                return;
            }

            let minutes = Math.floor(timeInSeconds / 60);
            let seconds = timeInSeconds % 60;

            timerDisplay.innerHTML = `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

            // Auto-save sisa waktu ke Redis setiap 10 detik
            if (timeInSeconds % 10 === 0) {
                fetch('{{ route('ujian.update_timer') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        tryout_id: tryoutId,
                        sisa_waktu: timeInSeconds
                    })
                });
            }

            if (timeInSeconds <= 300) {
                timerDisplay.classList.add('animate__animated', 'animate__flash', 'animate__infinite',
                    'text-danger');
            }

            timeInSeconds--;
        }, 1000);

        // 7. Simpan Jawaban ke Redis (AJAX)
        document.querySelectorAll('.opsi-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                let uiNomor = this.getAttribute('data-ui-nomor');
                let dbId = this.getAttribute('data-db-id');
                let opsiId = this.value;

                let btnNav = document.getElementById('nav-btn-' + uiNomor);

                if (!btnNav.classList.contains('btn-warning')) {
                    btnNav.classList.remove('btn-outline-secondary');
                    btnNav.classList.add('btn-success', 'text-white');
                }

                fetch('{{ route('ujian.simpan_temp') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        tryout_id: tryoutId,
                        question_id: dbId,
                        option_id: opsiId
                    })
                });
            });
        });

        // 8. Inisiasi Ujian
        document.addEventListener("DOMContentLoaded", function() {
            lompatKeSoal(1);
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
