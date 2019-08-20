@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Plan de servicios</h1>
        <form
        @if($process_model->id)
        action="{{ route('ps.update',  ['patient_id'=>$patient_id, 'ps'=>$process_model->id]) }}"
        @else
        action="{{ route('ps.store',  $patient_id) }}"
        @endif
        method="POST" enctype="multipart/form-data">
        @if($process_model->id) <input name="_method" type="hidden" value="PUT"> @endif
            {{ csrf_field() }}
            @component('components.text-input', [
                'title'=>'No. expediente',
                'field'=>'file_number',
                'errors'=>$errors,
                'type'=> 'text',
                'prev' => old('file_number', isset($process_model) ? $process_model->file_number : null),
                'maxlength' => 255,
                'required' => false
            ])@endcomponent
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
            <small-file
                name="file"
                serv_error="{{ $errors->has('file') ? $errors->first('file') : '' }}"
                ></small-file>
            <button class="button is-info" type="submit">@if($process_model->id) Actualizar @else Registrar @endif </button>
        </form>
    </div>
</section>
@endsection