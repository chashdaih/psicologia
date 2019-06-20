<nav id="app-nav" class="navbar has-shadow" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="{{ route('home') }}">
      <img src="{{ asset('/img/t3.png') }}" alt="">
      <p>Inicio</p>
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
      {{-- @auth --}}
      @if(Auth::user()->type == 5)
      <div class="navbar-item">
        <a href="{{ route('apartar') }}" class="navbar-item">Apartar espacio</a>
      </div>
      @endif
      @if(Auth::user()->type == 6)
      <div class="navbar-item">
        <a href="{{ route('partaker.index') }}" class="navbar-item">Participantes</a>
      </div>
      <div class="navbar-item">
        <a href="{{ route('supervisor.index') }}" class="navbar-item">Supervisores</a>
      </div>
      @endif
      {{-- <div class="navbar-item">
        <a href="/asignar" class="navbar-item">Referir cita</a>
      </div> --}}
      {{-- <div class="navbar-item has-dropdown is-hoverable" >
        <a href="{{ route('procedures') }}" class="navbar-link is-arrowless">Procesos</a>
        <div class="navbar-dropdown" style="background-color: white;">
          <a href="#" class="navbar-item">Elaboración y seguimiento de planeación estratégica y operativa</a>
          <a href="{{ route('procedures', 'ie') }}" class="navbar-item">Ingreso del estudiante</a>
          <a href="{{ route('procedures', 'fe') }}" class="navbar-item">Servicios psicológicos a través de la Formación Supervisada del Estudiante</a>
          <a href="{{ route('procedures', 'ee') }}" class="navbar-item">Egreso del estudiante</a>
          <a href="#" class="navbar-item">Gestión de recursos humanos, materiales y financieros</a>
        </div>
      </div> --}}
      {{-- @if (Auth::user()->type == 3)
      <div class="navbar-item">
        <a href="{{ route('insc') }}" class="navbar-item">Inscribirse a programa</a>
      </div>
      @else
      <div class="navbar-item">
        <a href="{{ route('evaluar.index') }}" class="navbar-item">Evaluar estudiante</a>
      </div>
      <div class="navbar-item">
        <a href="{{ route('cub_type.index') }}" class="navbar-item">Registrar tipo de cubículo</a>
      </div>
      @endif --}}
      {{-- @endauth --}}
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