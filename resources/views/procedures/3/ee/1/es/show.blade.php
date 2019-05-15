<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ES</title>
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
        <p>3-EE1-ES</p>
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

    <h2>Evaluación de la satisfacción del estudiante con la formación a través del servicio psicológico</h2>

    <div style="width:100%; text-align: right;">
        <p><span style="font-weight:bold">Fecha: </span>{{ $doc->created_at->format('d/m/Y') }}</p>
        <p><span style="font-weight:bold">{{ $doc->program_type }}</span></p>
    </div>
    <div>
        <p><span style="font-weight:bold">Nombre del estudiante: </span>{{ $doc->partaker->full_name }}</p>
    </div>
    <div>
        <table class="table is-bordered" style="width: 100%; table-layout: fixed">
            <tr style="">
                <td style="width:60%;height: 100px;">
                    <p class="has-text-weight-bold">¿Qué tan satisfecho te sientes con...?</p>
                </td>
                <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">Muy satisfecho</p></td>
                <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">Satisfecho</p></td>
                <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">Ni satisfecho <br/> ni insatisfecho</p></td>
                <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">Insatisfecho</p></td>
                <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">Muy insatisfecho</p></td>
                <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">No aplica</p></td>
            </tr>
            <tr>
                <td style="width:60%">
                    <p>1. La supervisión que recibiste para adquirir competencias en relación con:</p>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @foreach ($questions as $key => $text)
            <tr>
                <td style="width:60%">
                    <p>{{ $text }}</p>
                </td>
                @for ($i = 0; $i < 6; $i++)
                <td>
                    {{-- <input name="{{ $key }}" value="{{ $i }}" type="radio" disabled> --}}
                    <input type="radio" {{ $doc[$key] == $i ? 'checked' : '' }}>
                </td>
                @endfor
            </tr>
            @endforeach
        </table>
    </div>
    <div>
        <br/>
        <p><span style="font-weight:bold">Comentarios: </span>{{ $doc->comments }}</p>
    </div>
</body>
</html>