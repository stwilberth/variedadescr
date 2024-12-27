<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta_tags')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $title = !isset($title) ? 'Relojería' : $title;
    @endphp

    <title> {{ $title }} | VariedadesCR.com</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" rel="stylesheet">
    @yield('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('style_css')

    <style>
        .whatsapp-btn {
            animation: pulse 4s infinite;
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
        @include('blocks.navbar')
        @include('blocks.contactar_barra')
        <main>
            @yield('content')
        </main>
        @include('blocks.footer')
    </div>

    <!-- Botón flotante de WhatsApp -->
    <a href="{{ config('ajustes.redes.whatsapp') }}" 
       class="btn btn-success rounded-circle position-fixed d-flex align-items-center justify-content-center whatsapp-btn"
       style="bottom: 20px; right: 20px; width: 60px; height: 60px; font-size: 30px; z-index: 1000;"
       target="_blank">
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
