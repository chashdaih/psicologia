@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Resumen de sesión</h1>
        {{-- <h2 class="subtitle">{{ $program->programa }}</h2> --}}
        <div class="container">
            <a class="button is-info" href="{{ $isIntervention ? route('intervencion.create', $patient_id) : route('breve.create', $patient_id) }}">Registrar resumen de sesión y subir documento</a>
        </div>
        <br />
        @if (count($records))
        <table class="table is-fullwidth is-hoverable is-striped">
            <thead>
                <tr>
                    <th>Programa asignado</th>
                    <th>Número de sesión</th>
                    <th>Registrado por</th>
                    <th>Fecha de registro</th>
                    <th>Editar o subir otro archivo</th>
                    <th>Ver pdf</th>
                    <th>Generar excel</th>
                    <th>Descargar archivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <td>{{$record->assign->program->programa}}</td>
                        <td>{{$record->session_number}}</td>
                        @if($record->user->type == 3)
                        <td>{{$record->user->partaker->full_name}}</td>
                        @else
                        <td>{{$record->user->supervisor->full_name}}</td>
                        @endif
                        <td>{{$record->created_at->format('d/m/Y')}}</td>
                        <td class="has-text-centered" >
                            <a href="{{ route($code_name.'.edit', ['patient_id'=>$patient_id, 'id'=>$record->id]) }}">
                                <fai icon="edit" size="2x" />
                            </a>
                        </td>
                        <td class="has-text-centered">
                            <a href="{{ route($code_name.'.show', ['patient_id'=>$patient_id, 'id'=>$record->id]) }}" class="button is-link">
                                <fai icon="file-pdf" size="1x" />
                            </a>
                        </td>
                        <td class="has-text-centered" >
                            <a href="{{ route('rse', $record->id) }}" class="button is-success">
                                <fai icon="file-excel" size="1x" />
                            </a>
                        </td>
                        <td class="has-text-centered" >
                            @if(file_exists($path.$record->id.'.pdf'))
                            <a href="{{ route('usuario.bajar', ['patient_id'=>$patient_id, 'code'=>$code_name,'id'=>$record->id, 'extension'=>'pdf']) }}">
                                <fai icon="download" size="2x" />
                            </a>
                            @elseif(file_exists($path.$record->id.'.png'))
                            <a href="{{ route('usuario.bajar', ['patient_id'=>$patient_id, 'code'=>$code_name,'id'=>$record->id, 'extension'=>'png']) }}">
                                <fai icon="download" size="2x" />
                            </a>
                            @elseif(file_exists($path.$record->id.'.jpg'))
                            <a href="{{ route('usuario.bajar', ['patient_id'=>$patient_id, 'code'=>$code_name,'id'=>$record->id, 'extension'=>'jpg']) }}">
                                <fai icon="download" size="2x" />
                            </a>
                            @elseif(file_exists($path.$record->id.'.jpeg'))
                            <a href="{{ route('usuario.bajar', ['patient_id'=>$patient_id, 'code'=>$code_name,'id'=>$record->id, 'extension'=>'jpeg']) }}">
                                <fai icon="download" size="2x" />
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
        <p>No se han registrado resumenes de sesión para el usuario seleccionado.</p>
        @endif
    </div>
</section>
@endsection