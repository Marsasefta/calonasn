<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<html lang="en">
  <head>
    @include('partials.head')

    <title>{{ config('app.name', 'CalonASN.id') }}</title>

    @stack('styles')
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
