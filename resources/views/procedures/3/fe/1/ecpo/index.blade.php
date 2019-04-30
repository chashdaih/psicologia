@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('procedures') }}">Procedimientos</a></li>
                <li ><a href="{{ route('procedures', 'fe') }}" aria-current="page">Servicios psicológicos a través de la Formación Supervisada del Estudiante</a></li>
                <li ><a href="#" aria-current="page">Seguimiento y monitoreo de la adquisición de competencias de los estudiantes</a></li>
                <li class="is-active"><a href="#" aria-current="page">{{ $doc_name }}</a></li>
            </ul>
        </nav>
        <h1 class="title">{{ $doc_name }}</h1>
        {{-- <p class="subtitle">Elige una opción</p> --}}
        <button class="button"><a href="{{ route($doc_code.'.create') }}">Llenar nuevo cuestionario</a></button>
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Nombre del estudiante</th>
                    <th>Ver online</th>
                    <th>Generar pdf</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>
                        {{ $record->its_student->nombre_t }}
                    </td>
                    <td>
                        <a href="{{ route($doc_code.'.show', $record->id) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                    </td>
                    <td>
                        <a href="{{ route($doc_code.'_pdf', $record->id) }}">
                            <fai icon="file-pdf" size="2x" />
                        </a>
                    </td>
                    {{-- <td>
                        <a href="{{ route($doc_code.'.show', $record->id) }}"><i class="far fa-file-code fa-2x"></i></a>
                    </td>
                    <td>
                        <a href="{{ route($doc_code.'_pdf', $record->id) }}"><i class="far fa-file-pdf fa-2x"></i></a>
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection