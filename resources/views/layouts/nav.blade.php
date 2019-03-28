<nav class="navbar has-shadow" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
          <a class="navbar-item" href="/">
            Agenda
          </a>
      
          <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
          </a>
        </div>
      
        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
              @auth
              <div class="navbar-item">
                <a href="/apartar" class="navbar-item">Apartar espacio</a>
              </div>
              <div class="navbar-item">
                <a href="/asignar" class="navbar-item">Referir cita</a>
              </div>
              @endauth
            </div>
      
            <div class="navbar-end">
            @guest
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="button is-primary">
                        <strong>Registrarse</strong>
                        </a>
                        <a class="button is-light">
                        Iniciar sesión
                        </a>
                    </div>
                </div>
            @else
                <p class="navbar-item">{{ Auth::user()->name }}</p>
                <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-light" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                    Cerrar sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                </div>
            @endguest
          </div>
        </div>
      </nav>