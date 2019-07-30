<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta line="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
        footer {
            position: fixed; 
            bottom: -60px; 
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
        p {
            margin: 0
        }
        div .age {
            margin-top: 1em;
        }
        .section { margin-top: 1em; }
        .my-blue { color: rgb(104, 178, 255); }
        .nav-title {
            float: right;
            width: 50%;
            font-size: 20px;
        }
        .top-data {
            text-align: right;
            text-justify:  
        }
        .line {
            /* border: 2px solid red; */
            display: inline-block;
        }
        .b-line {
            border-bottom: 1px solid black;
        }
        .bold {
            font-weight: bold;
            margin-bottom: 0.5em;
        }
        .center {
            text-align: center;
        }
        .top {
            vertical-align: top;
        }
        .r-space {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ asset('img/logo_unam.jpg') }}">
        <img src="{{ asset('img/logo_psi.jpg') }}">
        <img src="{{ asset('img/llanta.png') }}">
        <p class="nav-title my-blue">Coordinación de Centros de Formación y Servicios Psicológicos</p>
    </header>

    <footer class="my-blue">
        <p>ESTE DOCUMENTO FORMA PARTE DEL SISTEMA DE GESTIÓN DE CALIDAD</p>
        <p>3-FE3-FDG</p>
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
        <h2 class="center">FICHA DE DATOS GENERALES</h2>
        <div class="top-data">
            <p><span class="bold">No. Expediente:</span> {{ $fdg->id }}</p>
            <p><span class="bold">No. Cuenta/No. Trabajador/CURP:</span> {{ $fdg->curp }}</p>
            <p><span class="bold">Fecha:</span> {{ $fdg->created_at }}</p>
        </div>
        <div class="person-data">
            <p class="bold">Identificación de la persona que requiere el servicio</p>
            <p class="bold">Nombre</p>
            <div>
                <div class="line">
                    <p class="b-line">{{ $fdg->name }}</p>
                    <p>Nombre(s)</p>
                </div>
                <div class="line">
                    <p class="b-line">{{ $fdg->last_name }}</p>
                    <p>Apellido paterno</p>
                </div>
                <div class="line">
                    <p class="b-line">{{ $fdg->mothers_name }}</p>
                    <p>Apellido materno</p>
                </div>
            </div>
            <div>
                <div class="line">
                    <p><span class="bold">Sexo:</span> {{ $fdg->gender ? 'Hombre' : 'Mujer' }}</p>
                </div>
            </div>
            <div class="age">
                <p class="bold line top">Fecha de nacimiento: </p>
                <div class="line">
                    <p class="b-line">{{ $fdg->birthdate->day }}</p>
                    <p>día</p>
                </div>
                <p class="line top">/</p>
                <div class="line">
                    <p class="b-line">{{ $fdg->birthdate->month }}</p>
                    <p>mes</p>
                </div>
                <p class="line top">/</p>
                <div class="line r-space">
                    <p class="b-line">{{ $fdg->birthdate->year }}</p>
                    <p>año</p>
                </div>
                <div class="line top">
                    <p><span class="bold">Edad:</span> {{ $fdg->birthdate->age }} años</p>
                </div>
            </div>
            <div>
                <p><span class="bold">Estado civil de la persona que requiere el servicio: </span>{{ $fdg->marital_status }}</p>
            </div>
            <div>
                <p><span class="bold">¿Pertenece a la Comunidad UNAM?</span> {{ $fdg->is_unam? 'Si': 'No' }}</p>
            </div>
            @if ($fdg->is_unam)
            <div>
                <p><span class="bold">Entidad académica de procedencia</span> {{ $fdg->academic_entity }}</p>
                <p><span class="bold">Es:</span> {{ $fdg->position }}</p>
                <p><span class="bold">Carrera que estudia:</span> {{ $fdg->career }}</p>
                <p><span class="bold">Semestre que cursa:</span> {{ $fdg->semester }}</p>
            </div>
            @endif
            <div>
                <p><span class="bold">Persona que solicita el servicio</span> {{ $fdg->person_requesting }}</p>
                @if ($fdg->person_requesting)
                <p><span class="bold">Nombre de quien solicita el servicio</span> {{ $fdg->name_requester }}</p>
                @endif
            </div>
            @if ($fdg->is_under_age)
            <div class="section">
                <i>La atención es para un menor de edad</i>
                <p><span class="bold">Nombre {{ $fdg->relationship_1 }} </span> {{ $fdg->tutor_name_1 }}</p>
            </div>
            <div class="age">
                <p class="bold line top">Fecha de nacimiento: </p>
                <div class="line">
                    <p class="b-line">{{ $fdg->tutor_birthdate_1->day }}</p>
                    <p>día</p>
                </div>
                <p class="line top">/</p>
                <div class="line">
                    <p class="b-line">{{ $fdg->tutor_birthdate_1->month }}</p>
                    <p>mes</p>
                </div>
                <p class="line top">/</p>
                <div class="line r-space">
                    <p class="b-line">{{ $fdg->tutor_birthdate_1->year }}</p>
                    <p>año</p>
                </div>
                <div class="line top">
                    <p><span class="bold">Edad:</span> {{ $fdg->tutor_birthdate_1->age }} años</p>
                </div>
            </div>
            <div>
                <p><span class="bold">Nivel máximo de estudios:</span> {{ $fdg->studies_level_1 }}</p>
                <p><span class="bold">Ocupación {{ $fdg->relationship_1 }}</span> {{ $fdg->occupation_1 }}</p>
            </div>
            @if ($fdg->tutor_name_2)
            <div>
                <p><span class="bold">Nombre {{ $fdg->relationship_2 }} </span> {{ $fdg->tutor_name_2 }}</p>
            </div>
            <div class="age">
                <p class="bold line top">Fecha de nacimiento: </p>
                <div class="line">
                    <p class="b-line">{{ $fdg->tutor_birthdate_2->day }}</p>
                    <p>día</p>
                </div>
                <p class="line top">/</p>
                <div class="line">
                    <p class="b-line">{{ $fdg->tutor_birthdate_2->month }}</p>
                    <p>mes</p>
                </div>
                <p class="line top">/</p>
                <div class="line r-space">
                    <p class="b-line">{{ $fdg->tutor_birthdate_2->year }}</p>
                    <p>año</p>
                </div>
                <div class="line top">
                    <p><span class="bold">Edad:</span> {{ $fdg->tutor_birthdate_2->age }} años</p>
                </div>
            </div>
            <div>
                <p><span class="bold">Nivel máximo de estudios:</span> {{ $fdg->studies_level_2 }}</p>
                <p><span class="bold">Ocupación {{ $fdg->relationship_2 }}</span> {{ $fdg->occupation_2 }}</p>
            </div>
            @endif
            @endif
        </div> {{-- person data --}}
        <div class="section address-data">
            <h3 class="bold">Dirección de la persona que requiere el servicio</h3>
            <div>
                <div class="line">
                    <p class="b-line">{{ $fdg->street_name }}</p>
                    <p>Calle</p>
                </div>
                <div class="line">
                    <p class="b-line">{{ $fdg->external_number }}</p>
                    <p>Número exterior</p>
                </div>
                @if ($fdg->internal_number)
                <div class="line r-space">
                    <p class="b-line">{{ $fdg->internal_number }}</p>
                    <p>Número interior</p>
                </div>
                @endif
            </div>
            <div>
                <div class="line">
                    <p class="b-line">{{ $fdg->neighborhood }}</p>
                    <p>Colonia</p>
                </div>
                <div class="line">
                    <p class="b-line">{{ $fdg->postal_code }}</p>
                    <p>C.P.</p>
                </div>
            </div>
            <div>
                <div class="line">
                    <p class="b-line">{{ $fdg->municipality }}</p>
                    <p>Delegación/Municipio</p>
                </div>
                <div class="line">
                    <p class="b-line">{{ $fdg->state }}</p>
                    <p>Entidad federativa</p>
                </div>
            </div>
            <div>
                @if ($fdg->house_phone)
                <div class="line">
                    <p class="b-line">{{ $fdg->house_phone }}</p>
                    <p>Teléfono de casa</p>
                </div>
                @endif
                @if ($fdg->cell_phone)
                <div class="line">
                    <p class="b-line">{{ $fdg->cell_phone }}</p>
                    <p>Teléfono celular</p>
                </div>
                @endif
                @if ($fdg->work_phone)
                <div class="line">
                    <p class="b-line">{{ $fdg->work_phone }}</p>
                    <p>Teléfono de trabajo</p>
                </div>
                @endif
                @if ($fdg->work_phone_ext)
                <div class="line">
                    <p class="b-line">{{ $fdg->work_phone_ext }}</p>
                    <p>ext.</p>
                </div>
                @endif
            </div>
        </div>{{-- address data --}}
        <div class="section scholarship">
            <p><span class="bold">Escolaridad de la persona que requiere el servicio</span> {{ $fdg->scholarship }}</p>
            <p><span class="bold">Años concluidos de estudio</span> {{ $fdg->studied_years }}</p>
        </div>
        <div class="section socio-economic">
            <h3 class="bold">Situación laboral de la persona que requiere el servicio</h3>
            <p><span class="bold">¿Trabaja actualmente?</span> {{ $fdg->has_work? 'Si':'No' }}</p>
            <p><span class="bold">¿Recibe remuneración económica por su trabajo?</span> {{ $fdg->has_salary? 'Si':'No' }}</p>
            <p class="bold">Descripción de su trabajo</p>
            <p>{{ $fdg->work_description }}</p>
            <p><span class="bold">Número de integrantes del hogar</span>(contando la persona que requiere el servicio): {{ $fdg->household_members }}</p>
            <p><span class="bold">Ingreso familiar mensual:</span> {{ $fdg->monthly_family_income }}</p>
            <p><span class="bold">Número de personas que aportan a este ingreso</span>(contando la persona que requiere el servicio): {{ $fdg->number_people_contributing }}</p>
            <p><span class="bold">Número de personas que dependen de este ingreso</span>(contando la persona que requiere el servicio): {{ $fdg->number_people_depending }}</p>
            <p><span class="bold">Su casa es:</span> {{ $fdg->house_is }}</p>
        </div>
        <div class="section about-service">
            <h3 class="bold">Sobre el servicio que se solicita</h3>
            <p><span class="bold">Tipo de servicio:</span> {{ $fdg->service_type }}</p>
            <p><span class="bold">Modalidad de servicio que solicita:</span> {{ $fdg->service_modality }}</p>
            <p><span class="bold">Motivo de consulta</span></p><i>(Descripción detallada de lo que le pasa y qué espera de la atención que se le puede brindar en este Centro/Programa)</i>
            <p>{{ $fdg->consultation_cause }}</p>
            <p><span class="bold">Clasificación del motivo de consulta según la Guía mhGAP</span> {{ $fdg->mhGAP_cause_classification }}</p>
            <p><span class="bold">¿Desde cuándo le pasa esto?</span> {{ $fdg->problem_since }}</p>
            <p><span class="bold">¿Ha recibido anteriormente tratamiento para dar solución a esta situación?</span> {{ $fdg->has_recived_previous_treatment? 'Si':'No' }}</p>
            @if ($fdg->has_recived_previous_treatment)
            <p><span class="bold">Tipo de atención que ha recibido</span> {{ $fdg->type_previous_treatment }}</p>
            <p><span class="bold">Número de veces que ha sido atendido para esta situación</span> {{ $fdg->number_times_treatment }}</p>
            @endif
            <p><span class="bold">¿Viene referido de otra institución?</span> {{ $fdg->refer }}</p>
            @if ($fdg->refer)
            <p class="bold">Problemática referido de la institución</p>
            <p>{{ $fdg->refer_problem }}</p>
            @endif
            <p><span class="bold">¿Ha recibido atención en otros Centros y/o programs de la FACULTAD para su motivo de consulta?</span> {{ $fdg->unam_previous_treatment? 'Si':'No' }}</p>
            @if ($fdg->unam_previous_treatment)
            <p><span class="bold">Centro/Programa</span> {{ $fdg->prev_program->nombre }}</p>
            @endif
            <p><span class="bold">¿Tiene algún problema de salud?</span> {{ $fdg->has_health_issue? 'Si':'No' }}</p>
            @if ($fdg->has_health_issue)
            <p><span class="bold">¿Cuál?</span> {{ $fdg->health_issue }}</p>
            <p><span class="bold">¿Toma medicamentos?</span> {{ $fdg->takes_medication? 'Si':'No' }}</p>
            @if ($fdg->takes_medication)
            <p><span class="bold">¿Cuáles?</span> {{ $fdg->medication }}</p>
            <p><span class="bold">Dosis</span> {{ $fdg->medication_dose }}</p>
            @endif
            <p><span class="bold">Horario de preferencia</span> {{ $fdg->prefer_time }}</p>
            @endif
        </div>
    </div>
</body>
</html>