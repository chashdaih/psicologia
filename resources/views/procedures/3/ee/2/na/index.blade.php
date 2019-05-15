@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1>
        {{-- <p class="subtitle">Elige una opción</p> --}}
        <div class="container">
            <button class="button"><a href="{{ route($doc_code.'.create') }}">Subir archivo</a></button>
        </div>

        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Nombre del prestador de servicio social</th>
                    <th>Programa</th>
                    <th>Descargar archivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    @foreach ($record->nas as $na)
                    <tr>
                        <td>{{ $na->full_name }}</td>
                        <td>{{ $record->programa }}</td>
                        <td>
                            <a href="{{ route($doc_code.'_download', $record->id_practica.'_'.$na->num_cuenta) }}">
                                <fai icon="file-pdf" size="2x" />
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection