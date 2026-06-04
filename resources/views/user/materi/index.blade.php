<!doctype html>
<html lang="en">

<head>
    @include('partials.head')
    <title>Ruang Belajar SKD - CalonASN.id</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Efek melayang saat kartu disentuh mouse */
        .hover-lift {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .15) !important;
        }
    </style>
</head>

<body>
    @include('partials.navbar')
    @include('partials.navbar-student')

    <div class="db-content text-dark">
        <div class="container-fluid py-4">

            <div class="row mb-4">
                <div class="col-12 d-flex align-items-center">
                    <div class="bg-primary text-white rounded p-2 me-3 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.815 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.815 8.985.936 8 1.783" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="fw-bold text-dark mb-0">Ruang Belajar SKD</h2>
                        <p class="text-muted fs-6 mb-0">Pahami konsep dasarnya sebelum bertempur di simulasi Tryout.</p>
                    </div>
                </div>
            </div>



            <div class="row g-4">
                @foreach ($categories as $category)
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift">
                            <div class="card-body p-4 p-xl-5 d-flex flex-column">

                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-{{ $category['color_theme'] }} text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 me-3 shadow-sm"
                                        style="width: 60px; height: 60px;">

                                        <i class="{{ $category['icon'] }} fs-2"></i>

                                    </div>

                                    <div>
                                        <span
                                            class="badge bg-{{ $category['color_theme'] }}-subtle text-{{ $category['color_theme'] }} fw-semibold mb-2 border border-{{ $category['color_theme'] }}">
                                            {{ $category['total_pages'] }} Halaman Materi
                                        </span>
                                        <h4 class="fw-bold mb-0 text-dark">{{ $category['name'] }}</h4>
                                    </div>
                                </div>

                                <p class="text-muted mb-4 flex-grow-1 fs-5">
                                    {{ $category['description'] }}
                                </p>

                                <div class="mt-auto">
                                    <a href="{{ route('materi.show', $category['slug']) }}"
                                        class="btn btn-outline-{{ $category['color_theme'] }} w-100 rounded-pill fw-bold py-2 d-flex align-items-center justify-content-center">
                                        Mulai Belajar
                                        <i class="bi bi-play-circle-fill ms-2 fs-5"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0 bg-light rounded-4 shadow-sm border-start border-warning border-4">
                        <div
                            class="card-body p-4 d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <div class="mb-3 mb-md-0 d-flex align-items-center">
                                <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm"
                                    style="width: 45px; height: 45px;">
                                    <i class="bi bi-lightbulb-fill fs-5"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1 text-dark">Tips Cepat Hafal! 💡</h5>
                                    <p class="mb-0 text-muted small">Membaca materi saja tidak cukup. Padukan dengan
                                        mengerjakan soal-soal HOTS agar insting menjawabmu tajam.</p>
                                </div>
                            </div>
                            <a href="{{ route('dashboard') }}"
                                class="btn btn-warning text-dark fw-bold px-4 rounded-pill shadow-sm">
                                Kerjakan Tryout Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('partials.btn-scroll-top')
    @include('partials.scripts')
    <script src="assets/js/vendors/navbar-nav.js"></script>

    <style>
        .btn-hover-solid:hover {
            background-color: currentColor !important;
            color: #fff !important;
            transition: all 0.3s ease;
        }

        /* Penyesuaian text warna saat di hover untuk tema warning/kuning */
        .btn-warning.btn-hover-solid:hover {
            color: #000 !important;
        }
    </style>
</body>

</html>
