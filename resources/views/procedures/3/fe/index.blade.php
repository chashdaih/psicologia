@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">{{ $patient->full_name }}</h1>
        <h2 class="subtitle">{{ $program->programa }}</h2>
        <br>
        @if ($car_ser->primer_contacto)
        @component('components.fe-table')
        @slot('title')FE3 - Primer contacto @endslot
            <tr>
                <td>Ficha de datos generales</td>
                <td>FDG</td>
                <td><a href="{{ route('patient.edit', ['program_id'=>$program->id_practica, 'fdg'=>$patient->id]) }}"> <fai icon="edit" size="2x" /></a></td>
                <td><a href="{{ route('fdg_pdf', $patient->id) }}"><fai icon="file-pdf" size="2x" /></a></td>
                {{-- <td><fai icon="ban" size="2x" /></td> --}}
                <td><a href="#"><fai icon="trash" size="2x" /></a></td>
            </tr>
            <tr>
                <td>Cuestionario de detección de riesgos en la salud física y mental</td>
                <td>CDR</td>
                @if (isset($cdr))
                <td><a href="{{ route('cdr.edit',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 'cdr'=>$cdr->id]) }}"> <fai icon="edit" size="2x" /></a></td>
                <td><a href="{{ route('cdr_pdf',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 'cdr'=>$cdr->id]) }}"><fai icon="file-pdf" size="2x" /></a></td>
                @else
                <td><a href="{{ route('cdr.create',  ['program'=>$program->id_practica, 'patient'=>$patient->id]) }}"> <fai icon="plus-circle" size="2x" /></a></td>
                <td><fai icon="times" size="2x" /></td>
                @endif
                {{-- <td><a href="#"> <fai icon="file-upload" size="2x" /></a></td> --}}
                <td><a href="#"><fai icon="trash" size="2x" /></a></td>
            </tr>
        @endcomponent
        @endif
        @if ($car_ser->admision)
        @component('components.fe-table')
        @slot('title')FE4 - Admisión @endslot
        <tr>
            <td>Plan de servicios</td>
            <td>PS</td>
            @if (isset($ps))
            <td><a href="{{ route('ps.edit',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 'ps'=>$ps->id]) }}"> <fai icon="edit" size="2x" /></a></td>
            <td><a href="{{ route('ps_pdf',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 'ps'=>$ps->id]) }}"><fai icon="file-pdf" size="2x" /></a></td>
            @else
            <td><a href="{{ route('ps.create',  ['program'=>$program->id_practica, 'patient'=>$patient->id]) }}"> <fai icon="plus-circle" size="2x" /></a></td>
            <td><fai icon="times" size="2x" /></td>
            @endif
            {{-- <td><a href="#"> <fai icon="file-upload" size="2x" /></a></td> --}}
            <td><a href="#"><fai icon="trash" size="2x" /></a></td>
        </tr>
        @endcomponent
        @endif
        @if ($car_ser->evaluacion)
        @component('components.fe-table')
        @slot('title')FE5 - Evaluación @endslot
        <tr>
            <td>Resultados de evaluación</td>
            <td>RE</td>
            @if (isset($re))
            <td><a href="{{ route('re.edit',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 're'=>$re->id]) }}"> <fai icon="edit" size="2x" /></a></td>
            <td><a href="{{ route('re_pdf',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 're'=>$re->id]) }}"><fai icon="file-pdf" size="2x" /></a></td>
            <td><a href="#"><fai icon="trash" size="2x" /></a></td>
            @else
            <td><a href="{{ route('re.create',  ['program'=>$program->id_practica, 'patient'=>$patient->id]) }}"> <fai icon="plus-circle" size="2x" /></a></td>
            <td><fai icon="ban" size="2x" /></td>
            <td><fai icon="ban" size="2x" /></td>
            @endif
            {{-- <td><a href="#"> <fai icon="file-upload" size="2x" /></a></td> --}}
        </tr>
        @endcomponent
        @endif
        @if ($car_ser->orientacion)
        <h1 class="title">FE6 - Orientación / Consejo breve</h1>
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Procedimiento</th>
                    <th>Ir a lista de documentos</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Resumen de sesión</td>
                    <td>
                        <a href="{{ route('breve.index',  ['program'=>$program->id_practica, 'patient'=>$patient->id]) }}">
                            <fai icon="arrow-circle-right" size="2x" />
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        @endif
        @if ($car_ser->intervencion)
        <h1 class="title">FE7 - Intervención</h1>
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Procedimiento</th>
                    <th>Ir a lista de documentos</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Resumen de sesión</td>
                    <td>
                        <a href="{{ route('intervencion.index',  ['program'=>$program->id_practica, 'patient'=>$patient->id]) }}">
                            <fai icon="arrow-circle-right" size="2x" />
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        @endif
        @if ($car_ser->egreso)
        @component('components.fe-table')
        @slot('title')FE8 - Egreso @endslot
        <tr>
            <td>Hoja de egreso</td>
            <td>HE</td>
            @if (isset($he))
            <td><a href="{{ route('he.edit',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 'he'=>$he->id]) }}"> <fai icon="edit" size="2x" /></a></td>
            <td><a href="{{ route('he_pdf',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 'he'=>$he->id]) }}"><fai icon="file-pdf" size="2x" /></a></td>
            <td><a href="#"><fai icon="trash" size="2x" /></a></td>
            @else
            <td><a href="{{ route('he.create',  ['program'=>$program->id_practica, 'patient'=>$patient->id]) }}"> <fai icon="plus-circle" size="2x" /></a></td>
            <td><fai icon="ban" size="2x" /></td>
            <td><fai icon="ban" size="2x" /></td>
            @endif
        </tr>
        <tr>
            <td>Cuestionario de satisfacción con el servicio psicológico</td>
            <td>CSSP</td>
            @if (isset($cssp))
            <td><a href="{{ route('cssp.edit',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 'cssp'=>$cssp->id]) }}"> <fai icon="edit" size="2x" /></a></td>
            <td><a href="{{ route('cssp_pdf',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 'cssp'=>$cssp->id]) }}"><fai icon="file-pdf" size="2x" /></a></td>
            <td><a href="#"><fai icon="trash" size="2x" /></a></td>
            @else
            <td><a href="{{ route('cssp.create',  ['program'=>$program->id_practica, 'patient'=>$patient->id]) }}"> <fai icon="plus-circle" size="2x" /></a></td>
            <td><fai icon="ban" size="2x" /></td>
            <td><fai icon="ban" size="2x" /></td>
            @endif
        </tr>
        @endcomponent
        @endif
    </div>
</section>
@endsection