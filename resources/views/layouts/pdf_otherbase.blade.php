<!DOCTYPE html>
<html>
<head>
    <style>
    @page {
        margin: 12.7mm;
    }
    @font-face {
        font-family: "font";
        src: url({{ storage_path('fonts\GOTHIC.TTF') }}) format("truetype");
    }
    @font-face {
        font-family: "fontB";
        src: url({{ storage_path('fonts\GOTHICB.TTF') }}) format("truetype");
    }
    body {
        font-family: "font";
        font-size: 9pt;
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
    /* .unam {
        position: absolute;
    }
    .psico {
        position: absolute;
        top:0;
        right: 17mm;
    }
    .header p {
        margin:0;
    } */
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
        font-family:fontB;text-align:center;
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

            $doc_full_code = "2-IE1-RPS";
            $pdf->page_text(40, $y, $doc_full_code, $font, $size, $color);
        }
    </script>
    @component('pdf.header')
    REGISTRO DE PROGRAMAS DE SERVICIOS PSICOLÓGICOS A TRAVÉS DE LA FORMACIÓN SUPERVISADA
    @endcomponent
    <div>
        <p style="font-size:10pt;">Los Programas de Servicios Psicológicos a través de la Formación Supervisada
             permiten que estudiantes de los semestres intermedios de la Carrera (5° a 8º) y estudiantes de posgrado
              inicien un ejercicio profesional en escenarios reales, bajo la supervisión académica e in situ del supervisor
               y del Escenario, respectivamente. La supervisón es fundamental para la adquisición de competencias profesionales del estudiante.
               <br/>
        </p>
    </div>
    <div>
        <p style="background-color:#96B804;font-family:fontB;text-align: center;">PROGRAMA</p>
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <td class="left" ><p class="p-left">NOMBRE DEL PROGRAMA</p></td>
                <td class="right"><p>{{ $doc->programa }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">CENTRO AL CUAL PERTENECE EL PROGRAMA</p></td>
                <td class="right"><p>{{ $doc->center->full_name }}</p></td>
            </tr>
            @foreach ($extraCenters as $extraCenter)
            <tr>
                <td class="left"><p class="p-left">CENTRO ADICIONAL</p></td>
                <td class="right"><p>{{ $extraCenter->center->nombre }}</p></td>
            </tr>
            @endforeach
            <tr>
                <td class="left"><p class="p-left">DIRECCIÓN DEL ESCENARIO</p></td>
                <td class="right"><p>{{ $doc->center->direccion }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">TIPO DE PROGRAMA</p></td>
                <td class="right"><p>{{ $doc->tipo }}</p></td>
            </tr>
        </table>
    </div>
    <div>
        <p style="background-color:#96B804;font-family:fontB;text-align: center;">DATOS DEL SUPERVISOR ACADÉMICO</p>
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <td class="left" ><p class="p-left">NOMBRE</p></td>
                <td class="right"><p>{{ $doc->supervisor->full_name }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">ADSCRIPCIÓN</p></td>
                <td class="right"><p>{{ $doc->supervisor->coordinacion }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">NOMBRAMIENTO</p></td>
                <td class="right"><p>{{ $doc->supervisor->nombramiento }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">CORREO</p></td>
                <td class="right"><p>{{ $doc->supervisor->correo }}</p></td>
            </tr>
        </table>
        {{-- <table style="width: 100%; table-layout: fixed">
            <tr>
                <td ><p style="text-align:center;"><span style="font-family:fontB;">Teléfono: </span>{{ $doc->supervisor->telefono }}</p></td>
                <td ><p style="text-align:center;"><span style="font-family:fontB;">Celular: </span>{{ $doc->supervisor->celular }}</p></td>
                <td ><p style="text-align:center;"><span style="font-family:fontB;">e-mail: </span>{{ $doc->supervisor->correo }}</p></td>
            </tr>
        </table> --}}
        {{-- <table style="width: 100%; table-layout: fixed">
            <tr>
                <td class="left" ><p class="p-left">Número de trabajador: </p></td>
                <td class="right"><p>{{ $doc->supervisor->num_trabajador }}</p></td>
            </tr>
        </table> --}}
    </div>
    <div>
        <p style="background-color:#96B804;font-family:fontB;text-align: center;">DATOS @if(count($supsInSitu) < 2) DEL SUPERVISOR @else DE LOS SUPERVISORES @endif IN SITU</p>
        @foreach ($supsInSitu as $supInSitu)
        @if ($supInSitu->full_name)
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <td class="left" ><p class="p-left">NOMBRE</p></td>
                <td class="right"><p>{{ $supInSitu->full_name }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">ADSCRIPCIÓN</p></td>
                <td class="right"><p>{{ $supInSitu->ascription }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">NOMBRAMIENTO</p></td>
                <td class="right"><p>{{ $supInSitu->nomination }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">CORREO</p></td>
                <td class="right"><p>{{ $supInSitu->email }}</p></td>
            </tr>
        </table>
        <br>
        @else {{-- ELSE --}}
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <td class="left" ><p class="p-left">NOMBRE</p></td>
                <td class="right"><p>{{ $supInSitu->supervisor->full_name }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">ADSCRIPCIÓN</p></td>
                <td class="right"><p>{{ $supInSitu->supervisor->coordinacion }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">NOMBRAMIENTO</p></td>
                <td class="right"><p>{{ $supInSitu->supervisor->nombramiento }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">CORREO</p></td>
                <td class="right"><p>{{ $supInSitu->supervisor->correo }}</p></td>
            </tr>
        </table>
        <br>
        @endif
        @endforeach
    </div>
    <div>
        <p style="background-color:#96B804;font-family:fontB;text-align: center;">CARACTERISTICAS DEL PROGRAMA</p>
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <td class="left" ><p class="p-left">RESUMEN</p></td>
                <td class="right"><p>{!! nl2br(e($datos->resumen)) !!}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">JUSTIFICACION</p></td>
                <td class="right"><p>{!! nl2br(e($datos->justificacion)) !!}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">OBJETIVO GENERAL</p></td>
                <td class="right"><p>{!! nl2br(e($datos->objetivo_g)) !!}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">OBJETIVOS ESPECÍFICOS</p></td>
                <td class="right"><p>{!! nl2br(e($datos->objetivo_es)) !!}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">EL PROGRAMA VA DIRIGIDO A</p></td>
                <td class="right"><p>{{ $car->pre_pos }}</p></td>
            </tr>
            @if ($car->pre)
            <tr>
                <td class="left"><p class="p-left">SEMESTRE AL QUE VA DIRIGIDO</p></td>
                <td class="right"><p>{{ $car->pre }}</p></td>
            </tr>
            @endif
            @if($car->pos)
            <tr>
                <td class="left"><p class="p-left">GRADO AL QUE VA DIRIGIDO</p></td>
                <td class="right"><p>{{ $car->pos }}</p></td>
            </tr>
            @endif
            <tr>
                <td class="left"><p class="p-left">FECHA DE INICIO</p></td>
                <td class="right"><p>{{ $car->fecha_inicio ? $car->fecha_inicio->formatLocalized('%d de %B %Y') : '' }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">FECHA DE TÉRMINO</p></td>
                <td class="right"><p>{{ $car->fecha_fin ? $car->fecha_fin->formatLocalized('%d de %B %Y') : '' }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">REQUISITOS DE INGRESO AL PROGRAMA</p></td>
                <td class="right"><p>{!! nl2br(e($datos->requisitos)) !!}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">ASIGNATURAS ACADÉMICAS DEL PLAN CURRICULAR 2008 CON LAS CUALES EMPATA EL PROGRAMA</p></td>
                <td class="right"><p>{!! nl2br(e($datos->asig_emp)) !!}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">NO. MÁXIMO DE ALUMNOS</p></td>
                <td class="right"><p>{{ $doc->cupo }}</p></td>
            </tr>
        </table>
    </div>
    <div>
        <p style="background-color:#96B804;font-family:fontB;text-align: center;">CARACTERISTICAS DEL SERVICIO</p>
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <td class="left">
                    <p class="p-left">HORARIO GENERAL DEL PROGRAMA</p>
                    <p>Horario en el que los alumnos asisten</p>
                </td>
                <td>
                    <p class="p-left">No. de horas: {{ $car->gen_horas_total }}</p>
                    @if ($car->gen_l)
                    <p class="p-left">Lunes, <span style="font-family: font;">{{ $car->gen_hora_l }}</span></p>
                    @endif
                    @if ($car->gen_ma)
                    <p class="p-left">Martes, <span style="font-family: font;">{{ $car->gen_hora_ma }}</span></p>
                    @endif
                    @if ($car->gen_mi)
                    <p class="p-left">Miercoles, <span style="font-family: font;">{{ $car->gen_hora_mi }}</span></p>
                    @endif
                    @if ($car->gen_j)
                    <p class="p-left">Jueves, <span style="font-family: font;">{{ $car->gen_hora_j }}</span></p>
                    @endif
                    @if ($car->gen_v)
                    <p class="p-left">Viernes, <span style="font-family: font;">{{ $car->gen_hora_v }}</span></p>
                    @endif
                    @if ($car->gen_s)
                    <p class="p-left">Sábado, <span style="font-family: font;">{{ $car->gen_hora_s }}</span></p>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="left">
                    <p class="p-left">HORARIO DE SERVICIO PSICOLÓGICO</p>
                    <p class="">Horario destinado al servicio, en el cual se les realizarán asignaciones de personas que solicitan atención</p>
                </td>
                <td>
                    <p class="p-left">No. de horas: {{ $car->serv_horas_total }}</p>
                    @if ($car->serv_l)
                    <p class="p-left">Lunes, <span style="font-family: font;">{{ $car->serv_hora_l }}</span></p>
                    @endif
                    @if ($car->serv_ma)
                    <p class="p-left">Martes, <span style="font-family: font;">{{ $car->serv_hora_ma }}</span></p>
                    @endif
                    @if ($car->serv_mi)
                    <p class="p-left">Miercoles, <span style="font-family: font;">{{ $car->serv_hora_mi }}</span></p>
                    @endif
                    @if ($car->serv_j)
                    <p class="p-left">Jueves, <span style="font-family: font;">{{ $car->serv_hora_j }}</span></p>
                    @endif
                    @if ($car->serv_v)
                    <p class="p-left">Viernes, <span style="font-family: font;">{{ $car->serv_hora_v }}</span></p>
                    @endif
                    @if ($car->serv_s)
                    <p class="p-left">Sábado, <span style="font-family: font;">{{ $car->serv_hora_s }}</span></p>
                    @endif
                </td>
            </tr>
            <tr>
                <td><p class="p-left">NÚMERO DE PERSONAS ATENDIDAS A LA SEMANA <span style="font-family: font;">{{ $car->pacientes_semana }}</span></p></td>
                <td><p class="p-left">CANTIDAD MÍNIMA DE USUARIOS QUE SE ATENDERÁN EN
                    EL SEMESTRE: <span style="font-family: font;">{{ $car->minimo_pacientes_semestre }}</span></p></td>
            </tr>
            <tr>
                <td class="left">
                    <p class="p-left">TIPO DE SERVICIO QUE BRINDA EL PROGRAMA</p>
                </td>
                <td>
                    @if ($car->primer_contacto)
                    <p class="p-left">PRIMER CONTACTO</p>
                    @endif
                    @if ($car->admision)
                    <p class="p-left">ADMISIÓN</p>
                    @endif
                    @if ($car->evaluacion)
                    <p class="p-left">EVALUACIÓN</p>
                    @endif
                    @if ($car->orientacion)
                    <p class="p-left">ORIENTACIÓN / CONSEJO BREVE</p>
                    @endif
                    @if ($car->intervencion)
                    <p class="p-left">INTERVENCIÓN</p>
                    @endif
                    @if ($car->egreso)
                    <p class="p-left">EGRESO</p>
                    @endif
                    <p class="p-left">{{$car->otro_servicio}}</p>
                </td>
            </tr>
            <tr>
                <td class="left">
                    <p class="p-left">PROBLEMÁTICA ATENDIDA</p>
                </td>
                <td>
                    @if ($car->depresion)
                    <p class="p-left">DEPRESIÓN</p>
                    @endif
                    @if ($car->duelo)
                    <p class="p-left">DUELO</p>
                    @endif
                    @if ($car->psicosis)
                    <p class="p-left">PSICOSIS</p>
                    @endif
                    @if ($car->epilepsia)
                    <p class="p-left">EPILEPSIA</p>
                    @endif
                    @if ($car->demencia)
                    <p class="p-left">DEMENCIA</p>
                    @endif
                    @if ($car->emocionales_niños)
                    <p class="p-left">TRASTORNOS EMOCIONALES NIÑOS</p>
                    @endif
                    @if ($car->emocionales_ad)
                    <p class="p-left">TRASTORNOS EMOCIONALES ADOLESCENTES</p>
                    @endif
                    @if ($car->conductuales_niños)
                    <p class="p-left">TRASTORNOS CONDUCTUALES NIÑOS</p>
                    @endif
                    @if ($car->conductuales_ad)
                    <p class="p-left">TRASTORNOS CONDUCTUALES ADOLESCENTES</p>
                    @endif
                    @if ($car->desarrollo_niños)
                    <p class="p-left">TRASTORNOS DEL DESARROLLO NIÑOS</p>
                    @endif
                    @if ($car->desarrollo_ad)
                    <p class="p-left">TRASTORNOS DEL DESARROLLO ADOLESCENTES</p>
                    @endif
                    @if ($car->autolesion)
                    <p class="p-left">AUTOLESIÓN / SUICIDIO</p>
                    @endif
                    @if ($car->ansiedad)
                    <p class="p-left">ANSIEDAD</p>
                    @endif
                    @if ($car->estres)
                    <p class="p-left">ESTRÉS</p>
                    @endif
                    @if ($car->sexualidad)
                    <p class="p-left">SEXUALIDAD</p>
                    @endif
                    @if ($car->violencia)
                    <p class="p-left">VIOLENCIA</p>
                    @endif
                    @if ($car->sustancias)
                    <p class="p-left">TRASTORNOS POR EL CONSUMO DE SUSTANCIAS</p>
                    @endif
                    @if ($car->p_intervencion)
                    <p class="p-left">INTERVENCIÓN PSICOEDUCATIVA</p>
                    @endif
                    @if ($car->otra_problematica)
                    <p class="p-left">OTROS: {{ $car->otra_problematica }}</p>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="left">
                    <p class="p-left">ENFOQUE DEL SERVICIO</p>
                </td>
                <td>
                    @if ($car->otro_enfoque)
                    <p class="p-left">OTRO: {{ $car->otro_enfoque }}</p>
                    @else
                    <p class="p-left">{{ $car->enfoque_servicio }}</p>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <div>
        <p style="background-color:#96B804;font-family:fontB;text-align: center;">CARACTERÍSTICAS DE LA SUPERVISIÓN Y EVALUACIÓN</p>
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <td class="left">
                    <p class="p-left">MODALIDAD DE SUPERVISIÓN</p>
                </td>
                <td>
                    @if ($car->individual)
                    <p class="p-left">Individual</p>
                    @endif
                    @if ($car->grupal)
                    <p class="p-left">Grupal</p>
                    @endif
                    @if ($car->colaborativa)
                    <p class="p-left">Colaborativa</p>
                    @endif
                    @if ($car->indirecta)
                    <p class="p-left">Indirecta</p>
                    @endif
                    @if ($car->directa)
                    <p class="p-left">Directa</p>
                    @endif
                    @if ($car->supervision_otra)
                    <p class="p-left">Otra: <span style="font-family: font;font-size: 7pt;">{{ $car->supervision_otra }}</span></p>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <div>
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <td class="left">
                    <p class="p-left">ESTRATEGIAS DE ENSEÑANZA Y SUPERVISIÓN</p>
                </td>
                <td>
                    @if ($car->observacion)
                    <p class="p-left">Observación</p>
                    @endif
                    @if ($car->juego_roles)
                    <p class="p-left">Juego de roles</p>
                    @endif
                    @if ($car->modelamiento)
                    <p class="p-left">Modelamiento</p>
                    @endif
                    @if ($car->moldeamiento)
                    <p class="p-left">Moldeamiento</p>
                    @endif
                    @if ($car->cascada)
                    <p class="p-left">Cascada o diseminación</p>
                    @endif
                    @if ($car->auto_supervision)
                    <p class="p-left">Auto supervisión</p>
                    @endif
                    @if ($car->equipo_reflexivo)
                    <p class="p-left">Equipo reflexivo</p>
                    @endif
                    @if ($car->con_colegas)
                    <p class="p-left">Supervisión con colegas</p>
                    @endif
                    @if ($car->analisis_caso)
                    <p class="p-left">Análisis de caso</p>
                    @endif
                    @if ($car->ensenanza_otra)
                    <p class="p-left">Otra: <span style="font-family: font;font-size: 7pt;">{{ $car->ensenanza_otra }}</span></p>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="left" ><p class="p-left">CONTENIDO TEMÁTICO (TEMAS Y SUBTEMAS)</p></td>
                <td class="right"><p>{!! nl2br(e($datos->cont_tematico)) !!}</p></td>
            </tr>
            <tr>
                <td class="left" ><p class="p-left">ESTRATEGIA DE SEGUIMIENTO Y EVALUACIÓN DE IMPACTO DEL SERVICIO</p></td>
                <td class="right"><p>{!! nl2br(e($datos->estra_ev_imp)) !!}</p></td>
            </tr>
            <tr>
                <td class="left">
                    <p class="p-left">COMPETENCIAS PROFESIONALES A DESARROLLAR</p>
                </td>
                <td>
                    @if ($car->fundamentales)
                    <p class="p-left">Fundamentales</p>
                    @endif
                    @if ($car->entrevista)
                    <p class="p-left">Entrevista</p>
                    @endif
                    @if ($car->c_evaluacion)
                    <p class="p-left">Evaluación</p>
                    @endif
                    @if ($car->impresion_diagnostica)
                    <p class="p-left">Impresión diagnostica</p>
                    @endif
                    @if ($car->implementacion_intervenciones)
                    <p class="p-left">Diseño / Implementación de intervenciones</p>
                    @endif
                    @if ($car->integracion_expediente)
                    <p class="p-left">Integración de expediente</p>
                    @endif
                    @if ($car->elaboracion_documentos)
                    <p class="p-left">Elaboración de documentos escritos de avances y resultados</p>
                    @endif
                    @if ($car->competencias_otra)
                    <p class="p-left">Otra: <span style="font-family: font;font-size: 7pt;">{{ $car->competencias_otra }}</span></p>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="left">
                    <p class="p-left">ESTRATEGIAS DE EVALUACIÓN DE COMPETENCIAS</p>
                </td>
                <td>
                    @if ($car->formativa)
                    <p class="p-left">FORMATIVA</p>
                    @endif
                    @if ($car->integrativa)
                    <p class="p-left">INTEGRATIVA</p>
                    @endif
                    @if ($car->contextual)
                    <p class="p-left">CONTEXTUAL COMUNITARIA O INSTITUCIONAL</p>
                    @endif
                    @if ($car->holistica)
                    <p class="p-left">HOLÍSTICA</p>
                    @endif
                    @if ($car->plural)
                    <p class="p-left">PLURAL E INCLUYENTE</p>
                    @endif
                    @if ($car->reflexiva)
                    <p class="p-left">REFLEXIVA Y CON AUTONOMÍA PROFESIONAL</p>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <div>
        <p style="background-color:#96B804;font-family:fontB;text-align: center;">ACTIVIDADES A TRAVÉS DE LAS CUALES SE ALCANZAN LAS COMPETENCIAS</p>
        <table style="width: 100%; table-layout: fixed">
                <tr>
                    <th>SEMANA</th>
                    <th>ACTIVIDAD</th>
                    <th>COMPETENCIA(S)</th>
                </tr>
                @foreach ($semanas as $semana)
                <tr>
                    <td class="right"><p>{!! nl2br(e($semana->semana)) !!}</p></td>
                    <td class="right"><p>{!! nl2br(e($semana->actividad)) !!}</p></td>
                    <td class="right"><p>{!! nl2br(e($semana->competencias)) !!}</p></td>
                </tr>
                @endforeach
        </table>
    </div>
    <br>
    <div>
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <th>CRITERIOS DE ACREDITACIÓN</th>
                <th>¿Cuándo se mide?</th>
                <th>¿Cómo se mide?</th>
            </tr>
            @foreach ($criteriosAc as $criterio)
            <tr>
                <td class="right"><p>{!! nl2br(e($criterio->criterio)) !!}</p></td>
                <td class="right"><p>{!! nl2br(e($criterio->cuando)) !!}</p></td>
                <td class="right"><p>{!! nl2br(e($criterio->como)) !!}</p></td>
            </tr>
            @endforeach
        </table>
    </div>
    <div>
        <p style="background-color:#96B804;font-family:fontB;text-align: center;">REFERENCIAS</p>
        <table style="width: 100%; table-layout: fixed">
            <tr><td class="right"><p>{!! nl2br(e($datos->referencias)) !!}</p></td></tr>
        </table>
    </div>
</body>
</html>