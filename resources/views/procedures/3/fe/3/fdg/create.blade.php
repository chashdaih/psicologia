@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title"> Registrar ficha de datos generales</h1>
        <p class="subtitle">Agregue los datos de la persona que requiere el servicio</p>
        {{-- <f-d-g-form url="{{ route('fdg.store') }}" :programs="{{ $programs }}"></f-d-g-form> --}}
        {{-- <f-d-g-form inline-template> --}}
            <div>
                <form action="{{ route('fdg.store', ['id'=> $program_id]) }}" method="POST">
                        {{ csrf_field() }}
                    @component('components.text-input', [
                        'title'=>'Nombre(s)',
                        'field'=>'name',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->name : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Apellido paterno',
                        'field'=>'last_name',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->last_name : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Apellido materno',
                        'field'=>'mothers_name',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->mothers_name : null,
                        'maxlength' => 255
                    ])@endcomponent
                    <div class="field">
                        <label class="label">Sexo</label>
                        <div class="control">
                            <div class="select">
                            <select name="gender">
                                <option value="0">Mujer</option>
                                <option value="1">Hombre</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <date-component
                        label="Fecha de nacimiento"
                        name="birthdate"
                        old=@if(old('birthdate')) {{old('birthdate')}} @elseif(isset($fdg)){{ $fdg->birthdate ? $fdg->birthdate->format('Y-m-d') : null }} @else {{null}} @endif
                    ></date-component>
                    <div class="field">
                        <label class="label">Estado civil</label>
                        <div class="control">
                            <div class="select">
                            <select name="marital_status">
                                <option value="0">Soltero</option>
                                <option value="1">Casado</option>
                                <option value="2">Unión libre</option>
                                <option value="3">Viudo</option>
                                <option value="4">Separado</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Persona que solicita el servicio</label>
                        <div class="control">
                            <div class="select">
                            <select name="person_requesting">
                            @foreach (['La persona', 'Padres o tutores', 'Otro familiar', 'Otro'] as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    @component('components.text-input', [
                        'title'=>'CURP/No.Cuenta/No.Trabajador',
                        'field'=>'curp',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->curp : null,
                        'maxlength' => 255
                    ])@endcomponent
                    <div class="field">
                        <label class="label">Es comunidad UNAM</label>
                        <div class="control">
                            <div class="select">
                            <select name="is_unam">
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    @component('components.text-input', [
                        'title'=>'Calle',
                        'field'=>'street_name',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->street_name : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Número',
                        'field'=>'external_number',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->external_number : null,
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
                        'title'=>'Municipio',
                        'field'=>'municipality',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->municipality : null,
                        'maxlength' => 255
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Estado',
                        'field'=>'state',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev' => isset($fdg) ? $fdg->state : null,
                        'maxlength' => 255
                    ])@endcomponent
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
                    <div class="field">
                        <label class="label">¿Trabaja actualmente?</label>
                        <div class="control">
                            <div class="select">
                            <select name="has_work">
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                            </div>
                        </div>
                    </div>
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
                    @component('components.text-input', [
                        'title'=>'Número de integrantes del hogar',
                        'field'=>'household_members',
                        'errors'=>$errors,
                        'type'=> 'number',
                        'prev'=> isset($fdg) ? $fdg->household_members : null
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Ingreso familiar mensual',
                        'field'=>'monthly_family_income',
                        'errors'=>$errors,
                        'type'=> 'text',
                        'prev'=> isset($fdg) ? $fdg->monthly_family_income : null
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Número de personas que aportan a este ingreso (contando la persona que requiere el servicio)',
                        'field'=>'number_people_contributing',
                        'errors'=>$errors,
                        'type'=> 'number',
                        'prev'=> isset($fdg) ? $fdg->number_people_contributing : null
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Número de personas que dependen de este ingreso (contando la persona que requiere el servicio)',
                        'field'=>'number_people_depending',
                        'errors'=>$errors,
                        'type'=> 'number',
                        'prev'=> isset($fdg) ? $fdg->number_people_depending : null
                    ])@endcomponent
                    <div class="field">
                        <label class="label">Su casa es:</label>
                        <div class="control">
                            <div class="select">
                            <select name="house_is">
                                <option value="0">Otra</option>
                                <option value="1">Propia</option>
                                <option value="2">Propia, pero la está pagando</option>
                                <option value="3">Rentada</option>
                                <option value="4">Prestada</option>
                                <option value="5">Intenstada o en litigio</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Servicio solicitado</label>
                        <div class="control">
                            <div class="select">
                            <select name="service_type">
                            @foreach (['Orientación/Consejo breve', 'Evaluación', 'Intervención'] as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Modalidad de servicio que solicita</label>
                        <div class="control">
                            <div class="select">
                            <select name="service_modality">
                            @foreach (['Individual/Grupal', 'Familiar/Pareja'] as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    @component('components.text-input', [
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
                    <div class="field">
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
                    </div>
                    <div class="field">
                        <label class="label">¿Ha recibido anteriormente tratamiento para dar solución a esta situación?</label>
                        <div class="control">
                            <div class="select">
                            <select name="has_recived_previous_treatment">
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">¿Viene referido de otra institución?</label>
                        <div class="control">
                            <div class="select">
                            <select name="refer">
                            @foreach (['No', 'Escuela', 'Trabajo', 'Hospital/Instituto', 'Dpto. de Psiquiatría y Salud Mental (Fac. Medicina)'] as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">¿Ha recibido atención en otros Centros y/o Programas de la facultad para su motivo de consulta?</label>
                        <div class="control">
                            <div class="select">
                            <select name="unam_previous_treatment">
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">¿Tiene algún problema de salud?</label>
                        <div class="control">
                            <div class="select">
                            <select name="has_health_issue">
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                            </div>
                        </div>
                    </div>
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
                            <button class="button is-info">Registrar</button>
                        </div>
                    </div>
                </form>
            </div>
        {{-- </f-d-g-form> --}}
    </div>
</section>
@endsection