@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1>
        <div class="container">
            <button class="button"><a href="{{ route('rs.create') }}">Generar nuevo documento</a></button>
        </div>
        <br />
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Registrar resumen de sesión</th>
                    <th>No. sesión</th>
                    <th>¿Existe?</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>
                        {{ $record->patient->full_name }}
                    </td>
                    <td>
                        {{ $record->session_number }}
                    </td>
                    <td>
                        <fai icon="{{ $record->exist? 'check' : 'times' }}" size="2x" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection