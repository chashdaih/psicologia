@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Hoja de egreso</h1>
        <form
        @if($process_model->id)
        action="{{ route('he.update',  ['patient_id'=>$patient_id, 'he'=>$process_model->id]) }}"
        @else
        action="{{ route('he.store',  $patient_id) }}"
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
                @elseif($field['type'] == "table")
                <h2 class="subtitle">{{$field['title']}}</h2>
                <p>{{$field['subtitle']}}</p>
                <br>
                <table class="table is-fullwidth is-striped is-hoverable">
                    <thead>
                        <tr>
                            @foreach ($field['headers'] as $header)
                            <th>{{$header}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($field['questions'] as $i=>$question)
                        <tr>
                            <td>{{$question}}</td>
                            <td>
                                <div class="field has-addons">
                                    <div class="control">
                                        <input type="number" min="0" max="100" class="input" value="{{ old('hi'.($i+1), $process_model['hi'.($i+1)]) }}" placeholder="0-100" name="{{'hi'.($i+1)}}">
                                    </div>
                                    <p class="control">
                                        <a class="button is-static">%</a>
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="field has-addons">
                                    <div class="control">
                                        <input type="number" min="0" max="100" class="input" value="{{ old('ht'.($i+1), $process_model['ht'.($i+1)]) }}" placeholder="0-100" name="{{'ht'.($i+1)}}">
                                    </div>
                                    <p class="control">
                                        <a class="button is-static">%</a>
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="field">
                                    <span class="select">
                                        <select name="{{'ha'.($i+1)}}">
                                            <option value="1" 
                                            @if(old('ha'.($i+1), $process_model['ha'.($i+1)]) == 1) selected="selected" @endif>Si</option>
                                            <option value="0" 
                                            @if(old('ha'.($i+1), $process_model['ha'.($i+1)]) === 0) selected="selected" @endif>No</option>
                                        </select>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            @endforeach
            <small-file
                name="file"
                serv_error="{{ $errors->has('file') ? $errors->first('file') : '' }}"
                ></small-file>
            <button class="button is-info" type="submit">@if($process_model->id) Actualizar @else Registrar @endif </button>
        </form>
    </div>
</section>
@endsection