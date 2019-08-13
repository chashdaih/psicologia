<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@if(isset($full_code)){{$full_code}}@endif</title>
    <style>
        @page {
            margin: 100px 50px;
        }
        @font-face {
            font-family: Arial, Helvetica, sans-serif;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
        }
        img {
            height: 50pt;
            width: auto;
            display: inline;
            margin:0;
        }
        .my-blue { color: rgb(104, 178, 255); }
        footer {
            position: fixed; 
            bottom: -100px; 
            left: 0px; 
            right: 0px;
            height: 50px;
        }
        footer p {
            font-size: 0.8em;
        }
        p {
            margin: 0
        }
        .nav-title {
            float: right;
            width: 50%;
            font-size: 20px;
        }
        .bordered-table {
            border-collapse: collapse;
            border: 1px solid black;
        }
        .bordered-table  td {
            border: 1px solid black;
        }
        .bordered-table  th {
            border: 1px solid black;
        }
        .bordered-table tr {
            text-align: center;
        }

    </style>
</head>
<body>
    <header>
        <img src="{{ asset('img/logo_unam.jpg') }}">
        <img src="{{ asset('img/logo_psi.jpg') }}">
        <img src="{{ asset('img/sllanta.png') }}">
        <p class="nav-title my-blue">Coordinación de Centros de Formación y Servicios Psicológicos</p>
    </header>

    <footer class="my-blue">
        <p>ESTE DOCUMENTO FORMA PARTE DEL SISTEMA DE GESTIÓN DE CALIDAD</p>
        @if(isset($full_code))<p>{{$full_code}}</p>@endif
    </footer>
    <script type="text/php">
        if (isset($pdf)) {
            $text = "{PAGE_NUM} / {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) ;
            $y = $pdf->get_height() - 35;
            $color = array(0.4, 0.7, 1);
            $pdf->page_text($x, $y, $text, $font, $size, $color);
        }
    </script>
    
    @yield('content')


</body>
</html>