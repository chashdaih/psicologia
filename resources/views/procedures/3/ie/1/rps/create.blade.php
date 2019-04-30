@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1>

        <ecpr-form inline-template :fields={{ $values }} url={{ route($doc_code.'.store') }}>
            <form @submit.prevent="onSubmit">
            @foreach ($sections as $section)
                <h2>{{ $section['name'] }}</h2>
                @foreach ($section['fields'] as $title => $field)
                <div class="field">
                    <label class="label">{{ $field['title'] }}</label>
                    <div class="control">
                    @switch($field['type'])
                    @case("text")
                        <input class="input" type="text" v-model="form.{{ $title }}" placeholder="{{ $field['title'] }}" required>
                        @break
                    @case("date")
                    <div class="field">
                        <input class="input" type="date" v-model="form.{{ $title }}" required>
                        @break
                    @case("select")
                        <div class="select">
                            <select v-model="form.{{ $title }}">
                                <option value="0" disabled>Seleccione una opción</option>
                                @foreach ($field['options'] as $option)
                                <option :value="{{ $option->id }}">{{ $option->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @break
                    @case("area")
                    <div class="field">
                        <textarea v-model="form.{{ $title }}" class="textarea" placeholder="{{ $field['title'] }}"></textarea>
                        @break
                    @case("boolean")
                    <div class="field">
                        <input type="checkbox" v-model="form.{{ $title }}">
                        @break
                    @case("number")
                    <div class="field">
                        <input type="number" v-model="form.{{ $title }}" required>
                        @break
                    @endswitch
                    </div>
                </div>
                @endforeach
            @endforeach
            <button v-bind:class="{ 'is-loading': form.isLoading }" class="button" type="submit">Registrar</button>
            </form>
        </ecpr-form>
    </div>
</section>
@endsection