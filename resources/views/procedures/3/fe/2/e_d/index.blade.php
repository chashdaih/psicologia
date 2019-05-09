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
                    <th>Evaluación 1</th>
                    <th>Evaluación 2</th>
                    <th>Evaluación 3</th>
                    <th>Evaluación 4</th>
                    <th>Evaluación 5</th>
                    <th>Evaluación 6</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $program)
                @foreach ($program->fe2s as $fe2)
                <tr>
                    <td>
                        {{ $fe2->full_name }}
                    </td>
                    <td>
                        <a href="{{ route($doc_code.'_download', $program->id_practica."_".$fe2->num_cuenta."_0") }}">
                            <fai icon="file-pdf" size="2x" />
                        </a>
                    </td>
                    <td>
                        @if ($fe2->pivot->evaluation_stage > 0)
                        <a href="{{ route($doc_code.'_download', $program->id_practica."_".$fe2->num_cuenta."_1") }}">
                            <fai icon="file-pdf" size="2x" />
                        </a>  
                        @endif
                    </td>
                    <td>
                        @if ($fe2->pivot->evaluation_stage > 1)
                        <a href="{{ route($doc_code.'_download', $program->id_practica."_".$fe2->num_cuenta."_2") }}">
                            <fai icon="file-pdf" size="2x" />
                        </a>  
                        @endif
                    </td>
                    <td>
                        @if ($fe2->pivot->evaluation_stage > 2)
                        <a href="{{ route($doc_code.'_download', $program->id_practica."_".$fe2->num_cuenta."_3") }}">
                            <fai icon="file-pdf" size="2x" />
                        </a>  
                        @endif
                    </td>
                    <td>
                        @if ($fe2->pivot->evaluation_stage > 3)
                        <a href="{{ route($doc_code.'_download', $program->id_practica."_".$fe2->num_cuenta."_4") }}">
                            <fai icon="file-pdf" size="2x" />
                        </a>  
                        @endif
                    </td>
                    <td>
                        @if ($fe2->pivot->evaluation_stage > 4)
                        <a href="{{ route($doc_code.'_download', $program->id_practica."_".$fe2->num_cuenta."_5") }}">
                            <fai icon="file-pdf" size="2x" />
                        </a>  
                        @endif
                    </td>
                </tr>    
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection