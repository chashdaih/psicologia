{{-- @extends('layouts.base')

@section('content')
<section class="section">
    @include('layouts.breadcrumbs')
    @if(session('success'))
    <div class="notification is-primary">
        {{ session('success') }}
    </div>
    @endif
    <h1 class="title">{{ $bread->last()['title'] }}</h1>
    <div class="container has-text-centered">
        <button class="button"><a href="{{ route($doc_code.'.create') }}">Registrar nueva práctica</a></button>
        <br/>
    </div>
    <div ><br></div>
    <sortable-table
        url="{{ route($doc_code.".index") }}"
        :records="{{ $records }}" 
        @if(isset($stages)):stages="{{ $stages }}"@endif
        @if(isset($supervisors)):supervisors="{{ $supervisors }}"@endif
        :supervisor={{ Auth::user()->supervisor->id_supervisor }}
        :stage={{ Auth::user()->supervisor->id_centro }}
        ></sortable-table>
</section>
@endsection --}}