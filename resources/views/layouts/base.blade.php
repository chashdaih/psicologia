<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agenda</title>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <div id="app">
        @include('layouts.nav')
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    
</body>
</html>