@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        {{-- @include('layouts.breadcrumbs') --}}
        <h1 class="title">{{ $bread->last()['title'] }}</h1>
        @if(!isset($program))
        <div class="notification is-info">
            <p>Solo el campo 'Nombre del programa' es requerido para poder guardar.</p>
            <p>Si lo deseas, puedes llenar una parte ahora y regresar a editarlo después.</p>
            <p>*El programa no se ofertará hasta que se llene el campo 'No. máximo de alumnos'*</p>
        </div>
        @endif
        {{-- @if ($errors->any())
        <div class="notification is-danger">
            <p>El formulario contiene errores:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif --}}
        <form method="POST" 
        action="{{ isset($program) ? route($doc_code.'.update', [$program->id_practica]) : route($doc_code.'.store') }}"
        >
            @if(isset($program)) <input name="_method" type="hidden" value="PUT"> @endif
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
                        'type'=> 'text',
                        'prev' => isset($program) ? $program->programa : null,
                        'maxlength' => 250,
                        'required' => true
                        ])@endcomponent
                    {{-- @if (Auth::user()->type == 6 || Auth::user()->supervisor->id_centro == 10) --}}
                    @component('components.select', [
                        'title'=>'Centro al cual pertenece el programa',
                        'field'=>'id_centro',
                        'errors'=>$errors,
                        'options'=> $buildings,
                        'prev' => isset($program) ? $program->id_centro : null,
                        'id' => old('id_centro', Auth::user()->supervisor->id_centro)
                        ])@endcomponent

                    <add-row inline-template :sups=0 @isset($extraCenters) :old={{ count($extraCenters) }} @endisset >
                    <div>
                        
                        @if(isset($extraCenters))
                        @foreach ($extraCenters as $key => $extraCenter)
                        <template  v-if="visible[{{ $key }}]">

                        <input type="hidden" name="extracenterid[]" value={{$extraCenter->id}} >

                            @component('components.select', [
                                'title'=>'Centro adicional',
                                'field'=>'extracenter[]',
                                'errors'=>$errors,
                                'options'=> $buildings,
                                'prev' => $extraCenter->center_id
                                ])@endcomponent

                            <button class="button is-danger is-outlined is-small" type="button" :id={{ $key }}
                            @click="deleteOld('{{ route('del_row', ['center', $extraCenter->id]) }}')"
                            >Borrar</button>
                            <br><br>
                        </template>
                        @endforeach
                        @endif

                        <div v-for="row in rows" :key="row">
                            @component('components.select', [
                                'title'=>'Centro adicional',
                                'field'=>'extracenter[]',
                                'options'=> $buildings,
                                ])@endcomponent
                            <button v-if="row==rows && rows>sups" 
                                class="button is-danger is-outlined is-small"
                                type="button" @click="deleteRow(row)">
                                Borrar centro adicional
                            </button>
                            <br><br>
                        </div>

                        <button class="button is-info is-small" type="button" v-on:click="addRow">Añadir otro centro</button>
                        <br><br>
                    </div>
                    </add-row>
                    {{-- @else
                    <input name="id_centro" type="hidden" value={{  Auth::user()->supervisor->id_centro }}>
                    @endif --}}
                    <div class="field">
                        <div class="label">Semestre en el que inicia el programa</div>
                        <div class="control">
                            <div class="select">
                                <select name="semestre_activo">
                                    @foreach (Config::get('globales.semestres') as $sem)
                                        <option value="{{$sem}}"
                                            @if ($sem == old('semestre_activo', isset($program)?$program->semestre_activo:Config::get('globales.semestre_activo')) )
                                            selected="selected"
                                            @endif
                                            >{{$sem}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title is-centered">SUPERVISORES</p>
                </header>
                <div class="card-content">
                    {{-- @if(Auth::user()->type != 2) --}}

                    {{-- @component('components.select', [
                        'title'=>'Supervisor académico',
                        'field'=>'id_supervisor',
                        'errors'=>$errors,
                        'options'=> $supervisors,
                        'prev' => isset($program) ? $program->id_supervisor : null,
                        'id' => $user_id,
                        'disabled' => Auth::user()->type == 2 ? true : false
                        ])@endcomponent --}}

                    <sups-auto field="id_supervisor"
                        :sups="{{$supervisors}}"
                        :user="{{old('id_supervisor', isset($program)?$program->id_supervisor:Auth::user()->supervisor->id_supervisor)}}"
                        @if(Auth::user()->type == "2")
                        dis=true
                        @endif
                    ></sups-auto>

                    {{-- @else
                    <input name="id_supervisor" type="hidden" value={{  Auth::user()->supervisor->id_supervisor }}>
                    @endif --}}
                    <label class="label">Supervisor in situ</label>
                    <add-row inline-template
                    @if(isset($sups))
                        :sups=0
                        :old={{ count($sups) }}
                    @endif
                    >
                        <div>
                            <table class="table is-fullwidth">
                                @if(isset($sups))
                                @foreach ($sups as $key => $sup)
                                <template  v-if="visible[{{ $key }}]">
                                <tr>
                                    @component('components.insitu-row', [
                                        'supervisors' => $supervisors,
                                        'user_id' => $user_id,
                                        'data' => $sup,
                                        'errors'=> $errors
                                    ])@endcomponent
                                    <td>
                                        <button class="button is-danger is-outlined" type="button"
                                        :id={{ $key }}
                                        @click="deleteOld('{{ route('del_row', ['sup', $sup->id]) }}')"
                                        >Borrar</button>
                                    </td>
                                </tr>
                                </template>
                                @endforeach
                                @endif
                                <tr v-for="row in rows" :key="row">
                                    @component('components.insitu-row', [
                                        'supervisors' => $supervisors,
                                        'user_id' => $user_id,
                                        'errors'=> $errors
                                    ])@endcomponent
                                    <td>
                                        <button v-if="row==rows && rows>sups" 
                                            class="button is-danger is-outlined"
                                            type="button" @click="deleteRow(row)">
                                            Borrar renglón
                                        </button>
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
                        'prev'=> isset($inf_prac) ? $inf_prac->resumen : null
                        ])@endcomponent
                    @component('components.area-input', [
                        'title'=>'Justificación',
                        'field'=>'justificacion',
                        'errors'=>$errors,
                        'prev'=> isset($inf_prac) ? $inf_prac->justificacion : null
                        ])@endcomponent
                    @component('components.area-input', [
                        'title'=>'Objetivo general',
                        'field'=>'objetivo_g',
                        'errors'=>$errors,
                        'prev'=> isset($inf_prac) ? $inf_prac->objetivo_g : null
                        ])@endcomponent
                    @component('components.area-input', [
                        'title'=>'Objetivos específicos',
                        'field'=>'objetivo_es',
                        'errors'=>$errors,
                        'prev'=> isset($inf_prac) ? $inf_prac->objetivo_es : null
                        ])@endcomponent
                    <text-input class="field" inline-template
                        {{ $errors->has('tipo') ? ":error=true" : '' }}
                        title="tipo">
                        <div>
                        <label class="label">Curricular / Extracurricular</label>
                        <div class="control">
                            <div class="select">
                                <select name="tipo"> {{-- TODO cambiar esto de lugar --}}
                                    <option value="CURRICULAR"
                                     @if(old('tipo', isset($program)?$program->tipo:null) == "CURRICULAR") selected @endif 
                                     >Curricular</option>
                                    <option value="EXTRACURRICULAR"
                                    @if(old('tipo', isset($program)?$program->tipo:null) == "EXTRACURRICULAR") selected="selected" @endif
                                    >Extracurricular</option>
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
                                    <option value=1
                                    @if(old('periodicidad', isset($program)?$program->periodicidad:null) == 1) selected="selected" @endif
                                    >1</option>
                                    <option value=2
                                    @if(old('periodicidad', isset($program)?$program->periodicidad:null) == 2) selected="selected" @endif
                                    >2</option>
                                    <option value=3
                                    @if(old('periodicidad', isset($program)?$program->periodicidad:null) == 3) selected="selected" @endif
                                    >3</option>
                                    <option value=4
                                    @if(old('periodicidad', isset($program)?$program->periodicidad:null) == 4) selected="selected" @endif
                                    >4</option>
                                </select>
                            </div>
                        </div>
                        @if ($errors->has('periodicidad'))
                        <p v-if="hasError" class="help is-danger">{{ $errors->first('periodicidad') }}</p>
                        @endif
                        </div>
                    </text-input>
                    <related-input inline-template
                    @if(old('pre_pos', isset($car_serv)?$car_serv->pre_pos:null) == '1')
                    :old-value="1"
                    @endif
                    >
                        <div>
                            <label class="label">El programa va dirigido a pregrado / posgrado</label>
                            <div class="control">
                                <div class="select">
                                    <select v-model="selected" name="pre_pos"> 
                                        <option value=0>Pregrado</option>
                                        <option value=1
                                        @if(old('pre_pos', isset($car_serv)?$car_serv->pre_pos:null) == '1')
                                        selected="selected"
                                        @endif
                                        >Posgrado</option>
                                    </select>
                                </div>
                            </div>
                            <template v-if="selected == 0">
                            <label class="label">Semestres a los que va dirigido el programa</label>
                            @component('components.check', ['title'=>'5to', 'field'=>'quinto', 'prev' => isset($car_serv)?$car_serv->quinto:null])@endcomponent
                            @component('components.check', ['title'=>'6to', 'field'=>'sexto', 'prev' => isset($car_serv)?$car_serv->sexto:null])@endcomponent
                            @component('components.check', ['title'=>'7mo', 'field'=>'septimo', 'prev' => isset($car_serv)?$car_serv->septimo:null])@endcomponent
                            @component('components.check', ['title'=>'8vo', 'field'=>'octavo', 'prev' => isset($car_serv)?$car_serv->octavo:null])@endcomponent
                            </template>
                            <template v-else>
                            <label class="label">Grados a los que va dirigido el programa</label>
                            @component('components.check', ['title'=>'Especialidad', 'field'=>'especialidad', 'prev' => isset($car_serv)?$car_serv->especialidad:null])@endcomponent
                            @component('components.check', ['title'=>'Maestría', 'field'=>'maestria', 'prev' => isset($car_serv)?$car_serv->maestria:null])@endcomponent
                            @component('components.check', ['title'=>'Doctorado', 'field'=>'doctorado', 'prev' => isset($car_serv)?$car_serv->doctorado:null])@endcomponent
                            </template>
                            <br>
                        </div>
                    </related-input>
                    <date-component
                        label="Fecha de inicio"
                        name="fecha_inicio"
                        old=@if(old('fecha_inicio')) {{old('fecha_inicio')}} @elseif(isset($car_serv)){{ $car_serv->fecha_inicio ? $car_serv->fecha_inicio->format('Y-m-d') : null }} @else {{null}} @endif
                        ></date-component>
                        <date-component
                            label="Fecha de término"
                            name="fecha_fin"
                            old=@if(old('fecha_fin')) {{old('fecha_fin')}} @elseif(isset($car_serv)){{ $car_serv->fecha_fin ? $car_serv->fecha_fin->format('Y-m-d') : null }} @else {{null}} @endif
                        ></date-component>
                    {{-- @component('components.text-input', [
                        'title'=>'Fecha de inicio',
                        'field'=>'fecha_inicio',
                        'errors'=>$errors,
                        'type'=> 'date',
                        'prev'=> isset($car_serv) ? $car_serv->fecha_inicio : null
                        ])@endcomponent --}}
                    {{-- @component('components.text-input', [
                        'title'=>'Fecha de término',
                        'field'=>'fecha_fin',
                        'errors'=>$errors,
                        'type'=> 'date',
                        'prev'=> isset($car_serv) ? $car_serv->fecha_fin : null
                        ])@endcomponent --}}
                    @component('components.area-input', [
                        'title'=>'Requisitos de ingreso al programa',
                        'field'=>'requisitos',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev'=> isset($inf_prac) ? $inf_prac->requisitos : null
                        ])@endcomponent
                    @component('components.area-input', [
                        'title'=>'Asignaturas académicas del plan curricular 2008 con las cuales empata el programa',
                        'field'=>'asig_emp',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev'=> isset($inf_prac) ? $inf_prac->asig_emp : null
                        ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'No. máximo de alumnos',
                        'field'=>'cupo',
                        'errors'=>$errors,
                        'type'=> 'number',
                        'prev'=> isset($program) ? $program->cupo : null
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
                        'type'=> 'number',
                        'prev'=> isset($car_serv) ? $car_serv->gen_horas_total : null
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
                                <td><label class="checkbox"><input type="checkbox" 
                                    @if(old('gen_l', isset($car_serv)?$car_serv->gen_l:null)) checked @endif value="1" name="gen_l"
                                     > Lunes</label></td>
                                <td><input value="{{ old('gen_hora_l', isset($car_serv)?$car_serv->gen_hora_l:null) }}"
                                    name="gen_hora_l" class="input" type="text" placeholder="Horario lunes" maxlength=255></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox"
                                     @if(old('gen_ma', isset($car_serv)?$car_serv->gen_ma:null)) checked @endif value="1" name="gen_ma"
                                     > Martes</label></td>
                                <td><input value="{{ old('gen_hora_ma', isset($car_serv)?$car_serv->gen_hora_ma:null) }}"
                                    name="gen_hora_ma" class="input" type="text" placeholder="Horario martes" maxlength=255></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" 
                                    @if(old('gen_mi', isset($car_serv)?$car_serv->gen_mi:null)) checked @endif value="1" name="gen_mi"
                                    > Miercoles</label></td>
                                <td><input value="{{ old('gen_hora_mi', isset($car_serv)?$car_serv->gen_hora_mi:null) }}"
                                    name="gen_hora_mi" class="input" type="text" placeholder="Horario miercoles" maxlength=255></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" 
                                    @if(old('gen_j', isset($car_serv)?$car_serv->gen_j:null)) checked @endif value="1" name="gen_j"
                                    > Jueves</label></td>
                                <td><input value="{{ old('gen_hora_j', isset($car_serv)?$car_serv->gen_hora_j:null) }}"
                                    name="gen_hora_j" class="input" type="text" placeholder="Horario jueves" maxlength=255></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox"
                                     @if(old('gen_v', isset($car_serv)?$car_serv->gen_v:null)) checked @endif value="1" name="gen_v"
                                     > Viernes</label></td>
                                <td><input value="{{ old('gen_hora_v', isset($car_serv)?$car_serv->gen_hora_v:null) }}"
                                    name="gen_hora_v" class="input" type="text" placeholder="Horario viernes" maxlength=255></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" 
                                    @if(old('gen_s', isset($car_serv)?$car_serv->gen_s:null)) checked @endif value="1" name="gen_s"
                                    > Sábado</label></td>
                                <td><input value="{{ old('gen_hora_s', isset($car_serv)?$car_serv->gen_hora_s:null) }}"
                                    name="gen_hora_s" class="input" type="text" placeholder="Horario sabado" maxlength=255></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="is-size-4">Horario de servicio psicológico (Indicar el horario destinado al servicio, en el cual se les realizarán asignaciones de personas que solicitan atención)</p>
                    @component('components.text-input', [
                        'title'=>'No. de horas a la semana',
                        'field'=>'serv_horas_total',
                        'errors'=>$errors,
                        'type'=> 'number',
                        'prev'=> isset($car_serv) ? $car_serv->serv_horas_total : null
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
                                <td><label class="checkbox"><input type="checkbox" 
                                    @if(old('serv_l', isset($car_serv)?$car_serv->serv_l:null)) checked @endif value="1" name="serv_l"
                                    > Lunes</label></td>
                                <td><input value="{{ old('serv_hora_l', isset($car_serv)?$car_serv->serv_hora_l:null) }}"
                                    name="serv_hora_l" class="input" type="text" placeholder="Horario lunes" maxlength=255></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" 
                                    @if(old('serv_ma', isset($car_serv)?$car_serv->serv_ma:null)) checked @endif value="1" name="serv_ma"
                                    > Martes</label></td>
                                <td><input value="{{ old('serv_hora_ma', isset($car_serv)?$car_serv->serv_hora_ma:null) }}"
                                    name="serv_hora_ma" class="input" type="text" placeholder="Horario martes" maxlength=255></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" 
                                    @if(old('serv_mi', isset($car_serv)?$car_serv->serv_mi:null)) checked @endif value="1" name="serv_mi"
                                    > Miercoles</label></td>
                                <td><input value="{{ old('serv_hola_mi', isset($car_serv)?$car_serv->serv_hora_mi:null) }}"
                                    name="serv_hora_mi" class="input" type="text" placeholder="Horario miercoles" maxlength=255></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox"
                                     @if(old('serv_j', isset($car_serv)?$car_serv->serv_j:null)) checked @endif value="1" name="serv_j"
                                     > Jueves</label></td>
                                <td><input value="{{ old('serv_hora_j', isset($car_serv)?$car_serv->serv_hora_j:null) }}"
                                    name="serv_hora_j" class="input" type="text" placeholder="Horario jueves" maxlength=255></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox"
                                     @if(old('serv_v', isset($car_serv)?$car_serv->serv_v:null)) checked @endif value="1" name="serv_v"
                                     > Viernes</label></td>
                                <td><input value="{{ old('serv_hora_v', isset($car_serv)?$car_serv->serv_hora_v:null) }}"
                                    name="serv_hora_v" class="input" type="text" placeholder="Horario viernes" maxlength=255></td>
                            </tr>
                            <tr>
                                <td><label class="checkbox"><input type="checkbox" 
                                    @if(old('serv_s', isset($car_serv)?$car_serv->serv_s:null)) checked @endif value="1" name="serv_s"
                                    > Sábado</label></td>
                                <td><input value="{{ old('serv_hora_s', isset($car_serv)?$car_serv->serv_hora_s:null) }}"
                                    name="serv_hora_s" class="input" type="text" placeholder="Horario sabado" maxlength=255></td>
                            </tr>
                        </tbody>
                    </table>
                    @component('components.text-input', [
                        'title'=>'Número de personas atendidas a la semana (Tomando en cuenta el número de personas que puede atender un estudiante por semana)',
                        'field'=>'pacientes_semana',
                        'errors'=>$errors,
                        'type'=> 'number',
                        'prev'=> isset($car_serv) ? $car_serv->pacientes_semana : null
                        ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Cantidad mínima de usuarios que se atenderán en el semestre',
                        'field'=>'minimo_pacientes_semestre',
                        'errors'=>$errors,
                        'type'=> 'number',
                        'prev'=> isset($car_serv) ? $car_serv->minimo_pacientes_semestre : null
                        ])@endcomponent
                    <div class="field">
                        <label class="label">Identifica el tipo de servicio que brinda el programa (puedes marcar más de una opción)</label>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('primer_contacto', isset($car_serv)?$car_serv->primer_contacto:null)) checked @endif value="1" name="primer_contacto"> Primer contacto</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('admision', isset($car_serv)?$car_serv->admision:null)) checked @endif value="1" name="admision"> Admisión</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('evaluacion', isset($car_serv)?$car_serv->evaluacion:null)) checked @endif value="1" name="evaluacion"> Evaluación</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('orientacion', isset($car_serv)?$car_serv->orientacion:null)) checked @endif value="1" name="orientacion"> Orientación / Consejo breve</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('intervencion', isset($car_serv)?$car_serv->intervencion:null)) checked @endif value="1" name="intervencion"> Intervención</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('egreso', isset($car_serv)?$car_serv->egreso:null)) checked @endif value="1" name="egreso"> Egreso</label>
                        </div>
                        <div class="field is-horizontal is-expanded">
                            <div class="field-label is-normal">
                                <label class="label">Otros</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" value="{{ old('otra_problematica', isset($car_serv)?$car_serv->otro_servicio:null) }}"
                                            type="text" name="otro_servicio" placeholder="Otros" maxlength=255></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Problemática atendida (puedes marcar más de una opción)</label>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('depresion', isset($car_serv)?$car_serv->depresion:null)) checked @endif value="1" name="depresion"> Depresión</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('duelo', isset($car_serv)?$car_serv->duelo:null)) checked @endif value="1" name="duelo"> Duelo</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('psicosis', isset($car_serv)?$car_serv->psicosis:null)) checked @endif value="1" name="psicosis"> Psicosis</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('epilepsia', isset($car_serv)?$car_serv->epilepsia:null)) checked @endif value="1" name="epilepsia"> Epilepsia</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('demencia', isset($car_serv)?$car_serv->demencia:null)) checked @endif value="1" name="demencia"> Demencia</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('emocionales_niños', isset($car_serv)?$car_serv->emocionales_niños:null)) checked @endif value="1" name="emocionales_niños"> Trastornos emocionales niños</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('emocionales_ad', isset($car_serv)?$car_serv->emocionales_ad:null)) checked @endif value="1" name="emocionales_ad"> Trastornos emocionales adolescentes</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('conductuales_niños', isset($car_serv)?$car_serv->conductuales_niños:null)) checked @endif value="1" name="conductuales_niños"> Trastornos conductuales niños</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('conductuales_ad', isset($car_serv)?$car_serv->conductuales_ad:null)) checked @endif value="1" name="conductuales_ad"> Trastornos conductuales adolescentes</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('desarrollo_niños', isset($car_serv)?$car_serv->desarrollo_niños:null)) checked @endif value="1" name="desarrollo_niños"> Trastornos del desarrollo niños</label>
                        </div>
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" 
                                @if(old('desarrollo_ad', isset($car_serv)?$car_serv->desarrollo_ad:null)) 
                                checked 
                                @endif 
                                value="1" 
                                name="desarrollo_ad"> Trastornos del desarrollo adolescentes</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('autolesion', isset($car_serv)?$car_serv->autolesion:null)) checked @endif value="1" name="autolesion"> Autolesión / suicidio</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('ansiedad', isset($car_serv)?$car_serv->ansiedad:null)) checked @endif value="1" name="ansiedad"> Ansiedad</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('estres', isset($car_serv)?$car_serv->estres:null)) checked @endif value="1" name="estres"> Estrés</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('sexualidad', isset($car_serv)?$car_serv->sexualidad:null)) checked @endif value="1" name="sexualidad"> Sexualidad</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('violencia', isset($car_serv)?$car_serv->violencia:null)) checked @endif value="1" name="violencia"> Violencia</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('sustancias', isset($car_serv)?$car_serv->sustancias:null)) checked @endif value="1" name="sustancias"> Trastornos por el consumo de sustancias</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('p_intervencion', isset($car_serv)?$car_serv->p_intervencion:null)) checked @endif value="1" name="p_intervencion"> Intervención psicoeducativa</label>
                        </div>

                        <div class="field is-horizontal is-expanded">
                            <div class="field-label is-normal">
                                <label class="label">Otros</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" value="{{ old('otra_problematica', isset($car_serv)?$car_serv->otra_problematica:null) }}"
                                         type="text" name="otra_problematica" placeholder="Otros"></label>
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
                                    <option value="0" @if(old('enfoque_servicio', isset($car_serv)?$car_serv->enfoque_servicio:null) == 0) selected="selected" @endif>Cognitivo-conductual</option>
                                    <option value="1" @if(old('enfoque_servicio', isset($car_serv)?$car_serv->enfoque_servicio:null) == 1) selected="selected" @endif>Conductual</option>
                                    <option value="2" @if(old('enfoque_servicio', isset($car_serv)?$car_serv->enfoque_servicio:null) == 2) selected="selected" @endif>Cognitivo</option>
                                    <option value="3" @if(old('enfoque_servicio', isset($car_serv)?$car_serv->enfoque_servicio:null) == 3) selected="selected" @endif>Sistémico</option>
                                    <option value="4" @if(old('enfoque_servicio', isset($car_serv)?$car_serv->enfoque_servicio:null) == 4) selected="selected" @endif>Psicodinámico</option>
                                    <option value="5" @if(old('enfoque_servicio', isset($car_serv)?$car_serv->enfoque_servicio:null) == 5) selected="selected" @endif>Gestalt</option>
                                    <option value="6" @if(old('enfoque_servicio', isset($car_serv)?$car_serv->enfoque_servicio:null) == 6) selected="selected" @endif>Constructivista</option>
                                    <option value="7" @if(old('enfoque_servicio', isset($car_serv)?$car_serv->enfoque_servicio:null) == 7) selected="selected" @endif>Otro</option>
                                </select>
                            </div>
                        </div>
                        <div class="field is-horizontal is-expanded">
                            <div class="field-label is-normal">
                                <label class="label">Otro</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" value="{{ old('otro_enfoque', isset($car_serv)?$car_serv->otro_enfoque:null) }}"
                                        type="text" name="otro_enfoque" placeholder="Otro" maxlength=255></label>
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
                                    <label class="label"><input type="checkbox" @if(old('individual', isset($car_serv)?$car_serv->individual:null)) checked @endif value="1" name="individual"> Individual</label>
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
                                    <label class="label"><input type="checkbox" @if(old('grupal', isset($car_serv)?$car_serv->grupal:null)) checked @endif value="1" name="grupal"> Grupal</label>
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
                                    <label class="label"><input type="checkbox" @if(old('colaborativa', isset($car_serv)?$car_serv->colaborativa:null)) checked @endif value="1" name="colaborativa"> Colaborativa</label>
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
                                    <label class="label"><input type="checkbox" @if(old('indirecta', isset($car_serv)?$car_serv->indirecta:null)) checked @endif value="1" name="indirecta"> Indirecta</label>
                                </div>
                            </td>
                            <td><p>Se realiza después de la intervención, incluye varias submodalidades: narrada, 
                                presentación del caso en video o audiograbación.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('directa', isset($car_serv)?$car_serv->directa:null)) checked @endif value="1" name="directa"> Directa</label>
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
                                <input class="input" value="{{ old('supervision_otra', isset($car_serv)?$car_serv->supervision_otra:null) }}"
                                type="text" name="supervision_otra" placeholder="Otra (descríbala)"></label>
                            </td>
                        </tr>
                    </table>
                    <p class="is-size-4">Estrategias de enseñanza y supervisión</p>
                    <p>(Puede elegir más de una)</p><br>
                    <table class="table">
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('observacion', isset($car_serv)?$car_serv->observacion:null)) checked @endif value="1" name="observacion"> Observación</label>
                                </div>
                            </td>
                            <td><p>Los supervisados en forma directa o a través de una videograbación observan a un experto y 
                                apoyados en una “guía de observación” hacen sus reportes.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('juego_roles', isset($car_serv)?$car_serv->juego_roles:null)) checked @endif value="1" name="juego_roles"> Juego de roles</label>
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
                                    <label class="label"><input type="checkbox" @if(old('modelamiento', isset($car_serv)?$car_serv->modelamiento:null)) checked @endif value="1" name="modelamiento"> Modelamiento</label>
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
                                    <label class="label"><input type="checkbox" @if(old('moldeamiento', isset($car_serv)?$car_serv->moldeamiento:null)) checked @endif value="1" name="moldeamiento"> Moldeamiento</label>
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
                                    <label class="label"><input type="checkbox" @if(old('cascada', isset($car_serv)?$car_serv->cascada:null)) checked @endif value="1" name="cascada"> Cascada</label>
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
                                    <label class="label"><input type="checkbox" @if(old('auto_supervision', isset($car_serv)?$car_serv->auto_supervision:null)) checked @endif value="1" name="auto_supervision"> Auto supervisión</label>
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
                                    <label class="label"><input type="checkbox" @if(old('equipo_reflexivo', isset($car_serv)?$car_serv->equipo_reflexivo:null)) checked @endif value="1" name="equipo_reflexivo"> Equipo reflexivo</label>
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
                                    <label class="label"><input type="checkbox" @if(old('con_colegas', isset($car_serv)?$car_serv->con_colegas:null)) checked @endif value="1" name="con_colegas"> Supervisión con colegas</label>
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
                                    <label class="label"><input type="checkbox" @if(old('analisis_caso', isset($car_serv)?$car_serv->analisis_caso:null)) checked @endif value="1" name="analisis_caso"> Análisis de caso</label>
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
                                <input class="input" value="{{ old('ensenanza_otra', isset($car_serv)?$car_serv->ensenanza_otra:null) }}"
                                type="text" name="ensenanza_otra" placeholder="Otra (descríbala)" maxlength=255></label>
                            </td>
                        </tr>
                    </table>
                    @component('components.area-input', [
                        'title'=>'Contenido temático (temas y subtemas)',
                        'field'=>'cont_tematico',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev'=> isset($inf_prac) ? $inf_prac->cont_tematico : null
                        ])@endcomponent
                    @component('components.area-input', [
                        'title'=>'Estrategia de seguimiento y evaluación de impacto del servicio',
                        'field'=>'estra_ev_imp',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev'=> isset($inf_prac) ? $inf_prac->estra_ev_imp : null
                        ])@endcomponent
                    <div class="field">
                        <label class="label">Competencias profesionales a desarrollar</label>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('fundamentales', isset($car_serv)?$car_serv->fundamentales:null)) checked @endif value="1" name="fundamentales"> Fundamentales</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('entrevista', isset($car_serv)?$car_serv->entrevista:null)) checked @endif value="1" name="entrevista"> Entrevista</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('c_evaluacion', isset($car_serv)?$car_serv->c_evaluacion:null)) checked @endif value="1" name="c_evaluacion"> Evaluación</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('impresion_diagnostica', isset($car_serv)?$car_serv->impresion_diagnostica:null)) checked @endif value="1" name="impresion_diagnostica"> Impresión diagnóstica</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('implementacion_intervenciones', isset($car_serv)?$car_serv->implementacion_intervenciones:null)) checked @endif value="1" name="implementacion_intervenciones"> Diseño / Implementación de intervenciones</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('integracion_expediente', isset($car_serv)?$car_serv->integracion_expediente:null)) checked @endif value="1" name="integracion_expediente"> Integración de expediente</label>
                        </div>
                        <div class="control">
                            <label class="checkbox"><input type="checkbox" @if(old('elaboracion_documentos', isset($car_serv)?$car_serv->elaboracion_documentos:null)) checked @endif value="1" name="elaboracion_documentos"> Elaboración de documentos escritos de avances y resultados</label>
                        </div>
                        <div class="field is-horizontal is-expanded">
                            <div class="field-label is-normal">
                                <label class="label">Otra</label>
                            </div>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" value="{{ old('ensenanza_otra', isset($car_serv)?$car_serv->ensenanza_otra:null) }}"
                                        type="text" name="competencias_otra" placeholder="Otra (descríbala)" maxlength=255></label>
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
                    <add-row inline-template
                    @if(isset($acts))
                        :sups=0
                        :old={{ count($acts) }}
                    @endif
                    >
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
                                    @if(isset($acts))
                                    @foreach ($acts as $key => $act)
                                    <template  v-if="visible[{{ $key }}]">
                                    <tr>
                                        @component('components.semana-row', [
                                            'data' => $act,
                                            'errors'=> $errors
                                        ])@endcomponent
                                        <td>
                                            <button class="button is-danger is-outlined" type="button"
                                            :id={{ $key }}
                                            @click="deleteOld('{{ route('del_row', ['act', $act->id]) }}')"
                                            >Borrar</button>
                                        </td>
                                    </tr>
                                    </template>
                                    @endforeach
                                    @endif
                                    <tr v-for="row in rows" :key="row">
                                        @component('components.semana-row',compact('errors'))@endcomponent
                                        <td>
                                            <button v-if="row==rows && rows>sups" class="button is-danger is-outlined" type="button" @click="deleteRow(row)">
                                                Borrar renglón
                                            </button>
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
                                    <label class="label"><input type="checkbox" @if(old('formativa', isset($car_serv)?$car_serv->formativa:null)) checked @endif value="1" name="formativa"> Formativa</label>
                                </div>
                            </td>
                            <td><p>Ya que se dirige al desarrollo de competencias profesionales desde la licenciatura y hasta el posgrado.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('integrativa', isset($car_serv)?$car_serv->integrativa:null)) checked @endif value="1" name="integrativa"> Integrativa</label>
                                </div>
                            </td>
                            <td><p>Al considerar las diferentes aproximaciones teóricas para la evaluación, intervención e investigación psicológicas y la necesidad de integrar estrategias y recursos que conduzcan a la optimización del proceso de supervisión.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('contextual', isset($car_serv)?$car_serv->contextual:null)) checked @endif value="1" name="contextual"> Contextual comunitaria o institucional</label>
                                </div>
                            </td>
                            <td><p>Ya que considera el ámbito comunitario o institucional, destacando que además de la formación teórico-técnica los estudiantes deben conocer métodos de investigación, acercamiento e inserción comunitaria para trabajar directamente con su población, o bien, para atender a la población que enfocada como comunidad, se constituye por las usuarias de diferentes instituciones de salud, educativas o sociales.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('holistica', isset($car_serv)?$car_serv->holistica:null)) checked @endif value="1" name="holistica"> Holística</label>
                                </div>
                            </td>
                            <td><p>En cuanto considerar una concepción integral bio-psico-socio-cultural del ser humano aplicable a la concepción de salud en general y salud mental en particular.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('plural', isset($car_serv)?$car_serv->plural:null)) checked @endif value="1" name="plural"> Plural e incluyente</label>
                                </div>
                            </td>
                            <td><p>Para reconocer la complejidad y diversidad de los usuarios y de las necesidades de atención psicológica desde una perspectiva de equidad, procurando en todo momento la inclusión de todos los casos que pueden ser atendidos, pero la cual habrá de regirse por criterios de competencia para su manejo o, cuando sea necesario, saber cuándo y en qué forma hacer la derivación o referencia institucional de los mismos.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">
                                <div class="control">
                                    <label class="label"><input type="checkbox" @if(old('reflexiva', isset($car_serv)?$car_serv->reflexiva:null)) checked @endif value="1" name="reflexiva"> Reflexiva y con autonomía profesional</label>
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
                    <add-row inline-template
                    @if(isset($crits))
                        :sups=0
                        :old={{ count($crits) }}
                    @endif
                    >
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
                                    @if(isset($crits))
                                    @foreach ($crits as $key => $crit)
                                    <template  v-if="visible[{{ $key }}]">
                                    <tr>
                                        @component('components.criterio-row', [
                                            'data' => $crit,
                                            'errors'=> $errors
                                        ])@endcomponent
                                        <td>
                                            <button class="button is-danger is-outlined" type="button"
                                            :id={{ $key }}
                                            @click="deleteOld('{{ route('del_row', ['crit', $crit->id]) }}')"
                                            >Borrar</button>
                                        </td>
                                    </tr>
                                    </template>
                                    @endforeach
                                    @endif
                                    <tr v-for="row in rows" :key="row">
                                        @component('components.criterio-row', compact('errors'))@endcomponent
                                        <td>
                                            <button v-if="row==rows && rows>sups" class="button is-danger is-outlined" type="button" @click="deleteRow(row)">
                                                Borrar renglón
                                            </button>
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
                        'type'=> 'text',
                        'prev'=> isset($inf_prac) ? $inf_prac->referencias : null
                        ])@endcomponent
                </div>
            </div>
            <br>
            <div class="field">
                <div class="control">
                    <button class="button is-link">{{ isset($program) ? 'Actualizar' : 'Registrar' }}</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection