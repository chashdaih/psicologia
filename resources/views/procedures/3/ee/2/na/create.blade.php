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
                        <select name="provider_id">
                        @foreach ($programs[0]->partakers as $partaker)
                            <option value="{{ $partaker->num_cuenta }}">{{ $partaker->full_name }}</option>
                        @endforeach
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