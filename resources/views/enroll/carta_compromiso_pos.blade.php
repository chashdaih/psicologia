@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <br>
    <h2 style="text-align:center;">CARTA COMPROMISO DEL ESTUDIANTE DE POSGRADO</h2>
    <div>
        <br>
        <p>Por este medio, yo {{ Auth::user()->partaker->full_name }}, con número de cuenta {{ Auth::user()->partaker->num_cuenta }}, con conocimiento de cada uno de los lineamientos obtenidos a través del plan de estudios que a continuación se señalan y que conforman el reglamento institucional para todos y cada uno de los programas de residencia que se llevan a cabo en colaboración académica con demás instituciones, por medio de la presente me comprometo a cumplir y mostrar apego profesional y ético a cada uno de los lineamientos.</p>
        <br>
        <p>Como estudiante de posgrado tengo derecho a: </p>
        <ol>
            <li>Desarrollar las competencias de acuerdo con el plan de estudios correspondiente al programa de la Maestría o Doctorado en el que me encuentro inscrito.</li>
            <li>Recibir supervisión en mi entrenamiento de estudiante.</li> 
            <li>Recibir un trato digno, humano y sin discriminación. </li>
        </ol>
        <br>
        <p>Me comprometo como parte de mis obligaciones a cumplir con lo que se señalan a continuación:</p>
        <ol>
            <li>Respetar la hora de entrada y la hora de salida de cada Centro/Programa.</li>
            <li>En aquellas instituciones donde sea requerido, usar bata blanca en condiciones de higiene, durante toda la estancia en la institución.</li>
            <li>Proporcionar servicio psicológico a las personas asignadas por la Institución asistiendo puntualmente, preparando cada sesión con anticipación y manteniendo el expediente clínico al día, con las acotaciones pertinentes a los lineamientos clínicos de cada Institución y llevar trabajo conjunto con los psicólogos y otros profesionales de la Institución para el servicio profesional con las personas atendidas de terapia individual y grupal. </li>
            <li>Modular el tono de voz para evitar interrumpir el trabajo de otros profesionistas. </li>
            <li>Trabajar con apego a los lineamientos de la estructura de los programas académicos y de investigación con titularidad en la UNAM, al impartir la intervención a la persona atendida en la misma UNAM o en instituciones externas.  </li>
            <li>Respetar los reglamentos internos de cada Institución.</li>
            <li>Mantener contacto estrictamente profesional con las personas atendidas y no proporcionar teléfonos privados a las personas atendidas en sedes externas.</li>
            <li>Regirme en todo momento por el Código Ético del Psicólogo, iniciando por el principio de confidencialidad, por lo que no proporcionaré información con respecto a las actividades realizadas a las personas atendidas a cualquier ajeno a la Institución.</li>
            <li>Dirigirme con respeto y ética profesional a todo el personal de la Institución, evitar comentarios negativos sobre compañeros estudiantes de posgrado y de otros profesionales de la institución y cuidar las instalaciones de las éstas. </li>
            <li>Consultaré al supervisor académico e in situ antes de tomar cualquier decisión profesional.</li>
            <li>Relacionarme de forma estrictamente profesional con las personas atendidas.</li>
        </ol>
    </div>
    <div style="text-align: center">
        <p style="font-weight: bold">Contingencias al estudiante por incumplimiento de los lineamientos del reglamento</p>
    </div>
    <div>
        <p>Acercamiento personal con los usuarios (relación no profesional o contacto personal, fuera de la institución con cualquier usuario) implican baja definitiva de la institución (con evidencia del reporte del usuario y/o familiar).<br>Incumplimiento de alguno de los puntos anteriores implicará llamada de atención, a las tres llamadas de atención se hará acreedor a una sanción y a las dos sanciones se dará de baja de la institución.</p>
        <br>
        <p>Estas sanciones tendrán impacto en la calificación del módulo de entrenamiento en el programa de supervisor académico que se encuentre a cargo, correspondiendo la llamada de atención a un punto menos (sobre la calificación final), la sanción a tres puntos menos y la baja definitiva a la institución a NA.</p>
        <br>
        <p>Adicionalmente y en conocimiento de las contingencias que se establecieron por incumplimiento de los lineamientos señalados con anterioridad, acepto su aplicación en caso de incurrir en su falta.</p>
        <br>
    </div>
    <div style="text-align: center; font-weight: bold">
        <p>ATENTAMENTE</p>
        <p>"POR MI RAZA, HABLARÁ EL ESPÍRITU"</p>
        <p>CIUDAD UNIVERSITARIA A {{ strtoupper (\Carbon\Carbon::now()->formatLocalized('%d de %B %Y')) }}</p>
        <p>VO. BO.</p>
    </div>
    <div style="text-align: center; font-weight: bold">
        <br>
        <p style="font-weight: bold">_______________________________</p>
        <p style="font-weight: bold">NOMBRE Y FIRMA DEL ESTUDIANTE</p>
    </div>
</section>
@endsection