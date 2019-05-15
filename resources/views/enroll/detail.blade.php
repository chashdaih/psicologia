@extends('layouts.base')

@section('content')
<section class="section">
    <h1 class="title">Detalles de la práctica</h1>
    <h2 class="subtitle">{{ $program->programa }}</h2>
    <div class="box">
        <div class="columns">
            <div class="column has-text-centered">
                <form action="{{ route('insc.enroll', $program->id_practica) }}" method="POST" >
                    {{ csrf_field() }}
                    <button class="button is-primary is-large" type="submit">Inscribirme al programa</button>
                </form>
            </div>
        </div>
        <div class="columns">
            <div class="column is-one-fifth"><p class="has-text-weight-bold">Resumen del programa</p></div>
            <div class="column">{{ $extra->resumen }}</div>
        </div>
        <div class="columns">
            <div class="column is-one-fifth"><p class="has-text-weight-bold">Justificación</p></div>
            <div class="column">{{ $extra->justificacion }}</div>
        </div>
        <div class="columns">
            <div class="column is-one-fifth"><p class="has-text-weight-bold">Objetivo general</p></div>
            <div class="column">{{ $extra->objetivo_g }}</div>
        </div>
        <div class="columns">
            <div class="column is-one-fifth"><p class="has-text-weight-bold">Objetivo especifico</p></div>
            <div class="column">{{ $extra->objetivo_es }}</div>
        </div>
        @if ($extra->cont_tematico)
        <div class="columns">
            <div class="column is-one-fifth"><p class="has-text-weight-bold">Contenido temático</p></div>
            <div class="column">{{ $extra->cont_tematico }}</div>
        </div>
        @endif
        @if ($extra->metodologia)
        <div class="columns">
            <div class="column is-one-fifth"><p class="has-text-weight-bold">Metodología a seguir</p></div>
            <div class="column">{{ $extra->metodologia }}</div>
        </div>
        @endif
        <div class="columns">
            <div class="column is-one-fifth"><p class="has-text-weight-bold">Criterios de evaluación</p></div>
            <div class="column">{{ $extra->criterios_eva }}</div>
        </div>
        <div class="columns">
            <div class="column is-one-fifth"><p class="has-text-weight-bold">Requisitos para obtener constancia</p></div>
            <div class="column">{{ $extra->requisitos }}</div>
        </div>
        <div class="columns">
            <div class="column is-one-fifth"><p class="has-text-weight-bold">Recursos utilizados en el programa</p></div>
            <div class="column">{{ $extra->recursos }}</div>
        </div>
        <div class="columns">
            <div class="column is-one-fifth"><p class="has-text-weight-bold">Referencias</p></div>
            <div class="column">{{ $extra->referencias }}</div>
        </div>
    </div>
</section>
@endsection