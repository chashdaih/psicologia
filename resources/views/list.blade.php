@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Bienvenido al sistema</h1>
        @if(Auth::user()->type != 3)
        <a href="{{ route('rps.create') }}">Registrar nuevo programa de servicios psicológicos a través de la formación supervisada</a>
        @endif
        {{-- <h1 class="title">Citas del día</h1>
        <h2 class="subtitle">Centro de Servicios Psicológicos Dr. Guillermo Dávila</h2>
        
        <table id="appointments-table" class="table is-striped is-hoverable">
            <thead>
                <tr>
                    <th scope="col">Hora de Cita</th>
                    <th scope="col">Terapeuta</th>
                    <th scope="col">Supervisor</th>
                    <th scope="col">Paciente</th>
                    <th scope="col">Cubículo</th>
                    <th scope="col">Asistencia</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->hora }}</td>
                    <td>{{ $appointment->student['nombre_t'].' '.$appointment->student['ap_paterno_t'].' '.$appointment->student['ap_materno_t'] }}</td>
                    <td>{{ $appointment->supervisor['nombre'].' '.$appointment->supervisor['ap_paterno'].' '.$appointment->supervisor['ap_materno'] }}</td>
                    <td>{{ $appointment->patient['nombre'].' '.$appointment->patient['a_paterno'].' '.$appointment->patient['a_materno'] }}</td>
                    <td>{{ $appointment->sala }}</td>
                    <td>
                        <list-checkbox :appointment="{{$appointment}}"></list-checkbox>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table> --}}
    </div>
</section>
@endsection