@extends('layouts.base')

@section('content')
<section class="section">
    @if (session('message'))
    <div class="notification is-primary">
        {{ session('message') }}
    </div>
    @endif
    @if (count($enroll_programs) > 0)
    <div class="container">
            <h1 class="title">Mis prácticas</h1>
            <div class="box">
            @foreach ($enroll_programs as $enr)
                <form action="{{ route('insc.docs') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{$enr->id_tramite}}" name="id_tramite">
                    <div class="columns">
                        <div class="column">
                            <p class="has-text-weight-bold">Programa</p>
                            <p>{{ $enr->program->programa}}</p>
                        </div>
                        @if ($enr->document->seguro_imss && $enr->document->carta_comp && $enr->document->historial_ac)
                        <div class="column">
                            <p class="subtitle">Ya has subido todos los documentos</p>
                        </div>
                        @else
                        <div class="column">
                            <p class="has-text-weight-bold">Seguro</p>
                            <small-file
                            name="seguro_imss"
                            serv_error="{{ $errors->has('seguro_imss') ? $errors->first('seguro_imss') : '' }}"
                            @if ($enr->document->seguro_imss)
                            color="is-primary"
                            text="seguro.pdf"
                            :disable=true
                            @endif
                            ></small-file>
                        </div>
                        <div class="column">
                            <p class="has-text-weight-bold">Carta compromiso</p>
                            <small-file
                            name="carta_comp"
                            serv_error="{{ $errors->has('carta_comp') ? $errors->first('carta_comp') : '' }}"
                            @if ($enr->document->carta_comp)
                            color="is-primary"
                            text="carta_compromiso.pdf"
                            :disable=true
                            @endif
                            ></small-file>
                        </div>
                        <div class="column">
                            <p class="has-text-weight-bold">Historial académico</p>
                            <small-file
                            name="historial_ac"
                            serv_error="{{ $errors->has('historial_ac') ? $errors->first('historial_ac') : '' }}"
                            @if ($enr->document->historial_ac)
                            color="is-primary"
                            text="Historial.pdf"
                            :disable=true
                            @endif
                            ></small-file>
                        </div>
                        <div class="column">
                            <button class="button" type="submit">Enviar Documentos</button>
                        </div>
                        @endif
                    </div>
                    <div>
                        <a class="button is-info" href="{{ route('insc.carta', $enr->id_practica) }}">Generar carta compromiso</a>
                        <p class="is-italic">Por favor, revisa la carta, imprímela, firmala y sube un solo archivo que contenga las dos páginas</p>
                    </div>
                </form>
            @endforeach
            </div>
        </div>    
    @endif
    <br>
    <div class="container">
        <h1 class="title">Prácticas disponibles</h1>
        {{-- @foreach ($programs as $program) --}}
        <programs-list 
            :programs="{{ json_encode($programs) }}"
            pdf-url="{{ route('rps_pdf', 0) }}"
            en-url="{{ route('insc.enroll', 0) }}"
        ></programs-list>
        {{-- @endforeach --}}
    </div>
</section>
@endsection