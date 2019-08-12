@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Por razones de seguridad, es necesario que cambies tu contraseña</h1>
        <h2 class="subtitle">Por favor, guarda tu nueva contraseña en un lugar seguro</h2>
        {{-- @if ($errors->any())
        <diss-noti>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </diss-noti>
        @endif --}}
        <div class="card">
            <form action="{{ route('pass_up') }}" method="POST">
            {{ csrf_field() }}
                <div class="card-content has-text-centered">
                    @component('components.text-input', [
                        'title'=>'Nueva contraseña',
                        'field'=>'password',
                        'errors'=>$errors,
                        'type'=> 'password',
                        'send'=> true,
                        'required'=>true
                    ])@endcomponent
                    @component('components.text-input', [
                        'title'=>'Repetir nueva contraseña',
                        'field'=>'password_confirmation',
                        'errors'=>$errors,
                        'type'=> 'password',
                        'send'=> true,
                        'required'=>true
                    ])@endcomponent
                    <button type="submit" class="button is-medium is-success">Cambiar contraseña</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection