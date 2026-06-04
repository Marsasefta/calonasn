<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <title>Belajar {{ $categoryName }} - CalonASN.id</title>
    <style>
        .reading-area {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }

        .sidebar-sticky {
            position: sticky;
            top: 85px;
            /* Jarak dari navbar atas */
        }

        /* Style untuk link materi di sidebar kiri */
        .materi-link {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: #4a5568;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.2s ease;
        }

        .materi-link:hover {
            background-color: #f8f9fa;
        }

        .materi-link.active {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            font-weight: 600;
        }
    </style>
</head>

<body>
    @include('partials.navbar')
    @include('partials.navbar-student')

    <div class="db-content text-dark">
        <div class="container-fluid py-4">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('materi.index') }}"
                                class="text-decoration-none">Ruang Belajar</a></li>
                        <li class="breadcrumb-item active fw-bold" aria-current="page">Materi {{ $categoryName }}</li>
                    </ol>
                </nav>
            </div>

            <div class="row g-4">

                <div class="col-lg-3">
                    <div class="sidebar-sticky">
                        <h5 class="fw-bold mb-3 d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="text-primary me-2" viewBox="0 0 16 16">
                                <path
                                    d="M4.5 11.5A.5.5 0 0 1 5 11h10a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm-2-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm-2-4A.5.5 0 0 1 1 3h10a.5.5 0 0 1 0 1H1a.5.5 0 0 1-.5-.5z" />
                            </svg>
                            Daftar Isi
                        </h5>

                        <div class="accordion border-0" id="accordionChapters">
                            @foreach ($chapters as $index => $chapter)
                                <div class="accordion-item border-0 mb-2 shadow-sm rounded-3 overflow-hidden">
                                    <h2 class="accordion-header" id="heading{{ $chapter['id'] }}">
                                        <button
                                            class="accordion-button fw-bold {{ $index != 0 ? 'collapsed' : '' }} bg-white"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $chapter['id'] }}"
                                            aria-expanded="{{ $index == 0 ? 'true' : 'false' }}">
                                            {{ $chapter['title'] }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $chapter['id'] }}"
                                        class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                        data-bs-parent="#accordionChapters">
                                        <div class="accordion-body p-2 bg-white">

                                            @foreach ($chapter['materials'] as $materi)
                                                <a href="#"
                                                    class="materi-link {{ $materi['active'] ? 'active' : '' }}">

                                                    @if ($materi['is_locked'])
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="#dc3545" class="me-2 flex-shrink-0"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="me-2 flex-shrink-0 {{ $materi['active'] ? 'text-primary' : 'text-muted' }}"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                        </svg>
                                                    @endif

                                                    <span class="small">{{ $materi['title'] }}</span>
                                                </a>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="fw-bold mb-4">Sejarah Lahirnya Pancasila</h2>

                            <div class="reading-area">
                                <p>Sidang pertama Badan Penyelidik Usaha Persiapan Kemerdekaan Indonesia (BPUPKI)
                                    dilaksanakan pada tanggal 29 Mei hingga 1 Juni 1945. Dalam sidang ini, beberapa
                                    tokoh menyampaikan gagasan mengenai dasar negara Indonesia merdeka.</p>
                                <p>Pada tanggal 1 Juni 1945, Ir. Soekarno menyampaikan pidatonya yang fenomenal. Dalam
                                    pidato tersebut, beliau mengusulkan lima dasar negara yang diberi nama
                                    <strong>Pancasila</strong>. Kelima dasar tersebut adalah:</p>
                                <ul>
                                    <li>Kebangsaan Indonesia</li>
                                    <li>Internasionalisme atau Perikemanusiaan</li>
                                    <li>Mufakat atau Demokrasi</li>
                                    <li>Kesejahteraan Sosial</li>
                                    <li>Ketuhanan yang Berkebudayaan</li>
                                </ul>
                                <p>Pidato ini kemudian dikenal sebagai hari lahirnya Pancasila. Setelah melalui berbagai
                                    penyempurnaan oleh Panitia Sembilan, rumusan final Pancasila disahkan bersamaan
                                    dengan UUD 1945 pada tanggal 18 Agustus 1945.</p>
                            </div>

                            <hr class="my-5">

                            <div
                                class="d-flex justify-content-between align-items-center bg-light p-3 rounded-4 border">
                                <span class="fw-medium text-muted">Selesai membaca? Lanjut ke materi berikutnya.</span>
                                <button class="btn btn-primary rounded-pill px-4 fw-bold">
                                    Tandai Selesai <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="ms-1" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                    </svg>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="sidebar-sticky">
                        <!-- Background putih murni dengan border kuning/emas agar menonjol tapi tetap bersih -->
                        <div class="card bg-white border border-warning border-2 rounded-4 shadow-sm text-center">
                            <div class="card-body p-4">

                                <!-- Ikon Emas dengan teks gelap -->
                                <div class="bg-warning text-dark rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm"
                                    style="width: 60px; height: 60px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M15.228 2.746a4.746 4.746 0 0 0-1.874-1.874l-.21-.088a2.637 2.637 0 0 0-1.04-.214H11.5a5.55 5.55 0 0 0-3.327 1.108 5.6 5.6 0 0 0-1.4 1.488c-.628 1.05-.98 2.302-1.008 3.593l-.008.384L3.655 9.25a2.53 2.53 0 0 0-.648 3.023l.163.31a.5.5 0 0 0 .762.158l.764-.611.838.839-.611.764a.5.5 0 0 0 .158.762l.31.163a2.53 2.53 0 0 0 3.023-.648l2.106-2.106.384-.008c1.291-.028 2.543-.38 3.593-1.008a5.6 5.6 0 0 0 1.488-1.4 5.55 5.55 0 0 0 1.108-3.327v-.604a2.637 2.637 0 0 0-.214-1.04l-.088-.21zm-2.079 3.428a1.5 1.5 0 1 1-2.121-2.121 1.5 1.5 0 0 1 2.121 2.121" />
                                    </svg>
                                </div>

                                <!-- Teks diubah menjadi warna gelap (text-dark dan text-muted) agar kontras maksimal -->
                                <h5 class="fw-bold text-dark mb-3">Tantang Dirimu!</h5>
                                <p class="text-muted small mb-4">
                                    Materi {{ $categoryName }} butuh daya ingat tajam. Uji pemahamanmu sekarang dengan
                                    simulasi CAT Tryout Premium!
                                </p>

                                <!-- Tombol kuning yang sangat jelas -->
                                <a href="{{ route('checkout') }}"
                                    class="btn btn-warning text-dark w-100 rounded-pill fw-bold shadow-sm mb-3">
                                    Beli Paket Premium
                                </a>

                                <!-- Area Kupon dibuat berbentuk kotak khusus agar makin mirip voucher -->
                                <div class="bg-light rounded p-2 border border-2 border-light border-dashed">
                                    <span class="d-block text-muted mb-1" style="font-size: 0.75rem;">Gunakan kode
                                        diskon:</span>
                                    <strong class="text-danger fs-5" style="letter-spacing: 1.5px;">ASN2026</strong>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('partials.scripts')
    <script src="assets/js/vendors/navbar-nav.js"></script>
</body>

</html>
