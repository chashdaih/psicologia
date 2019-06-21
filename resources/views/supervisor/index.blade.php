@extends('layouts.base')

@section('content')
<section class="section">
    <h1 class="title">Supervisores registrados</h1>
    <div class="has-text-centered">
        <a href="{{ route('register') }}" class="button is-info">Registrar supervisor</a>
    </div>
    <div><br></div>
    <sups-table 
    :supervisors="{{ $supervisors }}"
    :stages="{{ $stages }}"
    url="{{ url('/') }}"
    >
    </sups-table>
</section>
@endsection