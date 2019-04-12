@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h1 style="text-align:center;">Plan de servicios</h1>
    <div style="text-align:right;">
        <p><span style="font-weight:bold;">No. de cuenta/Trabajador/CURP: </span>{{ $doc->patient->curp }}</p>
        <p><span style="font-weight:bold;">Fecha: </span>{{ $doc->created_at->format('d/m/Y') }}</p>
    </div>
    <div>
        <p><span style="font-weight:bold;">Nombre: </span>{{ $doc->patient->full_name }}</p>
        <p><span style="font-weight:bold;">Centro: </span>{{ $doc->center->nombre }}</p>
        <p><span style="font-weight:bold;">Programa: </span>{{ $doc->program->programa }}</p>
        <p><span style="font-weight:bold;">Académico/Supervisor: </span>{{ $doc->supervisor->full_name }}</p>
        <p><span style="font-weight:bold;">Estudiante: </span>{{ $doc->student->nombre_t }}</p>
        <p><span style="font-weight:bold;">¿Fue necesario hacer referencia?: </span>{{ $doc->refer_needed? 'Si': 'No' }}</p>
        @if ($doc->refer_needed)
        <p><span style="font-weight:bold;">Lugar de referencia: </span>{{ $doc->refer_place }}</p>
        @endif
    </div>  
</section>
@endsection