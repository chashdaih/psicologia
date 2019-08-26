@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h1 style="text-align:center;">Resultados de evaluación</h1>
    <div style="text-align:right;">
        {{-- <p><span style="font-weight:bold;">No. de cuenta/Trabajador/CURP del usuario: </span>{{ $doc->patient->curp }}</p> --}}
        <p><span style="font-weight:bold;">No. expediente: </span>{{ $doc->file_number }}</p>
        <p><span style="font-weight:bold;">Fecha: </span>{{ $doc->created_at->format('d/m/Y') }}</p>
    </div>
    <div>
        <p><span style="font-weight:bold;">Registrado por: </span>{{ $doc->user->type == 3 ? $doc->user->partaker->full_name : $doc->user->supervisor->full_name }}</p>
        <br><br>
        <p><span style="font-weight:bold;">¿Fue necesario hacer referencia?: </span>{{ $doc->referencia_necesaria? 'Si': 'No' }}</p>
        @if ($doc->referencia_necesaria)
        <p><span style="font-weight:bold;">Lugar de referencia: </span>{{ $doc->lugar_de_referencia }}</p>
        @endif
    </div>  
</section>
@endsection