@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Usuarios registrados al programa</h1>
        <div class="has-text-centered">
            <a href="{{ route('fdg.create') }}" class="button is-info">Registrar persona atendida (3-FE3-FDG)</a>
        </div>
        {{-- <partaker-search url="{{ url('/') }}"></partaker-search> --}}
        <br>
        @if (count($patients))
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Editar ficha de datos generales </th>
                    <th>Descargar ficha en pdf</th>
                    {{-- <th>Eliminar</th> --}}
                </tr>
            </thead>
            @foreach ($patients as $patient)
            <tr>
                <td>{{ $patient->full_name }}</td>
                <td>
                    <a href="">
                        <fai icon="file-code" size="2x" />
                    </a>
                </td>
                <td>
                    <a href="">
                        <fai icon="file-code" size="2x" />
                    </a>
                </td>
            </tr>
            @endforeach
        </table>
        @else
        <p>No hay personas atendidas registradas en el programa</p>
        @endif
    </div>
</section>
@endsection
