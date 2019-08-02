@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h1 style="text-align:center;">Hoja de egreso</h1>
    <div style="text-align:right;">
        <p><span style="font-weight:bold;">No. Expediente: </span>{{ $doc->file_number }}</p>
        <p><span style="font-weight:bold;">Fecha: </span>{{ $doc->created_at->format('d/m/Y') }}</p>
    </div>
    <div>
        <p><span style="font-weight:bold;">Documento registrado por: </span>{{ $doc->user_id == 3 ? $doc->user->partaker->full_name : $doc->user->supervisor->full_name }}</p>
    </div>
    <div>
        <br>
        <p><span style="font-weight:bold;">Tipo de egreso: </span>{{ $doc->egress_type }}</p>

    </div>
</section>
@endsection