@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <div class="columns">
            <div class="column">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">Registrar nuevo usuario</div>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                            <text-input class="field" inline-template
                                {{ $errors->has('type') ? ":error=true" : '' }}
                                title="type">
                                <div>
                                <label class="label">Tipo de usuario</label>
                                <div class="control">
                                    <div class="select">
                                        <select name="type">
                                            <option value=2>Supervisor</option>
                                        </select>
                                    </div>
                                </div>
                                @if ($errors->has('type'))
                                <p v-if="hasError" class="help is-danger">{{ $errors->first('type') }}</p>
                                @endif
                                </div>
                            </text-input>
                            @component('components.text-input', [
                                'title'=>'Correo electrónico',
                                'field'=>'email',
                                'errors'=>$errors,
                                'type'=> 'email'
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Contraseña',
                                'field'=>'password',
                                'errors'=>$errors,
                                'type'=> 'password'
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Confirmar contraseña',
                                'field'=>'password_confirmation',
                                'errors'=>$errors,
                                'type'=> 'password'
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Nombre',
                                'field'=>'nombre',
                                'errors'=>$errors,
                                'type'=> 'text'
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Apellido paterno',
                                'field'=>'ap_paterno',
                                'errors'=>$errors,
                                'type'=> 'text'
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Apellido materno',
                                'field'=>'ap_materno',
                                'errors'=>$errors,
                                'type'=> 'text'
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Número de trabajador',
                                'field'=>'num_trabajador',
                                'errors'=>$errors,
                                'type'=> 'text'
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'RFC',
                                'field'=>'rfc',
                                'errors'=>$errors,
                                'type'=> 'text'
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Adscripción',
                                'field'=>'coordinacion',
                                'errors'=>$errors,
                                'type'=> 'text'
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Nombramiento',
                                'field'=>'nombramiento',
                                'errors'=>$errors,
                                'type'=> 'text'
                                ])@endcomponent
                            @component('components.select', [
                                'title'=>'Centro al cual pertenece el usuario',
                                'field'=>'id_centro',
                                'errors'=>$errors,
                                'options'=> $buildings
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Teléfono',
                                'field'=>'telefono',
                                'errors'=>$errors,
                                'type'=> 'text'
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Celular',
                                'field'=>'celular',
                                'errors'=>$errors,
                                'type'=> 'text'
                                ])@endcomponent
                            <div class="field">
                                <p class="control">
                                    <button class="button is-success">Registrar</button>
                                </p>
                             </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
