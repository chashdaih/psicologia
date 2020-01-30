@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h1 style="text-align:center;">Resultados de evaluación</h1>
    <div style="text-align:right;">
        {{-- <p><span style="font-weight:bold;">No. de cuenta/Trabajador/CURP del usuario: </span>{{ $doc->patient->curp }}</p> --}}
        <p><span style="font-weight:bold;">No. expediente: </span>{{ $patient->fdg->file_number }}</p>
        <p><span style="font-weight:bold;">No. de cuenta/Trabajador/CURP: </span>{{ $patient->fdg->curp }}</p>
        <p><span style="font-weight:bold;">Fecha: </span>{{ $doc->created_at->format('d/m/Y') }}</p>
    </div>
    <div>
        <p><span style="font-weight:bold;">Nombre: </span>{{ $patient->fdg->full_name }}</p>
        <p><span style="font-weight:bold;">Centro: </span>{{ $doc->assign->program->center->nombre }}</p>
        <p><span style="font-weight:bold;">Programa: </span>{{ $doc->assign->program->programa }}</p>
        <p><span style="font-weight:bold;">Académico/Supervisor: </span>{{ $doc->assign->program->supervisor->full_name }}</p>
        <p><span style="font-weight:bold;">Registrado por: </span>{{ $doc->user->type == 3 ? $doc->user->partaker->full_name : $doc->user->supervisor->full_name }}</p>
        <br>
    </div>
    <div>
        <br>
        <table style="width: 100%; table-layout: fixed">
            <tr>
                <th>Instrumentos</th>
                <th>Resultados obtenidos</th>
            </tr>
            <tr>
                <td>{{$doc->tecnicas_evaluacion}}</td>
                <td>{{$doc->resultados_obtenidos}}</td>
            </tr>
        </table>
        <br>
        <b>Indicadores de evolución</b>
        <textarea>{{$doc->indicadores_evolucion}}</textarea>
        <br>
        <p><span style="font-weight:bold;">¿Fue necesario hacer referencia?: </span>{{ $doc->referencia_necesaria? 'Si': 'No' }}</p>
        <br>
        <b>Impresión diagnóstica o tipo de problemática</b>
        <textarea>{{$doc->tipo_problematica}}</textarea>
    </div>
</section>
@endsection