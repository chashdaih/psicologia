@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h3 style="text-align:center;">Evaluación de competencias del estudiante de pregrado</h3>
    <div style="text-align:right;">
        <p><span style="font-weight:bold;">Fecha de registro: </span>{{ $doc->created_at->format('d/m/Y') }}</p>
    </div>
    <div>
        <p><span style="font-weight:bold;">Nombre del estudiante: </span>{{ $partaker->full_name }}</p>
        <p><span style="font-weight:bold;">Semestre que cursa: </span>{{ $semesters[$doc->semester] }}</p>
        <p><span style="font-weight:bold;">Fase de evaluación: </span>{{ $doc->evaluation_phase }}</p>
        <p><span style="font-weight:bold;">Supervisor del programa: </span>{{ $program->supervisor->full_name }}</p>
    </div>
    <br>
    <div>
        <b>Escala:</b>
        <p>0 - No lo domina, 1 a 4 - En proceso, 5 - Lo domina, 6 - No aplica.</p>
    </div>
    <br>
    <div>
        @foreach ($sections as $section)
        <table class="table is-fullwidth is-hoverable is-striped">
            <thead>
                <tr>
                    <th>{{$section['title']}}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($section['questions'] as $question)
                    <tr style="line-height: 27pt;">
                        <td>{{$question}}</td>
                        <td>{{$doc->{'q'.str_replace('.', '', strstr($question, ' ', true))} }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        @endforeach
    </div>
</section>
@endsection