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

    <div class="db-content">
        <div class="container-fluid py-4">

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4"
                        style="background: linear-gradient(135deg, #1e40af 0%, #0ea5e9 100%);">
                        <div
                            class="card-body p-4 p-md-5 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
                            <div>
                                <div class="mb-3">
                                    @if ($isPaketLengkapPdf)
                                        <span class="badge bg-white text-primary px-3 py-2 rounded-pill shadow-sm">
                                            <i class="bi bi-star-fill text-warning me-1"></i> Member Tryout Unlimited + Materi Full
                                        </span>
                                    @elseif($isPaketTryoutSaja)
                                        <span class="badge bg-white text-success px-3 py-2 rounded-pill shadow-sm">
                                            <i class="bi bi-check-circle-fill me-1"></i> Member Tryout Mandiri (1x)
                                        </span>
                                    @else
                                        <span class="badge bg-dark bg-opacity-25 text-white px-3 py-2 rounded-pill">
                                            <i class="bi bi-person-fill me-1"></i> Member Gratisan
                                        </span>
                                    @endif
                                </div>

                                <h2 class="fw-bold mb-2" style="color: #ffffff !important;">Halo, {{ auth()->user()->name ?? 'Pejuang NIP' }}! 👋</h2>
                                <p class="mb-0 fs-5" style="color: rgba(255, 255, 255, 0.88) !important;">
                                    @if ($isPaketLengkapPdf)
                                        Akses penuh aktif! Latih terus konsistensi skormu hingga melampaui Passing Grade.
                                    @elseif (isset($access) && $access['status'] == 'unlocked')
                                        Kuota ujianmu siap digunakan. Kerjakan dengan fokus dan raih skor terbaik!
                                    @else
                                        Ukur kesiapanmu sekarang — mulai dari materi gratis atau langsung simulasi CAT 110 soal.
                                    @endif
                                </p>
                            </div>

                            <!-- 3 Langkah Kesiapan (Road to NIP) -->
                            @php
                                $step2Done = $hasCompletedExam || $isPaketLengkapPdf || $isPaketTryoutSaja;
                                $step3Done = $hasCompletedExam;
                            @endphp
                            <div class="rounded-4 p-3 flex-shrink-0"
                                 style="width: 100%; max-width: 310px; background: rgba(15, 23, 42, 0.32); border: 1px solid rgba(255, 255, 255, 0.28); backdrop-filter: blur(8px); color: #ffffff !important;">
                                <div class="small fw-bold text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.6px; color: #fde68a !important;">
                                    Target Kesiapan SKD
                                </div>
                                <div class="d-flex flex-column gap-2 small">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-success rounded-circle p-1 d-inline-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">✓</span>
                                        <span class="fw-medium" style="color: #ffffff !important;">1. Daftar Akun CalonASN</span>
                                    </div>
                                    <a href="{{ route('demo.index') }}" class="d-flex align-items-center gap-2 text-decoration-none" style="color: #ffffff !important;">
                                        <span class="badge {{ $step2Done ? 'bg-success' : 'bg-warning text-dark' }} rounded-circle p-1 d-inline-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">
                                            {{ $step2Done ? '✓' : '2' }}
                                        </span>
                                        <span class="{{ $step2Done ? 'opacity-75 text-decoration-line-through' : 'fw-bold text-decoration-underline' }}" style="color: #ffffff !important;">2. Coba Demo 10 Soal / Bab 1</span>
                                    </a>
                                    <a href="{{ route('ujian.persiapan', $tryout->id ?? 1) }}" class="d-flex align-items-center gap-2 text-decoration-none" style="color: #ffffff !important;">
                                        <span class="badge {{ $step3Done ? 'bg-success' : 'bg-light text-dark' }} rounded-circle p-1 d-inline-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">
                                            {{ $step3Done ? '✓' : '3' }}
                                        </span>
                                        <span class="{{ $step3Done ? 'opacity-75 text-decoration-line-through' : 'fw-semibold' }}" style="color: #ffffff !important;">3. Taklukkan Tryout 110 Soal</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @php
            $promo24h = $promo24h ?? (auth()->check() ? auth()->user()->newMemberPromo() : null);
            $isUnlocked = isset($access) && $access['status'] == 'unlocked';
            $topLeader = $topNational->first();
            $hargaMandiri = (int) ($tryoutMandiri->price ?? 20000);
            $hargaLengkap = (int) ($tryoutLengkap->price ?? 49000);
            $hargaUpgrade = (int) ($tryoutUpgrade->price ?? 29000);
            $diskonPromo = $promo24h ? (int) $promo24h['discount_amount'] : 0;
            $hargaMandiriAkhir = max(0, $hargaMandiri - $diskonPromo);
            $hargaLengkapAkhir = max(0, $hargaLengkap - $diskonPromo);
        @endphp
        @include('partials.promo-24h-banner', ['showCta' => true, 'promo24h' => $promo24h])

        <div class="row g-4 mb-4">

            <!-- CARD GRATIS (Urutan ke-2 jika user sudah unlocked) -->
            <div class="col-lg-6 col-12 {{ $isUnlocked ? 'order-2' : 'order-1' }}">

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

            <!-- CARD UTAMA UJIAN / PENAWARAN PAKET (Urutan ke-1 jika user sudah unlocked) -->
            <div class="col-lg-6 col-12 {{ $isUnlocked ? 'order-1' : 'order-2' }}">
                <div
                    class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden position-relative hover-card-premium">

                    @if ($isUnlocked)
                        <div class="position-absolute top-0 end-0">
                            <div class="bg-warning text-dark fw-bold px-4 py-2 shadow-sm"
                                style="border-bottom-left-radius:16px;">
                                ✅ PREMIUM AKTIF
                            </div>
                        </div>

                        <div class="card-body p-4 p-xl-5 d-flex flex-column">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 me-3 shadow-sm"
                                    style="width:60px;height:60px;">
                                    <i class="bi bi-unlock-fill fs-3"></i>
                                </div>
                                <div>
                                    <span
                                        class="badge bg-warning-subtle text-dark fw-semibold mb-2 border border-warning">
                                        AKSES TERBUKA
                                    </span>
                                    <h3 class="fw-bold mb-0 text-dark">
                                        Siap Ujian!
                                    </h3>
                                </div>
                            </div>

                            @if (isset($access['is_unlimited']) && $access['is_unlimited'])
                                <p class="text-dark fs-5 mb-4">
                                    <strong>Akses Tryout Unlimited Aktif:</strong> Anda bebas mengulang tryout ini sepuasnya untuk mematangkan latihan dan mencetak skor terbaik.
                                </p>

                                <div class="alert alert-success bg-success-subtle border-0 rounded-4 py-3 px-4 mb-4 shadow-sm">
                                    <ul class="text-start mb-0 small fw-medium ps-3 text-success-emphasis">
                                        <li class="mb-1"><strong>Simulasi Tanpa Batas:</strong> Kerjakan berkali-kali kapan saja.</li>
                                        <li class="mb-1"><strong>Evaluasi Terupdate:</strong> Rapor, grafik perkembangan, ranking & sertifikat diperbarui tiap sesi.</li>
                                        <li>Pastikan koneksi internet stabil sebelum memulai ujian.</li>
                                    </ul>
                                </div>
                            @else
                                <p class="text-dark fs-5 mb-4">
                                    Pembayaran berhasil diverifikasi. Anda memiliki <strong>1x kesempatan</strong>
                                    untuk mengerjakan simulasi tryout ini sekarang.
                                </p>

                                <div class="alert alert-info border-0 rounded-4 py-3 px-4 mb-4 shadow-sm">
                                    <ul class="text-start mb-0 small fw-medium ps-3">
                                        <li class="mb-1">Pastikan koneksi internet stabil.</li>
                                        <li class="mb-1">Ujian akan otomatis berhenti jika waktu habis (100 Menit).</li>
                                        <li>Satu kali klik "Selesai", kesempatan tryout ini akan terpakai.</li>
                                    </ul>
                                </div>
                            @endif

                            <div class="mt-auto">
                                <a href="{{ route('ujian.persiapan', $tryout->id ?? 1) }}"
                                    class="btn btn-warning text-dark btn-lg rounded-pill fw-bold px-4 py-3 shadow-sm w-100">
                                    Mulai Ujian Sekarang
                                    <i class="fe fe-play ms-2"></i>
                                </a>
                            </div>
                        </div>
                    @elseif ($isPaketTryoutSaja)
                        <div class="position-absolute top-0 end-0">
                            <div class="bg-primary text-white fw-bold px-4 py-2 shadow-sm"
                                style="border-bottom-left-radius:16px;">
                                ⭐ HEMAT UPGRADE
                            </div>
                        </div>

                        <div class="card-body p-4 p-xl-5 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 me-3 shadow-sm"
                                    style="width:60px;height:60px;">
                                    <i class="bi bi-arrow-up-circle-fill fs-3"></i>
                                </div>
                                <div>
                                    <span class="badge bg-primary-subtle text-primary fw-semibold mb-2">
                                        KUOTA MANDIRI HABIS
                                    </span>
                                    <h3 class="fw-bold mb-0 text-dark">
                                        Upgrade ke Unlimited!
                                    </h3>
                                </div>
                            </div>

                            <p class="text-muted mb-3">
                                Kuota 1x Tryout Mandiri Anda sudah terpakai. Daripada beli 1x lagi berkali-kali, upgrade sekali untuk membuka:
                            </p>

                            <div class="p-3 rounded-4 bg-primary-soft border border-primary border-opacity-25 mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-dark">Tryout Unlimited + Full Materi</span>
                                    <span class="fs-4 fw-bolder text-primary">Rp {{ number_format($hargaUpgrade, 0, ',', '.') }}</span>
                                </div>
                                <ul class="mb-0 ps-3 small text-dark">
                                    <li><strong>Tryout berkali-kali sepuasnya</strong> (soal & opsi acak baru)</li>
                                    <li><strong>Buka semua 26 Modul Materi</strong> TWK, TIU, TKP</li>
                                </ul>
                            </div>

                            <div class="mt-auto d-grid gap-2">
                                <a href="{{ route('checkout', 3) }}"
                                    class="btn btn-primary btn-lg rounded-pill fw-bold px-4 py-3 shadow-sm">
                                    Upgrade Sekarang (Rp {{ number_format($hargaUpgrade, 0, ',', '.') }})
                                    <i class="fe fe-zap ms-1"></i>
                                </a>
                                <a href="{{ route('checkout', 1) }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                                    Atau beli 1x kuota ulang (Rp {{ number_format($hargaMandiri, 0, ',', '.') }})
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="position-absolute top-0 end-0">
                            <div class="bg-danger text-white fw-bold px-4 py-2 shadow-sm"
                                style="border-bottom-left-radius:16px;">
                                🔥 PALING LARIS
                            </div>
                        </div>

                        <div class="card-body p-4 p-xl-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 me-3 shadow-sm"
                                    style="width:56px;height:56px;">
                                    <i class="bi bi-award-fill fs-3"></i>
                                </div>
                                <div>
                                    <span class="badge bg-success-subtle text-success fw-semibold mb-1">
                                        SIMULASI CAT STANDAR BKN
                                    </span>
                                    <h3 class="fw-bold mb-0 text-success">
                                        Langsung Tempur!
                                    </h3>
                                </div>
                            </div>

                            <!-- Social Proof Real -->
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-3 small text-muted bg-light rounded-3 px-3 py-2 border">
                                <i class="bi bi-people-fill text-primary"></i>
                                <span><strong>{{ $totalParticipants }} peserta</strong> sudah ikut Tryout</span>
                                @if ($topLeader)
                                    <span>• Skor tertinggi: <strong class="text-dark">{{ $topLeader->total_score }} Poin</strong></span>
                                @endif
                            </div>

                            <!-- 2 Opsi Paket Transparan -->
                            <div class="row g-2 mb-3">
                                <div class="col-sm-6 d-flex">
                                    <div class="p-3 rounded-3 border bg-light w-100 d-flex flex-column">
                                        <span class="badge bg-secondary align-self-start mb-1" style="font-size: 0.68rem;">TRYOUT MANDIRI (1X)</span>
                                        @if ($diskonPromo > 0)
                                            <small class="text-muted text-decoration-line-through">Rp {{ number_format($hargaMandiri, 0, ',', '.') }}</small>
                                            <div class="fs-4 fw-bolder text-dark lh-sm mb-1">Rp {{ number_format($hargaMandiriAkhir, 0, ',', '.') }}</div>
                                        @else
                                            <div class="fs-4 fw-bolder text-dark lh-sm mb-1">Rp {{ number_format($hargaMandiri, 0, ',', '.') }}</div>
                                        @endif
                                        <small class="text-muted mb-3">110 Soal CAT + Pembahasan + Ranking</small>
                                        <a href="{{ route('checkout', 1) }}" class="btn btn-outline-dark btn-sm rounded-pill fw-bold w-100 mt-auto">
                                            Pilih Rp {{ number_format($hargaMandiriAkhir / 1000, 0) }}rb <i class="fe fe-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-sm-6 d-flex">
                                    <div class="p-3 rounded-3 border border-2 border-primary bg-primary-soft w-100 d-flex flex-column">
                                        <span class="badge bg-primary align-self-start mb-1" style="font-size: 0.68rem;">⭐ UNLIMITED + MATERI</span>
                                        @if ($diskonPromo > 0)
                                            <small class="text-muted text-decoration-line-through">Rp {{ number_format($hargaLengkap, 0, ',', '.') }}</small>
                                            <div class="fs-4 fw-bolder text-primary lh-sm mb-1">Rp {{ number_format($hargaLengkapAkhir, 0, ',', '.') }}</div>
                                        @else
                                            <div class="fs-4 fw-bolder text-primary lh-sm mb-1">Rp {{ number_format($hargaLengkap, 0, ',', '.') }}</div>
                                        @endif
                                        <small class="text-dark mb-3">Tryout Unlimited + Full 26 Modul Materi</small>
                                        <a href="{{ route('checkout', 2) }}" class="btn btn-primary btn-sm rounded-pill fw-bold w-100 mt-auto shadow-xs">
                                            Ambil Unlimited <i class="fe fe-zap ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto text-center">
                                <a href="{{ route('user.pilih-paket') }}" class="small fw-semibold text-decoration-none text-success">
                                    Lihat perbandingan lengkap fitur kedua paket <i class="fe fe-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>

        <!-- WIDGET RINGKAS RUANG BELAJAR SKD -->
        @if (isset($learningCategories) && $learningCategories->count() > 0)
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-body p-3 p-md-4 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                            <div class="d-flex align-items-start align-items-md-center gap-3">
                                <div class="bg-primary-soft text-primary rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                    <i class="bi bi-journal-bookmark-fill fs-4"></i>
                                </div>
                                <div>
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                        <h5 class="fw-bold text-dark mb-0">Ruang Belajar SKD (Micro-Learning)</h5>
                                        @if ($isPaketLengkapPdf)
                                            <span class="badge bg-success-subtle text-success rounded-pill small">Full Akses Aktif</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-dark border border-warning rounded-pill small">Bab 1 Gratis • Bab 2+ Paket Lengkap</span>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 small text-muted">
                                        @foreach ($learningCategories as $lc)
                                            <span><i class="bi bi-check2-circle text-primary me-1"></i><strong>{{ $lc->name }}</strong> ({{ $lc->materials_count }} Modul)</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('materi.index') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold text-nowrap">
                                <i class="fe fe-book-open me-1"></i> Buka Ruang Belajar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="d-flex align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0 me-2">Statistik & Evaluasi Belajar Kamu</h5>
            @if ($hasCompletedExam)
                <span class="badge bg-success-subtle text-success rounded-pill"><i class="bi bi-unlock-fill me-1"></i> Aktif</span>
            @else
                <span class="badge bg-secondary rounded-pill"><i class="bi bi-lock-fill me-1"></i> Terkunci</span>
            @endif
        </div>

        <div class="row">
            <!-- KOLOM KIRI: STATISTIK & GRAFIK PRIBADI (TERKUNCI JIKA BELUM PERNAH TRYOUT) -->
            <div class="col-xl-8 col-lg-12 mb-4">
                <div class="position-relative h-100">
                    @if (!$hasCompletedExam)
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center rounded-4 p-3"
                            style="background: rgba(255, 255, 255, 0.72); backdrop-filter: blur(4px); z-index: 10;">
                            <div class="bg-white p-4 rounded-4 shadow-lg text-center border" style="max-width: 440px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="#6c757d" class="mb-2"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1" />
                                </svg>
                                <h4 class="fw-bold text-dark">Statistik Pribadimu Belum Terbuka</h4>
                                <p class="text-muted small mb-3">Kerjakan Tryout CAT pertamamu untuk membuka grafik perkembangan skor, rasio kelulusan PG, dan posisimu dibanding {{ $totalParticipants }} peserta lainnya.</p>
                                @if ($isUnlocked)
                                    <a href="{{ route('ujian.persiapan', $tryout->id ?? 1) }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                                        <i class="bi bi-play-circle-fill me-1"></i> Mulai Tryout Sekarang
                                    </a>
                                @else
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        <a href="{{ route('user.pilih-paket') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                                            <i class="bi bi-unlock-fill me-1"></i> Buka Akses Tryout
                                        </a>
                                        <a href="{{ route('demo.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
                                            Coba Demo Dulu
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div style="{{ !$hasCompletedExam ? 'opacity: 0.4; pointer-events: none; user-select: none;' : '' }}">
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6 col-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-muted mb-0 small">Total Tryout</h6>
                                            <div class="icon-shape icon-sm bg-light-primary text-primary rounded-circle"><i
                                                    class="fe fe-file-text"></i></div>
                                        </div>
                                        <h2 class="fw-bold mb-0">{{ $totalUserExams }} <span class="fs-6 text-muted fw-normal">Sesi</span></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-muted mb-0 small">Skor Tertinggi</h6>
                                            <div class="icon-shape icon-sm bg-light-success text-success rounded-circle"><i
                                                    class="fe fe-trending-up"></i></div>
                                        </div>
                                        <h2 class="fw-bold mb-0 text-success">{{ $hasCompletedExam ? $highestScore : 435 }} <span
                                                class="fs-6 text-muted fw-normal">Poin</span></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-muted mb-0 small">Rasio Kelulusan</h6>
                                            <div class="icon-shape icon-sm bg-light-warning text-warning rounded-circle"><i
                                                    class="fe fe-pie-chart"></i></div>
                                        </div>
                                        <h2 class="fw-bold mb-0">{{ $hasCompletedExam ? $passRatio : 80 }}% <span class="fs-6 text-muted fw-normal">Lulus PG</span></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-muted mb-0 small">Peringkat Nasional</h6>
                                            <div class="icon-shape icon-sm bg-light-info text-info rounded-circle"><i
                                                    class="fe fe-award"></i></div>
                                        </div>
                                        <h2 class="fw-bold mb-0">
                                            @if ($userRank !== '-')
                                                #{{ $userRank }} <span class="fs-6 text-muted fw-normal">dari {{ $totalParticipants }}</span>
                                            @else
                                                #? <span class="fs-6 text-muted fw-normal">dari {{ $totalParticipants }}</span>
                                            @endif
                                        </h2>
                                    </div>
                                </div>
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
                </div>
            </div>

            <!-- KOLOM KANAN: TOP 3 NASIONAL (SELALU TERBUKA SEBAGAI BUKTI SOSIAL & KOMPETISI) -->
            <div class="col-xl-4 col-lg-12">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Top 3 Nasional</h5>
                        <a href="{{ route('ranking') }}" class="btn btn-sm btn-outline-primary rounded-pill">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse ($topNational as $index => $top)
                                @php
                                    $medal = $index === 0 ? '🥇' : ($index === 1 ? '🥈' : '🥉');
                                @endphp
                                <li class="list-group-item d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center">
                                        <span class="fs-4 me-3">{{ $medal }}</span>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $top->user->name ?? 'Peserta' }}</h6>
                                            <small class="text-muted">TWK: {{ $top->score_twk }} | TIU: {{ $top->score_tiu }} | TKP: {{ $top->score_tkp }}</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary fw-bold px-2 py-1 rounded-pill">
                                        {{ $top->total_score }} Poin
                                    </span>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted py-4">
                                    Belum ada data peserta tryout
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    @if (!$hasCompletedExam)
                        <div class="card-footer bg-light text-center py-2.5 border-top">
                            <small class="text-muted">Namamu belum ada di sini. <a href="{{ $isUnlocked ? route('ujian.persiapan', $tryout->id ?? 1) : route('user.pilih-paket') }}" class="fw-bold text-primary text-decoration-none">Uji skormu sekarang →</a></small>
                        </div>
                    @endif
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
        // Script Grafik
        document.addEventListener("DOMContentLoaded", function() {
            var chartLabels = @json($chartLabels);
            var chartScores = @json($chartScores);

            var options = {
                series: [{
                    name: 'Total Skor',
                    data: chartScores
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
                    categories: chartLabels,
                    tooltip: {
                        enabled: false
                    }
                },
                yaxis: {
                    min: 0,
                    max: 550,
                    tickAmount: 5
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " Poin";
                        }
                    }
                }
            };
            var chart = new ApexCharts(document.querySelector("#chartProgress"), options);
            chart.render();
        });
    </script>

    @include('partials.btn-scroll-top')
    @include('partials.scripts')
    <script src="/build/assets/js/vendors/tnsSlider.js"></script>
    <script src="/build/assets/js/vendors/chart.js"></script>
    <script src="/build/assets/js/vendors/navbar-nav.js"></script>

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
    @if (empty(auth()->user()->phone))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (sessionStorage.getItem('phone_prompt_dismissed')) {
                    return;
                }

                Swal.fire({
                    title: 'Eits, Ada yang Kelupaan Nih!',
                    html: `
                        <p class="text-start mb-2" style="text-align: justify; text-justify: inter-word; line-height: 1.5;">
                            Biar belajarnya makin sat-set dan mimin gampang ngabarin kalau ada info penting (atau promo rahasia!), bisikin nomor WhatsApp kamu di bawah ini dong.
                        </p>
                        <input id="swal-phone" type="tel" class="swal2-input" placeholder="Contoh: 08123456789...">
                    `,
                    showCloseButton: true,
                    showCancelButton: true,
                    cancelButtonText: 'Nanti saja',
                    confirmButtonText: 'Gas, Simpan Nomorku! 🚀',
                    allowOutsideClick: true,
                    allowEscapeKey: true,
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        const phoneEl = document.getElementById('swal-phone');
                        const phone = phoneEl ? phoneEl.value.trim() : '';
                        const digitsOnly = phone.replace(/\D/g, '');

                        if (!phone || !phone.startsWith('08') || digitsOnly.length < 9) {
                            Swal.showValidationMessage('Nomor harus diawali 08 dan minimal 9 digit.');
                            return false;
                        }

                        return fetch('{{ route("profile.updatePhone") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ phone: phone })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                throw new Error(data.message || 'Gagal menyimpan nomor telepon');
                            }
                            return data;
                        })
                        .catch(err => {
                            Swal.showValidationMessage(err.message || 'Gagal menyimpan nomor');
                        });
                    }
                }).then((result) => {
                    if (result.isDismissed) {
                        sessionStorage.setItem('phone_prompt_dismissed', '1');
                        return;
                    }

                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Tersimpan',
                            text: 'Nomor telepon berhasil disimpan.'
                        }).then(() => location.reload());
                    }
                });
            });
        </script>
    @endif
</body>

</html>
