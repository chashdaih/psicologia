@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title"> Registrar cuestionario</h1>
        <p>Califica de 0 a 10 qué tanto te describe cada una de las preguntas. "0" no me describe en lo absoluto, "1" me describe muy poco hasta "10" me describe exactamente.</p>
        <form
        @if($process_model->id)
        action="{{ route('cdr.update',  ['patient_id'=>$patient_id, 'cdr'=>$process_model->id]) }}"
        @else
        action="{{ route('cdr.store', $patient_id) }}"
        @endif
        method="POST">
        @if($process_model->id) <input name="_method" type="hidden" value="PUT"> @endif
            {{ csrf_field() }}
            @foreach ($sections as $section)
            <table class="table is-fullwidth is-hoverable is-striped">
                <thead>
                    <th>{{ $section['time'] }}</th>
                    @for ($i = 0; $i < 11; $i++)
                    <th>{{$i}}</th>
                    @endfor
                </thead>
                <tbody>
                    @foreach ($section['questions'] as $key => $question)
                    <tr>
                        <td style="width:60%">{{ $question }}</td>
                        @for ($i = 0; $i < 11; $i++)
                        <td>
                            <input type="radio" value="{{$i}}" name="{{$section['title'].$key}}" 
                            @if(old($section['title'].$key, $process_model->{$section['title'].$key}) == $i) checked="checked" @endif >
                            </td>
                        @endfor
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            @endforeach
            <button class="button is-info" type="submit">@if($process_model->id) Actualizar cuestionario @else Registrar cuestionario @endif</button>
        </form>
    </div>
</section>
@endsection