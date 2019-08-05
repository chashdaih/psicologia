@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h2 style="text-align:center;">Ficha de datos generales</h2>
    <div style="text-align:right;">
        <p><span style="font-weight:bold;">No. expediente: </span>{{ $doc->file_number }}</p>
        <p><span style="font-weight:bold;">No. Cuenta/No. Trabajador/CURP:</span> {{ $doc->curp }}</p>
        <p><span style="font-weight:bold;">Fecha de registro: </span>{{ $doc->created_at->format('d/m/Y') }}</p>
        <br>
    </div>
    <div>
        <h3>Identificación de la persona que requiere el servicio</h3>
        <p><span style="font-weight:bold;">Nombre: </span>{{ $doc->full_name}}</p>
        <p><span style="font-weight:bold;">Sexo: </span>{{ $doc->gender ? 'Hombre' : 'Mujer'}}</p>
        <p><span style="font-weight:bold;">Fecha de nacimiento: </span>{{ $doc->birthdate->format('d/m/Y')}}</p>
        <p><span style="font-weight:bold;">Edad: </span>{{ $doc->birthdate->age}}</p>
        <p><span style="font-weight:bold;">Estado civil de la persona que requiere el servicio: </span>{{ $doc->marital_status}}</p>
        <p><span style="font-weight:bold;">¿Pertenece a la comunidad UNAM?: </span>{{ $doc->is_unam? 'Si': 'No'}}</p>
        @if ($doc->is_unam)
        <p><span style="font-weight:bold;">Entidad académica de procedencia</span> {{ $doc->academic_entity }}</p>
        <p><span style="font-weight:bold;">Es:</span> {{ $doc->position }}</p>
        <p><span style="font-weight:bold;">Carrera que estudia:</span> {{ $doc->career }}</p>
        <p><span style="font-weight:bold;">Semestre que cursa:</span> {{ $doc->semester }}</p>
        @endif
        <p><span style="font-weight:bold;">Persona que solicita el servicio</span> {{ $doc->person_requesting }}</p>
        @if ($doc->person_requesting != 0)
        <p><span style="font-weight:bold;">Nombre de quien solicita el servicio</span> {{ $doc->name_requester }}</p>
        @endif
        @if ($doc->is_under_age)
        <i>La atención es para un menor de edad</i>
        <p><span style="font-weight:bold;">Nombre {{ $doc->relationship_1 }}</span> {{ $doc->tutor_name_1 }}</p>
        <p><span style="font-weight:bold;"></span>{{ $doc->tutor_birthdate_1->format('d/m/Y') }}</p>
        <p><span style="font-weight:bold;">Nivel máximo de estudios:</span> {{ $doc->studies_level_1 }}</p>
        <p><span style="font-weight:bold;">Ocupación {{ $doc->relationship_1 }}</span> {{ $doc->occupation_1 }}</p>
        </div>
        @if ($doc->tutor_name_2)
        <p><span style="font-weight:bold;">Nombre {{ $doc->relationship_2 }} </span> {{ $doc->tutor_name_2 }}</p>
        <p><span style="font-weight:bold;"></span>{{ $doc->tutor_birthdate_2->format('d/m/Y') }}</p>
        <p><span style="font-weight:bold;">Nivel máximo de estudios:</span> {{ $doc->studies_level_2 }}</p>
        <p><span style="font-weight:bold;">Ocupación {{ $doc->relationship_2 }}</span> {{ $doc->occupation_2 }}</p>
        @endif
        @endif
    </div>
    <div>
        <h3>Dirección de la persona que requiere el servicio</h3>
        <p><span style="font-weight:bold;">Calle: </span> {{ $doc->street_name }}</p>
        <p><span style="font-weight:bold;">Número exterior: </span> {{ $doc->external_number }}</p>
        <p><span style="font-weight:bold;">Número interior: </span> {{ $doc->internal_number }}</p>
        <p><span style="font-weight:bold;">Colonia: </span> {{ $doc->neighborhood }}</p>
        <p><span style="font-weight:bold;">Código postal: </span> {{ $doc->postal_code }}</p>
        <p><span style="font-weight:bold;">Delegación/Municipio: </span> {{ $doc->municipality }}</p>
        <p><span style="font-weight:bold;">Entidad federativa: </span> {{ $doc->state }}</p>
        <p><span style="font-weight:bold;">Teléfono de casa: </span> {{ $doc->house_phone }}</p>
        <p><span style="font-weight:bold;">Teléfono celular: </span> {{ $doc->cell_phone }}</p>
        <p><span style="font-weight:bold;">Teléfono de trabajo: </span> {{ $doc->work_phone }}</p>
        <p><span style="font-weight:bold;">Extensión: </span> {{ $doc->work_phone_ext }}</p>
        <p><span style="font-weight:bold;">Correo electrónico: </span> {{ $doc->email }}</p>
    </div>
    <div>
        <h3>Escolaridad de la persona que requiere el servicio</h3>
        <p><span style="font-weight:bold;">{{ $doc->scholarship }}: </span>{{ $doc->studied_years }} años</p>
    </div>
    <div>
        <h3>Situación laboral de la persona que requiere el servicio</h3>
        <p><span style="font-weight:bold;">¿Trabaja actualmente?</span> {{ $doc->has_work? 'Si':'No' }}</p>
        @if($doc->has_work)
        <p><span style="font-weight:bold;">¿Recibe remuneración económica por su trabajo?</span> {{ $doc->has_salary? 'Si':'No' }}</p>
        <p><span style="font-weight:bold;">Descripción de su trabajo: </span> {{ $doc->work_description }}</p>
        @else
        <p><span style="font-weight:bold;">Depende de: </span> {{ $doc->who_depends_on }}</p>
        @endif
        <p><span style="font-weight:bold;">Número de integrantes del hogar </span> (contando a la persona que requiere el servicio): {{ $doc->household_members }}</p>
        <p><span style="font-weight:bold;">Ingreso familiar mensual:</span> {{ $doc->monthly_family_income }}</p>
        <p><span style="font-weight:bold;">Número de personas que aportan a este ingreso </span>(contando la persona que requiere el servicio): {{ $doc->number_people_contributing }}</p>
        <p><span style="font-weight:bold;">Número de personas que dependen de este ingreso </span>(contando la persona que requiere el servicio): {{ $doc->number_people_depending }}</p>
        <p><span style="font-weight:bold;">Su casa es:</span> {{ $doc->house_is }}</p>
        @if($doc->house_other != null)
        <p><span style="font-weight:bold;">Otra:</span> {{ $doc->house_other }}</p>
        @endif
    </div>
    <div>
        <h3>Sobre el servicio que se solicita</h3>
        <p><span style="font-weight:bold;">Tipo de servicio:</span> {{ $doc->service_type }}</p>
        <p><span style="font-weight:bold;">Modalidad de servicio que solicita:</span> {{ $doc->service_modality }}</p>
        <p><span style="font-weight:bold;">Motivo de consulta: </span>{{ $doc->consultation_cause }}</p>
        {{-- <p><span style="font-weight:bold;">Clasificación del motivo de consulta según la Guía mhGAP</span> {{ $doc->mhGAP_cause_classification }}</p> --}}
        <p><span style="font-weight:bold;">¿Desde cuándo le pasa esto?</span> {{ $doc->problem_since }}</p>
        <p><span style="font-weight:bold;">¿Ha recibido anteriormente tratamiento para dar solución a esta situación?</span> {{ $doc->has_recived_previous_treatment? 'Si':'No' }}</p>
        @if ($doc->has_recived_previous_treatment)
        <p><span style="font-weight:bold;">Tipo de atención que ha recibido</span> {{ $doc->type_previous_treatment }}</p>
        <p><span style="font-weight:bold;">Número de veces que ha sido atendido para esta situación</span> {{ $doc->number_times_treatment }}</p>
        @endif
        <p><span style="font-weight:bold;">¿Viene referido de otra institución?</span> {{ $doc->refer }}</p>
        @if ($doc->refer != 0)
        <p style="font-weight:bold;">Problemática referido de la institución</p>
        <p>{{ $doc->refer_problem }}</p>
        @endif
        <p><span style="font-weight:bold;">¿Ha recibido atención en otros Centros y/o programss de la facultad para su motivo de consulta?</span> {{ $doc->unam_previous_treatment? 'Si':'No' }}</p>
        @if ($doc->unam_previous_treatment)
        <p><span style="font-weight:bold;">Centro/Programa</span> {{ $doc->prev_program->nombre }}</p>
        @endif
        <p><span style="font-weight:bold;">¿Tiene algún problema de salud?</span> {{ $doc->has_health_issue? 'Si':'No' }}</p>
        @if ($doc->has_health_issue)
        <p><span style="font-weight:bold;">¿Cuál?</span> {{ $doc->health_issue }}</p>
        <p><span style="font-weight:bold;">¿Toma medicamentos?</span> {{ $doc->takes_medication? 'Si':'No' }}</p>
        @if ($doc->takes_medication)
        <p><span style="font-weight:bold;">¿Cuáles?</span> {{ $doc->medication }}</p>
        <p><span style="font-weight:bold;">Dosis</span> {{ $doc->medication_dose }}</p>
        @endif
        <p><span style="font-weight:bold;">Horario de preferencia</span> {{ $doc->prefer_time }}</p>
        @endif
        <br>
    </div>
    <div>
        <p><span style="font-weight:bold;">Nombre de quien realizó el primer contacto: </span> {{ $doc->other_filler != null ? $doc->other_filler : $doc->user->type == 3 ? $doc->user->partaker->full_name : $doc->user->supervisor->full_name }}</p>
        <p><span style="font-weight:bold;">Centro donde se realizó el primer contacto: </span> {{ $doc->center->nombre }}</p>

    </div>
</section>
@endsection