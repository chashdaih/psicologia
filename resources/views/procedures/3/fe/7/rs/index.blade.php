@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        {{-- @include('layouts.breadcrumbs') --}}
        {{-- <h1 class="title">{{ $bread->last()['title'] }}</h1> --}}
        <div class="container">
            <button class="button"><a href="{{ $isIntervention ? route('intervencion.create', ['program'=>$program->id_practica, 'patient'=>$patient->id]) : route('breve.create', ['program'=>$program->id_practica, 'patient'=>$patient->id]) }}">Registrar resumen de sesión</a></button>
        </div>
        <br />
        @if (count($records))
        {{-- <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>No. sesión</th>
                    <th>¿Existe?</th>
                    <th>Ver documento subido</th>
                    <th>Borrar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>
                        {{ $record->session_number }}
                    </td>
                    <td>
                        <fai icon="{{ $record->exist? 'check' : 'times' }}" size="2x" />
                    </td>
                    <td>
                        <a href="{{ $isIntervention ? route('intervencion_pdf',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 'rs'=>$record->session_number]) : route('breve_pdf',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 'rs'=>$record->session_number]) }}">
                            <fai icon="file-pdf" size="2x" />
                        </a>
                    </td>
                    <td>
                        <a href="{{route('intervencion.destroy',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 'rs'=>$record->session_number])}}">
                            <fai icon="trash" size="2x" />
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table> --}}

        <table-rs
            @if ($isIntervention)
                base-url="{{ route('intervencion.index',  ['program'=>$program->id_practica, 'patient'=>$patient->id]) }}"
            @else
                base-url="{{ route('intervencion.index',  ['program'=>$program->id_practica, 'patient'=>$patient->id]) }}"
            @endif
            :rss="{{json_encode($records)}}"
        ></table-rs>

        @else 
        <p>No se han registrado resumenes de sesión en el sistema para el paciente / programa seleccionado.</p>
        @endif
    </div>
</section>
@endsection