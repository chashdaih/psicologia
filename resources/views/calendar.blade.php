@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Calendario del día</h1>
        <h2 class="subtitle">Centro de Servicios Psicológicos Dr. Guillermo Dávila</h2>

        <table class="table is-bordered is-fullwidth is-hoverable" style="table-layout: fixed;">
            <thead>
                <tr>
                    <th>Cubículos</th>
                    @foreach ($schedules as $schedule)
                    <th class="has-text-centered">{{ $schedule }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $cubicule => $appointments)
                    <tr>
                        <th>{{ $cubicule }}</th>
                        @foreach ($appointments as $appointment)
                        <td style="height:6em;padding:0;">
                            <calendar-space appointment="{{ $appointment }}"></calendar-space>
                        </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- <style>
            .column {
                border: 1px solid black;
            }
        </style>

        <div class="my-table is-fullwidth">
            <div class="my-row">
                <div class="columns">
                    <div class="column">Cubículos</div>
                    @foreach ($schedules as $item)
                    <div class="column">{{ $item }}</div>
                    @endforeach
                </div>
            </div>
            @foreach ($cubicules as $i => $cubicule)
            <div class="my-row">
                <div class="columns">
                    <div class="column">{{ $cubicule}}</div>
                </div>
            </div>
            @endforeach
        </div> --}}
        
    </div>
</section>
<calendar-modal v-on:open-modal="isActive = true"></calendar-modal>

@endsection