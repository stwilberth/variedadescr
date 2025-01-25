<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>¡Nuevo Producto Disponible!</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 30px;
        }
        h1 {
            color: #2c3e50;
            font-size: 28px;
            margin: 0;
            padding: 0;
        }
        h2 {
            color: #e74c3c;
            font-size: 24px;
            margin: 15px 0;
        }
        .product-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .product-details p {
            margin: 10px 0;
            color: #444;
        }
        .price {
            font-size: 20px;
            color: #27ae60;
            font-weight: bold;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #e74c3c;
            color: white !important;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #c0392b;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .unsubscribe {
            color: #666;
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
        }
        .unsubscribe a {
            color: #666;
            text-decoration: underline;
        }
        .image {
            text-align: center;
        }
        .image img {
            width: 100%;
            max-width: 200px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Nuevo Producto Disponible!</h1>
        </div>

        <p>Hola,</p>

        <p>Nos complace informarte que hemos agregado un nuevo producto a nuestro catálogo:</p>

        <div class="product-details">
            <h2>{{ $producto->nombre }}</h2>

            {{-- imagen --}}
            <div class="image">
                <img src="{{ url($producto->imagenes->first()->ruta) }}" alt="{{ $producto->nombre }}">
            </div>
            
            @if($producto->marca)
                <p><strong>Marca:</strong> {{ $producto->marca->nombre }}</p>
            @endif
            
            @if($producto->modelo)
                <p><strong>Modelo:</strong> {{ $producto->modelo }}</p>
            @endif

            @if($producto->precio_venta)
                <p class="price">₡{{ number_format($producto->precio_venta, 0) }}</p>
            @endif

            @if($producto->descripcion)
                <p>{!! $producto->descripcion !!}</p>
            @endif
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ config('app.url') }}/catalogo/{{ $producto->marca->slug ?? 'relojes' }}/{{ $producto->slug }}" 
               class="button">
                Ver Producto →
            </a>
        </div>

        <div class="footer">
            <p>¡Gracias por tu interés en nuestros productos!</p>
            <p><strong>VariedadesCR.com</strong></p>
        </div>

        <div class="unsubscribe">
            Si no deseas recibir más notificaciones, puedes 
            <a href="{{ route('subscriptionsDelete', ['id' => $subscriber->id]) }}">
                cancelar tu suscripción
            </a>
        </div>
    </div>
</body>
</html>