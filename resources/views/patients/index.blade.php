@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">{{ $program->programa }}</h1>
        <h2 class="subtitle">Usuarios registrados al programa</h2>
        <div class="has-text-centered">
            <a href="{{ route('patient.create', ['program_id'=> $program->id_practica]) }}" class="button is-info">Registrar persona atendida (3-FE3-FDG)</a>
        </div>
        {{-- <partaker-search url="{{ url('/') }}"></partaker-search> --}}
        <br>
        @if (count($patients))
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Ir a lista de procedimientos</th>
                    @if (Auth::user()->type == 6)
                    <th>Eliminar</th>
                    @endif
                </tr>
            </thead>
            @foreach ($patients as $patient)
            <tr>
                <td>{{ $patient->full_name }}</td>
                <td>
                    <a href="{{ route('fe.index', ['program_id'=> $program->id_practica, 'patient_id'=>$patient->id]) }}">
                        <fai icon="arrow-circle-right" size="2x" />
                    </a>
                </td>
                @if (Auth::user()->type == 6)
                <td>
                    <a href="">
                        <fai icon="file-code" size="2x" />
                    </a>
                </td>
                @endif
            </tr>
            @endforeach
        </table>
        @else
        <p>No hay personas atendidas registradas en el programa</p>
        @endif
    </div>
</section>
@endsection
