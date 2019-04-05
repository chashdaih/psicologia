@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('students') }}">Estudiantes</a></li>
                <li><a href="{{ route('fe3cdr.index') }}" aria-current="page">Detección de riesgos en la salud física y mental</a></li>
                <li class="is-active"><a href="#" aria-current="page">Registrar nuevo cuestionario</a></li>
            </ul>
        </nav>
        <h1 class="title"> Registrar cuestionario</h1>
        <p>Califica de 0 a 10 qué tanto te describe cada una de las preguntas. "0" no me describe en lo absoluto, "1" me describe muy poco hasta "10" me describe exactamente.</p>
        <cdr-form
            :fdgs="{{ $fdgs }}"
            :sections="{{ $sections }}"
            :programs="{{ $programs }}"
            url = "{{ route('fe3cdr.store') }}"
            redirect = "{{ route('fe3cdr.index') }}"
        ></cdr-form>
    </div>
</section>
@endsection