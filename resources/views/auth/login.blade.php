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
            <login-toggle inline-template>
                <div>
                <h1 class="title has-text-centered" v-if="!students && !supervisors">
                    Bienvenida y bienvenido a los Centros de Formación y Servicios Psicológicos de la Facultad de Psicología, UNAM.
                </h1>
                <p class="subtitle has-text-centered" v-if="!students && !supervisors">
                    Ingresa según tu perfil
                </p>
                <div class="columns">
                    <div class="column has-text-centered">
                        <a @click="showStudents" class="button is-large" :class="[students ? 'is-dark' : 'is-light']">Estudiantes</a>
                    </div>
                    <div class="column has-text-centered">
                        <a @click="showSupervisors" class="button is-large" :class="[supervisors ? 'is-dark' : 'is-light']" >Supervisores</a>
                    </div>
                </div>
                <div v-if="students" class="students">
                    <p class="is-size-5">Al ingresar como estudiante, podrás registrate en Programas de Servicios Psicológicos a través de la Formación Supervisada.</p>
                    <p class="has-text-weight-bold has-text-centered">Si es la primera vez que ingresas, tu contraseña es tu número de cuenta</p>
                    <br>
                    <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                        @component('components.text-input', [
                            'title'=>'Número de cuenta',
                            'field'=>'num_cuenta',
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
                            <p class="control has-text-centered">
                                <button class="button is-dark is-medium">Iniciar sesión</button>
                            </p>
                        </div>
                    </form>
                    <br><br>
                    <div class="field">
                        <p class="control has-text-centered">
                            <a href="{{ route('password.request') }}">Olvidé mi contraseña</a>
                        </p>
                    </div>
                </div>
                <div v-if="supervisors" class="supervisors">
                    {{-- <p class="subtitle">Bienvenido al sistema.</p> --}}
                    <p class="is-size-5">Al ingresar como supervisor, podrás registrar y ver tus programas de de servicios psicológicos a través de la formación supervisada, así como las listas de los estudiantes registrados en tus programas.</p>
                    <br>
                            <form method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                                @component('components.text-input', [
                                    'title'=>'Correo electrónico',
                                    'field'=>'email',
                                    'errors'=>$errors,
                                    'type'=> 'email',
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
                                    <p class="control has-text-centered">
                                        <button class="button is-dark is-medium">Iniciar sesión</button>
                                    </p>
                                </div>
                            </form>
                            <br><br>
                            <div class="field">
                                <p class="control has-text-centered">
                                    <a href="{{ route('password.request') }}">Olvidé mi contraseña</a>
                                </p>
                            </div>
                        </div>
                    
                    </div>
                    </login-toggle>
                </div>
            </div>
        </div>
    </section>
      
{{-- <header class="nav-bar" >
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <figure class="image is-128x128">
                        <img src="{{ asset('/img/t1.png') }}" alt="">
                    </figure>
                </div>
                <div class="level-item">
                    <figure class="image is-128x128">
                        <img src="{{ asset('/img/t2.png') }}" alt="">
                    </figure>
                </div>
                <div class="level-item">
                    <figure class="image is-128x128">
                        <img src="{{ asset('/img/t3.png') }}" alt="">
                    </figure>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item has-text-right">
                    <p class="title">
                        Coordinación de Centros de Formación<br>y Servicios Psicológicos
                    </p>
                </div>
            </div>
        </div>
</header> --}}
    {{-- <div class="container">
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
    </div> --}}
@endsection
