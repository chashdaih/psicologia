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
                    @csrf
                    <input type="hidden" value="{{$enr->id_tramite}}" name="id_tramite">
                    <div class="columns">
                        <div class="column">
                            <p class="has-text-weight-bold">Programa</p>
                            <p>{{ $enr->program->programa}}</p>
                        </div>
                        <div class="column">
                            <p class="has-text-weight-bold">Seguro</p>
                            <small-file
                            name="seguro_imss"
                            serv_error="{{ $errors->has('seguro_imss') ? $errors->first('seguro_imss') : '' }}"
                            @if ($enr->document->seguro_imss)
                            color="is-primary"
                            text="seguro.pdf"
                            {{-- @else --}}
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
                            {{-- @else
                            color="is-warning"
                            text="Elige un archivo..." --}}
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
                            {{-- @else --}}
                            @endif
                            ></small-file>
                        </div>
                        <div class="column">
                            <button class="button" type="submit">Enviar Documentos</button>
                        </div>
                    </div>
                </form>
            @endforeach
            </div>
        </div>    
    @endif
    <br>
    <div class="container">
        <h1 class="title">Prácticas disponibles</h1>
        @foreach ($programs as $program)
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">{{ $program->programa }}</p>
            </header>
            <div class="card-content">
                <div class="columns">
                    <div class="column">
                        @if ($program->supervisor)
                        <p class="has-text-weight-bold">Supervisor</p>
                        <p>{{ $program->supervisor->full_name }}</p>
                        @endif
                    </div>
                    <div class="column">
                        <p><span class="has-text-weight-bold">Periodicidad: </span>{{ $program->periodicidad }}</p>
                        <p>{{ $program->horario }}</p>
                    </div>
                </div>
                <p class="has-text-weight-bold">Descripción breve</p>
                <p>{{ $program->descripcion }}</p>
                <p class="has-text-weight-bold">Escenario</p>
                <p>{{ $program->escenario }}</p>
                <p>{{ $program->direccion }}</p>
            </div>
            <footer class="card-footer">
                <a href="{{ route('insc.det', $program->id_practica) }}" class="card-footer-item">Ver más detalles / Inscribirse</a>
            </footer>
        </div>
        <br>
        @endforeach
    </div>
</section>
@endsection