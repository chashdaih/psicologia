@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Calendario del día</h1>
        <h2 class="subtitle">{{ $center->nombre }}</h2>
        @if (Auth::user()->type==6)
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">Cambiar centro</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <div class="select">
                            <select>
                            @foreach ($centers as $ctr)
                                <option @if($ctr->id_centro == $center->id_centro) selected @endif value="{{$ctr->id_centro}}" onclick="window.location.href = '{{route('asignar', ['center_id'=> $ctr->id_centro, 'fecha'=>$fecha])}}';">{{$ctr->nombre}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if (count($supervisors))
        <cal-date-sel url="{{ route('asignar', ['center_id'=> $center->id_centro]) }}" fecha="{{ $fecha }}"></cal-date-sel>

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
                
        <calendar-modal v-on:open-modal="isActive = true" :supervisors="{{ json_encode($supervisors) }}" url="{{ route('get_students', 0) }}" fecha="{{ $fecha }}" send-url="{{ route('make_appo') }}"></calendar-modal>
        <cal-cancel-modal v-on:open-modal="isActive = true" url="{{ route('cancel_appo', 0) }}"></cal-cancel-modal>
        @else
        <p>No hay supervisores registrados</p>
        @endif
    </div>
</section>

@endsection