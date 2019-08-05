@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h1 style="text-align:center;">Plan de servicios</h1>
    <div style="text-align:right;">
        <p><span style="font-weight:bold;">No. Expediente: </span>{{ $doc->file_number }}</p>
        {{-- <p><span style="font-weight:bold;">No. de cuenta/Trabajador/CURP: </span>{{ $doc->user->fdg->curp }}</p> --}}
        <p><span style="font-weight:bold;">Fecha: </span>{{ $doc->created_at->format('d/m/Y') }}</p>
    </div>
    <div>
        {{-- <p><span style="font-weight:bold;">Nombre: </span>{{ $doc->user->fdg->full_name }}</p>
        <p><span style="font-weight:bold;">Centro: </span>{{ $doc->center->nombre }}</p> --}}
        <p><span style="font-weight:bold;">Documento registrado por: </span>{{ $doc->user->type == 3 ? $doc->user->partaker->full_name : $doc->user->supervisor->full_name }}</p>
        <p><span style="font-weight:bold;">Tipo de intervención: </span>{{ $doc->tipo_de_intervencion }}</p>
        <p><span style="font-weight:bold;">Modalidad de servicio: </span>{{ $doc->modalidad_de_servicio }}</p>
    </div>
    <div>
        <p style="font-weight:bold;text-align:center;">Sugerencias de intervención</p>
        <textarea style="width:100%;">{{ $doc->sugerencias_de_intervencion }}</textarea>
    </div>
</section>
@endsection