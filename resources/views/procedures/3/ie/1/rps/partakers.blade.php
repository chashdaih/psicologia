@extends('layouts.base')

@section('content')
<section class="section">
    {{-- @include('layouts.breadcrumbs') --}}
    {{-- @if(session('success'))
    <div class="notification is-primary">
        {{ session('success') }}
    </div>
    @endif --}}
    @if(count($pps))
    <h1 class="title">Alumnos inscritos al programa "{{ $pps[0]->program->programa}}"</h1>
    <div>
        <a href="{{ route('lps_pdf', $pps[0]->program->id_practica) }}" class="button is-info">Descargar lista de estudiantes inscritos en pdf (3-IE2-LPS)</a>
        <div>
            <br>
            <register-partaker url="{{URL::to('/')}}" :program="{{json_encode($pps[0]->program)}}"></register-partaker>
        </div>
    </div>
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
                    <td>@if($pp->document->seguro_imss)
                        <a href="{{ route('get_document', [$pp->document->id_tramite, 'seguro']) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                        @else
                        <fai icon="times" size="2x" />
                        @endif
                    </td>
                    <td>@if($pp->document->carta_comp)
                        <a href="{{ route('get_document', [$pp->document->id_tramite, 'carta']) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                        @else
                        <fai icon="times" size="2x" />
                        @endif
                    </td>
                    <td>@if($pp->document->historial_ac)
                        <a href="{{ route('get_document', [$pp->document->id_tramite, 'historial']) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                        @else
                        <fai icon="times" size="2x" />                        
                        @endif
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
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
    <p class="title">{{ $program->programa }}</p>
    <p class="subtitle">Aún no hay alumnos inscritos al programa.</p>
    <div>
        <br>
        <register-partaker url="{{URL::to('/')}}" :program="{{json_encode($program)}}"></register-partaker>
    </div>
    @endif
</section>
@endsection