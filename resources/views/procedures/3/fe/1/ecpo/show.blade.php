<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ECPO</title>
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
        <p>3-FE1-ECPO_V4</p>
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

    <h2 style="text-align: center;">Evaluación de competencias del estudiante de posgrado</h2>

    <div style="width:100%; text-align: right;">
        <p><span style="font-weight:bold">Registrado el : </span>{{ $doc->created_at->format('d/m/Y') }}</p>
        <p><span style="font-weight:bold">Número de cuenta del estudiante: </span>{{ $partaker->num_cuenta }}</p>
        <br>
    </div>
    <div>
        <p><span style="font-weight:bold">Nombre del estudiante: </span>{{ $partaker->full_name }}</p>
        <p><span style="font-weight:bold">Fase de evaluación: </span>{{ $doc->evaluation_phase }}</p>
        <p><span style="font-weight:bold">Registrado por: </span>{{ $doc->user->type == 3 ? $doc->user->partaker->full_name : $doc->user->supervisor->full_name }}</p>
        <br>
    </div>
    <div>
        @foreach ($sections as $index => $section)
        <p style="font-weight:bold">{{ $section['title'] }}</p>
        <table class="table is-hoverable is-bordered is-striped" style="width: 100%; table-layout: fixed">
            @foreach ($section['questions'] as $key => $question)
            <tr>
                <td style="width:80%">{{ $question }}</td>
                {{-- @for ($i = 0; $i < 7; $i++)
                <td>
                    <input type="radio" {{ $doc['q'.($index + 1).($key + 1)] == $i ? 'checked' : '' }}>
                </td>
                @endfor --}}
                <td>
                    @if ($doc['q'.($index + 1).($key + 1)])
                    {{$doc['q'.($index + 1).($key + 1)]}}
                    @else
                        N/A
                    @endif
                </td>
            </tr>    
            @endforeach
        </table>
        <br>
        @endforeach
    </div>
</body>
</html>