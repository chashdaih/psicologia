@extends('layouts.base')

@section('content')
<section class="section">
    @include('layouts.breadcrumbs')
{{-- </section>
<section class="section"> --}}
    <h1 class="title">{{ $bread->last()['title'] }}</h1>
    <div class="container has-text-centered">
        <button class="button"><a href="{{ route($doc_code.'.create') }}">Registrar nueva práctica</a></button>
        <br/>
    </div>
    <div ><br></div>
    <sortable-table
        :ldata="{{ $records }}" 
        url="{{ route($doc_code.".index") }}"
        :stages="{{ $stages }}"
        :supervisors="{{ $supervisors }}"></sortable-table>
</section>
@endsection