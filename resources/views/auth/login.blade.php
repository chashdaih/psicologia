@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <div class="columns">
            <div class="column">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">Iniciar sesión</div>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                            @component('components.text-input', [
                                'title'=>'Correo electrónico / Número de cuenta',
                                'field'=>'email',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'send'=> true
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Contraseña',
                                'field'=>'password',
                                'errors'=>$errors,
                                'type'=> 'password',
                                'send'=> true
                                ])@endcomponent
                            <div class="field">
                                <p class="control">
                                    <button class="button is-success">Iniciar sesión</button>
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
