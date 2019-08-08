@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Evaluación de competencias del estudiante de pregrado</h1>
        <form action="{{route('ecpr.store', ['program_id'=>$program_id, 'partaker_id'=>$partaker_id])}}" method="POST">
                {{ csrf_field() }}
            <date-component
                label="Fecha en que se llenó el documento"
                name="created_at"
                old="{{old('created_at', $ecpr->created_at)}}"
                ></date-component>
            @component('components.text-input', [
                'title'=>'Semestre que cursa',
                'field'=>'semester',
                'errors'=>$errors,
                'type'=> 'number',
                'prev' => old('semester', $ecpr->semester),
                'maxlength' => 1
                ])@endcomponent
            <label class="label">Fase de evaluación</label>
            <div class="control">
                <div class="select">
                    <select name="evaluation_phase">
                        @foreach ([1=>'Inicial', 2=>'Intermedia', 3=>'Final'] as $key=>$value)
                        <option value="{{ $key }}"
                        @if($key == old('evaluation_phase', $ecpr->evaluation_phase)) selected="selected" @endif
                        >{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            @foreach ($sections as $section)
            <table class="table is-fullwidth is-hoverable is-striped">
                <thead>
                    <tr>
                        <th>{{$section['title']}}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($section['questions'] as $question)
                        <tr>
                            <td>{{$question}}</td>
                            <td>
                                <input type="number" class="input"
                                placeholder="0 - 6"
                                min="0"
                                max="6"
                                name="{{'q'.str_replace('.', '', strstr($question, ' ', true))}}"
                                value="{{old('q'.str_replace('.', '', strstr($question, ' ', true)), $ecpr->{'q'.str_replace('.', '', strstr($question, ' ', true))})}}"
                                />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endforeach
            <button class="button is-info is-medium" type="submit">Registrar</button>
        </form>
    </div>
</section>
@endsection