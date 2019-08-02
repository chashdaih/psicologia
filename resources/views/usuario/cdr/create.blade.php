@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title"> Registrar cuestionario de detección de riesgos en la salud física y mental</h1>
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
        @if(Auth::user()->type != 3)
        @component('components.text-input', [
            'title' => 'Nombre de quien hizo la entrevista *OPCIONAL* (Solo si no está dado de alta en el sistema)',
            'field' => 'other_filler',
            'errors' => $errors,
            'type' => 'text',
            'prev' => old('other_filler', isset($process_model) ? $process_model->other_filler : null),
            'maxlength' => 255,
        ])@endcomponent
        @endif
        @component('components.text-input', [
            'title'=>'No. expediente',
            'field'=>'file_number',
            'errors'=>$errors,
            'type'=> 'text',
            'prev' => old('file_number', isset($process_model) ? $process_model->file_number : null),
            'maxlength' => 255,
            'required' => true
        ])@endcomponent
        <date-component
            label="Fecha de llenado"
            name="created_at"
            @if($errors->has("created_at"))
            error='{{$errors->first("created_at")}}'
            @endif
            @if(old('created_at'))
            old={{old('created_at')}}
            @elseif(isset($process_model))
            old={{ $process_model->created_at ? $process_model->created_at->format('Y-m-d') : null }}
            @endif
        ></date-component>
            @foreach ($sections as $section)
            <h2 class="subtitle">{{$section['title']}}</h2>
            <table class="table is-fullwidth is-hoverable is-striped">
                @if($section['title']=="SUSTANCIAS")
                @else
                @if(array_key_exists('medical', $section))
                <thead>
                    <tr>
                        <th>Descarte sintomatología física diagnosticada por un Médico</th>
                        <th>Respuesta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($section['medical'] as $question)
                        <tr>
                            <td>{{$question}}</td>
                            <td>
                                <div class="select">
                                    <select name="{{$section['code'].strtok($question, '.')}}" >
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                @endif
                @foreach ($section['main'] as $sub)
                @if (array_key_exists('period', $sub))
                <thead>
                    <tr>
                        <th>{{$sub['period']}}</th>
                        <th>Respuesta</th>
                    </tr>
                </thead>
                @endif
                <tbody>
                @if (array_key_exists('ten', $sub))
                    @foreach ($sub['ten'] as $question)
                    <tr>
                        <td>{{$question}}</td>
                        <td>
                            <div class="field">
                                <div class="control">
                                    <input type="number" min="0" max="10" class="input" placeholder="0 - 10" 
                                    name="{{$section['code'].strtok($question, '.')}}"
                                    value="{{old($section['code'].strtok($question, '.'), 0)}}"
                                    >
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                @if (array_key_exists('boolean', $sub))
                    @foreach ($sub['boolean'] as $question)
                    <tr>
                        <td>{{$question}}</td>
                        <td>
                            <div class="select">
                                <select name="{{$section['code'].strtok($question, '.')}}" >
                                    <option value="0">NO</option>
                                    <option value="1">SI</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
                @endforeach
                @endif {{-- end if no sustancias --}}
            </table>
            @endforeach
            <button class="button is-info" type="submit">@if($process_model->id) Actualizar cuestionario @else Registrar cuestionario @endif</button>
        </form>
    </div>
</section>
@endsection