@extends('layouts.base')

@section('content')
<section class="section">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{route('usuario.index')}}">Personas atendidas</a></li>
                <li class="is-active"><a href="#">Recepción</a></li>
            </ul>
        </nav>
    <div class="container">
        <h1 class="title">Recepción del {{$centerName}}</h1>
        <rec-table :patients="{{json_encode($patients)}}"></rec-table>
        {{-- <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. de expediente</th>
                        <th>Fecha de entrevista</th>
                        <th>Terapeuta entrevista inicial</th>
                        <th>Nombre del paciente</th>
                        <th>Edad</th>
                        <th>Sexo</th>
                        <th>Edo. civil</th>
                        <th>Nombre del responsable (En caso de ser menor de edad)</th>
                        <th>Alcaldía o municipio</th>
                        <th>Teléfonos</th>
                        <th>Email</th>
                        <th>Nivel estudios</th>
                        <th>¿Trabaja? (En caso de ser menor de edad, si el responsable trabaja)</th>
                        <th>Ocupación</th>
                        <th>Ingreso familiar</th>
                        <th>Dependientes económicos</th>
                        <th>Número de integrantes del hogar (contando al Px)</th>
                        <th>Motivo consulta referido por el paciente</th>
                        <th>Tiempo transcurrido en que comenzó la problemática</th>
                        <th>Tratamientos anteriores</th>
                        <th>Tipo de atención recibida</th>
                        <th>¿Fue referido?</th>
                        <th>¿De que institución fue canalizado?</th>
                        <th>Diagnostico de la institución de referencia</th>
                        <th>Otros problemas de salud (especificar)</th>
                        <th>¿Toma medicamentos?</th>
                        <th>Nombre del medicamento</th>
                        <th>Horario de preferencia</th>
                        <th>Programa asignado</th>
                        <th>Nombre del supervisor del programa</th>
                        <th>Fecha asignación al programa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $p)
                    <tr>
                        <td>{{$p->file_number}}</td>
                        <td>{{$p->created_at->format('d/m/Y')}}</td>
                        <td>{{$p->other_filler ? $p->other_filler : ($p->user->type == 3 ? $p->user->partaker->fullName : $p->user->supervisor->fullName)}}</td>
                        <td>{{$p->fullName}}</td>
                        <td>{{$p->birthdate->age}}</td>
                        <td>{{$p->gender ? 'Hombre':'Mujer'}}</td>
                        <td>{{$p->marital}}</td>
                        <td>{{$p->name_requester or 'N/A'}}</td>
                        <td>{{$p->municipality}}</td>
                        <td>{{$p->phones}}</td>
                        <td>{{$p->email or '-'}}</td>
                        <td>{{$p->studyLevel}}</td>
                        <td>{{$p->hasWork ? 'Si':'No'}}</td>
                        <td>{{$p->work_description or 'N/A'}}</td>
                        <td>{{$p->monthly_family_income}}</td>
                        <td>{{$p->number_people_depending}}</td>
                        <td>{{$p->household_members}}</td>
                        <td>{{$p->consultation_cause}}</td>
                        <td>{{$p->problem_since}}</td>
                        <td>{{$p->has_recived_previous_treament ? 'Si':'No'}}</td>
                        <td>{{$p->type_previous_treatment or 'N/A'}}</td>
                        <td>{{$p->refer ? 'Si':'No'}}</td>
                        <td>{{$p->refer_where or 'N/A'}}</td>
                        <td>{{$p->refer_problem or 'N/A'}}</td>
                        <td>{{$p->has_health_issue ? $p->health_issue : 'No'}}</td>
                        <td>{{$p->takes_medication ? 'Si':'No'}}</td>
                        <td>{{$p->medication or 'N/A'}}</td>
                        <td>{{$p->times}}</td>
                        <td>{{$p->patient ? ($p->patient->assigned->first() ? $p->patient->assigned->first()->program->programa : 'Sin referir') : '!'}}</td>
                        <td>{{$p->patient ? ($p->patient->assigned->first() ? $p->patient->assigned->first()->program->supervisor->fullName : 'Sin referir') : '!'}}</td>
                        <td>{{$p->patient ? ($p->patient->assigned->first() ? $p->patient->assigned->first()->created_at->format('d/m/Y') : 'Sin referir') : '!'}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}
    </div>
</section>
@endsection