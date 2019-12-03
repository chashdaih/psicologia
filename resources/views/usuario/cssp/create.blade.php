@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Cuestionario de satisfacción con el servicio psicológico</h1>
        <form
        @if($process_model->id)
        action="{{ route('cssp.update',  ['patient_id'=>$patient_id, 'cssp'=>$process_model->id]) }}"
        @else
        action="{{ route('cssp.store',  $patient_id) }}"
        @endif
        method="POST" enctype="multipart/form-data">
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
            <p>A continuación se presenta una lista con diferentes habilidades, según su consideración, anote el porcentaje con el que la persona atendida manejaba dicha habilidad al iniciar la intervención y el porcentaje del manejo de las habilidades posterior a la intervención.</p>
            <p class="has-text-weight-bold">Si no aplica, dejar en blanco</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Habilidad de:</th>
                        <th>Al iniciar la intervención (%)</th>
                        <th>Al terminar la intervención (%)</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($newQs as $key => $q)
                    <tr>
                        <td>{{$q}}</td>
                        <td>
                            <to-100-input name={{"n".($key + 1)."i"}} 
                                value={{old("n".($key + 1)."i", ($process_model->id ? $process_model["n".($key + 1)."i"] : null))}}
                            ></to-100-input>
                        </td>
                        <td>
                                <to-100-input name={{"n".($key + 1)."f"}} 
                                    value={{old("n".($key + 1)."f", ($process_model->id ? $process_model["n".($key + 1)."f"] : null))}}
                                ></to-100-input>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <small-file
                name="file"
                serv_error="{{ $errors->has('file') ? $errors->first('file') : '' }}"
                ></small-file>
            <button class="button is-info" type="submit">@if($process_model->id) Actualizar @else Registrar @endif </button>
        </form>
    </div>
</section>
@endsection