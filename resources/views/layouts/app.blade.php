<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta_tags')
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/js/app.js'])

    <!-- Preload fonts -->
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Nunito" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap">
    </noscript>

    <!-- Critical CSS -->
    <style>
        /* Estilos críticos para el primer render */
        body {
            margin: 0;
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
        }
        /* Solución para el scroll horizontal */
        html, body {
            overflow-x: hidden;
            width: 100%;
        }

        /* Estilos para lazy loading de imágenes */
        img:not([src]) {
            visibility: hidden;
        }
        img[data-src] {
            opacity: 0;
            transition: opacity .3s;
        }
        img[data-src][src] {
            opacity: 1;
        }
        
        /* Mantener el estilo existente del botón WhatsApp */
        .whatsapp-btn {
            animation: pulse 2s infinite;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            font-size: 40px;
            color: #25d366;
            text-decoration: none;
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

        .contact-bar {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
    @yield('styles')
    @yield('style_css')

    <!-- Defer non-critical CSS -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    
    <!-- Fallback for no-JS -->
    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </noscript>

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
        <div class="d-flex justify-content-center gap-3 my-1 p-2 contact-bar">
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ config('ajustes.redes.whatsapp') }}?text={{ url()->current() }}" class="text-success social-link fs-6 text-decoration-none" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                    <span class="ms-2 text-dark">8781-1054</span> 
                </a>
                <a href="https://www.facebook.com/variedadescrrelojeria/" class="text-primary social-link fs-6 text-decoration-none" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/variedadescrrelojeria/" class="text-danger social-link fs-6 text-decoration-none" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.youtube.com/@maxcastro5724" class="text-danger social-link fs-6 text-decoration-none" target="_blank"><i class="fab fa-youtube"></i></a>
                <a href="mailto:info@variedadescr.com" class="text-warning social-link fs-6 text-decoration-none" target="_blank"><i class="fa fa-envelope"></i></a>
                <a href="tel:+50687811054" class="text-info social-link fs-6 text-decoration-none" target="_blank"><i class="fa fa-phone"></i></a>
                <a href="https://www.tiktok.com/@variedadescr/" class="text-dark social-link fs-6 text-decoration-none" target="_blank"><i class="fab fa-tiktok"></i></a>

            </div>
        </div>
        </div>

        <main style="margin-top: 120px;">
            @yield('content')
        </main>
        
        {{-- Sección de suscripción --}}
        @if (Route::current()->getName() != 'subscriptionsCreate')
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="subscription-cta p-4 rounded-3 bg-light shadow-sm">
                        <h4 class="mb-3">¡Mantente Informado!</h4>
                        <p class="text-muted mb-4">Suscríbete a nuestro boletín y sé el primero en recibir:</p>
                        <ul class="list-unstyled text-muted mb-4">
                            <li><i class="fas fa-tag me-2"></i>Ofertas exclusivas</li>
                            <li><i class="fas fa-bell me-2"></i>Notificaciones de nuevos productos</li>
                            <li><i class="fas fa-percent me-2"></i>Descuentos especiales para suscriptores</li>
                        </ul>
                        <a href="{{ route('subscriptionsCreate') }}" class="btn btn-primary">
                            <i class="fas fa-envelope-open-text me-2"></i>Suscribirme al Boletín
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

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
                    {{ date('Y') }} <a href="https://www.variedadescr.com"
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

    <!-- Defer JS loading -->
    <script defer src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        // Cargar FontAwesome solo cuando se necesite
        document.addEventListener('DOMContentLoaded', function() {
            if (document.querySelector('.fa, .fab, .fas, .far')) {
                const script = document.createElement('script');
                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js';
                script.defer = true;
                document.body.appendChild(script);
            }

            // Google Analytics
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'UA-43437982-7', {
                'page_load': true,
                'optimize_id': 'GTM-TX44985'
            });
        });
    </script>

    @yield('scripts')
    @yield('script')
</body>

</html>
