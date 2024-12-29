<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta_tags')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $title = !isset($title) ? 'Relojes Costa Rica - Originales con Garantía' : $title;
    @endphp
    <title>{{ $title }} | VariedadesCR.com</title>
    <meta property="og:title" content="{{ $title }} | VariedadesCR.com">
    <meta property="og:description" content="Relojes Invicta originales en Costa Rica. Encuentra la mejor selección con garantía y envío a todo el país.">
    <meta property="og:image" content="{{ asset('images/relojes-invicta-banner.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Store",
        "name": "VariedadesCR.com",
        "description": "Tienda En Línea de relojes en Costa Rica",
        "telephone": "+506 8781-1054",
        "email": "info@variedadescr.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "San José, Costa Rica",
            "addressLocality": "San José",
            "addressRegion": "San José",
            "postalCode": "10101",
            "addressCountry": "Costa Rica"
        },
        "openingHoursSpecification": [
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                "opens": "09:00",
                "closes": "18:00"
            },
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Saturday"],
                "opens": "09:00",
                "closes": "13:00"
            }
        ],
        "paymentAccepted": ["Cash", "Credit Card", "Debit Card", "Bank Transfer", "Sinpe Móvil"],
        "currenciesAccepted": "CRC",
        "priceRange": "₡15000 - ₡500000",
        "sameAs": [
            "{{ config('ajustes.redes.facebook') }}",
            "{{ config('ajustes.redes.instagram') }}",
            "{{ config('ajustes.redes.whatsapp') }}"
        ],
        "hasMap": "{{ config('app.url') }}"
    }
    </script>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    @yield('styles')
    @yield('style_css')
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
    </style>
</head>

<body>
    <div id="app">
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
                            <a class="nav-link dropdown-toggle fw-bold" href="#" id="relojesDropdown" role="button" 
                               data-bs-toggle="dropdown" aria-expanded="false">
                                Relojes
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="relojesDropdown">
                                <li><a class="dropdown-item" href="/catalogo/relojes/invicta">Relojes Invicta</a></li>
                                <li><a class="dropdown-item" href="/catalogo/relojes">Ver Todos</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="/catalogo/perfumes">Perfumes</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="/contactenos">Contáctenos</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="/envio">Envio</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="/garantia">Garantia</a></li>

                        @if (Auth::check() && Auth::user()->AutorizaRoles('admin'))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-expanded="false">Dashboard</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="/">Inicio</a></li>
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
        <div class="d-flex justify-content-center gap-3 my-3">
            <a href="{{ config('ajustes.redes.whatsapp') }}?text="
                class="text-decoration-none d-inline-flex align-items-center">
                <i class="fab fa-whatsapp text-success" aria-hidden="true"></i>
                <span class="ms-2 text-dark">87811054</span>
            </a>

            <a href="mailto:info@variedadescr.com" class="text-decoration-none d-inline-flex align-items-center">
                <i class="fa fa-envelope text-danger" aria-hidden="true"></i>
                <span class="ms-2 text-dark">info@variedadescr.com</span>
            </a>
        </div>

        <main>
            @yield('content')
        </main>

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
    <a href="{{ config('ajustes.redes.whatsapp') }}"
        class="btn btn-success rounded-circle position-fixed d-flex align-items-center justify-content-center whatsapp-btn"
        style="bottom: 20px; right: 20px; width: 60px; height: 60px; font-size: 30px; z-index: 1000;" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-43437982-7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-43437982-7');
    </script>
    @yield('script')
    @yield('scripts')
</body>

</html>
