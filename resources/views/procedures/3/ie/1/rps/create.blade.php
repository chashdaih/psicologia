@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1>
        @if ($errors->any())
        <div class="notification is-danger">
            <p>El formulario contiene errores:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route($doc_code.'.store') }}">
            @csrf
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title is-centered">PROGRAMA</p>
                </header>
                <div class="card-content">
                    @component('components.text-input', [
                        'title'=>'Nombre del programa',
                        'field'=>'programa',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    @component('components.select', [
                        'title'=>'Centro al cual pertenece el programa',
                        'field'=>'id_centro',
                        'errors'=>$errors,
                        'options'=> $buildings
                        ])@endcomponent
                    <text-input class="field" inline-template
                        {{ $errors->has('dirigido_a') ? ":error=true" : '' }}
                        title="dirigido_a">
                        <div>
                        <label class="label">Curricular / Extracurricular</label>
                        <div class="control">
                            <div class="select">
                                <select name="tipo"> {{-- TODO cambiar esto de lugar --}}
                                    <option value="CURRICULAR">Curricular</option>
                                    <option value="EXTRACURRICULAR">Extracurricular</option>
                                </select>
                            </div>
                        </div>
                        @if ($errors->has('dirigido_a'))
                        <p v-if="hasError" class="help is-danger">{{ $errors->first('dirigido_a') }}</p>
                        @endif
                        </div>
                    </text-input>
                </div>
            </div>
            <br>
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title is-centered">SUPERVISORES</p>
                </header>
                <div class="card-content">
                    @component('components.select', [
                        'title'=>'Supervisor académico',
                        'field'=>'id_supervisor',
                        'errors'=>$errors,
                        'options'=> $supervisors
                        ])@endcomponent
                    @component('components.select', [
                        'title'=>'Supervisor in situ',
                        'field'=>'id_supervisord',
                        'errors'=>$errors,
                        'options'=> $supervisors
                        ])@endcomponent
                </div>
            </div>
            <br>
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title is-centered">CARACTERÍSTICAS DEL PROGRAMA</p>
                </header>
                <div class="card-content">
                    @component('components.text-input', [
                        'title'=>'Resumen',
                        'field'=>'resumen',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Justificación',
                        'field'=>'justificacion',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Objetivo general',
                        'field'=>'objetivo_g',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Objetivos específicos',
                        'field'=>'objetivo_es',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Duración del programa (Número de semestres que dura)',
                        'field'=>'periodicidad',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    <text-input class="field" inline-template
                        {{ $errors->has('dirigido_a') ? ":error=true" : '' }}
                        title="dirigido_a">
                        <div>
                        <label class="label">Semestre o grado al que va dirigido el programa</label>
                        <div class="control">
                            <div class="select">
                                <select name="dirigido_a"> {{-- TODO cambiar esto de lugar --}}
                                    <option value="0">Pregrado - 5to </option>
                                    <option value="1">Pregrado - 6to </option>
                                    <option value="2">Pregrado - 7mo </option>
                                    <option value="3">Pregrado - 8vo </option>
                                    <option value="4">Especialidad</option>
                                    <option value="5">Maestría</option>
                                    <option value="6">Doctorado</option>
                                </select>
                            </div>
                        </div>
                        @if ($errors->has('dirigido_a'))
                        <p v-if="hasError" class="help is-danger">{{ $errors->first('dirigido_a') }}</p>
                        @endif
                        </div>
                    </text-input>
                    @component('components.text-input', [
                        'title'=>'Fecha de inicio',
                        'field'=>'fecha_inicio',
                        'errors'=>$errors,
                        'type'=> 'date'
                        ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Fecha de término',
                        'field'=>'fecha_fin',
                        'errors'=>$errors,
                        'type'=> 'date'
                        ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Requisitos de ingreso al programa',
                        'field'=>'requisitos',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Asignaturas académicas del plan curricular 2008 con las cuales empata el programa',
                        'field'=>'asig_emp',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'No. máximo de alumnos',
                        'field'=>'cupo',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                </div>
            </div>
            <br>
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title is-centered">CARACTERÍSTICAS DEL SERVICIO</p>
                </header>
                <div class="card-content">
                    <p>Horario general del programa (Indicar el horario en el que los alumnos asisten)</p>
                    @component('components.text-input', [
                        'title'=>'No. de horas',
                        'field'=>'gen_horas_total',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    <table class="table is-fullwidth">
                        <thead>
                            <tr>
                                <th>Días</th>
                                <th>Horario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" name="gen_l"> Lunes</label></td>
                                <td><input name="gen_hora_l" class="input" type="text" placeholder="Horario lunes"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" name="gen_ma"> Martes</label></td>
                                <td><input name="gen_hora_ma" class="input" type="text" placeholder="Horario martes"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" name="gen_mi"> Miercoles</label></td>
                                <td><input name="gen_hora_mi" class="input" type="text" placeholder="Horario miercoles"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" name="gen_j"> Jueves</label></td>
                                <td><input name="gen_hora_j" class="input" type="text" placeholder="Horario jueves"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" name="gen_v"> Viernes</label></td>
                                <td><input name="gen_hora_v" class="input" type="text" placeholder="Horario viernes"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" name="gen_s"> Sábado</label></td>
                                <td><input name="gen_hora_s" class="input" type="text" placeholder="Horario sabado"></td>
                            </tr>
                        </tbody>
                    </table>
                    <p>Horario de servicio psicológico (Indicar el horario destinado al servicio)</p>
                    @component('components.text-input', [
                        'title'=>'No. de horas',
                        'field'=>'serv_horas_total',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    <table class="table is-fullwidth">
                        <thead>
                            <tr>
                                <th>Días</th>
                                <th>Horario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" name="serv_l"> Lunes</label></td>
                                <td><input name="serv_hora_l" class="input" type="text" placeholder="Horario lunes"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" name="serv_ma"> Martes</label></td>
                                <td><input name="serv_hora_ma" class="input" type="text" placeholder="Horario martes"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" name="serv_mi"> Miercoles</label></td>
                                <td><input name="serv_hora_mi" class="input" type="text" placeholder="Horario miercoles"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" name="serv_j"> Jueves</label></td>
                                <td><input name="serv_hora_j" class="input" type="text" placeholder="Horario jueves"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" name="serv_v"> Viernes</label></td>
                                <td><input name="serv_hora_v" class="input" type="text" placeholder="Horario viernes"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" name="serv_s"> Sábado</label></td>
                                <td><input name="serv_hora_s" class="input" type="text" placeholder="Horario sabado"></td>
                            </tr>
                        </tbody>
                    </table>
                    @component('components.text-input', [
                        'title'=>'Número de personas atendidas a la semana',
                        'field'=>'pacientes_semana',
                        'errors'=>$errors,
                        'type'=> 'number'
                        ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Cantidad mínima de usuarios que se atenderán en el semestre',
                        'field'=>'minimo_pacientes_semestre',
                        'errors'=>$errors,
                        'type'=> 'number'
                        ])@endcomponent
                    <div class="field">
                        <label class="label">Identifica el tipo de servicio que brinda el programa (puedes marcar más de una opción)</label>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="primer_contacto"> Primer contacto</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="admision"> Admisión</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="evaluacion"> Evaluación</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="orientacion"> Orientación / Consejo breve</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="intervencion"> Intervención</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="egreso"> Egreso</label>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Problemática atendida (puedes marcar más de una opción)</label>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="depresion"> Depresión</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="duelo"> Duelo</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="psicosis"> Psicosis</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="epilepsia"> Epilepsia</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="demencia"> Demencia</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="emocionales_niños"> Trastornos emocionales niños</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="emocionales_ad"> Trastornos emocionales adolescentes</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="conductuales_niños"> Trastornos conductuales niños</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="conductuales_ad"> Trastornos conductuales adolescentes</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="desarrollo_niños"> Trastornos del desarrollo niños</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="desarrollo_ad"> Trastornos del desarrollo adolescentes</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="autolesion"> Autolesión / suicidio</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="ansiedad"> Ansiedad</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="estres"> Estrés</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="sexualidad"> Sexualidad</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="violencia"> Violencia</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="sustancias"> Trastornos por el consumo de sustancias</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="p_intervencion"> Intervención psicoeducativa</label>
                        </div>
                        <div class="control">
                            <input class="input"  type="text" name="otra_problematica" placeholder="Otros"></label>
                        </div>
                    </div>
                    <text-input class="field" inline-template
                        {{ $errors->has('enfoque_servicio') ? ":error=true" : '' }}
                        title="enfoque_servicio">
                        <div>
                        <label class="label">Enfoque del servicio</label>
                        <div class="control">
                            <div class="select">
                                <select name="enfoque_servicio"> {{-- TODO cambiar esto de lugar --}}
                                    <option value="0">Cognitivo-conductual</option>
                                    <option value="1">Conductual</option>
                                    <option value="2">Cognitivo</option>
                                    <option value="3">Sistémico</option>
                                    <option value="4">Psicoinámico</option>
                                    <option value="5">Gestalt</option>
                                    <option value="6">Constructivista</option>
                                    <option value="7">Otro</option>
                                </select>
                            </div>
                        </div>
                        <div class="control">
                            <input class="input"  type="text" name="otro_enfoque" placeholder="Otro"></label>
                        </div>
                        @if ($errors->has('enfoque_servicio'))
                        <p v-if="hasError" class="help is-danger">{{ $errors->first('enfoque_servicio') }}</p>
                        @endif
                        </div>
                    </text-input>
                </div>
            </div>
            <br>
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title is-centered">CARACTERÍSTICAS DE LA SUPERVISIÓN Y EVALUACIÓN</p>
                </header>
                <div class="card-content">
                    <div class="field">
                        <label class="label">Modalidad de supervisión</label>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="individual"> Individual</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="grupal"> Grupal</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="colaborativa"> Colaborativa</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="indirecta"> Indirecta</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="directa"> Directa</label>
                        </div>
                        <div class="control">
                            <input class="input"  type="text" name="supervision_otra" placeholder="Otra (descríbala)"></label>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Estrategias de enseñanza y supervisión</label>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="observacion"> Observación</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="juego_roles"> Juego de roles</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="modelamiento"> Modelamiento</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="moldeamiento"> Moldeamiento</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="cascada"> Cascada o diseminación</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="auto_supervision"> Auto supervisión</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="equipo_reflexivo"> Equipo reflexivo</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="con_colegas"> Supervisión con colegas</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="analisis_caso"> Análisis de caso</label>
                        </div>
                        <div class="control">
                            <input class="input"  type="text" name="ensenanza_otra" placeholder="Otra (descríbala)"></label>
                        </div>
                    </div>
                    @component('components.text-input', [
                        'title'=>'Contenido temático (temas y subtemas)',
                        'field'=>'cont_tematico',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Estrategia de seguimiento y evaluación de impacto del servicio',
                        'field'=>'estra_ev_imp',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    <div class="field">
                        <label class="label">Competencias profesionales a desarrollar</label>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="fundamentales"> Fundamentales</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="entrevista"> Entrevista</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="c_evaluacion"> Evaluación</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="impresion_diagnostica"> Impresión diagnóstica</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="implementacion_intervenciones"> Diseño / Implementación de intervenciones</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="integracion_expediente"> Integración de expediente</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="elaboracion_documentos"> Elaboración de documentos escritos de avances y resultados</label>
                        </div>
                        <div class="control">
                            <input class="input"  type="text" name="competencias_otra" placeholder="Otra (descríbala)"></label>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title is-centered">ACTIVIDADES A TRAVÉS DE LAS CUALES SE ALCANZAN LAS COMPETENCIAS</p>
                </header>
                <div class="card-content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Semana</th>
                                <th>Actividad (indica las actividades que estará realizando el alumno en la semana(s) señaladas)</th>
                                <th>Competencia(s) (qué competencia desarrolla el alumno con la actividad señalada</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @component('components.simple-text', [
                                        'title'=>'Semana',
                                        'field'=>'semana',
                                        'errors'=>$errors,
                                        'type'=> 'text'
                                        ])@endcomponent
                                </td>
                                <td>
                                    @component('components.simple-text', [
                                        'title'=>'Actividad',
                                        'field'=>'actividad',
                                        'errors'=>$errors,
                                        'type'=> 'text'
                                        ])@endcomponent
                                </td>
                                <td>
                                    @component('components.simple-text', [
                                        'title'=>'Competencias',
                                        'field'=>'competencias',
                                        'errors'=>$errors,
                                        'type'=> 'text'
                                        ])@endcomponent
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title is-centered">ESTRATEGIAS DE EVALUACIÓN DE COMPETENCIAS</p>
                </header>
                <div class="card-content">
                    <div class="field">
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="formativa"> Formativa</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="integrativa"> Integrativa</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="contextual"> Contextual comunitaria o institucional</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="holistica"> Holística</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="plural"> Plural e incluyente</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" name="reflexiva"> Reflexiva y con autonomía profesional</label>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-content">
                    <table class="table is-fullwidth">
                        <thead>
                            <tr>
                                <th>Criterios de acreditación</th>
                                <th>¿Cuándo se mide?</th>
                                <th>¿Cómo se mide?</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @component('components.simple-text', [
                                        'title'=>'Criterios de acreditación',
                                        'field'=>'criterios_eva',
                                        'errors'=>$errors,
                                        'type'=> 'text'
                                        ])@endcomponent
                                </td>
                                <td>
                                    @component('components.simple-text', [
                                        'title'=>'¿Cuándo se mide?',
                                        'field'=>'cuando_acreditacion',
                                        'errors'=>$errors,
                                        'type'=> 'text'
                                        ])@endcomponent
                                </td>
                                <td>
                                    @component('components.simple-text', [
                                        'title'=>'¿Cómo se mide?',
                                        'field'=>'como_acreditacion',
                                        'errors'=>$errors,
                                        'type'=> 'text'
                                        ])@endcomponent
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-content">
                    @component('components.area-input', [
                        'title'=>'Referencias',
                        'field'=>'referencias',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                </div>
            </div>
            <br>

            {{-- @foreach ($sections as $section)
            <h2>{{ $section['name'] }}</h2>
            @foreach ($section['fields'] as $title => $field)
            @php $type = $field['type'] @endphp
            @switch($type)
            @case("text")
            @component('components.text-input', compact('title', 'field', 'errors', 'type'))
            @endcomponent
                @break
            @case("date")
            @component('components.text-input', compact('title', 'field', 'errors', 'type'))
            @endcomponent
                @break
            @case("number")
            @component('components.text-input', compact('title', 'field', 'errors', 'type'))
            @endcomponent
                @break
            @case("boolean")
            <div class="field">
                <div class="control">
                    <label class="checkbox">
                    <input type="checkbox" value="1" name="{{ $title }}" {{ old($title)? 'checked' : '' }}>
                    {{ $field['title'] }}
                    </label>
                </div>
            </div>
                @break
            @case("area")
            @component('components.area-input', compact('title', 'field', 'errors'))
            @endcomponent
                @break
            @endswitch
            @endforeach
            @endforeach --}}
            <div class="field">
                <div class="control">
                    <button class="button is-link">Registrar</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection