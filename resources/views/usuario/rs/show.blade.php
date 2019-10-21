@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h1 style="text-align:center;">Resumen de sesión</h1>
    <div style="text-align:right;">
        <p><span style="font-weight:bold;">No. expediente: </span>{{ $doc->file_number }}</p>
        <p><span style="font-weight:bold;">Fecha: </span>{{ $doc->created_at->format('d/m/Y') }}</p>
    </div>
    <div>
        <p><span style="font-weight:bold;">Registrado por: </span>{{ $doc->user->type == 3 ? $doc->user->partaker->full_name : $doc->user->supervisor->full_name }}</p>
        <br><br>
        <p><span style="font-weight:bold;">Número de sesión: </span>{{ $doc->session_number }}</p>
        <p><span style="font-weight:bold;">Objetivo de la sesión: </span>{{$doc->session_objective}}</p>
        <p><span style="font-weight:bold;">Descripción/resumen de la sesión: </span>{{$doc->session_summary}}</p>
        <p><span style="font-weight:bold;">Técnicas/procedimientos/temas abordados en la sesión: </span>{{$doc->session_techniques}}</p>
        <p><span style="font-weight:bold;">Resultados: </span>{{$doc->session_results}}</p>
    </div>  
</section>
@endsection