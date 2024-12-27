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
    @vite(['resources/css/app.css'])
    @yield('style_css')
</head>

<body>
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
    @vite(['resources/js/app.js'])
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
