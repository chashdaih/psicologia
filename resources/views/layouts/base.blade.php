<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema servicios psicológicos</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon-16x16.png') }}">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" href="{{asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{ url(mix('/css/app.css')) }}">
</head>
<body>

    <div id="app" style="min-height: 100vh; display: flex; flex-direction: column;">
        @auth
        @include('layouts.nav')
        @endauth
        @yield('content')
    </div>

    <script src="{{ url(mix('/js/manifest.js')) }}"></script>
    <script src="{{ url(mix('/js/vendor.js')) }}"></script>
    <script src="{{ url(mix('/js/app.js')) }}"></script>
    
</body>
</html>