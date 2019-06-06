@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Calendario del día</h1>
        <h2 class="subtitle">{{ Auth::user()->supervisor->center->nombre }}</h2>
        <cal-date-sel url="{{ route('apartar') }}" fecha="{{ $fecha }}"></cal-date-sel>

        <table class="table is-bordered is-hoverable is-fullwidth" style="table-layout: fixed" >
            <thead>
                <tr>
                    <th>#</th>
                    @foreach ($schedules as $schedule)
                    <th class="has-text-centered is-size-7">{{ $schedule }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @foreach ($cubicules as $key => $cubicule)
                <tr>
                    <th class="is-size-7">{{ $cubicule }}</th>
                    @foreach ($calendarData[$key] as $time => $data)
                    <td style="padding: 0;">
                        <calendar-space @if($data) v-bind:appointment="{{ json_encode($data) }}" @endif room="{{ $cubicule }}" time={{ $time }}></calendar-space>
                    </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
        
    </div>
</section>
<calendar-modal v-on:open-modal="isActive = true" :supervisors="{{ json_encode($supervisors) }}" url="{{ route('get_students', 0) }}" fecha="{{ $fecha }}" send-url="{{ route('make_appo') }}"></calendar-modal>
<cal-cancel-modal v-on:open-modal="isActive = true" url="{{ route('cancel_appo', 0) }}"></cal-cancel-modal>

@endsection