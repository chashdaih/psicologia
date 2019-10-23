@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1>
        <div class="container">
            <button class="button"><a href="{{ route($doc_code.'.create') }}">Llenar formato</a></button>
        </div>

        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Nombre del estudiante</th>
                    <th>Ver online</th>
                    <th>Generar pdf</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $program)
                @foreach ($program->partakers as $partaker)
                @foreach ($partaker->ess as $es)
                <tr>
                    <td>
                        {{ $partaker->full_name }}
                    </td>
                    <td>
                        <a href="{{ route($doc_code.'.show', $es->id) }}">
                            <fai icon="file-code" size="2x" />
                        </a>
                    </td>
                    <td>
                        <a href="{{ route($doc_code.'_pdf', $es->id) }}">
                            <fai icon="file-pdf" size="2x" />
                        </a>
                    </td>
                </tr>
                @endforeach
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection