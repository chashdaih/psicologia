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

            $doc_full_code = "3-IE2-CCEP";
            $pdf->page_text(40, $y, $doc_full_code, $font, $size, $color);
        }
    </script>
    {{-- <div class="header">
        <img class="unam" src="{{ asset('img/unam.jpg') }}">
        <div class="block" style="text-align: center;">
            <p style="font-size:12pt;">Coordinación de Centros de Formación y Servicios Psicológicos</p>
            <p style="font-size:9pt;">CARTA COMPROMISO DEL ESTUDIANTE DE PREGRADO</p>
        </div>
        <img class="psico" src="{{ asset('img/psi.jpg') }}">
    </div> --}}
    @component('pdf.header')
    <p style="font-size:12pt;">CARTA COMPROMISO DEL ESTUDIANTE DE PREGRADO</p>
    @endcomponent
    <div style="line-height: 1.5">
        <br>
        <p>Por este medio, yo {{ Auth::user()->partaker->full_name }}, con número de cuenta {{ Auth::user()->partaker->num_cuenta }}, manifiesto mi compromiso con
        la <span style="font-weight: bold">Coordinación de Centros de Formación y Servicios Psicológicos</span> y con el programa 
        <span style="font-weight: bold">{{ $program->programa }}</span>
        para realizar práctica supervisada en la sede <span style="font-weight: bold">{{ $program->center->nombre }}</span> 
        los {{ $program->car_ser->days() }}, dentro del período del {{ $program->car_ser->fecha_inicio ? $program->car_ser->fecha_inicio->formatLocalized('%d de %B %Y') : '' }} al {{ $program->car_ser->fecha_fin ? $program->car_ser->fecha_fin->formatLocalized('%d de %B %Y') : '' }}.</p>
        <p>Entiendo que como estudiante de licenciatura estaré participando en la Institución en los horarios acordados con mi supervisor académico.</p>
        <p>Como estudiante tengo <span style="text-decoration: underline">derecho</span> a:</p>
        <ol>
            <li>Desarrollar los protocolos de investigación afines a las actividades del programa.</li>
            <li>Recibir asesoría en mi desempeño dentro del programa.</li>
            <li>Recibir un trato digno y sin discriminación.</li>
        </ol>
        <p>Manifiesto mi conformidad y acuerdo en cumplir con los siguientes requisitos y lineamientos:</p>
        <ul>
            <li>Asistir puntualmente de acuerdo a los horarios establecidos. En caso de impuntualidad eventual, 
                será decisión del supervisor, establecer las consecuencias naturales correspondientes a dicha falta 
                (por ejemplo, no poder incorporarse a las actividades). En caso de impuntualidad reiterada (3 sesiones), 
                las prácticas se darán de baja de las actividades.</li>
            <li>Entregar copia de mi carnet actualizado, que da evidencia de mi seguro médico facultativo.</li>
            <li>Portar identificación dentro del Centro.</li>
            <li>Cumplir con la obligación de hacer uso adecuado de las instalaciones, equipo y mobiliario. En caso de cualquier desperfecto, me comprometo a apoyar en la reparación. Mi participación en delitos implicará el cese de actividades (por ejemplo: conducta violenta, robo, etc.).</li>
            <li>Cumplir el reglamento institucional, así como dirigirme con respeto a compañeros y autoridades durante las prácticas.</li>
            <li>Comprometerme a realizar las actividades académicas planeadas por mi supervisor in situ, en tiempo y forma.</li>
            <li>Cumplir el periodo de prácticas acordado, sin reducirlo o excederlo.</li>
            <li>Tengo estrictamente prohibido sacar material o expedientes de los Centros, así como cualquier dato relacionado con los mismos.</li>
            <li>Participar en la supervisión de mis actividades en la sede.</li>
            <li>Regirme en todo momento por el Código de Ética del Psicólogo, iniciando por el principio de confidencialidad, por lo que se prohíbe proporcionar información con respecto a las actividades realizadas y los usuarios a cualquier persona ajena a la institución.</li>
            <li>Al término de las prácticas, se me proporcionará la constancia correspondiente a las prácticas, firmada por el supervisor in situ y la Coordinación de Centros de Formación y Servicios Psicológicos.</li>
            <li>Tengo prohibido recibir regalos o remuneraciones económicas por parte de los usuarios, por las actividades realizadas.</li>
            <li>Tengo estrictamente prohibido el acercamiento personal con los usuarios (relación no profesional o contacto personal, fuera de la institución con cualquier usuario), de lo contrario implica baja definitiva del programa (con evidencia del reporte del usuario y/o familiar).</li>
            <li>Tengo estrictamente prohibido proporcionar a los usuarios información relacionada con el Centro o Institución, el personal de la institución o los compañeros de práctica.</li>
            <li>Cualquier inconformidad o problema con los usuarios lo deberé notificar por escrito al supervisor in situ y a la Coordinación de Centros de Formación y Servicios Psicológicos</li>
            <li>Manifiesto el acuerdo. Sé que con esta colaboración no establezco ninguna relación laboral ni con la Facultad de Psicología ni con la UNAM ni con la institución en donde realice prácticas en este momento o en el futuro.</li>
        </ul>
        <p>Incumplimiento de alguno de los puntos anteriores implicará llamado de atención, a las tres llamadas de atención se hará acreedor a una sanción y a las dos sanciones se dará de baja del Centro/Programa.</p>
        <p>Adicionalmente y en conocimiento de las contingencias que se establecieron por incumplimiento de los lineamientos señalados con anterioridad, acepto su aplicación en caso de incurrir en su falta.</p>
        <div style="text-align: center">
            <p style="font-weight: bold">ATENTAMENTE</p>
            <p style="font-weight: bold">"POR MI RAZA, HABLARÁ EL ESPÍRITU"</p>
            <p style="font-weight: bold">CIUDAD UNIVERSITARIA A {{ strtoupper (\Carbon\Carbon::now()->formatLocalized('%d de %B %Y')) }}</p>
            <p style="font-weight: bold">VO.BO.</p>
        </div>
        <div style="text-align: center">
            <p style="font-weight: bold">_______________________________</p>
            <p style="font-weight: bold">NOMBRE Y FIRMA DEL ESTUDIANTE</p>
        </div> 
    </div>
</body>
</html>