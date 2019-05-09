@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1>
        @if ($errors->any())
        <p>
            {{ $errors }}
        </p>
        @endif
        <form method="POST" action="{{ route($doc_code.'.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="field">
                <label class="label">Programa</label>
                <div class="control">
                    <div class="select">
                        <select name="program_id">
                        @foreach ($programs as $program)
                        <option value="{{ $program->id_practica }}">{{ $program->programa }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Participante</label>
                <div class="control">
                    <div class="select">
                        <select name="partaker_id">
                        @foreach ($programs as $program)
                            @foreach ($program->partakers as $partaker)
                            <option value="{{ $partaker->num_cuenta }}">{{ $partaker->full_name }}</option>
                            @endforeach
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Evaluación</label>
                <div class="control">
                    <div class="select">
                        <select name="evaluation_stage">
                            <option value="0">1</option>
                            <option value="1">2</option>
                            <option value="2">3</option>
                            <option value="3">4</option>
                            <option value="4">5</option>
                            <option value="5">6</option>
                        </select>
                    </div>
                </div>
            </div>
            <file-input serv_error="{{ $errors->has('upload_file') ? $errors->first('upload_file') : '' }}" ></file-input>
            {{-- <input class="form-control" type="file" name="upload_file" id="upload_file" required> --}}
            <div class="field">
                <div class="control">
                    <button class="button is-link">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection