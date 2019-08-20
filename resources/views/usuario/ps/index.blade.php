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
                    <th>Descargar archivo</th>
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
                            <a  href="{{ route('ps.show', ['patient_id'=>$patient->id, 'id'=>$record->id]) }}">
                                <fai icon="file-pdf" size="2x" />
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
                    </tr>
                @endforeach
            </tbody>
        </table>

        @else
        <div>
            <p class="is-italic">No se ha registrado plan de servicio para la persona atendida.</p>
        </div>
        @endif



        {{-- <div class="columns">
            <div class="column has-text-centered">
                @if(count($ps) == 0)
                <a href="{{route('ps.create', ['patient_id'=>$patient_id])}}" class="button is-large is-success">
                    <span class="file-icon">
                        <fai icon="plus-circle" />
                    </span>
                    <span class="file-label">Registrar nuevo ps</span>
                </a>
                @else
                <a href="{{route('ps.edit', ['patient_id'=>$patient_id, 'ps'=>$ps->id])}}" class="button is-large is-info">
                    <span class="file-icon">
                        <fai icon="edit" />
                    </span>
                    <span class="file-label">Editar ps</span>
                </a>
                @endif
            </div>
            <div class="column  has-text-centered">
                @if(count($ps)!=0)
                <a href="{{route('ps.show', ['patient_id'=>$patient_id, 'ps'=>$ps->id])}}" class="button is-large is-info">
                    <span class="file-icon">
                        <fai icon="file-pdf" />
                    </span>
                    <span class="file-label">Ver registro en pdf</span>
                </a>
                @else
                <a href="" class="button is-large is-info" disabled>
                    <span class="file-icon">
                        <fai icon="file-pdf" />
                    </span>
                    <span class="file-label">Ver registro en pdf</span>
                </a>
                @endif
            </div>
        </div>
        <br>
        <br>
        <div class="columns">
            <div class="column has-text-centered">
                <form action="{{ route('usuario.subir', $patient_id) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" value="ps" name="tipo_documento">
                    <input type="hidden" value="{{$patient_id}}" name="patient_id">
                    <div class="file is-success is-large is-centered">
                        <label class="file-label">
                            <input class="file-input" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" type="file" name="document" onchange="this.form.submit()">
                            <span class="file-cta">
                            <span class="file-icon">
                                <fai icon="upload" />
                            </span>
                            <span class="file-label">
                                Subir archivo
                            </span>
                            </span>
                        </label>
                    </div>
                </form>
            </div>
            <div class="column  has-text-centered">
                <a href="{{route('usuario.bajar', ['patient_id'=>$patient_id, 'clave'=>'ps'])}}" class="button is-large is-info" 
                @if(!file_exists(public_path().'/storage/patients/'.$patient_id.'/ps.pdf'))
                disabled
                @endif
                >
                    <span class="file-icon">
                        <fai icon="download" />
                    </span>
                    <span class="file-label">Descargar documento</span>
                </a>
            </div>
        </div> --}}
    </div>
</section>
@endsection
