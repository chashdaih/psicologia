@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1>
        {{-- <p class="subtitle">Elige una opción</p> --}}
        <div class="container">
            <button class="button"><a href="{{ route($doc_code.'.create') }}">Generar nuevo documento</a></button>
        </div>

        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Nombre del {{ $target }}</th>
                    <th>Ver online</th>
                    <th>Generar pdf</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>
                        {{ $record->its_student->nombre_t }}
                    </td>
                    <td>
                        <a href="{{ route($doc_code.'.show', $record->id) }}"><i class="far fa-file-code fa-2x"></i></a>
                    </td>
                    <td>
                        <a href="{{ route($doc_code.'_pdf', $record->id) }}"><i class="far fa-file-pdf fa-2x"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection