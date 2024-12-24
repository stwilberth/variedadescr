<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta_tags')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        if (!isset($title)) {
            $title = 'Relojería';
        }
    @endphp

    <title>{{ config('ajustes.sitio_web.nombre') }} | {{ $title }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('css/stilo.css') }}" rel="stylesheet">
    <link href="{{ asset('css/imagehover.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/0.9.9/magnific-popup.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.css" rel="stylesheet">

    <style>
        .social-link {
            transition: transform 0.3s ease;
        }

        .social-link:hover {
            transform: scale(1.4);
        }


        .logo-text {
            font-family: 'Orbitron', sans-serif;
        }

        .logo-text {
            font-family: 'Arial', sans-serif;
            /* Puedes cambiar a una fuente más similar */
            font-weight: bold;
            letter-spacing: 1px;
            font-size: 24px;
            text-transform: uppercase;
        }

        .logo-text .variedades {
            color: #2B5329;
            /* Verde oscuro, ajusta el color según necesites */
        }

        .logo-text .cr {
            color: #808080;
            /* Gris, ajusta el color según necesites */
        }

        /* Para asegurar que el logo se vea bien en el navbar oscuro */
        .navbar-dark .logo-text .variedades {
            color: #4CAF50;
            /* Verde más claro para mejor contraste en fondo oscuro */
        }

        .navbar-dark .logo-text .cr {
            color: #D3D3D3;
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
</head>

<body>
    <div id="app">
        @include('blocks.navbar')
        <div class="container">
            @include('blocks.contactar_barra')

        </div>
        <main>
            @yield('content')
        </main>
        @include('blocks.footer')
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
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
</body>

</html>
