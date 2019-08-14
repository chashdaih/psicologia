@extends('layouts.base')

@section('content')
<section class="section">
    <h1 class="title">Alumnos inscritos al programa "{{ $program->programa}}"</h1>
    <div>
        <a href="{{ route('lps_pdf', $program->id_practica) }}" class="button is-info">Descargar lista de estudiantes inscritos en pdf (3-IE2-LPS)</a>
    </div>
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
            @foreach ($pps as $pp)
                <tr>
                    <td>{{ $pp->partaker->full_name }}</td>
                    <td>{{ $pp->estado }}</td>
                    <td>@if($pp->document && $pp->document->seguro_imss)
                        <a href="{{ route('get_document', [$pp->document->id_tramite, 'seguro']) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                        @else
                        <fai icon="times" size="2x" />
                        @endif
                    </td>
                    <td>@if($pp->document && $pp->document->carta_comp)
                        <a href="{{ route('get_document', [$pp->document->id_tramite, 'carta']) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                        @else
                        <fai icon="times" size="2x" />
                        @endif
                    </td>
                    <td>@if($pp->document && $pp->document->historial_ac)
                        <a href="{{ route('get_document', [$pp->document->id_tramite, 'historial']) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                        @else
                        <fai icon="times" size="2x" />                        
                        @endif
                    </td>
                    <td>
                        @if ($pp->evaluate_student && $pp->evaluate_student->e1)
                            <a href="{{route('ecpr.edit', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante, 'ecpr'=>$pp->evaluate_student->e1])}}">Editar</a> / <a href="{{route('ecpr.show', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante, 'ecpr'=>$pp->evaluate_student->e1])}}">Pdf</a>
                        @else
                            <a href="{{route('ecpr.create', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante])}}">Registrar</a>
                        @endif
                    </td>
                    <td>
                        @if ($pp->evaluate_student && $pp->evaluate_student->e2)
                        <a href="{{route('ecpr.edit', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante, 'ecpr'=>$pp->evaluate_student->e1])}}">Editar</a> / <a href="{{route('ecpr.show', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante, 'ecpr'=>$pp->evaluate_student->e1])}}">Pdf</a>
                        @else
                            <a href="{{route('ecpr.create', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante])}}">Registrar</a>
                        @endif
                    </td>
                    <td>
                        @if ($pp->evaluate_student && $pp->evaluate_student->e3)
                        <a href="{{route('ecpr.edit', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante, 'ecpr'=>$pp->evaluate_student->e1])}}">Editar</a> / <a href="{{route('ecpr.show', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante, 'ecpr'=>$pp->evaluate_student->e1])}}">Pdf</a>
                        @else
                            <a href="{{route('ecpr.create', ['program_id'=>$program->id_practica, 'partaker_id'=>$pp->id_participante])}}">Registrar</a>
                        @endif
                    </td>
                    <td></td>
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