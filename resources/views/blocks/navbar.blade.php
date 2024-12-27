<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg">
    <!-- Navbar brand -->
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <div class="logo-text">
                <span class="variedades">VARIEDADES</span><span class="cr">CR</span>
            </div>
        </a>

        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#basicExampleNav"
            aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="basicExampleNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item"><a class="nav-link fw-bold" href="/catalogo/relojes">Relojes</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="/catalogo/perfumes">Perfumes</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="/contactenos">Contáctenos</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="/envio">Envio</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="/garantia">Garantia</a></li>

                @if (Auth::check() && Auth::user()->AutorizaRoles('admin'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-bs-toggle="dropdown"
                            aria-expanded="false">Dashboard</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="/home">Home</a></li>
                            <li><a class="dropdown-item" href="/producto-create">Agregar Producto</a></li>
                            <li><a class="dropdown-item" href="/users">Usuarios</a></li>
                            <li><a class="dropdown-item" href="/inventario">Inventario</a></li>
                            <li><a class="dropdown-item" href="/marcas">Marcas</a></li>
                        </ul>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav ms-auto">
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
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Salir') }}
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
