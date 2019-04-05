@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Procedimientos estudiantes</h1>
        <h2 class="subtitle">Elija el procedimiento para algún paciente</h2>

        <div class="card">
            <p class="card-header-title">FE3 Primer contacto</p>
            <div class="card-content">
                <div class="content">
                    <div class="list is-hoverable">
                        <a class="list-item" href="{{ route("FE3FDG.index") }}">Ficha de datos generales (3-FE3-FDG)</a>
                        <a class="list-item" href="{{ route('fe3cdr.index') }}">Cuestionario de detección de riesgos en la salud física y mental (3-FE3-CDR)</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <p class="card-header-title">FE4 Admisión</p>
            <div class="card-content">
                <div class="content">
                    <div class="list is-hoverable">
                        <a class="list-item">Plan de servicios (3-FE4-PS)</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <p class="card-header-title">FE5 Evaluación</p>
            <div class="card-content">
                <div class="content">
                    <div class="list is-hoverable">
                        <a class="list-item">Resultados de evaluación (3-FE5-RE)</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <p class="card-header-title">FE6 Orientación/consejo breve</p>
            <div class="card-content">
                <div class="content">
                    <div class="list is-hoverable">
                        <a class="list-item">Resumen de sesión (3-FE3-RS)</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <p class="card-header-title">FE7 Intervención</p>
            <div class="card-content">
                <div class="content">
                    <div class="list is-hoverable">
                        <a class="list-item">Resumen de sesión (3-FE6-RS)</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <p class="card-header-title">FE8 Egreso</p>
            <div class="card-content">
                <div class="content">
                    <div class="list is-hoverable">
                        <a class="list-item">Hoja de egreso (3-FE8-HE)</a>
                        <a class="list-item">Cuestionario de satisfacción con el servicio psicológico (3-FE8-CSSP)</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
    
@endsection