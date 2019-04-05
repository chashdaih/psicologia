@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('students') }}">Estudiantes</a></li>
                <li class="is-active"><a href="#" aria-current="page">Ficha de datos generales</a></li>
            </ul>
        </nav>
        <h1 class="title">Ficha de datos generales</h1>
        <p class="subtitle">Elige una opción</p>
        <a href="{{ route('FE3FDG.create') }}">Registrar nuevo paciente</a>
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Nombre del paciente</th>
                    <th>Ver online</th>
                    <th>Generar pdf</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>
                        {{ $record->full_name }}
                    </td>
                    <td>
                        <a href="{{ route('fdg_html', $record->id) }}"><i class="far fa-file-code fa-2x"></i></a>
                    </td>
                    <td>
                        <a href="{{ route('fdg', $record->id) }}"><i class="far fa-file-pdf fa-2x"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection