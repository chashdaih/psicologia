@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Programas registrados</h1>
        @if (count($programs))
        <table class="table is-fullwidth is-striped is-hoverable">
            <thead>
                <th>Nombre del programa</th>
                <th>Periodo</th>
                <th>Ver pdf</th>
                <th>Ver alumnos</th>
            </thead>
            <tbody>
                @foreach ($programs as $program)
                <tr>
                    <td>{{$program->programa}}</td>
                    <td>{{$program->semestre_activo}}</td>
                    <td>
                        <a href="{{route('rps_pdf', $program->id_practica)}}">
                            <fai icon="file-pdf" size="2x" />
                        </a>
                    </td>
                    <td>
                        <a href="{{route('users_list', $program->id_practica)}}">
                            <fai icon="chalkboard-teacher" size="2x" />
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p>El supervisor no ha registrado ningún programa</p>
        @endif
    </div>
</section>
@endsection