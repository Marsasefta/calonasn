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
                @if ($access['status'] == 'unlocked')
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body p-5 text-center">
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
                            </div>
                        </div>
                    </div>
                @elseif (str_contains(strtolower($access['message']), 'ulang') || str_contains(strtolower($access['message']), 'selesai'))
                    <div class="col-lg-6 col-md-8">
                        <div class="card shadow-sm border-0 rounded-4 mb-3">
                            <div class="card-body p-4 p-md-5 text-center">
                                <div class="mb-4">
                                    <div class="display-4 text-warning mb-3">
                                        <i class="fe fe-lock"></i>
                                    </div>
                                    <h3 class="fw-bold">Kuota Tryout Mandiri Habis</h3>
                                    <p class="text-muted mb-0">{{ $access['message'] }}</p>
                                </div>

                                @php
                                    $hargaUpgrade = (int) ($tryoutUpgrade->price ?? 29000);
                                    $hargaUlang = (int) ($tryout->price ?? 20000);
                                @endphp

                                <div class="p-3 rounded-4 border border-primary border-2 bg-primary-soft text-start mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-primary text-white rounded-pill px-2.5 py-1 fw-bold">⭐ LEBIH HEMAT</span>
                                        <span class="fw-bolder text-primary fs-4">Rp {{ number_format($hargaUpgrade, 0, ',', '.') }}</span>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-1">Upgrade ke Unlimited + Full Materi</h5>
                                    <p class="text-muted small mb-3">Sekali bayar, bisa mengulang Tryout CAT sepuasnya tanpa batas + akses penuh semua modul materi.</p>
                                    <a href="{{ route('checkout', 3) }}" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm">
                                        <i class="fe fe-zap me-1"></i> Upgrade Sekarang (Rp {{ number_format($hargaUpgrade, 0, ',', '.') }})
                                    </a>
                                </div>

                                <div class="d-grid gap-2">
                                    <a href="{{ route('checkout', $tryout->id) }}" class="btn btn-outline-secondary rounded-pill">
                                        <i class="fe fe-refresh-cw me-1"></i> Atau Beli 1x Kuota Ulang (Rp {{ number_format($hargaUlang, 0, ',', '.') }})
                                    </a>
                                    <a href="{{ route('dashboard') }}" class="btn btn-link text-muted">
                                        Kembali ke Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @php
                        $hargaMandiri = (int) ($tryoutMandiri->price ?? $tryout->price ?? 20000);
                        $hargaLengkap = (int) ($tryoutLengkap->price ?? 49000);
                        $diskon = !empty($promo24h) ? (int) $promo24h['discount_amount'] : 0;
                        $hargaMandiriAkhir = max(0, $hargaMandiri - $diskon);
                        $hargaLengkapAkhir = max(0, $hargaLengkap - $diskon);
                    @endphp

                    <div class="col-lg-10 col-12">
                        @include('partials.promo-24h-banner', ['showCta' => false, 'promo24h' => $promo24h ?? null])

                        <div class="text-center mb-4">
                            <span class="badge bg-warning-subtle text-dark border border-warning rounded-pill px-3 py-1.5 fw-bold mb-2">
                                <i class="fe fe-lock me-1"></i> Akses Ujian Terkunci
                            </span>
                            <h3 class="fw-bold text-dark mb-1">Pilih Paket untuk Membuka Simulasi CAT</h3>
                            <p class="text-muted mb-0">{{ $access['message'] }}</p>
                        </div>

                        <div class="row g-4 justify-content-center align-items-stretch">
                            <!-- Paket 1: Tryout Mandiri -->
                            <div class="col-md-6 d-flex">
                                <div class="card w-100 border border-2 border-light shadow-sm rounded-4 p-4 d-flex flex-column bg-white">
                                    <div class="mb-3">
                                        <span class="badge bg-secondary rounded-pill px-3 py-1 mb-2 fw-semibold">Paket Latihan</span>
                                        <h4 class="fw-bold text-dark mb-1">{{ $tryoutMandiri->title ?? 'Tryout Mandiri' }}</h4>
                                        <p class="text-muted small mb-3">Fokus uji ketahanan & manajemen waktu dengan 1x simulasi CAT.</p>

                                        <div class="p-3 bg-light rounded-3 border">
                                            @if ($diskon > 0)
                                                <div class="d-flex align-items-center gap-2 mb-1">
                                                    <span class="text-muted text-decoration-line-through small">Rp {{ number_format($hargaMandiri, 0, ',', '.') }}</span>
                                                    <span class="badge bg-success text-white rounded-pill" style="font-size: 0.7rem;">Kupon {{ $promo24h['code'] }}</span>
                                                </div>
                                                <h3 class="fw-bolder text-dark mb-0">
                                                    Rp {{ number_format($hargaMandiriAkhir, 0, ',', '.') }}
                                                    <span class="fs-6 text-muted fw-normal">/ sekali bayar</span>
                                                </h3>
                                            @else
                                                <h3 class="fw-bolder text-dark mb-0">
                                                    Rp {{ number_format($hargaMandiri, 0, ',', '.') }}
                                                    <span class="fs-6 text-muted fw-normal">/ sekali bayar</span>
                                                </h3>
                                            @endif
                                        </div>
                                    </div>

                                    <ul class="list-unstyled d-flex flex-column gap-2 text-dark small mb-4">
                                        <li><i class="fe fe-check-circle text-success me-2"></i><strong>1x Kesempatan</strong> Simulasi 110 Soal CAT BKN</li>
                                        <li><i class="fe fe-check-circle text-success me-2"></i>Skor Otomatis, Pembahasan & Ranking Nasional</li>
                                        <li><i class="fe fe-check-circle text-success me-2"></i>Sertifikat Resmi Ber-QR Code (Jika Lulus PG)</li>
                                        <li class="text-muted"><i class="fe fe-x-circle text-danger opacity-50 me-2"></i><span class="text-decoration-line-through">Full Modul Materi & Tryout Unlimited</span></li>
                                    </ul>

                                    <div class="mt-auto">
                                        <a href="{{ route('checkout', 1) }}" class="btn btn-outline-dark btn-lg rounded-pill fw-bold w-100">
                                            Pilih Paket Mandiri <i class="fe fe-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Paket 2: Super Lengkap (Rekomendasi) -->
                            <div class="col-md-6 d-flex">
                                <div class="card w-100 border-2 border-primary shadow rounded-4 p-4 d-flex flex-column bg-white position-relative overflow-hidden">
                                    <div class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1.5 small fw-bold shadow-sm"
                                         style="border-bottom-left-radius: 14px;">
                                        ⭐ REKOMENDASI TERBAIK
                                    </div>

                                    <div class="mb-3 mt-2">
                                        <span class="badge bg-primary-soft text-primary rounded-pill px-3 py-1 mb-2 fw-bold">Paket Super Lengkap</span>
                                        <h4 class="fw-bold text-dark mb-1">{{ $tryoutLengkap->title ?? 'Tryout + Materi Full' }}</h4>
                                        <p class="text-muted small mb-3">Solusi total: Kuasai modul materinya dan ulangi tryout sepuasnya.</p>

                                        <div class="p-3 bg-primary-soft rounded-3 border border-primary border-opacity-25">
                                            @if ($diskon > 0)
                                                <div class="d-flex align-items-center gap-2 mb-1">
                                                    <span class="text-muted text-decoration-line-through small">Rp {{ number_format($hargaLengkap, 0, ',', '.') }}</span>
                                                    <span class="badge bg-primary text-white rounded-pill" style="font-size: 0.7rem;">Kupon {{ $promo24h['code'] }}</span>
                                                </div>
                                                <h3 class="fw-bolder text-primary mb-0">
                                                    Rp {{ number_format($hargaLengkapAkhir, 0, ',', '.') }}
                                                    <span class="fs-6 text-muted fw-normal">/ selamanya</span>
                                                </h3>
                                            @else
                                                <h3 class="fw-bolder text-primary mb-0">
                                                    Rp {{ number_format($hargaLengkap, 0, ',', '.') }}
                                                    <span class="fs-6 text-muted fw-normal">/ selamanya</span>
                                                </h3>
                                            @endif
                                        </div>
                                    </div>

                                    <ul class="list-unstyled d-flex flex-column gap-2 text-dark small mb-4">
                                        <li class="text-primary fw-semibold"><i class="fe fe-repeat text-primary me-2"></i><strong>Tryout Unlimited</strong> — Ulangi berkali-kali tanpa batas</li>
                                        <li class="text-primary fw-semibold"><i class="fe fe-book-open text-primary me-2"></i><strong>Full Modul Materi</strong> TWK, TIU, TKP Terstruktur</li>
                                        <li><i class="fe fe-check-circle text-primary me-2"></i>110 Soal HOTS BKN, Pembahasan PDF & Grafik Progres</li>
                                        <li><i class="fe fe-check-circle text-primary me-2"></i>Ranking Nasional & Sertifikat Resmi Ber-QR Code</li>
                                    </ul>

                                    <div class="mt-auto">
                                        <a href="{{ route('checkout', 2) }}" class="btn btn-primary btn-lg rounded-pill fw-bold w-100 shadow-sm">
                                            Ambil Paket Lengkap <i class="fe fe-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('demo.index') }}" class="btn btn-link text-muted small">
                                <i class="fe fe-play-circle me-1"></i> Atau coba Ujicoba Gratis (10 Soal) dulu
                            </a>
                        </div>
                    </div>
                @endif
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
    <script src="/build/assets/js/vendors/tnsSlider.js"></script>
    <script src="/build/assets/js/vendors/chart.js"></script>
    <script src="/build/assets/js/vendors/navbar-nav.js"></script>
</body>

</html>
