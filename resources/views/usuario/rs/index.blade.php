@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Resumen de sesión</h1>
        {{-- <h2 class="subtitle">{{ $program->programa }}</h2> --}}
        <div class="container">
            <button class="button"><a href="{{ $isIntervention ? route('intervencion.create', $patient_id) : route('breve.create', $patient_id) }}">Registrar resumen de sesión</a></button>
        </div>
        <br />
        @if (count($records))

        <table-rs
            @if ($isIntervention)
                base-url="{{ route('intervencion.index', $patient_id) }}"
            @else
                base-url="{{ route('breve.index', $patient_id) }}"
            @endif
            :rss="{{json_encode($records)}}"
        ></table-rs>

        @else 
        <p>No se han registrado resumenes de sesión para el usuario seleccionado.</p>
        @endif
    </div>
</section>
@endsection