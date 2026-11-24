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

    <div class="db-content">
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
                                    @if (!empty($access['is_unlimited']))
                                        <p class="text-muted">Selamat! Anda memiliki akses <strong>Unlimited (Paket Lengkap)</strong>. Anda dapat mencoba dan mengerjakan simulasi tryout ini berkali-kali tanpa batas.</p>
                                    @else
                                        <p class="text-muted">Pembayaran berhasil diverifikasi. Anda memiliki satu
                                            kesempatan untuk mengerjakan tryout ini sekarang.</p>
                                    @endif
                                </div>

                                <div class="alert alert-info border-0 shadow-sm mb-4">
                                    <ul class="text-start mb-0 small">
                                        <li>Pastikan koneksi internet stabil.</li>
                                        <li>Ujian akan otomatis berhenti jika waktu habis.</li>
                                        @if (!empty($access['is_unlimited']))
                                            <li>Setelah selesai, Anda dapat mengulang tryout ini kapan saja tanpa harus membeli lagi.</li>
                                        @else
                                            <li>Satu kali klik "Selesai", akses akan terkunci kembali.</li>
                                        @endif
                                    </ul>
                                </div>

                                <button type="button" class="btn btn-primary btn-lg w-100 shadow-sm" data-bs-toggle="modal" data-bs-target="#briefingUjianModal">
                                    <i class="fe fe-play me-2"></i> Mulai Ujian Sekarang
                                </button>
                            @else
                                <div class="mb-4">
                                    <div class="display-4 text-warning mb-3">
                                        <i class="fe fe-lock"></i>
                                    </div>
                                    <h3 class="fw-bold">Akses Terkunci</h3>
                                    <p class="text-muted">{{ $access['message'] }}</p>
                                </div>

                                {{-- PERBAIKAN LOGIKA: Cek kata 'ulang' atau 'selesai' untuk mendeteksi user yang mau retry --}}
                                @if (str_contains(strtolower($access['message']), 'ulang') || str_contains(strtolower($access['message']), 'selesai'))
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('checkout', $tryout->id) }}" class="btn btn-outline-primary">
                                            <i class="fe fe-refresh-cw me-1"></i> Beli Kuota Baru (Mengulang)
                                        </a>
                                        <a href="{{ route('dashboard') }}" class="btn btn-link text-muted">
                                            Kembali ke Dashboard
                                        </a>
                                    </div>
                                @else
                                    {{-- Jika tidak ada kata 'ulang', berarti dia user baru yang belum pernah beli paket ini --}}
                                    <div class="bg-light p-3 rounded mb-4">
                                        <span class="text-muted d-block small">Investasi Paket:</span>
                                        <h4 class="fw-bold text-primary mb-0">Rp
                                            {{ number_format($tryout->price, 0, ',', '.') }}</h4>
                                    </div>

                                    <a href="{{ route('checkout', $tryout->id) }}"
                                        class="btn btn-primary btn-lg w-100 shadow-sm">
                                        <i class="fe fe-shopping-cart me-2"></i> Amankan Akses Sekarang
                                    </a>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PAKTA INTEGRITAS & HIMBAUAN UJIAN SEBELUM MULAI -->
    @if ($access['status'] == 'unlocked')
        <div class="modal fade" id="briefingUjianModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="briefingUjianModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 580px;">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <!-- Modal Header -->
                    <div class="modal-header bg-primary text-white py-3 px-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fe fe-shield fs-4"></i>
                            <div>
                                <h5 class="modal-title fw-bold mb-0 text-white" id="briefingUjianModalLabel">Pakta Integritas & Panduan Simulasi</h5>
                                <span class="small opacity-75 d-block" style="font-size: 0.76rem;">Simulasi CAT CPNS Resmi (Standar BKN 2026)</span>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body p-3 p-md-4 text-start">
                        <p class="text-dark small mb-3">
                            Demi mendapatkan <strong>hasil evaluasi yang akurat</strong> dan benar-benar menggambarkan kesiapan Anda menghadapi tes SKD BKN yang sesungguhnya, mohon perhatikan himbauan berikut:
                        </p>

                        <!-- Daftar Himbauan -->
                        <div class="d-flex flex-column gap-3 mb-3">
                            <!-- Poin 1 -->
                            <div class="d-flex align-items-start gap-3 p-2.5 rounded-3 border bg-light">
                                <div class="rounded-circle bg-primary-soft text-primary p-2 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="fe fe-clock fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1 small">1. Luangkan Waktu {{ $tryout->duration_minutes }} Menit Penuh (Non-Stop)</h6>
                                    <span class="text-muted small d-block" style="font-size: 0.76rem; line-height: 1.4;">
                                        Timer sistem langsung berjalan begitu ujian dimulai dan <strong>tidak dapat di-pause (dijeda)</strong>, sama persis seperti sistem CAT BKN resmi.
                                    </span>
                                </div>
                            </div>

                            <!-- Poin 2 -->
                            <div class="d-flex align-items-start gap-3 p-2.5 rounded-3 border bg-light">
                                <div class="rounded-circle bg-danger-soft text-danger p-2 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="fe fe-eye-off fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1 small">2. Uji Kemampuan Murni (Tanpa AI, Google, atau Kalkulator)</h6>
                                    <span class="text-muted small d-block" style="font-size: 0.76rem; line-height: 1.4;">
                                        Hindari bantuan ChatGPT, mesin pencari Google, kalkulator, atau buku contekan. Skor simulasi hanya akan bermanfaat jika Anda mengetahui kelemahan riil Anda sebelum tes nyata.
                                    </span>
                                </div>
                            </div>

                            <!-- Poin 3 -->
                            <div class="d-flex align-items-start gap-3 p-2.5 rounded-3 border bg-light">
                                <div class="rounded-circle bg-warning-soft text-warning p-2 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="fe fe-zap fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1 small">3. Strategi Waktu Cepat (110 Butir Soal: TWK, TIU, TKP)</h6>
                                    <span class="text-muted small d-block" style="font-size: 0.76rem; line-height: 1.4;">
                                        Waktu rata-rata per soal adalah <strong>±54 detik</strong>. Jangan terpaku pada satu soal sulit; gunakan tombol <strong>"Ragu-Ragu"</strong> warna kuning dan lanjutkan ke nomor berikutnya.
                                    </span>
                                </div>
                            </div>

                            <!-- Poin 4 -->
                            <div class="d-flex align-items-start gap-3 p-2.5 rounded-3 border bg-light">
                                <div class="rounded-circle bg-success-soft text-success p-2 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="fe fe-wifi fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1 small">4. Kesiapan Perangkat & Tempat Tenang</h6>
                                    <span class="text-muted small d-block" style="font-size: 0.76rem; line-height: 1.4;">
                                        Pastikan koneksi internet stabil, baterai perangkat mencukupi, dan posisikan diri di tempat tenang agar fokus dan mental Anda terlatih optimal.
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Checkbox Persetujuan Komitmen -->
                        <div class="p-3 rounded-3 border bg-warning-subtle text-dark mb-3">
                            <div class="form-check mb-0 d-flex align-items-center">
                                <input class="form-check-input flex-shrink-0 cursor-pointer me-2" type="checkbox" id="checkAgreement" onchange="toggleStartButton()" style="width: 1.25rem; height: 1.25rem;">
                                <label class="form-check-label text-dark fw-bold small cursor-pointer" for="checkAgreement" style="font-size: 0.8rem; line-height: 1.4;">
                                    Saya telah membaca panduan ini dan berkomitmen untuk mengerjakan ujian secara jujur, mandiri, dan bersungguh-sungguh.
                                </label>
                            </div>
                        </div>

                        <!-- Tombol Aksi Modal -->
                        <div class="d-flex flex-column flex-sm-row justify-content-end align-items-stretch align-items-sm-center gap-2 pt-2 border-top">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2 order-2 order-sm-1" data-bs-dismiss="modal">
                                Nanti Dulu
                            </button>
                            <a href="{{ route('ujian.mulai', $tryout->id) }}" id="btnConfirmStart"
                                class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 order-1 order-sm-2 disabled"
                                style="pointer-events: none; opacity: 0.5; transition: all 0.3s ease;">
                                <i class="fe fe-play"></i>
                                <span>Saya Siap, Mulai Ujian</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function toggleStartButton() {
                const chk = document.getElementById('checkAgreement');
                const btn = document.getElementById('btnConfirmStart');
                if (chk && btn) {
                    if (chk.checked) {
                        btn.classList.remove('disabled');
                        btn.style.pointerEvents = 'auto';
                        btn.style.opacity = '1';
                    } else {
                        btn.classList.add('disabled');
                        btn.style.pointerEvents = 'none';
                        btn.style.opacity = '0.5';
                    }
                }
            }
        </script>
    @endif

    <!-- Scroll top -->
    @include('partials.btn-scroll-top')
    <!-- Scripts -->
    @include('partials.scripts')
    <script src="assets/js/vendors/tnsSlider.js"></script>
    <script src="assets/js/vendors/chart.js"></script>
    <script src="assets/js/vendors/navbar-nav.js"></script>
</body>

</html>
