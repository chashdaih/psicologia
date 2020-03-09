@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @if (isset($fdg))
        <h1 class="title">{{$fdg->full_name}}</h1>
        <p class="subtitle">Editar ficha de datos generales</p>
        @else
        <h1 class="title">Registrar ficha de datos generales</h1>
        <p class="subtitle">Agregue los datos de la persona que requiere el servicio</p>
        @endif
        <article class="message is-info">
            <div class="message-body">
                <p>El sistema acepta acentos, mayúsculas y minúsculas.</p>
                <p>Por favor, ingresa los datos con minúsculas y mayúsculas para tener un registro uniforme.</p>
            </div>
        </article>
        <fdg-new inline-template
        v-on:mounted="console.log('mounted')"
        >
            <div>
                <form 
                @if(isset($fdg))
                action="{{ route('fdg.update', ['patient_id'=>0, 'fdg'=>$fdg->id]) }}" 
                @else
                action="{{ route('fdg.store', 0) }}" 
                @endif
                method="POST">
                @if(isset($fdg)) <input name="_method" type="hidden" value="PUT"> @endif
                        {{ csrf_field() }}
                    <div class="field">
                        <label class="label">Centro donde se llevó a cabo el registro</label>
                        <div class="control">
                            <div class="select">
                            <select name="center_id">
                                @foreach ($centers as $center)
                                <option value="{{$center->id_centro}}"
                                    @if ( old('center_id', isset($fdg)?$fdg->center_id:$preferedCenter) == $center->id_centro )
                                    selected="selected"
                                    @endif
                                    >{{$center->nombre}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->type != 3)
                    @component('components.text-input', [
                        'title' => 'Nombre de quien hizo la entrevista *OPCIONAL* (Solo si no está dado de alta en el sistema)',
                        'field' => 'other_filler',
                        'errors' => $errors,
                        'type' => 'text',
                        'prev' => old('other_filler', isset($fdg) ? $fdg->other_filler : null),
                        'maxlength' => 255,
                    ])@endcomponent
                    @endif
                    <br>
                    <article class="message is-danger">
                        <div class="message-header">Atención</div>
                        <div class="message-body">
                            <p>El número de expediente solo lleva números</p>
                        </div>
                    </article>
                    <label class="label">No. expediente</label>
                    <div class="field has-addons">
                        <span class="select">
                            <select name="file_year" >
                                @foreach ($years as $year)
                                <option value="{{$year}}"
                                    @if ( old('file_year', isset($fdg)?$fdg->file_year:null) == $year )
                                    selected="selected"
                                    @endif
                                    >{{$year}}</option>
                                @endforeach
                            </select>
                        </span>
                        <div class="control">
                            <numeric-input
                                name="file_number"
                                value="{{old('file_number', isset($fdg) ? $fdg->file_number : '')}}"
                                clazz="input {{$errors->has('file_number')? ' is-danger':'' }}"
                                max=9999
                            />
                        </div>
                        @if ($errors->has('file_number'))
                        <p class="help is-danger">{{ $errors->first('file_number') }}</p>
                        @endif
                    </div>
                    <br>
                    <!-- @component('components.text-input', [
                        'title'=>'No. expediente',
                        'field'=>'file_number',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => old('file_number', isset($fdg) ? $fdg->file_number : null),
                        'maxlength' => 255,
                    ])@endcomponent -->
                    @component('components.text-input', [
                        'title'=>'CURP/No.Cuenta/No.Trabajador',
                        'field'=>'curp',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->curp : null,
                        'maxlength' => 255
                    ])@endcomponent
                    <date-component
                        label="Fecha de llenado"
                        name="created_at"
                        @if($errors->has("created_at"))
                        error='{{$errors->first("created_at")}}'
                        @endif
                        @if(old('created_at'))
                        old={{old('created_at')}}
                        @elseif(isset($fdg))
                        old={{ $fdg->created_at ? $fdg->created_at->format('Y-m-d') : null }}
                        @endif
                    ></date-component>
                    <h2 class="subtitle">Identificación de la persona que requiere el servicio</h2>
                    @component('components.text-input', [
                        'title'=>'Nombre(s)',
                        'field'=>'name',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->name : null,
                        'maxlength' => 255,
                        'required' => true
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Apellido paterno',
                        'field'=>'last_name',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->last_name : null,
                        'maxlength' => 255,
                        'required' => true
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Apellido materno',
                        'field'=>'mothers_name',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->mothers_name : null,
                        'maxlength' => 255,
                        'required' => true
                    ])@endcomponent
                    @component('components.array-sel',[
                        'title'=>'Sexo',
                        'field'=>'gender',
                        'options'=>['Mujer', 'Hombre'],
                        'errors'=>$errors,
                        'prev'=>isset($fdg)?$fdg->gender:null
                    ])
                    @endcomponent
                    @component('components.text-input', [
                        'title'=>'Lugar de nacimiento',
                        'field'=>'birth_place',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->birth_place : null,
                        'maxlength' => 255,
                        'required' => true
                    ])@endcomponent
                    <date-component
                        label="Fecha de nacimiento"
                        name="birthdate"
                        @if($errors->has("birthdate"))
                        error='{{$errors->first("birthdate")}}'
                        @endif
                        @if(old('birthdate'))
                        old={{old('birthdate')}}
                        @elseif(isset($fdg))
                        old={{ $fdg->birthdate ? $fdg->birthdate->format('Y-m-d') : null }}
                        @endif
                        v-on:date-change="checkIfOver18"
                    ></date-component>
                    <div v-if="age != null">
                        <p><span class="has-text-weight-semibold">Edad: </span>@{{age}} años</p>
                        <br>
                    </div>
                    
                    @component('components.array-sel',[
                        'title'=>'Estado civil',
                        'field'=>'marital_status',
                        'options'=>config('globales.estado_civil'),
                        'errors'=>$errors,
                        'prev'=>isset($fdg)?$fdg->marital_status:null
                    ])@endcomponent
                    <div class="field"> 
                        <label class="label">Es comunidad UNAM</label>
                        <div class="control">
                            <div class="select">
                            <select name="is_unam" v-model="is_unam" >
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    {{-- Es comunidad unam --}}
                    <div v-if="is_unam">
                        @component('components.text-input', [
                            'title'=>'Entidad académica de procedencia',
                            'field'=>'academic_entity',
                            'errors'=>$errors,
                            'type'=> 'text',
                            'prev' => isset($fdg) ? $fdg->academic_entity : null,
                            'maxlength' => 255,
                            'required' => false
                        ])@endcomponent
                        @component('components.array-sel',[
                            'title'=>'Eres:',
                            'field'=>'position',
                            'options'=>['Estudiante', 'Académico', 'Administrativo'],
                            'errors'=>$errors,
                            'prev'=>isset($fdg)?$fdg->position:null
                        ])@endcomponent
                        @component('components.text-input', [
                            'title'=>'Carrera que estudias',
                            'field'=>'career',
                            'errors'=>$errors,
                            'type'=> 'text',
                            'prev' => isset($fdg) ? $fdg->career : null,
                            'maxlength' => 255,
                            'required' => false
                        ])@endcomponent
                        @component('components.text-input', [
                            'title'=>'Semestre que cursas',
                            'field'=>'semester',
                            'errors'=>$errors,
                            'type'=> 'text',
                            'prev' => isset($fdg) ? $fdg->semester : null,
                            'maxlength' => 255,
                            'required' => false
                        ])@endcomponent
                    </div>
                    {{-- termina comunidad unam --}}
                    <div class="field"> 
                            <label class="label">Persona que solicita el servicio</label>
                            <div class="control">
                                <div class="select">
                                <select name="person_requesting" v-model="requester" >
                                    <option value="0">La persona</option>
                                    <option value="1">Padres o tutores</option>
                                    <option value="2">Otro familiar</option>
                                    <option value="3">Otro</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div v-if="requester">
                            @component('components.text-input', [
                                'title'=>'Nombre de quien solicita el servicio',
                                'field'=>'name_requester',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($fdg) ? $fdg->name_requester : null,
                                'maxlength' => 255,
                                'required' => false
                            ])@endcomponent
                        </div>
                    <!-- Tutors -->
                    <div v-if="is_under_18">
                        <br>
                        <p class="title is-6">**La atención es para un menor de edad. Por favor, anote los datos de los padres o tutores**</p>
                        @component('components.text-input', [
                            'title'=>'Nombre del padre, madre o tutor',
                            'field'=>'tutor_name_1',
                            'errors'=>$errors,
                            'type'=> 'text',
                            'prev' => isset($fdg) ? $fdg->tutor_name_1 : null,
                            'maxlength' => 255,
                            'required' => false
                        ])@endcomponent
                        @component('components.array-sel',[
                            'title'=>'Parentesco',
                            'field'=>'relationship_1',
                            'options'=>['Madre', 'Padre', 'Tutor'],
                            'errors'=>$errors,
                            'prev'=>isset($fdg)?$fdg->relationship_1:null
                        ])@endcomponent
                        <date-component
                            label="Fecha de nacimiento del tutor"
                            name="tutor_birthdate_1"
                            @if($errors->has("tutor_birthdate_1"))
                            error='{{$errors->first("tutor_birthdate_1")}}'
                            @endif
                            @if(old('tutor_birthdate_1'))
                            old={{old('tutor_birthdate_1')}}
                            @elseif(isset($fdg))
                            old={{ $fdg->tutor_birthdate_1 ? $fdg->tutor_birthdate_1->format('Y-m-d') : null }}
                            @endif
                        ></date-component>
                        @component('components.array-sel',[
                            'title'=>'Nivel máximo de estudios',
                            'field'=>'studies_level_1',
                            'options'=>['No cuenta con escolaridad', 'Preescolar', 'Primaria', 'Secundaria', 'Preparatoria', 'Licenciatura', 'Posgrado'],
                            'errors'=>$errors,
                            'prev'=>isset($fdg)?$fdg->relationship_1:null
                        ])@endcomponent
                        @component('components.text-input', [
                            'title'=>'Ocupación',
                            'field'=>'occupation_1',
                            'errors'=>$errors,
                            'type'=> 'text',
                            'prev' => isset($fdg) ? $fdg->occupation_1 : null,
                            'maxlength' => 255,
                            'required' => false
                        ])@endcomponent
                        <div class="field" >
                            <div class="control">
                                <button v-if="second_tutor === false" class="button is-centered is-warning" @click.prevent="showSecondTutor">
                                    Añadir segundo tutor
                                </button>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div v-if="second_tutor">
                        @component('components.text-input', [
                            'title'=>'Nombre del segundo padre, madre o tutor',
                            'field'=>'tutor_name_2',
                            'errors'=>$errors,
                            'type'=> 'text',
                            'prev' => isset($fdg) ? $fdg->tutor_name_2 : null,
                            'maxlength' => 255,
                            'required' => false
                        ])@endcomponent
                        @component('components.array-sel',[
                            'title'=>'Parentesco',
                            'field'=>'relationship_2',
                            'options'=>['Madre', 'Padre', 'Tutor'],
                            'errors'=>$errors,
                            'prev'=>isset($fdg)?$fdg->relationship_2:null
                        ])@endcomponent
                        <date-component
                            label="Fecha de nacimiento del tutor"
                            name="tutor_birthdate_2"
                            @if($errors->has("tutor_birthdate_2"))
                            error='{{$errors->first("tutor_birthdate_2")}}'
                            @endif
                            @if(old('tutor_birthdate_2'))
                            old={{old('tutor_birthdate_2')}}
                            @elseif(isset($fdg))
                            old={{ $fdg->tutor_birthdate_2 ? $fdg->tutor_birthdate_2->format('Y-m-d') : null }}
                            @endif
                        ></date-component>
                        @component('components.array-sel',[
                            'title'=>'Nivel máximo de estudios',
                            'field'=>'studies_level_2',
                            'options'=>['No cuenta con escolaridad', 'Preescolar', 'Primaria', 'Secundaria', 'Preparatoria', 'Licenciatura', 'Posgrado'],
                            'errors'=>$errors,
                            'prev'=>isset($fdg)?$fdg->studies_level_2:null
                        ])@endcomponent
                        @component('components.text-input', [
                            'title'=>'Ocupación',
                            'field'=>'occupation_2',
                            'errors'=>$errors,
                            'type'=> 'text',
                            'prev' => isset($fdg) ? $fdg->occupation_2 : null,
                            'maxlength' => 255,
                            'required' => false
                        ])@endcomponent
                        <br>
                    </div>

                    {{-- termina segundo tutor --}}

                    {{-- empieza dirección --}}
                    <h2 class="subtitle">Dirección de la persona que requiere el servicio</h2>
                    @component('components.text-input', [
                        'title'=>'Calle',
                        'field'=>'street_name',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->street_name : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Número exterior',
                        'field'=>'external_number',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->external_number : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Número interior',
                        'field'=>'internal_number',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->internal_number : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Colonia',
                        'field'=>'neighborhood',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->neighborhood : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Código postal',
                        'field'=>'postal_code',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->postal_code : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Delegación / Municipio',
                        'field'=>'municipality',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->municipality : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Entidad Federativa',
                        'field'=>'state',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->state : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Teléfono de casa',
                        'field'=>'house_phone',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->house_phone : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Teléfono celular',
                        'field'=>'cell_phone',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->cell_phone : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Teléfono de trabajo',
                        'field'=>'work_phone',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->work_phone : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Ext.',
                        'field'=>'work_phone_ext',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->work_phone_ext : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Correo electrónico',
                        'field'=>'email',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->email : null,
                        'maxlength' => 255
                    ])@endcomponent
                    <h2 class="subtitle">Escolaridad de la persona que requiere el servicio</h2>
                    <div class="field">
                        <label class="label">Escolaridad</label>
                        <div class="control">
                            <div class="select">
                            <select name="scholarship">
                                <option value="0">No cuenta con escolaridad</option>
                                <option value="1">Preescolar</option>
                                <option value="2">Primaria</option>
                                <option value="3">Secundaria</option>
                                <option value="4">Preparatoria</option>
                                <option value="5">Licenciatura</option>
                                <option value="6">Posgrado</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Años concluidos de estudio</label>
                        <div class="control">
                            <div class="select">
                            <select name="studied_years">
                            @foreach (['1', '2', '3', '4', '5', '6 o más'] as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <h2 class="subtitle">Situación laboral de la persona que requiere el servicio</h2>
                    <div class="field">
                        <label class="label">¿Trabaja actualmente?</label>
                        <div class="control">
                            <div class="select">
                            <select name="has_work" v-model="has_work">
                                <option value=0>No</option>
                                <option value=1>Si</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <template v-if="has_work == '0'">
                        @component('components.text-input', [
                            'title'=>'Si no tiene trabajo, ¿de quién depende?',
                            'field'=>'who_depends_on',
                            'errors'=>$errors,
                            'type'=> 'text',
                            'prev' => isset($fdg) ? $fdg->who_depends_on : null,
                            'maxlength' => 255
                        ])@endcomponent
                    </template>
                    <template v-else>
                        <div class="field">
                            <label class="label">¿Recibe remuneración económica por su trabajo?</label>
                            <div class="control">
                                <div class="select">
                                <select name="has_salary">
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Descripción de su trabajo</label>
                            <div class="control">
                                <input value="{{old('work_description', isset($fdg) ? $fdg->work_description : null)}}" type="text" class="input" maxlength="255" placeholder="Descripción de su trabajo" name="work_description">
                            </div>
                        </div>
                    </template>
                    @component('components.array-sel', [
                        'title'=>'Número de integrantes del hogar (contando la persona que requiere el servicio)',
                        'field'=>'household_members',
                        'options'=> [1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>'7 o más' ],
                        'errors'=>$errors,
                        'prev'=>isset($fdg)?$fdg->household_members:null
                    ])@endcomponent
                    <br>
                    <p class="label">Ingreso familiar mensual</p>
                    <article class="message is-info">
                        <div class="message-body">
                            <p>Por favor, solo ingrese números enteros, sin comas ni puntos.</p>
                        </div>
                    </article>
                    <div class="field has-addons">
                        <p class="control">
                            <a class="button is-static">$</a>
                        </p>
                        <p class="control">
                            <input type="number" min="0" max="99999" class="input{{ $errors->has('monthly_family_income')? ' is-danger':'' }}" type="text" placeholder="Ingreso familiar mensual" name="monthly_family_income" value="{{ old('monthly_family_income', isset($fdg) ? $fdg->monthly_family_income : null) }}" />
                        </p>
                        @if ($errors->has('monthly_family_income'))
                        <p class="help is-danger">{{ $errors->first('monthly_family_income') }}</p>
                        @endif
                    </div>
                    <br>
                    @component('components.array-sel', [
                        'title'=>'Número de personas que aportan a este ingreso (contando la persona que requiere el servicio)',
                        'field'=>'number_people_contributing',
                        'options'=> [1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>'7 o más' ],
                        'errors'=>$errors,
                        'prev'=>isset($fdg)?$fdg->number_people_contributing:null
                    ])@endcomponent
                    @component('components.array-sel', [
                        'title'=>'Número de personas que dependen de este ingreso (contando la persona que requiere el servicio)',
                        'field'=>'number_people_depending',
                        'options'=> [1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>'7 o más' ],
                        'errors'=>$errors,
                        'prev'=>isset($fdg)?$fdg->number_people_depending:null
                    ])@endcomponent
                    <div class="field">
                        <label class="label">Su casa es:</label>
                        <div class="control">
                            <div class="select">
                            <select name="house_is" v-model="house_is">
                                    @foreach (['Propia', 'Propia, pero la está pagando', 'Rentada', 'Prestada', 'Intestada o en litigio', 'Otra'] as $key=>$value)
                                    <option value="{{ $key }}"
                                        @if(old('house_is', isset($prev)?$prev:null))
                                            @if ($key == old('house_is', isset($fdg)?$fdg->house_is:null) )
                                            selected="selected"
                                            @endif
                                        @endif
                                        >{{ $value }}</option>
                                    @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <template v-if="house_is==5">
                        @component('components.text-input', [
                            'title'=>'Otra:',
                            'field'=>'house_other',
                            'errors'=>$errors,
                            'type'=> 'text',
                            'prev'=> isset($fdg) ? $fdg->house_other : null
                        ])@endcomponent
                    </template>
                    <h2 class="subtitle">Sobre el servicio</h2>
                    @component('components.array-sel', [
                        'title'=>'Tipo de servicio',
                        'field'=>'service_type',
                        'options'=> ['Orientación/Consejo breve', 'Evaluación', 'Intervención'],
                        'errors'=>$errors,
                        'prev'=>isset($fdg)?$fdg->service_type:null
                    ])@endcomponent
                    @component('components.array-sel', [
                        'title'=>'Modalidad de servicio que solicita',
                        'field'=>'service_modality',
                        'options'=> ['Individual/Grupal', 'Familiar/Pareja'],
                        'errors'=>$errors,
                        'prev'=>isset($fdg)?$fdg->service_modality:null
                    ])@endcomponent
                    @component('components.area-input', [
                        'title'=>'Motivo de consulta (Describa de forma detallada lo que le pasa y qué espera de la atención que se le puede brindar en este Centro/Programa)',
                        'field'=>'consultation_cause',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev'=> isset($fdg) ? $fdg->consultation_cause : null
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'¿Desde cuándo le pasa esto?',
                        'field'=>'problem_since',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev'=> isset($fdg) ? $fdg->problem_since : null
                    ])@endcomponent
                    {{-- <div class="field">
                        <label class="label">Clasificación del motivo de consulta según la guía mhGAP</label>
                        <div class="control">
                            <div class="select">
                            <select name="mhGAP_cause_classification">
                            @foreach (['Depresión', 'Psicosis', 'Epilepsia', 'Transtornos mentales y conductuales del niño y el adolescente', 'Demencia', 'Transtornos por el consumo de sustancias', 'Autolesión/Suicidio', 'Otros padecimientos de salud importantes'] as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            </select>
                            </div>
                        </div>
                    </div> --}}
                    <div class="field">
                        <label class="label">¿Ha recibido anteriormente tratamiento para dar solución a esta situación?</label>
                        <div class="control">
                            <div class="select">
                            <select name="has_recived_previous_treatment" v-model="previous_treatment">
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <template v-if="previous_treatment != '0'">
                        @component('components.array-sel', [
                            'title'=>'Número de veces que ha sido atendido para esta situación:',
                            'field'=>'number_times_treatment',
                            'options'=> [1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>'7 o más' ],
                            'errors'=>$errors,
                            'prev'=>isset($fdg)?$fdg->number_times_treatment:null
                        ])@endcomponent
                        <div class="field">
                            <label class="label">Tipo de atención que ha recibido:</label>
                            <div class="control">
                                <div class="select">
                                <select name="has_recived_previous_treatment" v-model="has_recived_previous_treatment">
                                        @foreach (['Psicológica', 'Psiquiátrica', 'Médica', 'Neurológica', 'Otro'] as $key=>$value)
                                        <option value="{{ $key }}"
                                            @if(old('has_recived_previous_treatment', isset($prev)?$prev:null))
                                                @if ($key == old('has_recived_previous_treatment', isset($fdg)?$fdg->has_recived_previous_treatment:null) )
                                                selected="selected"
                                                @endif
                                            @endif
                                            >{{ $value }}</option>
                                        @endforeach
                                </select>
                                </div>
                            </div>
                        </div>
                        <template v-if="has_recived_previous_treatment=='4'">
                            @component('components.text-input', [
                                'title'=>'Otro tipo de atención:',
                                'field'=>'other_previous_treatment',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev'=> old('other_previous_treatment', isset($fdg) ? $fdg->other_previous_treatment : null)
                            ])@endcomponent
                        </template>
                    </template>
                    <div class="field">
                        <label class="label">¿Viene referido de otra institución?</label>
                        <div class="control">
                            <div class="select">
                            <select name="refer" v-model="refer">
                            @foreach (['No', 'Escuela', 'Trabajo', 'Hospital/Instituto', 'Dpto. de Psiquiatría y Salud Mental (Fac. Medicina)', 'Otra'] as $key=>$value)
                            <option value="{{ $key }}"
                                @if(old('refer', isset($prev)?$prev:null))
                                    @if ($key == old('refer', isset($fdg)?$fdg->refer:null) )
                                    selected="selected"
                                    @endif
                                @endif
                                >{{ $value }}</option>
                            @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <template v-if="refer =='1' || refer=='2' || refer=='3'">
                        @component('components.text-input', [
                            'title'=>'¿Cuál?',
                            'field'=>'refer_where',
                            'errors'=>$errors,
                            'type'=> 'text',
                            'prev'=> old('refer_where', isset($fdg) ? $fdg->refer_where : null)
                        ])@endcomponent
                    </template>
                    <template v-if="refer=='5'">
                        @component('components.text-input', [
                            'title'=>'Otra: ',
                            'field'=>'refer_other',
                            'errors'=>$errors,
                            'type'=> 'text',
                            'prev'=> old('refer_other', isset($fdg) ? $fdg->refer_other : null)
                        ])@endcomponent
                    </template>
                    <div class="field">
                        <label class="label">¿Ha recibido atención en otros Centros y/o Programas de la facultad para su motivo de consulta?</label>
                        <div class="control">
                            <div class="select">
                            <select name="unam_previous_treatment" v-model="unam_prev">
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <template v-if="unam_prev != '0'">
                        <div class="field">
                            <label class="label">Centro / Programa</label>
                            <div class="control">
                                <div class="select">
                                <select name="unam_previous_treatment_program">
                                    @foreach ($centers as $center)
                                    <option value="{{$center->id_centro}}"
                                        @if(old('unam_previous_treatment_program')&& old('unam_previous_treatment_program') == $center->id_centro) selected="selected" @elseif(isset($fdg) && $fdg->unam_previous_treatment_program == $center->id_centro) selected="selected" @endif
                                        >{{$center->nombre}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                        </div>
                    </template>
                    <div class="field">
                        <label class="label">¿Tiene algún problema de salud?</label>
                        <div class="control">
                            <div class="select">
                            <select name="has_health_issue" v-model="has_health_issue">
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <template v-if="has_health_issue != '0'">
                        <div class="field">
                            <label class="label">¿Toma medicamentos?</label>
                            <div class="control">
                                <div class="select">
                                <select name="takes_medication" v-model="takes_medication">
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <template v-if="takes_medication != '0'">
                            @component('components.text-input', [
                                'title'=>'¿Cuáles',
                                'field'=>'medication',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev'=> old('medication', isset($fdg) ? $fdg->medication : null)
                            ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Dosis: ',
                                'field'=>'medication_dose',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev'=> old('medication_dose', isset($fdg) ? $fdg->medication_dose : null)
                            ])@endcomponent
                        </template>
                    </template>
                    <div class="field">
                        <label class="label">Horario de preferencia</label>
                        <div class="control">
                            <div class="select">
                            <select name="prefer_time">
                            @foreach (['Matutino', 'Vespertino', 'Indiferente'] as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button class="button is-info">@if(isset($fdg)) Editar @else Registrar @endif</button>
                        </div>
                    </div>
                </form>
            </div>
        </fdg-new>
    </div>
</section>
@endsection