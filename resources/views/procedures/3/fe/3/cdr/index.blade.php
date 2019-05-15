@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('procedures') }}">Procedimientos</a></li>
                <li class="is-active"><a href="#" aria-current="page">Cuestionario de detección de riesgos en la salud física y mental</a></li>
            </ul>
        </nav>
        <h1 class="title">Cuestionario de detección de riesgos en la salud física y mental</h1>
        <p class="subtitle">Elige una opción</p>
        <a href="{{ route('cdr.create') }}">Llenar nuevo cuestionario</a>
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
                        {{ $record->patient->full_name }}
                    </td>
                    <td>
                        <a href="{{ route('cdr_html', $record->id) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('cdr', $record->id) }}">
                            <fai icon="file-pdf" size="2x" />
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection