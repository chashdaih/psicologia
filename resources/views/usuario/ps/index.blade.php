@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Plan de servicio</h1>
        <h2 class="subtitle">Para la persona atendida: {{$patient->fdg->full_name}}</h2>
        <div>
            <a href="{{route('ps.create', $patient->id)}}" class="button is-info">Registrar plan de servicio y subir archivo</a>
        </div>
        <div><br></div>
        @if (count($records))
        <table class="table is-fullwidth is-hoverable is-striped">
            <thead>
                <tr>
                    <th>Programa asignado</th>
                    <th>Registrado por</th>
                    <th>Fecha de registro</th>
                    <th>Editar o subir otro archivo</th>
                    <th>Ver pdf</th>
                    <th>Generar excel</th>
                    <th>Descargar archivo</th>
                    <th>Borrar plan de servicio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <td>{{$record->assign->program->programa}}</td>
                        @if($record->user->type == 3)
                        <td>{{$record->user->partaker->full_name}}</td>
                        @else
                        <td>{{$record->user->supervisor->full_name}}</td>
                        @endif
                        <td>{{$record->created_at->format('d/m/Y')}}</td>
                        <td class="has-text-centered" >
                            <a  href="{{ route('ps.edit', ['patient_id'=>$patient->id, 'id'=>$record->id]) }}">
                                <fai icon="edit" size="2x" />
                            </a>
                        </td>
                        <td class="has-text-centered" >
                            <a href="{{ route('ps.show', ['patient_id'=>$patient->id, 'id'=>$record->id]) }}" class="button is-link">
                                <fai icon="file-pdf" size="1x" />
                            </a>
                        </td>
                        <td class="has-text-centered" >
                            <a href="{{ route('pse', $record->id) }}" class="button is-success">
                                <fai icon="file-excel" size="1x" />
                            </a>
                        </td>
                        <td class="has-text-centered" >
                        @if(file_exists($path.$record->id.'.pdf'))
                        <a href="{{ route('usuario.bajar', ['patient_id'=>$patient->id, 'code'=>'ps','id'=>$record->id, 'extension'=>'pdf']) }}">
                            <fai icon="download" size="2x" />
                        </a>
                        @elseif(file_exists($path.$record->id.'.png'))
                        <a href="{{ route('usuario.bajar', ['patient_id'=>$patient->id, 'code'=>'ps','id'=>$record->id, 'extension'=>'png']) }}">
                            <fai icon="download" size="2x" />
                        </a>
                        @elseif(file_exists($path.$record->id.'.jpg'))
                        <a href="{{ route('usuario.bajar', ['patient_id'=>$patient->id, 'code'=>'ps','id'=>$record->id, 'extension'=>'jpg']) }}">
                            <fai icon="download" size="2x" />
                        </a>
                        @elseif(file_exists($path.$record->id.'.jpeg'))
                        <a href="{{ route('usuario.bajar', ['patient_id'=>$patient->id, 'code'=>'ps','id'=>$record->id, 'extension'=>'jpeg']) }}">
                            <fai icon="download" size="2x" />
                        </a>
                        @else
                        <fai icon="times" size="2x" />
                        @endif
                        </td>
                        <td>
                            <ps-delete
                                patient-id="{{$patient->id}}"
                                ps="{{$record->id}}"
                                base-url="{{URL::to('/')}}"
                            ></ps-delete>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div>
            <p class="is-italic">No se ha registrado plan de servicio para la persona atendida.</p>
        </div>
        @endif
    </div>
</section>
@endsection
