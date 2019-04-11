@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Servicios psicológicos a través de la Formación Supervisada del Estudiante</h1>
        {{-- <h2 class="subtitle">Elija el procedimiento para algún paciente</h2> --}}

        @foreach ($procedures as $key => $procedure)
        <div class="card">
            <p class="card-header-title">{{ Str::upper($acronym).($key+1) }} - {{ $procedure['title'] }}</p>
            <div class="card-content">
                <div class="content">
                    <div class="list is-hoverable">
                        @foreach ($procedure['docs'] as $doc)
                        <a href="{{ route(Str::lower($doc['code']).'.index') }}"
                         class="list-item" >{{ $doc['code'] }} - {{ $doc['title'] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
    </div>
</section>
@endsection