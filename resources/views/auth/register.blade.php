@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <div class="columns">
            <div class="column">
                @if(session('success'))
                <div class="notification is-primary">
                    <button class="delete"></button>
                    {{session('success')}}
                </div>
                @elseif ($errors->any())
                <div class="notification is-danger">
                    <p>El formulario contiene errores:</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">
                            @if (isset($supervisor))
                                @if ($supervisor->id_supervisor == Auth::user()->supervisor->id_supervisor)
                                    Editar mis datos 
                                @else
                                    Editar los datos de {{ $supervisor->full_name }}
                                @endif
                            @else
                            Registrar nuevo usuario
                            @endif
                        </div>
                    </div>
                    <div class="card-content">
                        <form class="control" 
                        method="POST" 
                        action="{{ isset($supervisor) ? route('supervisor.update', $supervisor->id_supervisor) : route('register') }}">
                        {{ csrf_field() }}
                        @if(isset($supervisor)) <input name="_method" type="hidden" value="PUT"> @endif
                        @if(!isset($supervisor))
                            <text-input class="field" inline-template
                                {{ $errors->has('type') ? ":error=true" : '' }}
                                title="type">
                                <div>
                                <label class="label">Tipo de usuario</label>
                                <div class="control">
                                    <div class="select">
                                        <select name="type">
                                            @foreach ($sup_types as $key => $type)
                                            <option value={{$key}}
                                            @if (isset($supervisor) && $key == Auth::user()->type) selected @endif
                                            >{{$type}}</option>
                                            @endforeach
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
                                'type'=> 'email',
                                'prev' => isset($supervisor) ? $supervisor->correo : null
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
                            @endif
                            @component('components.text-input', [
                                'title'=>'Nombre',
                                'field'=>'nombre',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($supervisor) ? $supervisor->nombre : null
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Apellido paterno',
                                'field'=>'ap_paterno',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($supervisor) ? $supervisor->ap_paterno : null
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Apellido materno',
                                'field'=>'ap_materno',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($supervisor) ? $supervisor->ap_materno : null
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Número de trabajador',
                                'field'=>'num_trabajador',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($supervisor) ? $supervisor->num_trabajador : null
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'RFC',
                                'field'=>'rfc',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($supervisor) ? $supervisor->rfc : null
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Adscripción',
                                'field'=>'coordinacion',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($supervisor) ? $supervisor->coordinacion : null
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Nombramiento',
                                'field'=>'nombramiento',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($supervisor) ? $supervisor->nombramiento : null
                                ])@endcomponent
                            @component('components.select', [
                                'title'=>'Centro al cual pertenece el usuario',
                                'field'=>'id_centro',
                                'errors'=>$errors,
                                'options'=> $buildings,
                                'prev' => isset($supervisor) ? $supervisor->id_centro : null,
                                'id' => isset($supervisor) ? Auth::user()->supervisor->id_centro : null
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Teléfono',
                                'field'=>'telefono',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($supervisor) ? $supervisor->telefono : null,
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Celular',
                                'field'=>'celular',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($supervisor) ? $supervisor->celular : null,
                                ])@endcomponent
                            <div class="field">
                                <p class="control">
                                    <button class="button is-success">
                                        @if (isset($supervisor))
                                        Actualizar
                                        @else
                                        Registrar
                                        @endif
                                    </button>
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
