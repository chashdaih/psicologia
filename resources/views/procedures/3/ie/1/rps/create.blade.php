@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1>
        @if ($errors->any())
        <div class="notification is-danger">
            {{-- <button class="delete"></button> --}}
            <p>El formulario contiene errores:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        {{-- <p>
            {{ $errors }}
        </p> --}}
        @endif
        <form method="POST" action="{{ route($doc_code.'.store') }}">
            @csrf
            @foreach ($sections as $section)
            <h2>{{ $section['name'] }}</h2>
            @foreach ($section['fields'] as $title => $field)
            @php $type = $field['type'] @endphp
            @switch($type)
            @case("text")
            @component('components.text-input', compact('title', 'field', 'errors', 'type'))
            @endcomponent
                @break
            @case("date")
            @component('components.text-input', compact('title', 'field', 'errors', 'type'))
            @endcomponent
                @break
            @case("number")
            @component('components.text-input', compact('title', 'field', 'errors', 'type'))
            @endcomponent
                @break
            @case("boolean")
            <div class="field">
                <div class="control">
                    <label class="checkbox">
                    <input type="checkbox" value="1" name="{{ $title }}" {{ old($title)? 'checked' : '' }}>
                    {{ $field['title'] }}
                    </label>
                </div>
            </div>
                @break
            @case("area")
            @component('components.area-input', compact('title', 'field', 'errors'))
            @endcomponent
                @break
            @endswitch
            @endforeach
            @endforeach
            <div class="field">
                <div class="control">
                    <button class="button is-link">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection