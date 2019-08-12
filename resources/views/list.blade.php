@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @if(Auth::user()->type != 3)
        @include('home.supervisors')
        @else
        @include('home.students')
        @endif
    </div>
</section>
@endsection