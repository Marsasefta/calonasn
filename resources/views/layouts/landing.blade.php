<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.head')

    @stack('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
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

</head>

<body class="bg-white">
    @include('partials.navbar-default')

    @yield('content')

    @include('partials.footer-default')
    @include('partials.btn-scroll-top')
    @include('partials.scripts')
    @stack('scripts')
</body>

</html>
