@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h1 style="text-align:center;">Hoja de egreso</h1>
    <div style="text-align:right;">
        <p><span style="font-weight:bold;">No. Expediente: </span>{{ $doc->assign->patient->fdg->center->siglas.'-'.$doc->assign->patient->fdg->file_year.'-'.$doc->assign->patient->fdg->file_number }}</p>
        <p><span style="font-weight:bold;">Registrado el: </span>{{ $doc->created_at->format('d/m/Y') }}</p>
    </div>
    <div>
        <p><span style="font-weight:bold;">Nombre:</span>{{ $doc->assign->patient->fdg->full_name }}</p>
        <p><span style="font-weight:bold;">Centro:</span>{{ $doc->assign->program->center->nombre }}</p>
        <p><span style="font-weight:bold;">Programa:</span>{{ $doc->assign->program->programa }}</p>
        <p><span style="font-weight:bold;">Supervisor:</span>{{ $doc->assign->program->supervisor->full_name }}</p>
        <p><span style="font-weight:bold;">Registrado por: </span>{{ $doc->user_id == 3 ? $doc->user->partaker->full_name : $doc->user->supervisor->full_name }}</p>
    </div>
    <div>
        <br>
        <p><span style="font-weight:bold;">Tipo de egreso: </span>{{ $doc->egress_type }}</p>
        <p><span style="font-weight:bold;">Descripción del egreso: </span>{{ $doc->descripcion_del_egreso }}</p>
        <p><span style="font-weight:bold;">Observaciones/recomendaciones: </span>{{ $doc->observaciones_recomendaciones }}</p>
    </div>
    <div>
        <table class="table is-fullwidth is-striped is-hoverable">
            <thead>
                <tr>
                    @foreach ($fields['hita']['headers'] as $header)
                    <th>{{$header}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($fields['hita']['questions'] as $i=>$question)
                <tr>
                    <td>{{$question}}</td>
                    <td>{{ $doc['hi'.($i+1)]}} %</td>
                    <td>{{ $doc['hi'.($i+1)]}} %</td>
                    <td>{{ $doc['hi'.($i+1)] ? 'Si':'No' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection