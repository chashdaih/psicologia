@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $process['process'] }}</h1>

        @foreach ($process['procedures'] as $key => $procedure)
        <collapsible-card inline-template>
            <div class="card">
                <header class="card-header" v-on:click="toggleContent">
                    <p class="card-header-title">{{ Str::upper($key) }} - {{ $procedure['name'] }}</p>
                    <a href="#" class="card-header-icon" aria-label="alternar" >
                        <span class="icon">
                            <fai :icon="open ? 'angle-up' : 'angle-down'" />
                        </span>
                    </a>
                </header>
                <div class="card-content" >
                    <div class="content"  :style="contentStyle">
                        <div class="list is-hoverable">
                            @foreach ($procedure['documents'] as $code => $doc)
                            <a href="{{ route($code.'.index') }}"
                             class="list-item" >{{ strpos($code, "_") ? $doc : Str::upper($code).' - '.$doc }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </collapsible-card>
        <br />
        @endforeach
        
    </div>
</section>
@endsection