@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Participantes registrados al programa</h1>
        <div class="has-text-centered">
            <a href="{{ route('partaker.create') }}" class="button is-info">Registrar nuevo participante</a>
        </div>
        <partaker-search url="{{ url('/') }}"></partaker-search>
        <br>
        <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Número de cuenta</th>
                    <th>Editar</th>
                    {{-- <th>Eliminar</th> --}}
                </tr>
            </thead>
            @foreach ($partakers as $partaker)
            <tr>
                <td>{{ $partaker->full_name }}</td>
                <td>{{ $partaker->num_cuenta }}</td>
                <td>
                    <a href="{{ route('partaker.edit', $partaker->num_cuenta) }}">
                        <fai icon="edit" size="2x" />
                    </a>
                </td>
                {{-- <td>
                    <button class="button is-danger is-outlined">
                        <fai icon="trash" size="2x" />
                    </button>
                </td> --}}
            </tr>
            @endforeach
        </table>
        <div style="background-color: white ">
            {{ $partakers->links('vendor.pagination.bulma') }}
        </div>
    </div>
</section>
@endsection
