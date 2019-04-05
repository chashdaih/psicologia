@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('students') }}">Estudiantes</a></li>
                <li><a href="{{ route('FE3FDG.index') }}" aria-current="page">Ficha de datos generales</a></li>
                <li class="is-active"><a href="#" aria-current="page">Registrar ficha de datos generales</a></li>
            </ul>
        </nav>
        <h1 class="title"> Registrar ficha de datos generales</h1>
        <p class="subtitle">Agregue los datos de la persona que requiere el servicio</p>
        <f-d-g-form url="{{ route('FE3FDG.store') }}" :programs="{{ $programs }}"></f-d-g-form>
    </div>
</section>
@endsection