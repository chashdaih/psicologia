<nav id="app-nav" class="navbar has-shadow" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="{{ route('home') }}">
     <img src="{{ asset('/img/t3.png') }}" alt="Inicio">
    </a>

    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample" 
    v-bind:class="{ 'is-active': isActive }"
    v-on:click="toggleMenu">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu"
  v-bind:class="{ 'is-active': isActive }">
    <div class="navbar-start">
      <div class="navbar-item">
        <a href="{{route('home')}}" class="navbar-item">Programas</a>
      </div>
      <div class="navbar-item">
        @if(Auth::user()->type == 3 )
        @if(count(Auth::user()->partaker->programs))
        <a href="{{ route('asignar', ['center_id'=> Auth::user()->partaker->programs[0]->id_centro]) }}" class="navbar-item">Asignar espacio</a>
        @endif
        @else
        <a href="{{ route('asignar', ['center_id'=> Auth::user()->supervisor->id_centro]) }}" class="navbar-item">Asignar espacio</a>
        @endif
      </div>
      <div class="navbar-item">
        <a href="{{route('usuario.index')}}" class="navbar-item">Personas atendidas</a>
      </div>
      @if(Auth::user()->type > 4)
      <div class="navbar-item">
        <a href="{{ route('partaker.index') }}" class="navbar-item">Estudiantes</a>
      </div>
      <div class="navbar-item">
        <a href="{{ route('supervisor.index') }}" class="navbar-item">Supervisores</a>
      </div>
      @endif
    </div>

    <div class="navbar-end">
    @if (Auth::user()->type == 3) <!-- student -->
      <p class="navbar-item">{{ Auth::user()->partaker->full_name }}</p>
      <div class="navbar-item">
        <a href="{{ route('partaker.edit', Auth::user()->partaker->num_cuenta) }}" class="navbar-link is-arrowless">Ver / Editar mis datos</a>
      </div>
    @else
      <p class="navbar-item">{{ Auth::user()->supervisor->full_name }}</p>
      <div class="navbar-item">
        <a class="navbar-link is-arrowless" href="{{ route('supervisor.edit', Auth::user()->supervisor->id_supervisor)}}">Ver / Editar mis datos</a>
      </div>
    @endif
      <div class="navbar-item">
        <div class="buttons">
            <a class="button" style="background-color: #9400D3; color:white" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
              Cerrar sesión
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
        </div>
      </div>
    </div>
  </div>
</nav>
@if ($errors->any())
<diss-noti>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</diss-noti>
@endif
@if (session('status'))
<diss-noti color="is-success">
    {{ session('status') }}
</diss-noti>
@endif
@if (session('success'))
<diss-noti color="is-success">
    {{ session('success') }}
</diss-noti>
@endif
@if (session('fail'))
<diss-noti>
    {{ session('fail') }}
</diss-noti>
@endif
@if(isset($migajas))
<section class="section">
  <nav class="breadcrumb" aria-label="breadcrumbs">
    <ul>
      @foreach ($migajas as $key => $miga)
      <li @if($loop->last) class="is-active" @endif><a href="{{$key}}" >{{$miga}}</a></li>
      @endforeach
    </ul>
</section>
</nav>
@endif