@extends('layouts.base')

@section('content')
<section class="section">
    <h1 class="title">Alumnos inscritos al programa "{{ $program->programa}}"</h1>
    <div class="field is-grouped">
        <div class="control">
            <a href="{{ route('lps_pdf', $program->id_practica) }}" class="button is-info">
                <span class="icon"><fai icon="file-pdf" size="1x" /></span>
                <span>Descargar lista de estudiantes inscritos en pdf (3-IE2-LPS)</span>
            </a>
        </div>
        <div class="control">
            <a href="{{ route('students_list', $program->id_practica) }}" class="button is-info">
                <span class="icon"><fai icon="file-excel" size="1x" /></span>
                <span>Descargar excel con la información de esta pantalla</span>
            </a>
        </div>
    </div>
    <div>
    <div><br></div>
    @if($program->cupo_actual > 0)
    <div>
        <register-partaker url="{{URL::to('/')}}" :program="{{json_encode($program)}}"></register-partaker>
    </div>
    @else
    <div class="button is-success">
        <p class="is-italic">Programa sin cupo disponible</p>
    </div>
    <div><br></div>
    @endif
    @if(count($pps))
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre del alumno</th>
                <th>Estatus</th>
                <th>Seguro</th>
                <th>Carta Compromiso</th>
                <th>Historial</th>
                <th>Primera evaluación</th>
                <th>Segunda evaluación</th>
                <th>Tercera evaluación</th>
                <th>Satisfacción</th>
                {{-- TODO: dar de baja participantes --}}
                <th>Dar de baja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pps as $key=>$pp)
                <tr>
                    <td>{{ $pp->partaker->full_name }}</td>
                    <td>
                        @if(file_exists($base_path.$pp->id_tramite.'/seguro.pdf') && file_exists($base_path.$pp->id_tramite.'/carta.pdf') && file_exists($base_path.$pp->id_tramite.'/historial.pdf'))
                        Inscrito
                        @else
                        Necesita documentación
                        @endif
                    </td>
                    @if(isset($imssUrls))
                    <td>
                        @if($imssUrls[$key])
                        <a href="{{$imssUrls[$key]}}">descargar</a>
                        @else
                        <fai icon="times" size="2x" />
                        @endif
                    </td>
                    @else
                    <td>
                        @if(file_exists($base_path.$pp->id_tramite.'/seguro.pdf'))
                        <a href="{{ route('get_document', [$pp->id_tramite, 'seguro']) }}">
                            <fai icon="file-code" size="2x" />
                        </a> 
                        @else
                        <fai icon="times" size="2x" />
                        @endif
                    </td>
                    @endif
                    @if(isset($cartaUrls))
                    <td>
                        @if($cartaUrls[$key])
                        <a href="{{$cartaUrls[$key]}}">descargar</a>
                        @else
                        <fai icon="times" size="2x" />
                        @endif
                    </td>
                    @else
                    <td>
                        @if(file_exists($base_path.$pp->id_tramite.'/carta.pdf'))
                        <a href="{{ route('get_document', [$pp->id_tramite, 'carta']) }}">
                            <fai icon="file-code" size="2x" />
                        </a> 
                        @else
                        <fai icon="times" size="2x" />
                        @endif
                    </td>
                    @endif
                    @if(isset($historialUrls))
                    <td>
                        @if($historialUrls[$key])
                        <a href="{{$historialUrls[$key]}}">descargar</a>
                        @else
                        <fai icon="times" size="2x" />
                        @endif
                    </td>
                    @else
                    <td>
                        @if(file_exists($base_path.$pp->id_tramite.'/historial.pdf'))
                        <a href="{{ route('get_document', [$pp->id_tramite, 'historial']) }}">
                            <fai icon="file-code" size="2x" />
                        </a> 
                        @else
                        <fai icon="times" size="2x" />                        
                        @endif
                    </td>
                    @endif
                    <td>
                        @if ($pp->evaluate_student && $pp->evaluate_student->e1)
                            <a href="{{route('ecpr.edit', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante, 'ecpr'=>$pp->evaluate_student->e1])}}">Editar</a> / <a href="{{route('ecpr.show', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante, 'ecpr'=>$pp->evaluate_student->e1])}}">Pdf</a>
                        @else
                            <a href="{{route('ecpr.create', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante])}}">Registrar</a>
                        @endif
                    </td>
                    <td>
                        @if ($pp->evaluate_student && $pp->evaluate_student->e2)
                        <a href="{{route('ecpr.edit', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante, 'ecpr'=>$pp->evaluate_student->e2])}}">Editar</a> / <a href="{{route('ecpr.show', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante, 'ecpr'=>$pp->evaluate_student->e2])}}">Pdf</a>
                        @else
                            <a href="{{route('ecpr.create', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante])}}">Registrar</a>
                        @endif
                    </td>
                    <td>
                        @if ($pp->evaluate_student && $pp->evaluate_student->e3)
                        <a href="{{route('ecpr.edit', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante, 'ecpr'=>$pp->evaluate_student->e3])}}">Editar</a> / <a href="{{route('ecpr.show', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante, 'ecpr'=>$pp->evaluate_student->e3])}}">Pdf</a>
                        @else
                            <a href="{{route('ecpr.create', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante])}}">Registrar</a>
                        @endif
                    </td>
                    <td>
                        @if ($pp->evaluate_student && $pp->evaluate_student->es_id)
                        <a href="{{route('es.show', ['assign_id' => $pp->id_tramite, 'id' => $pp->evaluate_student->es_id])}}">Pdf</a>
                        @else 
                            <p class="has-text-centered">-</p>
                        @endif
                    </td>
                    <td>
                        <usuario-disenroll
                        url="{{route('insc.disenroll', $pp->id_tramite)}}"
                        program="{{$pp->program->programa}}"
                        partaker="{{$pp->partaker->full_name}}"
                        >{!! csrf_field() !!}</usuario-disenroll>
                    </td>
                </tr>
       
            @endforeach
        </tbody>
    </table>
    @else
    {{-- <p class="title">{{ $program->programa }}</p> --}}
    <p class="subtitle">Aún no hay alumnos inscritos al programa.</p>
    {{-- <div>
        <br>
        <register-partaker url="{{URL::to('/')}}" :program="{{json_encode($program)}}"></register-partaker>
    </div> --}}
    @endif
</section>
@endsection