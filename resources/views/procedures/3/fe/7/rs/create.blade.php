@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Programa</a></li>
                <li><a href="#">Paciente</a></li>
                <li class="is-active"><a href="#">Resultados de evaluación</a></li>
            </ul>
        </nav>
        <h1 class="title">Resultados de evaluación</h1>
        <form
        @if($process_model->id)
        action="{{ $isIntervention ? route('intervencion.update',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 'id'=>$process_model->id]) : route('breve.update',  ['program'=>$program->id_practica, 'patient'=>$patient->id, 'id'=>$process_model->id]) }}"
        @else
        action="{{ $isIntervention ? route('intervencion.store',  ['program'=>$program->id_practica, 'patient'=>$patient->id]) : route('breve.store',  ['program'=>$program->id_practica, 'patient'=>$patient->id]) }}"
        @endif
        method="POST"
        enctype="multipart/form-data"
        >
        @if($process_model->id) <input name="_method" type="hidden" value="PUT"> @endif
            {{ csrf_field() }}
            @foreach ($fields as $field_name => $field)
                @if ($field['type'] == "text")
                @component('components.text-input', [
                    'title'=>$field['title'],
                    'field'=>$field_name,
                    'errors'=>$errors,
                    'type'=> 'text',
                    'prev' => old($field_name, $process_model->$field_name),
                    'maxlength' => 250
                    ])@endcomponent
                @elseif ($field['type'] == "number")
                @component('components.text-input', [
                    'title'=>$field['title'],
                    'field'=>$field_name,
                    'errors'=>$errors,
                    'type'=> 'number',
                    'prev' => old($field_name, $process_model->$field_name),
                    ])@endcomponent
                @elseif($field['type'] == "date")
                <date-component
                    label="{{ $field['title'] }}"
                    name="{{$field_name}}"
                    old="{{old($field_name, $process_model->$field_name)}}"
                    ></date-component>
                @elseif($field['type'] == "select")
                <label class="label">{{ $field['title'] }}</label>
                <div class="control">
                    <div class="select">
                        <select name="{{ $field_name }}">
                            @foreach ($field['options'] as $key=>$value)
                            <option value="{{ $key }}"
                            @if($key == old($field_name, $process_model->$field_name)) selected="selected" @endif
                            >{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @elseif($field['type'] == "area")
                <text-input class="field" inline-template
                    {{ $errors->has($field_name) ? ":error=true" : '' }}
                    title="{{ $field['title'] }}">
                    <div>
                    <label class="label">{{ $field['title'] }}</label>
                    <div class="control">
                        <textarea name="{{ $field_name }}"
                            class="textarea{{ $errors->has($field_name)? ' is-danger':'' }}"
                            placeholder="{{ $field['title'] }}"
                            v-on:input="clearError"
                            ref="{{ $field['title'] }}"
                            @if(isset($field['required']) && $field['required']) required @endif
                            >{{ old($field_name, $process_model->$field_name) }}</textarea>
                    </div>
                    @if ($errors->has($field_name))
                    <p v-if="hasError" class="help is-danger">{{ $errors->first($field_name) }}</p>
                    @endif
                    </div>
                </text-input>
                @endif
            @endforeach
            <small-file
                name="file"
                serv_error="{{ $errors->has('file') ? $errors->first('file') : '' }}"
                ></small-file>
            <button class="button is-info" type="submit">@if($process_model->id) Actualizar @else Registrar @endif resumen de sesión </button>
        </form>
    </div>
</section>
@endsection