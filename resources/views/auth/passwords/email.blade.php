@extends('layouts.base')
@section('content')
<section class="hero is-fullheight is-light is-bold">
    <div class="hero-head">
        <nav class="navbar is-spaced">
            <div class="navbar-brand">
            <a href="https://unam.mx/" class="navbar-item">
                <img src="{{ asset('/img/t1cut.png') }}" alt="logo UNAM">
            </a>
            <a href="http://www.psicologia.unam.mx/" class="navbar-item">
                <img src="{{ asset('/img/t2.png') }}" alt="logo psicología">
            </a>
            <a href="{{ route('home') }}" class="navbar-item">
                <img src="{{ asset('/img/t3.png') }}" alt="logo coordinación">
            </a>
            </div>
            <div class="navbar-menu">
            <div class="navbar-end">
                <p class="navbar-item has-text-weight-bold">
                Coordinación de Centros de Formación y Servicios Psicológicos
                </p>
            </div>
            </div>
        </nav>
    </div>
      
    <div class="hero-body">
        <div class="container">
            {{-- @if (session('status'))
            <diss-noti color="is-success">
                {{ session('status') }}
            </diss-noti>
            @endif --}}
            <form method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}
                @component('components.text-input', [
                    'title'=>'Correo electrónico',
                    'field'=>'email',
                    'errors'=>$errors,
                    'type'=> 'email',
                    'send'=> true
                ])@endcomponent
                <div class="field">
                    <p class="control has-text-centered">
                        <button class="button is-dark is-medium">Enviar correo para restablecer la contraseña</button>
                    </p>
                </div>
            </form>
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
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

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

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
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
