<!DOCTYPE html>
<html>
<head>
    <style>
    @page {
        margin: 12.7mm;
    }
    /* @font-face {
        font-family: "font";
        src: url({{ storage_path('fonts\GOTHIC.TTF') }}) format("truetype");
    }
    @font-face {
        font-family: "fontB";
        src: url({{ storage_path('fonts\GOTHICB.TTF') }}) format("truetype");
    } */
    body {
        /* font-family: "font";
        font-size: 9pt; */
    }
    .my-blue { color: rgb(104, 178, 255); }
    footer {
        position: fixed; 
        bottom: -12.7mm; 
        left: 0px; 
        right: 0px;
        height: 50px;
        text-align: center;
    }
    .unam {
        position: absolute;
    }
    .psico {
        position: absolute;
        top:0;
        right: 17mm;
    }
    .header p {
        margin:0;
    }
    table {
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }
    .left {
        width:30%;
    }
    .p-left {
        /* font-family:fontB; */
        text-align:center;
    }
    .centrado {
    text-align:center;
    }
    .aintlyin {
    display:inline-block;
    vertical-align:top;
    width: 45%;
    border: 1px solid black;
    }
    </style>
</head>
<body>
    <footer class="my-blue">
        <p style="margin:0">ESTE DOCUMENTO FORMA PARTE DEL SISTEMA DE GESTIÓN DE CALIDAD</p>
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
    {{-- <div class="header">
        <img class="unam" src="{{ asset('img/unam.jpg') }}">
        <div class="block" style="text-align: center;">
            <p style="font-size:12pt;">Coordinación de Centros de Formación y Servicios Psicológicos</p>
            <p style="font-size:9pt;">COMPROBANTE DE REGISTRO A PROGRAMA</p>
        </div>
        <img class="psico" src="{{ asset('img/psi.jpg') }}">
    </div> --}}
    @component('pdf.header')
        <p style="font-size:12pt;">COMPROBANTE DE REGISTRO A PROGRAMA</p>
    @endcomponent
    <div>
        <br>
        <br>
        <p>Estimado(a) alumno(a) {{ Auth::user()->partaker->full_name }}</p>
        <p style="font-weight: bold">PRESENTE</p>
    </div>
    <div>
        <p>Su incripción ha sido exitosa.</p>
        <p>A continuación encontrarás la información en relación a la sede en la que deberás de presentarte:</p>
    </div>
    <div style="border: 1px solid black; padding: 25px">
        <p style="font-style: italic">Nombre de la práctica:</p> 
        <p style="font-weight: bold;">{{ $programPartaker->program->programa }}</p>
        <p><span style="font-style: italic">Sede:</span> {{ $programPartaker->program->center->nombre }}</p>
        <p><span style="font-style: italic">Dirección:</span> {{ $programPartaker->program->center->direccion }}</p>
        <p><span style="font-style: italic">Supervisor:</span> {{ $programPartaker->program->supervisor->full_name }}</p>
        @if ($programPartaker->program->car_ser->fecha_inicio)
        <p><span style="font-style: italic">Fecha de inicio:</span> {{ $programPartaker->program->car_ser->fecha_inicio->formatLocalized('%d de %B %Y') }}</p>
        @endif
        @if ($programPartaker->program->car_ser->fecha_fin)
        <p><span style="font-style: italic">Fecha de finalización:</span> {{ $programPartaker->program->car_ser->fecha_fin->formatLocalized('%d de %B %Y') }}</p>
        @endif
    </div>
    <div>
        <br>
        <br>
        <br>
        <p style="font-weight: bold">ATENTAMENTE</p>
        <p>Coordinación de Centros de Formación y Servicios Psicológicos</p>
    </div>
</body>
</html>