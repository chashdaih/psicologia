@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h1 style="text-align:center;">Plan de servicios</h1>
    <div style="text-align:right;">
        <p><span style="font-weight:bold;">No. Expediente: </span>{{ $doc->file_number }}</p>
        <p><span style="font-weight:bold;">No. de cuenta/Trabajador/CURP: </span>{{ $doc->patient->curp }}</p>
        <p><span style="font-weight:bold;">Fecha: </span>{{ $doc->created_at->format('d/m/Y') }}</p>
    </div>
    <div>
        <p><span style="font-weight:bold;">Nombre: </span>{{ $doc->patient->full_name }}</p>
        <p><span style="font-weight:bold;">Centro: </span>{{ $doc->center->nombre }}</p>
        <p><span style="font-weight:bold;">Programa: </span>{{ $doc->program->programa }}</p>
        <p><span style="font-weight:bold;">Académico/Supervisor: </span>{{ $doc->supervisor->full_name }}</p>
        <p><span style="font-weight:bold;">Estudiante: </span>{{ $doc->student->nombre_t }}</p>
        <p><span style="font-weight:bold;">Tipo de intervención: </span>{{ $doc->intervention_type }}</p>
        <p><span style="font-weight:bold;">Modalidad de servicio: </span>{{ $doc->service_modality }}</p>
    </div>
    <div>
        <p style="font-weight:bold;text-align:center;">Sugerencias de intervención</p>
        <textarea style="width:100%;">{{ $doc->intervention_suggestions }}</textarea>
    </div>
</section>
@endsection