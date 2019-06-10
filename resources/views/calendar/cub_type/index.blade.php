@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @if(session('success'))
        <div class="notification is-primary">
            <button class="delete"></button>
            {{session('success')}}
        </div>
        @endif
        <h1 class="title">Tipos de cubículos</h1>
        <h2 class="subtitle">Tipos de cubículos</h2>

        <a class="button" href="{{ route('cub_type.create') }}">Registrar un nuevo tipo de cubículo</a>

        @if (count($types))
        <table class="table is-bordered is-hoverable is-fullwidth" style="table-layout: fixed" >
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Borrar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($types as $type)
                    <tr>
                        <td><a href="{{route('cub_type.edit', $type->id)}}">{{$type->name}}</a></td>
                        <td><a href="{{route('cub_type.edit', $type->id)}}">{{$type->description}}</a></td>
                        <td>
                            <a href="{{route('cub_type.destroy', $type->id)}}" class="button is-danger is-outlined">
                                <fai icon="trash" size="2x" />
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No hay cubículos registrados</p>
        @endif
        
    </div>
</section>

@endsection