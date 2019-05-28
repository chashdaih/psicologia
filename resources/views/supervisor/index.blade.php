@extends('layouts.base')

@section('content')
<section class="section">
    {{-- @include('layouts.breadcrumbs') --}}

    <h1 class="title">Lista de supervisores</h1>
    <div><br></div>

    <sups-table 
    :supervisors="{{ $supervisors }}"
    :stages="{{ $stages }}"
    >
    </sups-table>
</section>
@endsection