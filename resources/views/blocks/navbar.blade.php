
<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark default-color-dark">

        <!-- Navbar brand -->
        <a class="navbar-brand" href="/">VariedadesCR.com</a>
      
        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
          aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="basicExampleNav">
      
          <!-- Links -->
          <ul class="navbar-nav mr-auto">
            <!-- Dropdown -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Catálogo</a>
              <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="/catalogo/relojes">Relojes</a>
                <a class="dropdown-item" href="/catalogo/perfumes">Perfumes</a>
              </div>
            </li>

            @foreach (config('estructura.menus.principal') as $item)
            @php
                if ($item['url'] === Request::path()) {
                  $active = 'active';
                } else {
                  $active = '';
                }
            @endphp
              <li class="nav-item {{$active}}">
                <a class="nav-link" href="/{{$item['url']}}">{{$item['nombre']}}</a>
              </li>
            @endforeach

            @php
              $isAdmin = false;
              if (Auth::check()) {
                $isAdmin = Auth::user()->AutorizaRoles('admin');
              }
              @endphp
            @if ($isAdmin)
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">Dashboard</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="/home">Home</a>
                  <a class="dropdown-item" href="/producto-create">Agregar Producto</a>
                  <a class="dropdown-item" href="/users">Usuarios</a>
                  <a class="dropdown-item" href="/inventario">Inventario</a>
                  <a class="dropdown-item" href="/marcas">Marcas</a>
                </div>
              </li>
            @endif

          </ul>
          <!-- Links -->
          
          <ul class="navbar-nav ml-auto">
              <!-- Authentication Links -->
              @guest
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesion') }}</a>
                  </li>
                  @if (Route::has('register'))
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarme') }}</a>
                      </li>
                  @endif
              @else
                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->name }} <span class="caret"></span>
                      </a>

                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                              {{ __('Salir') }}
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                          </form>
                          {{-- <a href="/users/" class="dropdown-item">Perfil</a>
                          <a href="/users/" class="dropdown-item">Mensajes</a>
                          <a href="/users/" class="dropdown-item">Pedidos</a> --}}

                      </div>
                  </li>
              @endguest
          </ul>
        </div>
        <!-- Collapsible content -->
</nav>