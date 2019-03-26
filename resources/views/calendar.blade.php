@extends('layouts.base')

@section('content')
<section class="section">
        <div class="container">
            <h1 class="title">Calendario del día</h1>
            <h2 class="subtitle">Centro de Servicios Psicológicos Dr. Guillermo Dávila</h2>

            <table class="table is-bordered is-fullwidth is-hoverable">
                <thead>
                    <tr>
                        <th>
                            Cubículos
                        </th>
                        @foreach ($schedules as $schedule)
                        <th>{{ $schedule }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $cubicule => $items)
                        <tr>
                            <th>{{ $cubicule }}</th>
                            @foreach ($items as $item)
                            <td @click="openModal">{{$item}}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</section>
<calendar-modal inline-template>
    <div class="modal" :class="{ 'is-active': isActive }">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Agendar nueva cita</p>
                <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <!-- Content ... -->
                Aquí va el form
            </section>
            <footer class="modal-card-foot">
                <button class="button is-success">Agendar cita</button>
                <button class="button">Cancelar</button>
            </footer>
        </div>
    </div>
</calendar-modal>

@endsection