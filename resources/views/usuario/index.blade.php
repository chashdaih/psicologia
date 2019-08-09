@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <div class="has-text-centered">
            <a href="{{route('usuario.create')}}" class="button is-success is-centered is-large">Registrar persona a atender (3-FE3-FDG)</a>
            <div><br></div>
            @if(Auth::user()->type > 3)
            <a href="{{route('programs_excel')}}" class="button is-info">
                <span class="icon">
                    <fai icon="file-excel" />
                </span>
                <span>Descargar info programas</span>
            </a>
            <div><br></div>
            @endif
        </div>
        @if(Auth::user()->type > 4)
        @include('layouts.usuario.porAsignar')
        @endif
        @include('layouts.usuario.porCdr')
        @include('layouts.usuario.asignados')
    </div>
</section>
@endsection
