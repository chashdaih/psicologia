@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1>

        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Nombre del programa</th>
                    <th>Número de estudiantes inscritos</th>
                    <th>Ver lista online</th>
                    <th>Descargar pdf</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>
                        {{ $record->programa }}
                    </td>
                    <td>{{ count($record->partakers) }}</td>
                    <td>
                        <a href="{{ route($doc_code.'.show', $record->id_practica) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                    </td>
                    <td>
                        <a href="{{ route($doc_code.'_pdf', $record->id_practica) }}">
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