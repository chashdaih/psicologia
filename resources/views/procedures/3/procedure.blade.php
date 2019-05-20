@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1>

        <div class="card">
            <p class="card-header-title">{{ $procedure['name'] }}</p>
            <div class="card-content">
                <div class="content">
                    <div class="list is-hoverable">
                        @foreach ($procedure['documents'] as $code => $doc)
                        <a href="{{ route($code.'.index') }}"
                         class="list-item" >{{ strtoupper($code) }} - {{ $doc }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>
@endsection