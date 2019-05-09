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
    .header p{
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
        font-family:fontB;text-align:center;
    }
    .centrado {
    text-align:center;
    }
    .aintlyin {
    display:inline-block;
    vertical-align:top;
    width: 45%;
    /* margin: 20px;
    padding: 20px; */
    border: 1px solid black;
    /* background: #fff; */
    }
    /* .table {
        width: 100%;
        background-color: red;
    }
    .row {
        overflow: hidden;
        background-color: green;
    }
    .col {
        text-align: center;
    }
    .left {
        background-color: yellow;
        width: 30%;
        float: left;
    }
    .left p {
        font-family: 'fontB';
    }
    .right {
        overflow: hidden;
        background-color: blue;
    } */
    </style>
</head>
<body>
    <div class="header">
        {{-- <img class="block" src="{{ asset('img/unam.jpg') }}"> --}}
        <div class="block" style="text-align: center;">
            <p style="font-size:12pt;">Coordinación de Centros de Formación y Servicios Psicológicos</p>
            <p style="font-size:10pt;">FACULTAD DE PSICOLOGÍA, UNAM</p>
            <p style="font-size:9pt;font-family: fontB;">REGISTRO DE PROGRAMAS DE SERVICIOS PSICOLÓGICOS A TRAVÉS DE LA FORMACIÓN SUPERVISADA</p>
        </div>
        {{-- <img class="block" src="{{ asset('img/psi.jpg') }}"> --}}
    </div>
    <div>
        <p style="font-size:10pt;">Los Programas de Servicios Psicológicos a través de la Formación Supervisada
             permiten que estudiantes de los semestres intermedios de la Carrera (5° a 8º) y estudiantes de posgrado
              inicien un ejercicio profesional en escenarios reales, bajo la supervisión académica e in situ del supervisor
               y del Escenario, respectivamente. La supervisón es fundamental para la adquisición de competencias profesionales del estudiante.
               <br/><br/>
            A continuación podrá proporcionar toda la información para su Programa de Práctica integral supervisada, 
            es importante <span style="font-family: fontB;">llene todos los campos solicitados.</span>
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
            <tr>
                <td class="left"><p class="p-left">DIRECCIÓN DEL ESCENARIO</p></td>
                <td class="right"><p>{{ $doc->center->direccion }}</p></td>
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
        </table>
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <td ><p style="text-align:center;"><span style="font-family:fontB;">Teléfono: </span>{{ $doc->supervisor->telefono }}</p></td>
                <td ><p style="text-align:center;"><span style="font-family:fontB;">Celular: </span>{{ $doc->supervisor->celular }}</p></td>
                <td ><p style="text-align:center;"><span style="font-family:fontB;">e-mail: </span>{{ $doc->supervisor->correo }}</p></td>
            </tr>
        </table>
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <td class="left" ><p class="p-left">Número de trabajador: </p></td>
                <td class="right"><p>{{ $doc->supervisor->num_trabajador }}</p></td>
            </tr>
        </table>
    </div>
    <div>
        <p style="background-color:#96B804;font-family:fontB;text-align: center;">DATOS DEL SUPERVISOR IN SITU</p>
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <td class="left" ><p class="p-left">NOMBRE</p></td>
                <td class="right"><p>{{ $doc->supervisord->full_name }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">ADSCRIPCIÓN</p></td>
                <td class="right"><p>{{ $doc->supervisord->coordinacion }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">NOMBRAMIENTO</p></td>
                <td class="right"><p>{{ $doc->supervisord->nombramiento }}</p></td>
            </tr>
        </table>
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <td ><p style="text-align:center;"><span style="font-family:fontB;">Teléfono: </span>{{ $doc->supervisord->telefono }}</p></td>
                <td ><p style="text-align:center;"><span style="font-family:fontB;">Celular: </span>{{ $doc->supervisord->celular }}</p></td>
                <td ><p style="text-align:center;"><span style="font-family:fontB;">e-mail: </span>{{ $doc->supervisord->correo }}</p></td>
            </tr>
        </table>
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <td class="left" ><p class="p-left">Número de trabajador: </p></td>
                <td class="right"><p>{{ $doc->supervisord->num_trabajador }}</p></td>
            </tr>
        </table>
    </div>
    <div>
        <p style="background-color:#96B804;font-family:fontB;text-align: center;">CARACTERISTICAS DEL PROGRAMA</p>
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <td class="left" ><p class="p-left">RESUMEN</p></td>
                <td class="right"><p>{{ $datos->resumen }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">JUSTIFICACION</p></td>
                <td class="right"><p>{{ $datos->justificacion }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">OBJETIVO GENERAL</p></td>
                <td class="right"><p>{{ $datos->objetivo_g }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">OBJETIVOS ESPECÍFICOS</p></td>
                <td class="right"><p>{{ $datos->objetivo_es }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">SEMESTRE O GRADO AL QUE VA DIRIGIDO EL PROGRAMA</p></td>
                <td class="right"><p>{{ $car->dirigido_a }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">FECHA DE INICIO</p></td>
                <td class="right"><p>{{ $car->fecha_inicio }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">FECHA DE TÉRMINO</p></td>
                <td class="right"><p>{{ $car->fecha_fin }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">REQUISITOS DE INGRESO AL PROGRAMA</p></td>
                <td class="right"><p>{{ $datos->requisitos }}</p></td>
            </tr>
            <tr>
                <td class="left"><p class="p-left">ASIGNATURAS ACADÉMICAS DEL PLAN CURRICULAR 2008 CON LAS CUALES EMPATA EL PROGRAMA</p></td>
                <td class="right"><p>{{ $datos->asig_emp }}</p></td>
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
                    <p class="p-left">(Indicar el horario en el que los alumnos asisten)</p>
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
                    <p class="p-left">(Indicar el horario destinado al servicio, en el cual se les realizarán asignaciones de personas que solicitan atención)</p>
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
                <td><p class="p-left">NÚMERO DE PERSONAS ATENDIDAS A LA SEMANA (Tomando en cuenta el número de 
                    personas que puede atender un estudiante por semana): <span style="font-family: font;">{{ $car->pacientes_semana }}</span></p></td>
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
                    <p>{{ $car->enfoque_servicio }}</p>
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
                    <p class="p-left">Individual: <span style="font-family: font;font-size: 7pt;">(aquella en la que participan
                         dos actores: supervisado y supervisor, este tipo de supervisión permite profundizar en 
                         los aspectos teórico-prácticos del proceso de intervención psicológica, en la relación 
                         supervisado-usuario y en el impacto del proceso en la persona del supervisado, puede por 
                         otra parte ser limitada al no tener acceso a otras voces y a una red de apoyo de pares que 
                         brinden pertenencia y contención.)</span></p>
                    @endif
                    @if ($car->grupal)
                    <p class="p-left">Individual: <span style="font-family: font;font-size: 7pt;">(participan un supervisor
                         y un grupo de supervisados, uno de ellos presenta un caso y el supervisor y el grupo analizan los 
                         mismos aspectos citados en la modalidad individual, con la diferencia de que todo el grupo participa
                          y enriquece la visión del proceso psicológico, éste es un proceso recursivo en el que también el grupo
                           se beneficia, permite también que un número mayor de personas se capaciten)</span></p>
                    @endif
                    @if ($car->colaborativa)
                    <p class="p-left">Individual: <span style="font-family: font;font-size: 7pt;">(la supervisión se brinda
                         en colaboración con otras personas, ya sean los responsables de las instituciones en las cuales se
                          desarrollan las prácticas profesionales (por ejemplo, los docentes de una escuela); por otras personas
                           de la comunidad (por ejemplo, los padres y las madres de familia que llevan a sus hijos a los talleres
                            que se brindan en los Centros de Servicios de la Facultad de Psicología)</span></p>
                    @endif
                    @if ($car->indirecta)
                    <p class="p-left">Individual: <span style="font-family: font;font-size: 7pt;">(se realiza después de la intervención,
                         incluye varias submodalidades: narrada, presentación del caso en video o audiograbación</span></p>
                    @endif
                    @if ($car->directa)
                    <p class="p-left">Individual: <span style="font-family: font;font-size: 7pt;">(es la que se desarrolla durante la sesión
                         de intervención bajo la coordinación de un supervisor (Ceberio & Linares, 2006). En general, las sesiones se dividen
                          en 3 fases: pre-sesión, sesión (algunos modelos incluyen una inter- sesión) y postsesión.</span></p>
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
                    <p class="p-left">Observación: <span style="font-family: font;font-size: 7pt;">Los supervisados en forma directa
                         o a través de una videograbación observan a un experto y apoyados en una “guía de observación” hacen sus 
                         reportes.</span></p>
                    @endif
                    @if ($car->juego_roles)
                    <p class="p-left">Juego de roles: <span style="font-family: font;font-size: 7pt;">Uno de los estudiantes actúa
                         como psicólogo responsable de la intervención y el o los otros como usuario(s). En esta estrategia, 
                         se presenta un caso o situación, el supervisado-responsable de la intervención y el supervisado-usuario 
                         “actúan” y llevan a cabo la sesión, el grupo permanece como observador. Al finalizar se retroalimenta al 
                         supervisado-psicólogo en formación, enfatizando las fortalezas y detallando los aspectos a mejorar.</span></p>
                    @endif
                    @if ($car->modelamiento)
                    <p class="p-left">Modelamiento: <span style="font-family: font;font-size: 7pt;">En el modelaje, el supervisor lleva a 
                        cabo la intervención para que el supervisado pueda observarla y después llevarla a cabo. La ventaja en esta 
                        estrategia es que el supervisado puede ver casos o situaciones reales e intervenciones en problemáticas 
                        específicas.</span></p>
                    @endif
                    @if ($car->moldeamiento)
                    <p class="p-left">Moldeamiento: <span style="font-family: font;font-size: 7pt;">El supervisado interviene directamente, 
                        supervisor y grupo analizan directa o indirectamente la sesión y retroalimentan al supervisado. Los estudiantes 
                        que reciben entrenamiento pueden experimentar momentos de angustia, falta de seguridad o conflictos entre su autonomía 
                        y la obediencia. Por lo tanto, la creación de una atmósfera de confianza y seguridad, sustentada en el apoyo del 
                        supervisor y el grupo es fundamental para su aprendizaje y para el éxito de la intervención.</span></p>
                    @endif
                    @if ($car->directa)
                    <p class="p-left">Individual: <span style="font-family: font;font-size: 7pt;">(es la que se desarrolla durante la sesión
                         de intervención bajo la coordinación de un supervisor (Ceberio & Linares, 2006). En general, las sesiones se dividen
                          en 3 fases: pre-sesión, sesión (algunos modelos incluyen una inter- sesión) y postsesión.</span></p>
                    @endif
                    @if ($car->modelamiento)
                    <p class="p-left">Modelamiento: <span style="font-family: font;font-size: 7pt;">En el modelaje, el supervisor lleva a 
                        cabo la intervención para que el supervisado pueda observarla y después llevarla a cabo. La ventaja en esta 
                        estrategia es que el supervisado puede ver casos o situaciones reales e intervenciones en problemáticas 
                        específicas.</span></p>
                    @endif
                    @if ($car->cascada)
                    <p class="p-left">Cascada o diseminación: <span style="font-family: font;font-size: 7pt;">(experto/novato). 
                        En esta estrategia los novatos observan a un experto, que es de diferente nivel académico. 
                        En el grupo de observación hay también expertos, al finalizar la sesión ambos entregan y comparten diferentes 
                        reflexiones acerca del trabajo. Esta práctica hace que ambos niveles expertos y novatos se beneficien de la 
                        experiencia, a los expertos les da la oportunidad de compartir las destrezas que han adquirido y de escuchar 
                        voces diferentes y en algún sentido más “frescas”. A los novatos les puede dar la confianza de compartir sus 
                        puntos de vista y la certeza de que las habilidades se aprenden. Otro aspecto a considerar es la optimización 
                        de los recursos humanos en una institución.</span></p>
                    @endif
                    @if ($car->auto_supervision)
                    <p class="p-left">Auto supervisión: <span style="font-family: font;font-size: 7pt;">Esta estrategia es útil cuando no
                         sea posible que supervisor y supervisado tengan contacto frecuente y en el que este último haya alcanzado un grado 
                         de experiencia y autonomía que le permita recorrer la mayor parte del camino en forma independiente. Para realizar 
                         la autosupervisión se utiliza con frecuencia la videograbación, para observarse a sí mismo en el contexto de la 
                         intervención y analizar las técnicas, maniobras, lenguaje verbal y no verbal de él mismo y de los usuarios. De tal 
                         manera que le permitan focalizar el problema y planear futuras intervenciones. Tiene también la ventaja de que 
                         optimiza los encuentros con el supervisor centrándose en aquellos aspectos problemáticos del proceso.</span></p>
                    @endif
                    @if ($car->equipo_reflexivo)
                    <p class="p-left">Equipo reflexivo: <span style="font-family: font;font-size: 7pt;">Esta estrategia tiene como base 
                        teórica un enfoque posmoderno, en el que se considera al lenguaje como construcción social (Gergen, 1996), 
                        donde cada diálogo es una co-construcción entre el supervisor y sus supervisados, ambos participan y se transforman
                         en el proceso, construyendo nuevos significados, una nueva narración de la experiencia.</span></p>
                    @endif
                    @if ($car->con_colegas)
                    <p class="p-left">Supervisión con colegas: <span style="font-family: font;font-size: 7pt;">Esta estrategia, se ha dado 
                        principalmente en el ámbito institucional, en el que se acostumbran las sesiones de supervisión de forma abierta 
                        entre colegas. En este sentido, la supervisión entre colegas se caracteriza porque el supervisado puede aceptar o 
                        rechazar las sugerencias hechas por los otros compañeros, pues en ocasiones los puntos de vista pueden ser divergentes
                         o parecer inadecuados. Benshoff (1994, citado por López, 1998), señala que esta supervisión puede ser sumamente 
                         beneficiosa debido a que: en principio disminuye la dependencia hacia el llamado “experto” y propicia una relación
                          más abierta entre iguales, en el supervisado se pueden promover la autoconfianza e independencia, puede también 
                          elegir al colega de mayor confianza para compartir sus propias dudas.</span></p>
                    @endif
                    @if ($car->analisis_caso)
                    <p class="p-left">Análisis de caso: <span style="font-family: font;font-size: 7pt;">En esta estrategia la 
                        herramienta básica es el expediente psicológico o portafolio. Con la ayuda del supervisor, el(los) supervisado(s), 
                        revisan todos los elementos del expediente: datos sociodemográficos, entrevista inicial, historia clínica, 
                        pruebas aplicadas, resúmenes de evaluación, etc. Se revisa y discute la bibliografía propuesta y se elabora 
                        un plan de trabajo con objetivos, técnicas y duración específica.</span></p>
                    @endif
                    @if ($car->ensenanza_otra)
                    <p class="p-left">Otra: <span style="font-family: font;font-size: 7pt;">{{ $car->ensenanza_otra }}</span></p>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="left" ><p class="p-left">CONTENIDO TEMÁTICO (TEMAS Y SUBTEMAS)</p></td>
                <td class="right"><p>{{ $datos->cont_tematico }}</p></td>
            </tr>
            <tr>
                <td class="left" ><p class="p-left">ESTRATEGIA DE SEGUIMIENTO Y EVALUACIÓN DE IMPACTO DEL SERVICIO</p></td>
                <td class="right"><p>{{ $datos->estra_ev_imp }}</p></td>
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
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <th>CRITERIOS DE ACREDITACIÓN</th>
                <th>¿Cuándo se mide?</th>
                <th>¿Cómo se mide?</th>
            </tr>
            <tr>
                <td class="right"><p>{{ $datos->criterios_eva }}</p></td>
                <td class="right"><p>{{ $car->cuando_acreditacion }}</p></td>
                <td class="right"><p>{{ $car->como_acreditacion }}</p></td>
            </tr>
        </table>
    </div>
    <div>
        <p style="background-color:#96B804;font-family:fontB;text-align: center;">REFERENCIAS</p>
        <table style="width: 100%; table-layout: fixed">
            <tr><td class="right"><p>{{ $car->como_acreditacion }}</p></td></tr>
        </table>
    </div>
</body>
</html>