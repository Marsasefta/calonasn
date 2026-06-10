<title>@yield('title', 'Simulasi CAT CPNS 2026 Terakurat & Terbaru | CalonASN.id')</title>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<meta name="robots" content="index, follow">
<meta name="author" content="CalonASN.id">
<link rel="canonical" href="{{ url()->current() }}">

<!-- LOGIKA PINTAR LARAVEL UNTUK MENCEGAH DOBEL -->
@hasSection('meta_tags')
    {{-- Jika ini halaman artikel, ambil SEO dari artikel --}}
    @yield('meta_tags')
@else
    {{-- Jika ini homepage/halaman lain, gunakan SEO default ini --}}
    <meta name="description" content="Simulasi CAT CPNS 2026 terakurat standar BKN. Sedia paket tryout online SKD (TWK, TIU, TKP) dengan soal HOTS terbaru & pembahasan cepat. Coba demo gratis!">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Simulasi CAT CPNS 2026 Terakurat & Terbaru | CalonASN.id">
    <meta property="og:description"
        content="Simulasi CAT CPNS 2026 terakurat standar BKN. Sedia paket tryout online SKD (TWK, TIU, TKP) dengan soal HOTS terbaru & pembahasan cepat. Coba demo gratis!">
    <meta property="og:image" content="{{ asset('image/og-image.jpg') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Simulasi CAT CPNS 2026 Terakurat & Terbaru | CalonASN.id">
    <meta name="twitter:description"
        content="Simulasi CAT CPNS 2026 terakurat standar BKN. Sedia paket tryout online SKD (TWK, TIU, TKP) dengan soal HOTS terbaru & pembahasan cepat. Coba demo gratis!">
    <meta name="twitter:image" content="{{ asset('image/og-image.jpg') }}">
@endif

<!-- Favicon untuk Mesin Pencari Google & Browser -->
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('image/logoasn-96.png') }}">

<!-- Favicon cadangan ukuran lebih kecil -->
<link rel="icon" type="image/png" sizes="48x48" href="{{ asset('image/logoasn-48.png') }}">

<!-- Icon khusus untuk iOS -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/logoasn-apple.png') }}">

<!-- darkmode js -->
<script src="/build/assets/js/vendors/darkMode.js"></script>

<!-- Libs CSS -->
<link href="/build/assets/fonts/feather/feather.css" rel="stylesheet" />

<!-- Vendor Min CSS -->
<link href="/build/assets/css/vendors.min.css" rel="stylesheet" />

<!-- Theme CSS -->
<link href="/build/assets/css/theme.min.css" rel="stylesheet" />

 <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1537295501099660');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1537295501099660&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
