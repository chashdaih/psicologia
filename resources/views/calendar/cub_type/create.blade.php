@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Registrar nuevo tipo de cubículo</h1>
        <form method="POST"
         action="{{ isset($type) ? route('cub_type.update', $type->id) : route('cub_type.store') }}">
            @if(isset($type)) <input name="_method" type="hidden" value="PUT"> @endif
            {{ csrf_field() }}
            @component('components.text-input', [
                'title'=>'Tipo de cubículo',
                'field'=>'name',
                'errors'=>$errors,
                'type'=> 'text',
                'prev' => isset($type) ? $type->name : null,
                'required' => true
                ])@endcomponent
            @component('components.area-input', [
                'title'=>'Descripción',
                'field'=>'description',
                'errors'=>$errors,
                'prev'=> isset($type) ? $type->description : null,
                'required' => true
                ])@endcomponent
            <div class="field">
                <div class="control">
                    <button class="button is-link">{{ isset($type) ? 'Actualizar' : 'Registrar' }}</button>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection