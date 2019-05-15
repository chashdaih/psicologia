@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1>
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
                    @foreach ($record->ie4s as $ie4)
                    <tr>
                        <td>{{ $ie4->full_name }}</td>
                        <td>{{ $record->programa }}</td>
                        <td>
                            <a href="{{ route($doc_code.'_download', $record->id_practica.'_'.$ie4->num_cuenta) }}">
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