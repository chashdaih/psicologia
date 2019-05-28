@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Evaluar estudiante</h1>

        @foreach ($programs as $program)
        @if (count($program->evaluations)>0)
        <h2 class="subtitle ">{{ $program->programa }}</h2>
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Nombre del estudiante</th>
                    <th>Evaluación inicial</th>
                    <th>Evaluación intermedia</th>
                    <th>Evaluación final</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($program->eval_par as $partaker)
                <tr>
                    <td>
                        {{ $partaker->full_name }}
                    </td>
                    <td>
                        @if ($partaker->evaluation->e1)
                            <fai icon="file-pdf" size="2x" />
                        @else
                        {{ $partaker->evaluation->e1 }}
                        @endif
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No hay alumnos inscritos</p>
        @endif
        @endforeach

    </div>
</section>
@endsection