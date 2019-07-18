@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        {{-- @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1> --}}

        {{-- <ecpr-form inline-template :fields={{ $values }} url={{ route($code.'.store') }}> --}}
        <form method="POST" action="{{ route($code.'.store') }}" >
            @foreach ($fields as $title => $field)
            {{-- <div class="field">
                <label class="label">{{ $field['title'] }}</label>
                <div class="control"> --}}
                @if ($field['type'] == "text")
                @component('components.text-input', [
                    'title'=>$field['title'],
                    'field'=>$title,
                    'errors'=>$errors,
                    'type'=> 'text',
                    'prev' => null
                    ])@endcomponent
                    {{-- <input class="input" type="text" v-model="form.{{ $title }}" placeholder="{{ $field['title'] }}"> --}}
                @elseif ($field['type'] == "select")
                @component('components.select', [
                    'title'=>$field['title'],
                    'field'=>$title,
                    'errors'=>$errors,
                    'options'=> $field['options'],
                    'prev' => null,
                    'id' => Auth::user()->supervisor->id_centro
                    ])@endcomponent
                    {{-- <div class="select">
                        <select name={{ $title }}>
                            <option value="0" disabled>Seleccione una opción</option>
                            @foreach ($field['options'] as $option)
                            <option value="{{ $option->id }}">{{ $option->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                @elseif ($field['type'] == "date")
                @component('components.text-input', [
                    'title'=> $field['title'],
                    'field'=> $title,
                    'errors'=>$errors,
                    'type'=> 'date',
                    'prev'=> null,
                    'required' => true
                    ])@endcomponent
                @elseif ($field['type'] == "area")
                @component('components.area-input', [
                    'title'=> $field['title'],
                    'field'=> $title,
                    'errors'=>$errors,
                    'prev'=> null
                    ])@endcomponent
                @elseif ($field['type'] == "boolean")
                @component('components.check', [
                    'title'=> $field['title'],
                    'field'=> $title,
                    'prev' => null
                    ])@endcomponent
                @elseif ($field['type'] == "number")
                <div class="field">
                    <input type="number" name={{ $title }} required>
                @endif
                {{-- </div>
            </div> --}}
            @endforeach
            <button class="button" type="submit">Registrar</button>
        </form>
        {{-- </ecpr-form> --}}
    </div>
</section>
@endsection