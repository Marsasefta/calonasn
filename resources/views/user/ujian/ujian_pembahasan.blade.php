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
                    @foreach ($questions as $index => $q)
                        @php
                            $nomor = $index + 1;
                            $dijawab = $jawabanUser[$q->id] ?? null;

                            // Menentukan apakah soal ini kategori TKP
                            $isTkp = str_contains(strtoupper($q->category->name), 'TKP');

                            // Mencari Kunci Jawaban (Opsi dengan poin tertinggi, max 5)
                            $kunci = $q->options->sortByDesc('point')->first();

                            // Logika Benar/Salah untuk TWK & TIU
                            $isBenar = $dijawab == $kunci->id;

                            // Mencari poin yang didapat user (Khusus TKP)
                            $poinUser = 0;
                            if ($dijawab) {
                                $poinUser = $q->options->where('id', $dijawab)->first()->point ?? 0;
                            }
                        @endphp

                        <div
                            class="card shadow-sm mb-4 border-0 {{ $dijawab ? ($isTkp ? 'border-start border-primary border-4' : ($isBenar ? 'border-start border-success border-4' : 'border-start border-danger border-4')) : 'border-start border-secondary border-4' }}">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="badge bg-primary me-2">{{ $q->category->name }}</span>
                                        <span class="fw-bold">Soal Ke-{{ $nomor }}</span>
                                    </div>
                                    <div>
                                        @if (!$dijawab)
                                            <span class="badge bg-secondary">Tidak Dijawab</span>
                                        @elseif($isTkp)
                                            <span class="badge bg-primary">Skor: {{ $poinUser }} Poin</span>
                                        @elseif($isBenar)
                                            <span class="badge bg-success"><i class="fe fe-check"></i> Benar</span>
                                        @else
                                            <span class="badge bg-danger"><i class="fe fe-x"></i> Salah</span>
                                        @endif
                                    </div>
                                </div>

                                <h5 class="lh-base mb-3">{{ $q->question_text }}</h5>

                                <div class="mb-4">
                                    @foreach ($q->options as $optIndex => $opt)
                                        @php
                                            $bgColor = 'bg-white text-dark';
                                            $icon = '';
                                            $poinLabel = '';

                                            if ($isTkp) {
                                                // LOGIKA TAMPILAN TKP (Tampilkan semua poin)
                                                $poinLabel =
                                                    '<span class="badge bg-light text-dark border ms-2 float-end">Poin: ' .
                                                    $opt->point .
                                                    '</span>';

                                                if ($opt->id == $dijawab) {
                                                    $bgColor = 'bg-primary-soft text-primary fw-bold border-primary';
                                                    $icon =
                                                        '<i class="fe fe-check-circle float-end text-primary me-2 mt-1"></i>';
                                                }
                                            } else {
                                                // LOGIKA TAMPILAN TWK & TIU
                                                if ($opt->id == $kunci->id) {
                                                    // Kunci Jawaban (Warna Hijau)
                                                    $bgColor = 'bg-success text-white fw-bold border-success';
                                                    $icon =
                                                        '<i class="fe fe-check-circle float-end text-white mt-1"></i>';
                                                } elseif ($opt->id == $dijawab && !$isBenar) {
                                                    // Jawaban User yang Salah (Warna Merah Dicoret)
                                                    $bgColor =
                                                        'bg-danger text-white text-decoration-line-through border-danger';
                                                    $icon = '<i class="fe fe-x-circle float-end text-white mt-1"></i>';
                                                }
                                            }
                                        @endphp

                                        <div class="p-2 border rounded mb-2 {{ $bgColor }}">
                                            {{ chr(65 + $optIndex) }}. {{ $opt->option_text }}
                                            {!! $poinLabel !!}
                                            {!! $icon !!}
                                        </div>
                                    @endforeach
                                </div>

                                <div class="alert alert-info border-0 mb-0">
                                    <h6 class="alert-heading fw-bold"><i class="fe fe-info me-1"></i> Pembahasan:</h6>
                                    <p class="mb-0 small">
                                        {{ $q->discussion ?? 'Belum ada pembahasan untuk soal ini.' }}
                                    </p>
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
