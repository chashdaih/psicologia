@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Resultados de evaluación</h1>
        {{-- <h2 class="subtitle">Para el paciente NOMBRE en el programa PROGRAMA</h2> --}}
        <div class="columns">
            <div class="column has-text-centered">
                @if(count($re) == 0)
                <a href="{{route('re.create', ['patient_id'=>$patient_id])}}" class="button is-large is-success">
                    <span class="file-icon">
                        <fai icon="plus-circle" />
                    </span>
                    <span class="file-label">Registrar nuevo RE</span>
                </a>
                @else
                <a href="{{route('re.edit', ['patient_id'=>$patient_id, 're'=>$re->id])}}" class="button is-large is-info">
                    <span class="file-icon">
                        <fai icon="edit" />
                    </span>
                    <span class="file-label">Editar RE</span>
                </a>
                @endif
            </div>
            <div class="column  has-text-centered">
                @if(count($re)!=0)
                <a href="{{route('re.show', ['patient_id'=>$patient_id, 're'=>$re->id])}}" class="button is-large is-info">
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
                    <input type="hidden" value="re" name="tipo_documento">
                    <input type="hidden" value="{{$patient_id}}" name="patient_id">
                    <div class="file is-success is-large is-centered">
                        <label class="file-label">
                            <input class="file-input" accept="application/pdf" type="file" name="document" onchange="this.form.submit()">
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
                <a href="{{route('usuario.bajar', ['patient_id'=>$patient_id, 'clave'=>'re'])}}" class="button is-large is-info" 
                @if(!file_exists(public_path().'/storage/patients/'.$patient_id.'/re.pdf'))
                disabled
                @endif
                >
                    <span class="file-icon">
                        <fai icon="download" />
                    </span>
                    <span class="file-label">Descargar documento</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
