<!doctype html>
<html lang="en">

<head>
    @include('partials.head')

    <title>Rapor Hasil Ujian | CalonASN.id</title>
</head>

<body>
    <!-- Page Content -->
    @include('partials.navbar')
    <!-- Sidebar -->
    @include('partials.navbar-student')

    <div class="db-content text-dark">
        @php
            $lulus = true;
            foreach ($hasilPerKategori as $hasil) {
                if (($hasil['skor'] ?? 0) < ($hasil['passing_grade'] ?? 0)) {
                    $lulus = false;
                    break;
                }
            }
        @endphp

        <div class="container py-4 py-md-5">
            <!-- Header Status Kelulusan -->
            <div class="text-center mb-4 mb-md-5">
                @if ($lulus)
                    <div class="display-3 display-md-1 mb-2">🎉</div>
                    <h1 class="fw-bold text-success fs-2 fs-md-1 mb-2">SELAMAT! ANDA LULUS</h1>
                    <p class="lead text-muted small fs-md-5 mb-2">Skor Anda telah memenuhi dan melampaui ambang batas (Passing Grade) di semua subtes SKD.</p>
                @else
                    <div class="display-3 display-md-1 mb-2">😟</div>
                    <h1 class="fw-bold text-danger fs-2 fs-md-1 mb-2">TIDAK LULUS</h1>
                    <p class="lead text-muted small fs-md-5 mb-2">Maaf, nilai Anda pada salah satu atau lebih subtes masih di bawah ambang batas minimal.</p>
                @endif

                @if (!empty($sessionRank) && !empty($totalParticipants))
                    <span class="badge bg-primary-subtle text-primary border border-primary rounded-pill px-3 py-1.5 fw-bold">
                        <i class="fe fe-award me-1"></i> Peringkat Nasional Sesi Ini: #{{ $sessionRank }} dari {{ $totalParticipants }} Peserta
                    </span>
                @endif
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10 col-12">

                    <!-- 4 Kartu Skor Subtes & Total (Grid 2x2 di Mobile, 4 Kolom di Desktop) -->
                    <div class="row g-3 mb-4">
                        @foreach ($hasilPerKategori as $hasil)
                            @php
                                $skorKat = (int) ($hasil['skor'] ?? 0);
                                $pgKat = (int) ($hasil['passing_grade'] ?? 0);
                                $maxKat = (int) ($hasil['max_score'] ?? 150);
                                $diffKat = $skorKat - $pgKat;
                                $pctKat = min(100, $maxKat > 0 ? round(($skorKat / $maxKat) * 100) : 0);
                            @endphp
                            <div class="col-md-3 col-6">
                                <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100 bg-white d-flex flex-column justify-content-between">
                                    <div>
                                        <h6 class="text-muted small text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">Skor {{ $hasil['name'] }}</h6>
                                        <h2 class="fw-bolder mb-1 {{ $diffKat >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $skorKat }}
                                        </h2>
                                        <small class="text-muted d-block mb-2" style="font-size: 0.72rem;">Min PG: <strong>{{ $pgKat }}</strong> / {{ $maxKat }}</small>
                                    </div>
                                    <div>
                                        <div class="progress rounded-pill mb-2" style="height: 5px;">
                                            <div class="progress-bar {{ $diffKat >= 0 ? 'bg-success' : 'bg-danger' }}" role="progressbar" style="width: {{ $pctKat }}%;"></div>
                                        </div>
                                        @if ($diffKat >= 0)
                                            <span class="badge bg-success-subtle text-success rounded-pill" style="font-size: 0.68rem;">
                                                +{{ $diffKat }} di atas PG
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger rounded-pill" style="font-size: 0.68rem;">
                                                Kurang {{ abs($diffKat) }} poin
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-md-3 col-6">
                            <div class="card shadow-sm rounded-4 text-center p-3 h-100 d-flex flex-column justify-content-center" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important; color: #ffffff !important;">
                                <h6 class="small text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px; color: rgba(255,255,255,0.85) !important;">Total Skor</h6>
                                <h2 class="fw-bolder mb-1" style="color: #ffffff !important;">
                                    {{ $totalSkor }}
                                </h2>
                                <small style="font-size: 0.74rem; color: rgba(255,255,255,0.8) !important;">dari 550 Poin Maksimal</small>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Rincian Analisis Kemampuan -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden bg-white">
                        <div class="card-body p-3 p-md-4">
                            <h5 class="fw-bold mb-3 text-dark"><i class="fe fe-activity text-primary me-2"></i>Analisis Kemampuan Kategori</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="py-2.5">Materi</th>
                                            <th class="py-2.5">Keterangan Subtes</th>
                                            <th class="text-center py-2.5" style="width: 20%;">Status Kelulusan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hasilPerKategori as $hasil)
                                            @php
                                                $deskripsi = 'Evaluasi kemampuan materi ' . $hasil['name'];
                                                if (strtoupper($hasil['name']) == 'TWK') {
                                                    $deskripsi = 'Penguasaan wawasan kebangsaan, pilar negara, integritas, dan bela negara.';
                                                } elseif (strtoupper($hasil['name']) == 'TIU') {
                                                    $deskripsi = 'Komponen kemampuan verbal, numerik berhitung, logika silogisme, dan figural.';
                                                } elseif (strtoupper($hasil['name']) == 'TKP') {
                                                    $deskripsi = 'Aspek pelayanan publik, jejaring kerja, sosial budaya, TIK, dan profesionalisme.';
                                                }
                                            @endphp
                                            <tr>
                                                <td class="fw-bold text-dark">{{ $hasil['name'] }}</td>
                                                <td class="text-muted small">{{ $deskripsi }}</td>
                                                <td class="text-center">
                                                    @if ($hasil['skor'] >= $hasil['passing_grade'])
                                                        <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-1.5 fw-bold small">
                                                            <i class="fe fe-check-circle me-1"></i>Lolos PG
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger-subtle text-danger border border-danger rounded-pill px-3 py-1.5 fw-bold small">
                                                            <i class="fe fe-x-circle me-1"></i>Di Bawah PG
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Smart Upsell / Retry Card -->
                    @if (empty($isUnlimited))
                        <div class="card border-2 border-primary rounded-4 shadow-sm mb-4 overflow-hidden bg-white">
                            <div class="card-body p-3 p-md-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                                <div>
                                    <span class="badge bg-primary text-white rounded-pill px-2.5 py-1 fw-bold mb-1" style="font-size: 0.7rem;">
                                        ⭐ UPGRADE AKSES UNLIMITED
                                    </span>
                                    <h5 class="fw-bold text-dark mb-1">
                                        {{ !$lulus ? 'Belum Tembus Passing Grade? Ulangi Tryout Sampai Lulus!' : 'Mau Latih Konsistensi Skor dengan Soal Acak Baru?' }}
                                    </h5>
                                    <p class="text-muted small mb-0">
                                        Upgrade ke <strong>Paket Super Lengkap</strong> — bebas mengulang Tryout CAT berkali-kali + buka semua <strong>26 Modul Materi SKD</strong>.
                                    </p>
                                </div>
                                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 flex-shrink-0">
                                    @if (!empty($isPaketMandiri))
                                        <a href="{{ route('checkout', 3) }}" class="btn btn-primary rounded-pill px-4 py-2.5 fw-bold shadow-sm text-nowrap">
                                            <i class="fe fe-zap me-1"></i> Upgrade Rp {{ number_format($hargaUpgrade ?? 29000, 0, ',', '.') }}
                                        </a>
                                    @else
                                        <a href="{{ route('user.pilih-paket') }}" class="btn btn-primary rounded-pill px-4 py-2.5 fw-bold shadow-sm text-nowrap">
                                            <i class="fe fe-zap me-1"></i> Buka Akses Unlimited
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Card Feedback, Kritik & Saran & Rekomendasi (Khusus Peserta Selesai Tryout) -->
                    @php
                        $fbSaved = $existingFeedback ?? null;
                        $shareWaText = urlencode("Aku barusan selesai simulasi CAT SKD CPNS 110 soal di CalonASN.id (skor real-time + pembahasan lengkap)! Cobain juga yuk buat latihan CPNS 2026: " . url('/'));
                    @endphp
                    <div id="feedback-card" class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden bg-white">
                        <div class="card-body p-3 p-md-4">
                            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-3">
                                <div>
                                    <span class="badge bg-warning text-dark rounded-pill px-2.5 py-1 fw-bold mb-1" style="font-size: 0.7rem;">
                                        💬 SUARA PESERTA TRYOUT
                                    </span>
                                    <h5 class="fw-bold text-dark mb-0">Bagaimana Pengalaman Tryoutmu di CalonASN.id?</h5>
                                    <small class="text-muted">Masukanmu membantu kami meningkatkan kualitas soal &amp; pembahasan.</small>
                                </div>
                            </div>

                            @if (session('feedback_success'))
                                <div class="alert alert-success rounded-3 py-2 px-3 small mb-3">
                                    <i class="fe fe-check-circle me-1"></i> {{ session('feedback_success') }}
                                </div>
                            @endif

                            <div id="feedbackDoneBox" class="{{ $fbSaved ? '' : 'd-none' }}">
                                <div class="p-3 rounded-3 border bg-light">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
                                        <span class="fw-bold text-success small">
                                            <i class="fe fe-check-circle me-1"></i> Terima kasih! Penilaian &amp; masukanmu sudah kami terima.
                                        </span>
                                        <span id="fbDoneStars" class="text-warning fw-bold">
                                            @if ($fbSaved)
                                                {{ str_repeat('★', (int) $fbSaved->rating) . str_repeat('☆', max(0, 5 - (int) $fbSaved->rating)) }}
                                            @endif
                                        </span>
                                    </div>
                                    <p id="fbDoneMessage" class="small text-dark mb-0 fst-italic">
                                        @if ($fbSaved)
                                            "{{ $fbSaved->message }}"
                                        @endif
                                    </p>
                                </div>

                                <div id="fbShareWaBox" class="mt-3 p-3 rounded-3 border border-success bg-success-subtle d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 {{ ($fbSaved && $fbSaved->recommendation === 'yes') ? '' : 'd-none' }}">
                                    <div class="small text-dark fw-medium">
                                        <i class="bi bi-heart-fill text-danger me-1"></i> Terima kasih mau merekomendasikan CalonASN.id! Ajak teman pejuang NIP sekarang:
                                    </div>
                                    <a href="https://wa.me/?text={{ $shareWaText }}" target="_blank" rel="noopener noreferrer"
                                       class="btn btn-success btn-sm rounded-pill px-3 py-2 fw-bold text-nowrap">
                                        <i class="bi bi-whatsapp me-1"></i> Bagikan ke WhatsApp
                                    </a>
                                </div>
                            </div>

                            @if (!$fbSaved)
                                <form id="tryoutFeedbackForm" action="{{ route('ujian.feedback.store', $id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="rating" id="fbRatingInput" value="{{ old('rating', 5) }}">
                                    <input type="hidden" name="recommendation" id="fbRecommendInput" value="{{ old('recommendation', 'yes') }}">

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-5">
                                            <label class="form-label fw-semibold small text-dark mb-1">1. Penilaian Keseluruhan</label>
                                            <div class="d-flex align-items-center gap-1" id="fbStarButtons">
                                                @for ($s = 1; $s <= 5; $s++)
                                                    <button type="button" class="btn btn-sm border-0 p-1 fs-4 fb-star-btn text-warning" data-value="{{ $s }}" aria-label="{{ $s }} Bintang" style="line-height: 1;">
                                                        ★
                                                    </button>
                                                @endfor
                                                <span id="fbRatingLabel" class="small text-muted ms-2 fw-medium">5 / 5 Sangat Bagus</span>
                                            </div>
                                        </div>

                                        <div class="col-md-7">
                                            <label class="form-label fw-semibold small text-dark mb-1">2. Apakah kamu mau merekomendasikan CalonASN.id ke teman?</label>
                                            <div class="d-flex flex-wrap gap-2" id="fbRecommendButtons">
                                                <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold fb-rec-btn active" data-rec="yes">
                                                    👍 Ya, Pasti
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold fb-rec-btn" data-rec="maybe">
                                                    🤔 Mungkin
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold fb-rec-btn" data-rec="no">
                                                    👎 Belum
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fbMessageInput" class="form-label fw-semibold small text-dark mb-1">3. Testimoni / Kritik &amp; Saran</label>
                                        <textarea name="message" id="fbMessageInput" rows="3" class="form-control @error('message') is-invalid @enderror"
                                                  placeholder="Ceritakan pengalamanmu mengerjakan tryout atau tulis kritik &amp; saran agar CalonASN.id makin baik..." required minlength="5" maxlength="1000">{{ old('message') }}</textarea>
                                        <div id="fbErrorBox" class="text-danger small mt-1 d-none"></div>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                        <small class="text-muted">Ulasan pilihan berkesempatan tampil dengan nama tersamar di halaman utama.</small>
                                        <button type="submit" id="fbSubmitBtn" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-xs">
                                            <i class="fe fe-send me-1"></i> Kirim Masukan
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Tombol Aksi Bawah (Responsif, Mudah Diklik di HP & Desktop) -->
                    <div class="text-center d-flex flex-wrap gap-2 justify-content-center pt-2">
                        <a href="{{ route('sertifikat.riwayat') }}" class="btn btn-outline-secondary rounded-pill px-3.5 py-2 fw-medium shadow-xs">
                            <i class="fe fe-arrow-left me-1"></i> Riwayat Ujian
                        </a>

                        <a href="{{ route('ujian.pembahasan', $id) }}" class="btn btn-warning text-dark fw-bold rounded-pill px-3.5 py-2 shadow-xs">
                            <i class="fe fe-book-open me-1"></i> Buka Pembahasan Soal
                        </a>

                        @if ($lulus)
                            <a href="{{ route('ujian.sertifikat', $id) }}" target="_blank"
                                class="btn btn-success fw-bold rounded-pill px-4 py-2 shadow-sm">
                                <i class="fe fe-award me-1"></i> Unduh Sertifikat Resmi
                            </a>
                        @else
                            <button type="button" class="btn btn-secondary text-white rounded-pill px-3.5 py-2" disabled
                                title="Capai Passing Grade di semua kategori untuk membuka sertifikat"
                                style="cursor: not-allowed; opacity: 0.65;">
                                <i class="fe fe-lock me-1"></i> Sertifikat Terkunci
                            </button>
                        @endif

                        @if (!empty($isUnlimited))
                            <a href="{{ route('ujian.persiapan', $tryoutId ?? 1) }}" class="btn btn-outline-primary rounded-pill px-3.5 py-2 fw-bold shadow-xs">
                                <i class="fe fe-refresh-cw me-1"></i> Ulangi Tryout Baru
                            </a>
                        @endif

                        <a href="{{ route('ranking') }}" class="btn btn-primary rounded-pill px-3.5 py-2 fw-medium shadow-xs">
                            <i class="fe fe-trending-up me-1"></i> Lihat Ranking Nasional
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Scroll top -->
    @include('partials.btn-scroll-top')
    <!-- Scripts -->
    @include('partials.scripts')
    <script src="/build/assets/js/vendors/tnsSlider.js"></script>
    <script src="/build/assets/js/vendors/chart.js"></script>
    <script src="/build/assets/js/vendors/navbar-nav.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('tryoutFeedbackForm');
            if (!form) return;

            const ratingInput = document.getElementById('fbRatingInput');
            const ratingLabel = document.getElementById('fbRatingLabel');
            const recInput = document.getElementById('fbRecommendInput');
            const starBtns = Array.from(document.querySelectorAll('.fb-star-btn'));
            const recBtns = Array.from(document.querySelectorAll('.fb-rec-btn'));
            const labels = {
                1: '1 / 5 Kurang Puas',
                2: '2 / 5 Cukup',
                3: '3 / 5 Baik',
                4: '4 / 5 Bagus',
                5: '5 / 5 Sangat Bagus'
            };

            function renderStars(val) {
                starBtns.forEach(function (btn) {
                    const v = parseInt(btn.dataset.value, 10);
                    btn.classList.toggle('text-warning', v <= val);
                    btn.classList.toggle('text-muted', v > val);
                    btn.style.opacity = v <= val ? '1' : '0.35';
                });
                if (ratingLabel) {
                    ratingLabel.textContent = labels[val] || (val + ' / 5');
                }
            }

            starBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const val = parseInt(btn.dataset.value, 10);
                    ratingInput.value = val;
                    renderStars(val);
                });
            });

            recBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const val = btn.dataset.rec;
                    recInput.value = val;
                    recBtns.forEach(function (b) {
                        const isActive = b === btn;
                        b.classList.toggle('active', isActive);
                        b.classList.toggle('btn-primary', isActive);
                        b.classList.toggle('btn-outline-secondary', !isActive);
                    });
                });
            });

            renderStars(parseInt(ratingInput.value || '5', 10));

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const submitBtn = document.getElementById('fbSubmitBtn');
                const errBox = document.getElementById('fbErrorBox');
                const msgVal = document.getElementById('fbMessageInput').value.trim();

                errBox.classList.add('d-none');
                if (msgVal.length < 5) {
                    errBox.textContent = 'Mohon tulis masukan minimal 5 karakter ya.';
                    errBox.classList.remove('d-none');
                    return;
                }

                submitBtn.disabled = true;
                const origHtml = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengirim...';

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        rating: parseInt(ratingInput.value, 10),
                        recommendation: recInput.value,
                        message: msgVal
                    })
                })
                .then(async function (res) {
                    const data = await res.json();
                    if (!res.ok) {
                        const firstErr = data?.errors ? Object.values(data.errors).flat()[0] : (data?.message || 'Gagal mengirim masukan.');
                        throw new Error(firstErr);
                    }
                    const stars = parseInt(data.feedback.rating, 10);
                    document.getElementById('fbDoneStars').textContent = '★'.repeat(stars) + '☆'.repeat(5 - stars);
                    document.getElementById('fbDoneMessage').textContent = '"' + data.feedback.message + '"';
                    if (data.feedback.recommendation === 'yes') {
                        document.getElementById('fbShareWaBox').classList.remove('d-none');
                    }
                    form.classList.add('d-none');
                    document.getElementById('feedbackDoneBox').classList.remove('d-none');
                })
                .catch(function (err) {
                    errBox.textContent = err.message || 'Terjadi kesalahan, silakan coba lagi.';
                    errBox.classList.remove('d-none');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = origHtml;
                });
            });
        });
    </script>
</body>

</html>
