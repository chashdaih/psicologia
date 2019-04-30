@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('procedures') }}">Procedimientos</a></li>
                <li class="is-active"><a href="#" aria-current="page">Ficha de datos generales</a></li>
            </ul>
        </nav>
        <h1 class="title">Ficha de datos generales</h1>
        <p class="subtitle">Elige una opción</p>
        <a href="{{ route('fdg.create') }}">Registrar nuevo paciente</a>
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
                        <a href="{{ route('fdg_html', $record->id) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('fdg', $record->id) }}">
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