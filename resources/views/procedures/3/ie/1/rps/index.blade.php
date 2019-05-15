@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1>
        <div class="container">
            <button class="button"><a href="{{ route($doc_code.'.create') }}">Registrar nueva práctica</a></button>
        </div>
        <div>
            <sortable-table
                :ldata="{{ $records }}" 
                url="{{ route($doc_code.".index") }}"
                :stages="{{ $stages }}"></sortable-table>
        </div>
    </div>
</section>
@endsection