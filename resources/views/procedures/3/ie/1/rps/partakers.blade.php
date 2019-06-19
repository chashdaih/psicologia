@extends('layouts.base')

@section('content')
<section class="section">
    {{-- @include('layouts.breadcrumbs') --}}
    @if(session('success'))
    <div class="notification is-primary">
        {{ session('success') }}
    </div>
    @endif
    @if(count($pps))
    <h1 class="title">Alumnos inscritos al programa "{{ $pps[0]->program->programa}}"</h1>
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
            </tr>
        </thead>
        <tbody>
            @foreach ($pps as $pp)
                <tr>
                    <td>{{ $pp->partaker->full_name }}</td>
                    <td>{{ $pp->estado }}</td>
                    <td>@if($pp->document->seguro_imss)
                        <a href="{{ route('seguro', $pp->document->id_tramite) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                        @else
                        <fai icon="times" size="2x" />
                        @endif
                    </td>
                    <td>@if($pp->document->carta_compromiso)
                        <a href="{{ route('carta_compromiso', $pp->document->carta_compromiso) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                        @else
                        <fai icon="times" size="2x" />
                        @endif
                    </td>
                    <td>@if($pp->document->historial_academico)
                        <a href="{{ route('historial_academico', $pp->document->historial_academico) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                        @else
                        <fai icon="times" size="2x" />                        
                        @endif
                    </td>
                </tr>
       
            @endforeach
        </tbody>
    </table>
    @else
    <p class="title">{{ $program->programa }}</p>
    <p class="subtitle">Aún no hay alumnos inscritos al programa.</p>
    @endif
</section>
@endsection