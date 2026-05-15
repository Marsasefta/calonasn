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
            <div class="row mb-4 align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-0">Review & Pembahasan</h2>
                    <p class="text-muted">Pelajari letak kesalahanmu agar tidak mengulanginya di tes asli.</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('ujian.hasil', $id) }}" class="btn btn-outline-secondary">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @foreach ($questions as $q)
                        @php
                            $dijawab = $jawabanUser[$q['id']] ?? null;
                            $isBenar = $dijawab == $q['kunci'];

                            // Khusus TKP, tidak ada salah mutlak, tapi kita buat simulasi sederhana
                            if ($q['kategori'] == 'TKP' && $dijawab) {
                                $isBenar = true;
                            }
                        @endphp

                        <div
                            class="card shadow-sm mb-4 border-0 {{ $dijawab ? ($isBenar ? 'border-start border-success border-4' : 'border-start border-danger border-4') : 'border-start border-secondary border-4' }}">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="badge bg-primary me-2">{{ $q['kategori'] }}</span>
                                        <span class="fw-bold">Soal Ke-{{ $q['id'] }}</span>
                                    </div>
                                    <div>
                                        @if (!$dijawab)
                                            <span class="badge bg-secondary">Tidak Dijawab</span>
                                        @elseif($isBenar)
                                            <span class="badge bg-success"><i class="fe fe-check"></i> Benar</span>
                                        @else
                                            <span class="badge bg-danger"><i class="fe fe-x"></i> Salah</span>
                                        @endif
                                    </div>
                                </div>

                                <h5 class="lh-base mb-3">{{ $q['pertanyaan'] }}</h5>

                                <div class="mb-4">
                                    @foreach ($q['opsi'] as $opt)
                                        @php
                                            $bgColor = 'bg-white text-dark'; // Default: polos
                                            $icon = '';

                                            // Cek DULU apakah user menjawab soal ini
                                            if ($dijawab) {
                                                if ($opt == $q['kunci']) {
                                                    // Kunci Jawaban
                                                    $bgColor = 'bg-success text-white fw-bold border-success';
                                                    $icon = '<i class="fe fe-check-circle float-end text-white"></i>';
                                                } elseif ($opt == $dijawab && !$isBenar) {
                                                    // Jawaban User yang Salah
                                                    $bgColor =
                                                        'bg-danger text-white text-decoration-line-through border-danger';
                                                    $icon = '<i class="fe fe-x-circle float-end text-white"></i>';
                                                }
                                            }
                                        @endphp
                                        <div class="p-2 border rounded mb-2 {{ $bgColor }}">
                                            {{ $opt }} {!! $icon !!}
                                        </div>
                                    @endforeach
                                </div>

                                <div class="alert alert-info border-0 mb-0">
                                    <h6 class="alert-heading fw-bold"><i class="fe fe-info me-1"></i> Pembahasan:</h6>
                                    <p class="mb-0 small">{{ $q['pembahasan'] }}</p>
                                </div>

                            </div>
                        </div>
                    @endforeach
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
