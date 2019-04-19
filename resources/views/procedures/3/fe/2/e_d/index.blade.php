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
                    <th>Nombre del estudiante</th>
                    <th>Evaluación inicial</th>
                    <th>Evaluación intermedia</th>
                    <th>Evaluación final</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($records as $record)
                <tr>
                    <td>
                        {{ $record->student->nombre_t }}
                    </td>
                    <td>
                        @if ()
                            
                        @endif
                    </td>
                    <td>
                        <a href="{{ route($doc_code.'.show', $record->id) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                    </td>
                    <td>
                        <a href="{{ route($doc_code.'_pdf', $record->id) }}">
                            <fai icon="file-pdf" size="2x" />
                        </a>
                    </td>
                </tr>
                @endforeach --}}
            </tbody>
        </table>
    </div>
</section>
@endsection