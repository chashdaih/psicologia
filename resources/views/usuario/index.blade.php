@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <div class="has-text-centered">
            <a href="{{route('usuario.create')}}" class="button is-success is-centered is-large">Registrar usuario</a>
        </div>
        @if(Auth::user()->type > 4)
        @include('layouts.usuario.porAsignar')
        @endif
        @include('layouts.usuario.porCdr')
        @include('layouts.usuario.asignados')
    </div>
</section>
@endsection