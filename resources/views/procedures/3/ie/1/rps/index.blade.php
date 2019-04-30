@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1>
        {{-- <p class="subtitle">Elige una opción</p> --}}
        <div class="container">
            <button class="button"><a href="{{ route($doc_code.'.create') }}">Registrar nueva práctica</a></button>
        </div>

        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Nombre del programa</th>
                    {{-- <th>Centro</th> --}}
                    <th>Ver registro online</th>
                    <th>Descargar pdf</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>
                        {{ $record->program_name }}
                    </td>
                    {{-- <td>
                        {{ $record->center->nombre }}
                    </td> --}}
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
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection