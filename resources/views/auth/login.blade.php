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
        <div class="columns">
            <div class="column">
                <h1 class="title">
                    Bienvenid@ a los Centros de Formación y Servicios Psicológicos.
                </h1>
            </div>
            <login-toggle inline-template>
                <div class="column">
                    <h2 class="subtitle has-text-centered" v-if="!students && !supervisors">
                        Ingresa según tu perfil
                    </h2>
                    <div class="tabs is-toggle  is-large is-centered">
                        <ul>
                            <li :class="{ 'is-active': students }">
                                <a @click="showStudents">
                                    <span>Soy estudiante</span>
                                </a>
                            </li>
                            <li :class="{ 'is-active': supervisors }">
                                <a @click="showSupervisors">
                                    <span>Soy supervisor</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div v-if="students" class="students">
                        <p class="subtitle">Bienvenido al sistema.</p>
                        <p>Al ingresar como estudiante, podrás registrate en Programas de Servicios Psicológicos a través de la Formación Supervisada.</p>
                        <br>
                        <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                            @component('components.text-input', [
                                'title'=>'Número de cuenta',
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
                                <p class="control has-text-centered">
                                    <button class="button is-dark is-medium">Iniciar sesión</button>
                                </p>
                            </div>
                        </form>
                    </div>
                    <div v-if="supervisors" class="supervisors">
                        <p class="subtitle">Bienvenido al sistema.</p>
                        <p>Al ingresar como supervisor, podrás registrar y ver tus Programas de Servicios, así como las listas de los estudiantes registrados en tus programas.</p>
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
