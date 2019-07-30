@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Cuestionario de detección de riesgos en la salud física y mental</h1>
        <h2 class="subtitle">Para el paciente NOMBRE en el programa PROGRAMA</h2>
        {{-- <div class="tile is-ancestor">
            <div class="tile is-vertical is-parent">
                <div class="tile is-child has-text-centered">
                    <a href="{{route('cdr.create', ['patient_id'=>$patient_id])}}" class="button is-large is-info">
                        <span class="file-icon">
                            <fai icon="plus-circle" />
                        </span>
                        <span class="file-label">Registrar cdr</span>
                    </a>
                </div>
                <div class="tile is-child has-text-centered">
                    <a href="#" class="button">registrar cdr</a>
                </div>
            </div>
            <div class="tile is-vertical is-parent">
                    <div class="tile is-child has-text-centered">
                        <a href="#" class="button">registrar cdr</a>
                    </div>
                    <div class="tile is-child has-text-centered">
                        <a href="#" class="button">registrar cdr</a>
                    </div>
            </div>
        </div> --}}
        <div class="columns">
            <div class="column has-text-centered">
                @if(count($cdr) == 0)
                <a href="{{route('cdr.create', ['patient_id'=>$patient_id])}}" class="button is-large is-success">
                    <span class="file-icon">
                        <fai icon="plus-circle" />
                    </span>
                    <span class="file-label">Registrar nuevo CDR</span>
                </a>
                @else
                <a href="{{route('cdr.edit', ['patient_id'=>$patient_id, 'cdr'=>$cdr->id])}}" class="button is-large is-info">
                    <span class="file-icon">
                        <fai icon="edit" />
                    </span>
                    <span class="file-label">Editar CDR</span>
                </a>
                @endif
            </div>
            <div class="column  has-text-centered">
                @if(count($cdr)!=0)
                <a href="{{route('cdr.show', ['patient_id'=>$patient_id, 'cdr'=>$cdr->id])}}" class="button is-large is-info">
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
    </div>
</section>
@endsection
