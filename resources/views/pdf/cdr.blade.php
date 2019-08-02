<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PDF test</title>
    <style>
        @page {
            margin: 100px 25px;
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
            bottom: -60px; 
            left: 0px; 
            right: 0px;
            height: 50px; 
        }
        p {
            margin: 0
        }
        .nav-title {
            float: right;
            width: 50%;
            font-size: 20px;
        }
        /* Specific style */
        
        table {
        margin: 15px 0;
        /* border: 1px solid black; */
        table-layout: fixed;
        width: 100%; /* must have this set */
        }
        td:not(:first-child) {
        /* border: 1px solid black; */
            text-align: center;
        }
        .sturdy td:nth-child(1) {
        width: 50%;
        } 
        .bool td:nth-child(1) {
        width: 80%;
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
        <p>3-FE3-CDR</p>
    </footer>
    {{-- Page count / total, centered at bottom of page --}}
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

    <div class="main">
        <h2 style="text-align: center;">CUESTIONARIO DE DETECCIÓN DE RIESGOS EN LA SALUD FÍSICA Y MENTAL</h2>
        {{-- @for ($s = 0; $s < count($sections); $s++)
        <h3>{{ $sections[$s]['title'] }}</h3>
        <table class="sturdy">
            <tr>
                <td><i>{{ $sections[$s]['time'] }}</i></td>
                @for ($i = 0; $i < 11; $i++)
                <td>{{ $i }}</td>
                @endfor
            </tr>
            @for ($q = 0; $q < count($sections[$s]['questions']); $q++)
            <tr>
                <td >{{ $sections[$s]['questions'][$q] }}</td>
                @for ($i = 0; $i < 11; $i++)
                <td>
                    <input type="radio" {{ $cdr[$sections[$s]['code'].$q] == $i ? 'checked' : '' }}>
                </td>
                @endfor
            </tr>
            @endfor
        </table>
        @endfor --}}
        {{-- <h3>SUS</h3>
        @for ($i = 0; $i < count($sus['sections']); $i++)
        <h4>{{ $sus['sections'][$i]['title'] }}</h4>
        <table class="bool">
            @for ($j = 0; $j < count($sus['fields']); $j++)
            <tr>
                <td>{{ $sus['fields'][$j] }}</td>
                <td>{{ $sus['5opt'][0] }}</td>
                <td>{{ $sus[$sus['sections'][$i]['type']][$cdr[$sus['sections'][$i]['code'].$j]] }}</td>
            </tr>
            @endfor
        </table>
        <p>{{ $sus['sections'][$i]['obs'] }}</p>
        @endfor --}}

    </div>
</body>
</html>