@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        {{-- <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('procedures') }}">Estudiantes</a></li>
                <li><a href="{{ route('cdr.index') }}" aria-current="page">Detección de riesgos en la salud física y mental</a></li>
                <li class="is-active"><a href="#" aria-current="page">Registrar nuevo cuestionario</a></li>
            </ul>
        </nav> --}}
        <h1 class="title"> Registrar cuestionario</h1>
        <p>Califica de 0 a 10 qué tanto te describe cada una de las preguntas. "0" no me describe en lo absoluto, "1" me describe muy poco hasta "10" me describe exactamente.</p>
        {{-- <cdr-form
            :fdgs="{{ $fdgs }}"
            :sections="{{ $sections }}"
            :programs="{{ $programs }}"
            url = "{{ route('cdr.store',  ['program'=>$program->id_practica, 'patient'=>$patient->id]) }}"
            redirect = ""
        ></cdr-form> --}}
        <form
        @if($process_model->id)
        action="{{ route('cdr.update',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 'id'=>$process_model->id]) }}"
        @else
        action="{{ route('cdr.store',  ['program'=>$program->id_practica, 'patient'=>$patient->id]) }}"
        @endif
        method="POST">
        @if($process_model->id) <input name="_method" type="hidden" value="PUT"> @endif
            {{ csrf_field() }}
            @foreach ($sections as $section)
            {{-- <cdr-section :section="{{json_encode($section)}}"></cdr-section> --}}
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
                    {{-- <tr v-for="(question, index) in section.questions" :key="index">
                        <td style="width:60%">{{ question }}</td>
                        <td v-for="(j, i) in 11" :key="j">
                            <input  type="radio" 
                                    :value="i"
                                    :name="section.title + index"
                                    v-model="fields[section.title + index]"
                                    >
                        </td>
                    </tr> --}}
                </tbody>
            </table>
            <br>
            @endforeach
            <button class="button is-info" type="submit">@if($process_model->id) Actualizar cuestionario @else Registrar cuestionario @endif</button>
        </form>
    </div>
</section>
@endsection