@extends('layouts.base')

@section('content')
<section class="section">
    <br>
    <div class="container">
        <h1 class="title">Programas disponibles</h1>
        <programs-list 
            :programs="{{ json_encode($programs) }}"
            pdf-url="{{ route('rps_pdf', 0) }}"
            en-url="{{ route('insc.enroll', 0) }}"
        ></programs-list>
    </div>
</section>
@endsection