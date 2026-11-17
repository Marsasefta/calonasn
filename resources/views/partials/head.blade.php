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

<!-- Master Dark Mode Contrast & Inversion Bug Fixes -->
<style>
    /* 1. Global Dark Mode Body & Backgrounds */
    [data-bs-theme="dark"] body,
    [data-bs-theme="dark"] body.bg-white,
    [data-bs-theme="dark"] body.bg-light {
        background-color: #0f172a !important;
        color: #e2e8f0 !important;
    }

    [data-bs-theme="dark"] .hero-section {
        background: linear-gradient(135deg, #0b1324 0%, #0f172a 100%) !important;
    }

    /* 2. Fix Default Navbar on Landing & Blog Pages */
    [data-bs-theme="dark"] nav.navbar.bg-white,
    [data-bs-theme="dark"] nav.navbar {
        background-color: rgba(15, 23, 42, 0.95) !important;
        border-bottom-color: rgba(51, 65, 85, 0.6) !important;
    }

    [data-bs-theme="dark"] .navbar .navbar-brand .text-dark,
    [data-bs-theme="dark"] .navbar .nav-link.text-dark,
    [data-bs-theme="dark"] .navbar .nav-link:not(.active):not(.text-primary) {
        color: #e2e8f0 !important;
    }

    [data-bs-theme="dark"] .navbar .nav-link:hover,
    [data-bs-theme="dark"] .hover-bg-light:hover {
        background-color: rgba(59, 130, 246, 0.15) !important;
        color: #60a5fa !important;
    }

    /* 3. Fix Button Outline Dark */
    [data-bs-theme="dark"] .btn-outline-dark {
        color: #f1f5f9 !important;
        border-color: #475569 !important;
    }

    [data-bs-theme="dark"] .btn-outline-dark:hover {
        background-color: #1e293b !important;
        color: #ffffff !important;
        border-color: #94a3b8 !important;
    }

    /* 4. CRITICAL: Revert Geeks Theme Text-White Bug */
    /* Theme bug set [data-bs-theme=dark] .text-white { color: #0b1324 !important; } which broke all buttons/badges */
    [data-bs-theme="dark"] .text-white,
    [data-bs-theme="dark"] .btn-primary,
    [data-bs-theme="dark"] .btn-primary *,
    [data-bs-theme="dark"] .btn-success,
    [data-bs-theme="dark"] .btn-success *,
    [data-bs-theme="dark"] .btn-danger,
    [data-bs-theme="dark"] .btn-danger *,
    [data-bs-theme="dark"] .badge.bg-primary,
    [data-bs-theme="dark"] .badge.bg-success,
    [data-bs-theme="dark"] .badge.bg-danger,
    [data-bs-theme="dark"] .bg-primary *,
    [data-bs-theme="dark"] .bg-gradient * {
        color: #ffffff !important;
    }

    /* 5. CRITICAL: Yellow / Warning Elements MUST HAVE DARK TEXT (Never White!) */
    [data-bs-theme="dark"] .btn-warning,
    [data-bs-theme="dark"] .btn-warning *,
    [data-bs-theme="dark"] .btn-warning.text-dark,
    [data-bs-theme="dark"] .bg-warning,
    [data-bs-theme="dark"] .bg-warning *,
    [data-bs-theme="dark"] .bg-warning.text-dark,
    [data-bs-theme="dark"] .badge.bg-warning,
    [data-bs-theme="dark"] .badge.bg-warning *,
    [data-bs-theme="dark"] .voucher-badge {
        color: #0f172a !important;
    }

    /* 6. Fix Text-Dark on Normal Dark Surfaces */
    [data-bs-theme="dark"] .text-dark:not(.btn-warning):not(.btn-warning *):not(.bg-warning):not(.bg-warning *):not(.badge.bg-warning):not(.badge.bg-warning *):not(.voucher-badge):not(.badge-pkg-tryout):not(.badge-pkg-tryout *) {
        color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .text-muted {
        color: #94a3b8 !important;
    }

    /* 7. Fix Cards, Boxes & Hardcoded Inline Backgrounds */
    [data-bs-theme="dark"] .card.bg-white,
    [data-bs-theme="dark"] .card:not(.bg-primary):not(.bg-warning):not(.bg-gradient),
    [data-bs-theme="dark"] .table-modern-card,
    [data-bs-theme="dark"] .db-content .card,
    [data-bs-theme="dark"] [style*="background: #ffffff"],
    [data-bs-theme="dark"] [style*="background:#ffffff"] {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #e2e8f0 !important;
    }

    [data-bs-theme="dark"] section[style*="background: #f8fafc"],
    [data-bs-theme="dark"] section[style*="background:#f8fafc"],
    [data-bs-theme="dark"] .bg-light,
    [data-bs-theme="dark"] .bg-light-subtle {
        background-color: #0f172a !important;
        color: #e2e8f0 !important;
    }

    [data-bs-theme="dark"] div[style*="background: #f8fafc"],
    [data-bs-theme="dark"] div[style*="background:#f8fafc"],
    [data-bs-theme="dark"] div[style*="background: #f1f5f9"],
    [data-bs-theme="dark"] div[style*="background:#f1f5f9"] {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #e2e8f0 !important;
    }

    [data-bs-theme="dark"] [style*="background: #f0f7ff"],
    [data-bs-theme="dark"] [style*="background: #eff6ff"],
    [data-bs-theme="dark"] [style*="background: rgba(239, 246, 255"] {
        background-color: rgba(30, 58, 138, 0.25) !important;
        color: #93c5fd !important;
    }

    /* 8. Fix FAQ Accordions in Dark Mode */
    [data-bs-theme="dark"] .accordion-item {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    [data-bs-theme="dark"] .accordion-button {
        background-color: #1e293b !important;
        color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .accordion-button:not(.collapsed) {
        background-color: rgba(37, 99, 235, 0.15) !important;
        color: #60a5fa !important;
    }

    [data-bs-theme="dark"] .accordion-body,
    [data-bs-theme="dark"] .accordion-body * {
        color: #cbd5e1 !important;
    }

    /* 9. Fix Blog Post & TOC in Dark Mode */
    [data-bs-theme="dark"] .blog-post-content,
    [data-bs-theme="dark"] .blog-post-content p,
    [data-bs-theme="dark"] .blog-post-content li {
        color: #cbd5e1 !important;
    }

    [data-bs-theme="dark"] .blog-post-content h2,
    [data-bs-theme="dark"] .blog-post-content h3,
    [data-bs-theme="dark"] .blog-post-content h4 {
        color: #f8fafc !important;
    }

    [data-bs-theme="dark"] #toc-container {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    [data-bs-theme="dark"] #toc-list a {
        color: #94a3b8 !important;
    }

    [data-bs-theme="dark"] #toc-list a:hover {
        background-color: rgba(37, 99, 235, 0.15) !important;
        color: #60a5fa !important;
    }

    /* 10. Fix Tables in Dark Mode */
    [data-bs-theme="dark"] .table {
        color: #e2e8f0 !important;
        border-color: #334155 !important;
    }

    [data-bs-theme="dark"] .table thead th,
    [data-bs-theme="dark"] .table-light {
        background-color: #0f172a !important;
        color: #94a3b8 !important;
        border-color: #334155 !important;
    }

    [data-bs-theme="dark"] .table tbody tr {
        background-color: transparent !important;
        color: #e2e8f0 !important;
    }
</style>

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
