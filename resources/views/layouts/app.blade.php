<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta_tags')
    {{-- font nunito --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    {{-- font orbitron --}}
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Solución para el scroll horizontal */
        html,
        body {
            overflow-x: hidden;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        /* Mantener el estilo existente del botón WhatsApp */
        .whatsapp-btn {
            animation: pulse 2s infinite;
            box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }

            70% {
                box-shadow: 0 0 0 20px rgba(37, 211, 102, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }

        .social-link {
            transition: transform 0.3s ease;
        }

        .social-link:hover {
            transform: scale(1.4);
        }

        .logo-text {
            font-family: "Orbitron", sans-serif;
        }

        .logo-text {
            font-family: "Arial", sans-serif;
            /* Puedes cambiar a una fuente más similar */
            font-weight: bold;
            letter-spacing: 1px;
            font-size: 24px;
            text-transform: uppercase;
        }

        .logo-text .variedades {
            color: #2b5329;
            /* Verde oscuro, ajusta el color según necesites */
        }

        .logo-text .cr {
            color: #808080;
            /* Gris, ajusta el color según necesites */
        }

        /* Para asegurar que el logo se vea bien en el navbar oscuro */
        .navbar-dark .logo-text .variedades {
            color: #4caf50;
            /* Verde más claro para mejor contraste en fondo oscuro */
        }

        .navbar-dark .logo-text .cr {
            color: #d3d3d3;
            /* Gris más claro para mejor contraste en fondo oscuro */
        }

        .position-relative {
            position: relative;
        }

        .etiqueta-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 40%;
            /* ajusta según necesites */
            height: auto;
            opacity: 0.85;
            /* ajusta la transparencia si lo deseas */
            pointer-events: none;
            /* permite que los clicks pasen a través de la etiqueta */
        }
    </style>
    @yield('styles')
    @yield('style_css')
</head>

<body>
    <div id="app">
        <!--Navbar-->
        <div class="fixed-top" style="background-color: rgb(255 255 255);">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg">
            <!-- Navbar brand -->
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <div class="logo-text">
                        <span class="variedades">VARIEDADES</span><span class="cr">CR</span>
                    </div>
                </a>

                <!-- Collapse button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Links -->
                <div class="collapse navbar-collapse" id="basicExampleNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item"><a class="nav-link fw-bold" href="/">Inicio</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Relojes
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="/catalogo/relojes">Todos</a></li>
                                <li><a class="dropdown-item" href="/catalogo/relojes?marca=67&genero=0&orden=&descuento=0">Invicta</a></li>
                                <li><a class="dropdown-item" href="/catalogo/relojes?marca=66&genero=0&orden=&descuento=0">Fossil</a></li>
                                <li><a class="dropdown-item" href="/catalogo/relojes?marca=0&genero=1&orden=&descuento=0">Mujer</a></li>
                                <li><a class="dropdown-item" href="/catalogo/relojes?marca=0&genero=2&orden=&descuento=0">Hombre</a></li>
                                <li><a class="dropdown-item" href="/catalogo/relojes?marca=0&genero=0&orden=&descuento=2">Liquidación</a></li>
                                <li><a class="dropdown-item" href="/catalogo/relojes?marca=0&genero=0&orden=&descuento=1">Ofertas</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="/catalogo/perfumes">Perfumes</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="/contactenos">Contáctenos</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="/envio">Envio</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="/garantia">Garantía</a></li>

                        @if (Auth::check() && Auth::user()->AutorizaRoles('admin'))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-expanded="false">Dashboard</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="/home">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="/producto-create">Agregar Producto</a></li>
                                    <li><a class="dropdown-item" href="/users">Usuarios</a></li>
                                    <li><a class="dropdown-item" href="/inventario">Inventario</a></li>
                                    <li><a class="dropdown-item" href="/sin-publicar">Sin Publicar</a></li>
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
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Salir') }}
                                        </a>
                                    </li>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Contactar barra -->
        <div class="d-flex justify-content-center gap-3 my-1 p-2">
            <a href="{{ config('ajustes.redes.whatsapp') }}?text={{ url()->current() }}"
                class="text-decoration-none d-inline-flex align-items-center">
                <i class="fab fa-whatsapp text-success" aria-hidden="true"></i>
                <span class="ms-2 text-dark">87811054</span>
            </a>

            <a href="mailto:info@variedadescr.com" class="text-decoration-none d-inline-flex align-items-center">
                <i class="fa fa-envelope text-danger" aria-hidden="true"></i>
                <span class="ms-2 text-dark">info@variedadescr.com</span>
            </a>
        </div>
        </div>

        <main style="margin-top: 100px;">
            @yield('content')
        </main>
        

        <x-subscribe-form />

{{--         <script src="https://cdn.botpress.cloud/webchat/v2.2/inject.js"></script>
        <script src="https://files.bpcontent.cloud/2025/01/12/05/20250112054003-KM5ORRTC.js"></script>
 --}}    
        <!-- Footer -->
        <footer class="mt-5 bg-dark pb-3 pt-2">
            <div class="d-flex justify-content-between align-items-center gap-3 px-4">
                <div class="text-white">
                    Desarrollado por <a href="https://wilberth.com"
                        class="text-decoration-none text-info">wilberth.com</a>
                </div>
                <div class="text-white">
                    @include('blocks.social-links')
                </div>
            </div>

            <div class="pt-3 bg-dark">
                <div class="row g-4">
                    <!--First column-->
                    <div class="col-md-4 col-sm-12">
                        <div class="footer-card p-4 rounded-3 h-100">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fa fa-truck fa-2x text-info me-3"></i>
                                <h6 class="text-uppercase fw-bold mb-0 text-white">Envío</h6>
                            </div>
                            <hr class="text-white">
                            <p class="text-white mb-0">
                                Realizamos envíos a todo el país, excepto en zonas excluidas por Correos de
                                Costa Rica.
                            </p>
                        </div>
                    </div>

                    <!--Second column-->
                    <div class="col-md-4 col-sm-12">
                        <div class="footer-card p-4 rounded-3 h-100">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fa fa-certificate fa-2x text-warning me-3"></i>
                                <h6 class="text-uppercase fw-bold mb-0 text-white">Autenticidad</h6>
                            </div>
                            <hr class="text-white">
                            <p class="text-white mb-0">
                                Todos nuestros productos son 100% auténticos, ofreciendo el mejor servicio al
                                mejor precio.
                            </p>
                        </div>
                    </div>

                    <!--Third column-->
                    <div class="col-md-4 col-sm-12">
                        <div class="footer-card p-4 rounded-3 h-100">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fa fa-shield fa-2x text-success me-3"></i>
                                <h6 class="text-uppercase fw-bold mb-0 text-white">Garantía</h6>
                            </div>
                            <hr class="text-white">
                            <p class="text-white mb-0">
                                Ofrecemos nuestra propia garantía para brindar mayor tranquilidad y respaldo en
                                su compra.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-white">
                <div class="mb-0 text-white text-center pb-3">
                    © {{ date('Y') }} <a href="https://www.variedadescr.com"
                        class="text-decoration-none text-info">VariedadesCR.com</a>
                </div>
            </div>

        </footer>

    </div>

    <!-- Botón flotante de WhatsApp -->
    <a href="{{ config('ajustes.redes.whatsapp') }}?text={{ url()->current() }}"
        class="btn btn-success rounded-circle position-fixed d-flex align-items-center justify-content-center whatsapp-btn"
        style="bottom: 20px; right: 20px; width: 60px; height: 60px; font-size: 30px; z-index: 1000;" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script async defer src="https://www.googletagmanager.com/gtag/js?id=UA-43437982-7"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'UA-43437982-7');
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    @yield('scripts')
    @yield('script')
    @vite(['resources/js/app.js'])

</body>

</html>
