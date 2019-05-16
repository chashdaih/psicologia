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
            {{ csrf_field() }}
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
                    <label class="label">Supervisor in situ</label>
                    <add-row inline-template>
                        <div>
                            <table class="table is-fullwidth">
                                <tr v-for="row in rows" :key="row">
                                    <td>
                                    <related-input inline-template>
                                        <div>
                                            <div class="control">
                                                <label class="checkbox">
                                                    <input v-model="selected" type="checkbox" value="1">
                                                    Registrar nuevo supervisor
                                                </label>
                                            </div>
                                            <template v-if="selected">
                                                @component('components.text-input', [
                                                    'title'=>'Nombre completo',
                                                    'field'=>'full_name[]',
                                                    'errors'=>$errors,
                                                    'type'=> 'text'
                                                    ])@endcomponent
                                                @component('components.text-input', [
                                                    'title'=>'Adscripción',
                                                    'field'=>'ascription[]',
                                                    'errors'=>$errors,
                                                    'type'=> 'text'
                                                    ])@endcomponent
                                                @component('components.text-input', [
                                                    'title'=>'Nombramiento',
                                                    'field'=>'nomination[]',
                                                    'errors'=>$errors,
                                                    'type'=> 'text'
                                                    ])@endcomponent
                                                @component('components.text-input', [
                                                    'title'=>'Teléfono',
                                                    'field'=>'phone[]',
                                                    'errors'=>$errors,
                                                    'type'=> 'text'
                                                    ])@endcomponent
                                                @component('components.text-input', [
                                                    'title'=>'Celular',
                                                    'field'=>'cellphone[]',
                                                    'errors'=>$errors,
                                                    'type'=> 'text'
                                                    ])@endcomponent
                                                @component('components.text-input', [
                                                    'title'=>'Correo electrónico',
                                                    'field'=>'email[]',
                                                    'errors'=>$errors,
                                                    'type'=> 'email'
                                                    ])@endcomponent
                                                @component('components.text-input', [
                                                    'title'=>'Número de trabajador',
                                                    'field'=>'worker_number[]',
                                                    'errors'=>$errors,
                                                    'type'=> 'number'
                                                    ])@endcomponent
                                            </template>
                                            <template v-else>
                                                <div class="control">
                                                    <div class="select">
                                                        <select name="reg_sup_id[]">
                                                            @foreach ($supervisors as $option)
                                                            <option value="{{ $option->primary_key }}">{{ $option->full_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </related-input>
                                    </td>
                                </tr>
                            </table>
                            <button class="button is-info" type="button" v-on:click="addRow">Añadir otro supervisor in situ</button>
                        </div>
                    </add-row>
                </div>
            </div>
            <br>
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title is-centered">CARACTERÍSTICAS DEL PROGRAMA</p>
                </header>
                <div class="card-content">
                    @component('components.area-input', [
                        'title'=>'Resumen',
                        'field'=>'resumen',
                        'errors'=>$errors,
                        ])@endcomponent
                    @component('components.area-input', [
                        'title'=>'Justificación',
                        'field'=>'justificacion',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    @component('components.area-input', [
                        'title'=>'Objetivo general',
                        'field'=>'objetivo_g',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    @component('components.area-input', [
                        'title'=>'Objetivos específicos',
                        'field'=>'objetivo_es',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    <text-input class="field" inline-template
                        {{ $errors->has('tipo') ? ":error=true" : '' }}
                        title="tipo">
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
                        @if ($errors->has('tipo'))
                        <p v-if="hasError" class="help is-danger">{{ $errors->first('tipo') }}</p>
                        @endif
                        </div>
                    </text-input>
                    <text-input class="field" inline-template
                        {{ $errors->has('periodicidad') ? ":error=true" : '' }}
                        title="periodicidad">
                        <div>
                        <label class="label">Duración del programa (Número de semestres que dura)</label>
                        <div class="control">
                            <div class="select">
                                <select name="periodicidad"> {{-- TODO cambiar esto de lugar --}}
                                    <option value=1>1</option>
                                    <option value=2>2</option>
                                    <option value=3>3</option>
                                    <option value=4>4</option>
                                </select>
                            </div>
                        </div>
                        @if ($errors->has('periodicidad'))
                        <p v-if="hasError" class="help is-danger">{{ $errors->first('periodicidad') }}</p>
                        @endif
                        </div>
                    </text-input>
                    <related-input inline-template>
                        <div>
                            <label class="label">El programa va dirigido a pregrado / posgrado</label>
                            <div class="control">
                                <div class="select">
                                    <select v-model="selected" name="pre_pos"> 
                                        <option value=0>Pregrado</option>
                                        <option value=1>Posgrado</option>
                                    </select>
                                </div>
                            </div>
                            <template v-if="selected == 0">
                            <label class="label">Semestres a los que va dirigido el programa</label>
                            @component('components.check', ['title'=>'5to', 'field'=>'quinto'])@endcomponent
                            @component('components.check', ['title'=>'6to', 'field'=>'sexto'])@endcomponent
                            @component('components.check', ['title'=>'7mo', 'field'=>'septimo'])@endcomponent
                            @component('components.check', ['title'=>'8vo', 'field'=>'octavo'])@endcomponent
                            {{-- <div class="control">
                                <div class="select">
                                    <select name="pre"> 
                                        <option value=5>5to</option>
                                        <option value=6>6to</option>
                                        <option value=7>7mo</option>
                                        <option value=8>8vo</option>
                                    </select>
                                </div>
                            </div> --}}
                            </template>
                            <template v-else>
                            <label class="label">Grados a los que va dirigido el programa</label>
                            @component('components.check', ['title'=>'Especialidad', 'field'=>'especialidad'])@endcomponent
                            @component('components.check', ['title'=>'Maestría', 'field'=>'maestria'])@endcomponent
                            @component('components.check', ['title'=>'Doctorado', 'field'=>'doctorado'])@endcomponent
                            {{-- <div class="control">
                                <div class="select">
                                    <select name="pos"> 
                                        <option value=0>Especialidad</option>
                                        <option value=1>Maestria</option>
                                        <option value=2>Doctorado</option>
                                    </select>
                                </div>
                            </div> --}}
                            </template>
                            <br>
                        </div>
                    </related-input>
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
                    @component('components.area-input', [
                        'title'=>'Requisitos de ingreso al programa',
                        'field'=>'requisitos',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    @component('components.area-input', [
                        'title'=>'Asignaturas académicas del plan curricular 2008 con las cuales empata el programa',
                        'field'=>'asig_emp',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'No. máximo de alumnos',
                        'field'=>'cupo_actual',
                        'errors'=>$errors,
                        'type'=> 'number'
                        ])@endcomponent
                </div>
            </div>
            <br>
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title is-centered">CARACTERÍSTICAS DEL SERVICIO</p>
                </header>
                <div class="card-content">
                    <p class="is-size-4">Horario general del programa (Indicar el horario en el que los alumnos asisten)</p>
                    @component('components.text-input', [
                        'title'=>'No. de horas a la semana',
                        'field'=>'gen_horas_total',
                        'errors'=>$errors,
                        'type'=> 'number'
                        ])@endcomponent
                    <table class="table is-fullwidth">
                        <thead>
                            <tr>
                                <th>Días</th>
                                <th>Horario general del programa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" @if(old('gen_l')) checked @endif value="1" name="gen_l"> Lunes</label></td>
                                <td><input name="gen_hora_l" class="input" type="text" placeholder="Horario lunes"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" @if(old('gen_ma')) checked @endif value="1" name="gen_ma"> Martes</label></td>
                                <td><input name="gen_hora_ma" class="input" type="text" placeholder="Horario martes"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" @if(old('gen_mi')) checked @endif value="1" name="gen_mi"> Miercoles</label></td>
                                <td><input name="gen_hora_mi" class="input" type="text" placeholder="Horario miercoles"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" @if(old('gen_j')) checked @endif value="1" name="gen_j"> Jueves</label></td>
                                <td><input name="gen_hora_j" class="input" type="text" placeholder="Horario jueves"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" @if(old('gen_v')) checked @endif value="1" name="gen_v"> Viernes</label></td>
                                <td><input name="gen_hora_v" class="input" type="text" placeholder="Horario viernes"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" @if(old('gen_s')) checked @endif value="1" name="gen_s"> Sábado</label></td>
                                <td><input name="gen_hora_s" class="input" type="text" placeholder="Horario sabado"></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="is-size-4">Horario de servicio psicológico (Indicar el horario destinado al servicio, en el cual se les realizarán asignaciones de personas que solicitan atención)</p>
                    @component('components.text-input', [
                        'title'=>'No. de horas a la semana',
                        'field'=>'serv_horas_total',
                        'errors'=>$errors,
                        'type'=> 'number'
                        ])@endcomponent
                    <table class="table is-fullwidth">
                        <thead>
                            <tr>
                                <th>Días</th>
                                <th>Horario de servicio psicológico</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" @if(old('serv_l')) checked @endif value="1" name="serv_l"> Lunes</label></td>
                                <td><input name="serv_hora_l" class="input" type="text" placeholder="Horario lunes"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" @if(old('serv_ma')) checked @endif value="1" name="serv_ma"> Martes</label></td>
                                <td><input name="serv_hora_ma" class="input" type="text" placeholder="Horario martes"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" @if(old('serv_mi')) checked @endif value="1" name="serv_mi"> Miercoles</label></td>
                                <td><input name="serv_hora_mi" class="input" type="text" placeholder="Horario miercoles"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" @if(old('serv_j')) checked @endif value="1" name="serv_j"> Jueves</label></td>
                                <td><input name="serv_hora_j" class="input" type="text" placeholder="Horario jueves"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" @if(old('serv_v')) checked @endif value="1" name="serv_v"> Viernes</label></td>
                                <td><input name="serv_hora_v" class="input" type="text" placeholder="Horario viernes"></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" @if(old('serv_s')) checked @endif value="1" name="serv_s"> Sábado</label></td>
                                <td><input name="serv_hora_s" class="input" type="text" placeholder="Horario sabado"></td>
                            </tr>
                        </tbody>
                    </table>
                    @component('components.text-input', [
                        'title'=>'Número de personas atendidas a la semana (Tomando en cuenta el número de personas que puede atender un estudiante por semana)',
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
                            <label class="checkbox"><input type="checkbox" @if(old('primer_contacto')) checked @endif value="1" name="primer_contacto"> Primer contacto</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('admision')) checked @endif value="1" name="admision"> Admisión</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('evaluacion')) checked @endif value="1" name="evaluacion"> Evaluación</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('orientacion')) checked @endif value="1" name="orientacion"> Orientación / Consejo breve</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('intervencion')) checked @endif value="1" name="intervencion"> Intervención</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('egreso')) checked @endif value="1" name="egreso"> Egreso</label>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Problemática atendida (puedes marcar más de una opción)</label>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('depresion')) checked @endif value="1" name="depresion"> Depresión</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('duelo')) checked @endif value="1" name="duelo"> Duelo</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('psicosis')) checked @endif value="1" name="psicosis"> Psicosis</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('epilepsia')) checked @endif value="1" name="epilepsia"> Epilepsia</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('demencia')) checked @endif value="1" name="demencia"> Demencia</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('emocionales_niños')) checked @endif value="1" name="emocionales_niños"> Trastornos emocionales niños</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('emocionales_ad')) checked @endif value="1" name="emocionales_ad"> Trastornos emocionales adolescentes</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('conductuales_niños')) checked @endif value="1" name="conductuales_niños"> Trastornos conductuales niños</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('conductuales_ad')) checked @endif value="1" name="conductuales_ad"> Trastornos conductuales adolescentes</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('desarrollo_niños')) checked @endif value="1" name="desarrollo_niños"> Trastornos del desarrollo niños</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('desarrollo_ad')) checked @endif value="1" name="desarrollo_ad"> Trastornos del desarrollo adolescentes</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('autolesion')) checked @endif value="1" name="autolesion"> Autolesión / suicidio</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('ansiedad')) checked @endif value="1" name="ansiedad"> Ansiedad</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('estres')) checked @endif value="1" name="estres"> Estrés</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('sexualidad')) checked @endif value="1" name="sexualidad"> Sexualidad</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('violencia')) checked @endif value="1" name="violencia"> Violencia</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('sustancias')) checked @endif value="1" name="sustancias"> Trastornos por el consumo de sustancias</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('p_intervencion')) checked @endif value="1" name="p_intervencion"> Intervención psicoeducativa</label>
                        </div>

                        <div class="field is-horizontal is-expanded">
                            <div class="field-label is-normal">
                                <label class="label">Otros</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input class="input"  type="text" name="otra_problematica" placeholder="Otros"></label>
                                    </div>
                                </div>
                            </div>
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
                        {{-- <div class="control">
                            <input class="input"  type="text" name="otro_enfoque" placeholder="Otro"></label>
                        </div> --}}
                        <div class="field is-horizontal is-expanded">
                            <div class="field-label is-normal">
                                <label class="label">Otro</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input class="input"  type="text" name="otro_enfoque" placeholder="Otro"></label>
                                    </div>
                                </div>
                            </div>
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
                    <p class="is-size-4">Modalidad de supervisión</p>
                    <p>(Puede elegir más de una)</p><br>
                    <table class="table">
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('individual')) checked @endif value="1" name="individual"> Individual</label>
                                </div>
                            </td>
                            <td><p>Aquella en la que participan
                                        dos actores: supervisado y supervisor, este tipo de supervisión permite profundizar en 
                                        los aspectos teórico-prácticos del proceso de intervención psicológica, en la relación 
                                        supervisado-usuario y en el impacto del proceso en la persona del supervisado, puede por 
                                        otra parte ser limitada al no tener acceso a otras voces y a una red de apoyo de pares que 
                                        brinden pertenencia y contención.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('grupal')) checked @endif value="1" name="grupal"> Grupal</label>
                                </div>
                            </td>
                            <td><p>Participan un supervisor
                                        y un grupo de supervisados, uno de ellos presenta un caso y el supervisor y el grupo analizan los 
                                        mismos aspectos citados en la modalidad individual, con la diferencia de que todo el grupo participa
                                         y enriquece la visión del proceso psicológico, éste es un proceso recursivo en el que también el grupo
                                          se beneficia, permite también que un número mayor de personas se capaciten.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('colaborativa')) checked @endif value="1" name="colaborativa"> Colaborativa</label>
                                </div>
                            </td>
                            <td><p>La supervisión se brinda
                                        en colaboración con otras personas, ya sean los responsables de las instituciones en las cuales se
                                         desarrollan las prácticas profesionales (por ejemplo, los docentes de una escuela); por otras personas
                                          de la comunidad (por ejemplo, los padres y las madres de familia que llevan a sus hijos a los talleres
                                           que se brindan en los Centros de Servicios de la Facultad de Psicología.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('indirecta')) checked @endif value="1" name="indirecta"> Indirecta</label>
                                </div>
                            </td>
                            <td><p>Se realiza después de la intervención, incluye varias submodalidades: narrada, 
                                presentación del caso en video o audiograbación.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('directa')) checked @endif value="1" name="directa"> Directa</label>
                                </div>
                            </td>
                            <td><p>Es la que se desarrolla durante la sesión
                                    de intervención bajo la coordinación de un supervisor (Ceberio & Linares, 2006). En general, las sesiones se dividen
                                     en 3 fases: pre-sesión, sesión (algunos modelos incluyen una inter- sesión) y postsesión.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label">Otra (descríbala)</label>
                                </div>
                            </td>
                            <td>
                                <input class="input"  type="text" name="supervision_otra" placeholder="Otra (descríbala)"></label>
                            </td>
                        </tr>
                    </table>
                    <p class="is-size-4">Estrategias de enseñanza y supervisión</p>
                    <p>(Puede elegir más de una)</p><br>
                    <table class="table">
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('observacion')) checked @endif value="1" name="observacion"> Observación</label>
                                </div>
                            </td>
                            <td><p>Los supervisados en forma directa o a través de una videograbación observan a un experto y 
                                apoyados en una “guía de observación” hacen sus reportes.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('juego_roles')) checked @endif value="1" name="juego_roles"> Juego de roles</label>
                                </div>
                            </td>
                            <td><p>Uno de los estudiantes actúa
                                    como psicólogo responsable de la intervención y el o los otros como usuario(s). En esta estrategia, 
                                    se presenta un caso o situación, el supervisado-responsable de la intervención y el supervisado-usuario 
                                    “actúan” y llevan a cabo la sesión, el grupo permanece como observador. Al finalizar se retroalimenta al 
                                    supervisado-psicólogo en formación, enfatizando las fortalezas y detallando los aspectos a mejorar.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('modelamiento')) checked @endif value="1" name="modelamiento"> Modelamiento</label>
                                </div>
                            </td>
                            <td><p>En el modelaje, el supervisor lleva a 
                                    cabo la intervención para que el supervisado pueda observarla y después llevarla a cabo. La ventaja en esta 
                                    estrategia es que el supervisado puede ver casos o situaciones reales e intervenciones en problemáticas 
                                    específicas.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('moldeamiento')) checked @endif value="1" name="moldeamiento"> Moldeamiento</label>
                                </div>
                            </td>
                            <td><p>El supervisado interviene directamente, 
                                    supervisor y grupo analizan directa o indirectamente la sesión y retroalimentan al supervisado. Los estudiantes 
                                    que reciben entrenamiento pueden experimentar momentos de angustia, falta de seguridad o conflictos entre su autonomía 
                                    y la obediencia. Por lo tanto, la creación de una atmósfera de confianza y seguridad, sustentada en el apoyo del 
                                    supervisor y el grupo es fundamental para su aprendizaje y para el éxito de la intervención.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('cascada')) checked @endif value="1" name="cascada"> Cascada</label>
                                </div>
                            </td>
                            <td><p>(experto/novato). 
                                    En esta estrategia los novatos observan a un experto, que es de diferente nivel académico. 
                                    En el grupo de observación hay también expertos, al finalizar la sesión ambos entregan y comparten diferentes 
                                    reflexiones acerca del trabajo. Esta práctica hace que ambos niveles expertos y novatos se beneficien de la 
                                    experiencia, a los expertos les da la oportunidad de compartir las destrezas que han adquirido y de escuchar 
                                    voces diferentes y en algún sentido más “frescas”. A los novatos les puede dar la confianza de compartir sus 
                                    puntos de vista y la certeza de que las habilidades se aprenden. Otro aspecto a considerar es la optimización 
                                    de los recursos humanos en una institución.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('auto_supervision')) checked @endif value="1" name="auto_supervision"> Auto supervisión</label>
                                </div>
                            </td>
                            <td><p>Esta estrategia es útil cuando no
                                    sea posible que supervisor y supervisado tengan contacto frecuente y en el que este último haya alcanzado un grado 
                                    de experiencia y autonomía que le permita recorrer la mayor parte del camino en forma independiente. Para realizar 
                                    la autosupervisión se utiliza con frecuencia la videograbación, para observarse a sí mismo en el contexto de la 
                                    intervención y analizar las técnicas, maniobras, lenguaje verbal y no verbal de él mismo y de los usuarios. De tal 
                                    manera que le permitan focalizar el problema y planear futuras intervenciones. Tiene también la ventaja de que 
                                    optimiza los encuentros con el supervisor centrándose en aquellos aspectos problemáticos del proceso.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('equipo_reflexivo')) checked @endif value="1" name="equipo_reflexivo"> Equipo reflexivo</label>
                                </div>
                            </td>
                            <td><p>Esta estrategia tiene como base 
                                    teórica un enfoque posmoderno, en el que se considera al lenguaje como construcción social (Gergen, 1996), 
                                    donde cada diálogo es una co-construcción entre el supervisor y sus supervisados, ambos participan y se transforman
                                     en el proceso, construyendo nuevos significados, una nueva narración de la experiencia.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('con_colegas')) checked @endif value="1" name="con_colegas"> Supervisión con colegas</label>
                                </div>
                            </td>
                            <td><p>Esta estrategia, se ha dado 
                                    principalmente en el ámbito institucional, en el que se acostumbran las sesiones de supervisión de forma abierta 
                                    entre colegas. En este sentido, la supervisión entre colegas se caracteriza porque el supervisado puede aceptar o 
                                    rechazar las sugerencias hechas por los otros compañeros, pues en ocasiones los puntos de vista pueden ser divergentes
                                     o parecer inadecuados. Benshoff (1994, citado por López, 1998), señala que esta supervisión puede ser sumamente 
                                     beneficiosa debido a que: en principio disminuye la dependencia hacia el llamado “experto” y propicia una relación
                                      más abierta entre iguales, en el supervisado se pueden promover la autoconfianza e independencia, puede también 
                                      elegir al colega de mayor confianza para compartir sus propias dudas.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('analisis_caso')) checked @endif value="1" name="analisis_caso"> Análisis de caso</label>
                                </div>
                            </td>
                            <td><p>En esta estrategia la 
                                    herramienta básica es el expediente psicológico o portafolio. Con la ayuda del supervisor, el(los) supervisado(s), 
                                    revisan todos los elementos del expediente: datos sociodemográficos, entrevista inicial, historia clínica, 
                                    pruebas aplicadas, resúmenes de evaluación, etc. Se revisa y discute la bibliografía propuesta y se elabora 
                                    un plan de trabajo con objetivos, técnicas y duración específica.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label">Otra (descríbala)</label>
                                </div>
                            </td>
                            <td>
                                <input class="input"  type="text" name="ensenanza_otra" placeholder="Otra (descríbala)"></label>
                            </td>
                        </tr>
                    </table>
                    @component('components.area-input', [
                        'title'=>'Contenido temático (temas y subtemas)',
                        'field'=>'cont_tematico',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    @component('components.area-input', [
                        'title'=>'Estrategia de seguimiento y evaluación de impacto del servicio',
                        'field'=>'estra_ev_imp',
                        'errors'=>$errors,
                        'type'=> 'text'
                        ])@endcomponent
                    <div class="field">
                        <label class="label">Competencias profesionales a desarrollar</label>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('fundamentales')) checked @endif value="1" name="fundamentales"> Fundamentales</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('entrevista')) checked @endif value="1" name="entrevista"> Entrevista</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('c_evaluacion')) checked @endif value="1" name="c_evaluacion"> Evaluación</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('impresion_diagnostica')) checked @endif value="1" name="impresion_diagnostica"> Impresión diagnóstica</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('implementacion_intervenciones')) checked @endif value="1" name="implementacion_intervenciones"> Diseño / Implementación de intervenciones</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('integracion_expediente')) checked @endif value="1" name="integracion_expediente"> Integración de expediente</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('elaboracion_documentos')) checked @endif value="1" name="elaboracion_documentos"> Elaboración de documentos escritos de avances y resultados</label>
                        </div>
                        {{-- <div class="control">
                            <input class="input"  type="text" name="competencias_otra" placeholder="Otra (descríbala)"></label>
                        </div> --}}
                        <div class="field is-horizontal is-expanded">
                            <div class="field-label is-normal">
                                <label class="label">Otra</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input class="input"  type="text" name="competencias_otra" placeholder="Otra (descríbala)"></label>
                                    </div>
                                </div>
                            </div>
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
                    <add-row inline-template>
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Semana</th>
                                        <th>Actividad (indica las actividades que estará realizando el alumno en la semana(s) señaladas)</th>
                                        <th>Competencia(s) (qué competencia desarrolla el alumno con la actividad señalada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="row in rows" :key="row">
                                        <td>
                                            @component('components.simple-text', [
                                                'title'=>'Semana',
                                                'field'=>'semana[]',
                                                'errors'=>$errors,
                                                'type'=> 'text'
                                                ])@endcomponent
                                        </td>
                                        <td>
                                            @component('components.simple-text', [
                                                'title'=>'Actividad',
                                                'field'=>'actividad[]',
                                                'errors'=>$errors,
                                                'type'=> 'text'
                                                ])@endcomponent
                                        </td>
                                        <td>
                                            @component('components.simple-text', [
                                                'title'=>'Competencias',
                                                'field'=>'competencias[]',
                                                'errors'=>$errors,
                                                'type'=> 'text'
                                                ])@endcomponent
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="button is-info" type="button" v-on:click="addRow">Añadir semana</button>
                        </div>
                    </add-row>
                </div>
            </div>
            <br>
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title is-centered">ESTRATEGIAS DE EVALUACIÓN DE COMPETENCIAS</p>
                </header>
                <div class="card-content">
                    <table class="table">
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('formativa')) checked @endif value="1" name="formativa"> Formativa</label>
                                </div>
                            </td>
                            <td><p>Ya que se dirige al desarrollo de competencias profesionales desde la licenciatura y hasta el posgrado.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('integrativa')) checked @endif value="1" name="integrativa"> Integrativa</label>
                                </div>
                            </td>
                            <td><p>Al considerar las diferentes aproximaciones teóricas para la evaluación, intervención e investigación psicológicas y la necesidad de integrar estrategias y recursos que conduzcan a la optimización del proceso de supervisión.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('contextual')) checked @endif value="1" name="contextual"> Contextual comunitaria o institucional</label>
                                </div>
                            </td>
                            <td><p>Ya que considera el ámbito comunitario o institucional, destacando que además de la formación teórico-técnica los estudiantes deben conocer métodos de investigación, acercamiento e inserción comunitaria para trabajar directamente con su población, o bien, para atender a la población que enfocada como comunidad, se constituye por las usuarias de diferentes instituciones de salud, educativas o sociales.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('holistica')) checked @endif value="1" name="holistica"> Holística</label>
                                </div>
                            </td>
                            <td><p>En cuanto considerar una concepción integral bio-psico-socio-cultural del ser humano aplicable a la concepción de salud en general y salud mental en particular.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('plural')) checked @endif value="1" name="plural"> Plural e incluyente</label>
                                </div>
                            </td>
                            <td><p>Para reconocer la complejidad y diversidad de los usuarios y de las necesidades de atención psicológica desde una perspectiva de equidad, procurando en todo momento la inclusión de todos los casos que pueden ser atendidos, pero la cual habrá de regirse por criterios de competencia para su manejo o, cuando sea necesario, saber cuándo y en qué forma hacer la derivación o referencia institucional de los mismos.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('reflexiva')) checked @endif value="1" name="reflexiva"> Reflexiva y con autonomía profesional</label>
                                </div>
                            </td>
                            <td><p>Planteando que la formación profesional del psicólogo integra varios momentos y espacios de reflexión que se refieren al análisis sobre el caudal de conocimientos adquiridos, sobre la acción para y durante su puesta en práctica y sobre todo, para la reflexión durante la acción recíproca de la supervisión.</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-content">
                    <add-row inline-template>
                        <div>
                            <table class="table is-fullwidth">
                                <thead>
                                    <tr>
                                        <th>Criterios de acreditación</th>
                                        <th>¿Cuándo se mide?</th>
                                        <th>¿Cómo se mide?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="row in rows" :key="row">
                                        <td>
                                            @component('components.simple-text', [
                                                'title'=>'Criterios de acreditación',
                                                'field'=>'criterio[]',
                                                'errors'=>$errors,
                                                'type'=> 'text'
                                                ])@endcomponent
                                        </td>
                                        <td>
                                            @component('components.simple-text', [
                                                'title'=>'¿Cuándo se mide?',
                                                'field'=>'cuando[]',
                                                'errors'=>$errors,
                                                'type'=> 'text'
                                                ])@endcomponent
                                        </td>
                                        <td>
                                            @component('components.simple-text', [
                                                'title'=>'¿Cómo se mide?',
                                                'field'=>'como[]',
                                                'errors'=>$errors,
                                                'type'=> 'text'
                                                ])@endcomponent
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="button is-info" type="button" v-on:click="addRow">Añadir criterio</button>
                        </div>
                    </add-row>
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
            <div class="field">
                <div class="control">
                    <button class="button is-link">Registrar</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection