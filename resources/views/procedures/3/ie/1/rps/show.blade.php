@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h1 style="text-align:center;">Registro de prácticas supervisadas</h1>
    <div>
        <h2>PROGRAMA</h2>
        <p>Los programas de Práctica Integral Supervisada permiten que estudiantes de los semestres intermedios de la Carrera (5° a 8º) inicien un ejercicio Profesional en escenarios reales, bajo la supervisión académica e insitu del Responsable del Programa y del Escenario, respectivamente. La supervisón es fundamental para la adquisición de competencias profesionales del estudiante.</p>
    </div>
    <div>
        @foreach ($sections as $section)
        <h2>{{ $section['name'] }}</h2>
        <table>
            @foreach ($section['fields'] as $title => $field)
            <tr>
                <td>{{ $field['title'] }}</td>
                @if ($field['type'] == "date")
                <td>{{ $doc->{$title}->format('d/m/Y') }}</td>
                @elseif ($field['type'] == 'select')
                <td>{{ $field['options'][$doc->{$title}]->name }}</td>
                @elseif ($field['type'] == 'boolean')
                <td>{{ $doc->{$title} ? 'Si':'No' }}</td>
                @else
                <td>{{ $doc->{$title} }}</td>
                @endif
            </tr>
            @endforeach

        </table>
        @endforeach
        {{-- <h2>Programa</h2>
        <table>
            <tr>
                <td>Nombre del programa</td>
                <td>{{ $doc->program_name }}</td>
            </tr>
            <tr>
                <td>Escenario de práctica</td>
                <td>{{ $doc->scene }}</td>
            </tr>
            <tr>
                <td>Dirección del escenario</td>
                <td>{{ $doc->scene_address }}</td>
            </tr>
            <tr>
                <td>Institución a la que pertenece el escenario</td>
                <td>{{ $doc->scene }}</td>
            </tr>
            <tr>
                <td>Características del escenario</td>
                <td>{{ $doc->scene_chars}}</td>
            </tr>
        </table> --}}
    </div>
</section>
@endsection