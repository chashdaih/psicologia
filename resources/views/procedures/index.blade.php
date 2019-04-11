@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">

        <h1 class="title">Procedimientos</h1>
        <h2 class="subtitle">Coordinación de centros de formación y servicios psicológicos</h2>

        <div class="list is-hoverable">
            <a href="#" class="list-item">Elaboración y seguimiento de planeación estratégica y operativa</a>
            <a href="{{ route('procedures', 'ie')  }}" class="list-item">Ingreso del estudiante</a>
            <a href="{{ route('procedures', 'fe')  }}" class="list-item">Servicios psicológicos a través de la Formación Supervisada del Estudiante</a>
            <a href="{{ route('procedures', 'ee')  }}" class="list-item">Egreso del estudiante</a>
            <a href="#" class="list-item">Gestión de recursos humanos, materiales y financieros</a>
        </div>

    </div>
</section>
    
@endsection