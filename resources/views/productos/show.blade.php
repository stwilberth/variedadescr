@extends('layouts.app')
@section('meta_tags')
    @if ($producto)
        <meta property='article:published_time' content='{{ $producto->created_at }}' />
        <meta property='article:section' content='event' />
        @if ($producto->descripcion_social)
            <meta name='description' itemprop='description' content='{{ $producto->descripcion_social }}' />
            <meta property="og:description" content="{{ $producto->descripcion_social }}" />
        @endif
        <meta property="og:type" content="article" />
        @if ($producto->imagenes->count() > 0)
            <meta property="og:image"
                content="https://variedadescr.com/storage/productos/{{ $producto->imagenes->first()->ruta }}" />
            <meta property="og:image:secure_url"
                content="https://variedadescr.com/storage/productos/{{ $producto->imagenes->first()->ruta }}" />
        @endif
        <meta property="og:image:size" content="300" />
        <!-- En la página de producto individual -->
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "Product",
                "name": "{{ $producto->nombre }}",
                "description": "{{ $producto->descripcion }}",
                "image": "{{ $producto->imagenes->first()->ruta }}",
                "sku": "{{ $producto->sku }}",
                "brand": {
                    "@type": "Brand",
                    "name": "{{ $producto->marca->nombre }}"
                },
                "offers": {
                    "@type": "Offer",
                    "price": "{{ $producto->precio_venta }}",
                    "priceCurrency": "CRC",
                    "availability": "{{ $producto->disponibilidad == 3 ? 'https://schema.org/OutOfStock' : 'https://schema.org/InStock' }}"
                }
            }
    </script>
    @endif
@endsection

@section('content')
    @php
        $revendedor = auth()->check() && auth()->user()->AutorizaRoles('revendedor');
    @endphp

    <div class="container mb-5">

        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($admin)
            <div class="col-12 my-4">
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('productoEdit', $producto->slug) }}" class="btn btn-primary">
                        <i class="fa fa-edit"></i>
                        Editar
                    </a>
                    <a href="/image-edit/{{ $producto->slug }}" class="btn btn-info">
                        <i class="fa fa-image"></i>
                        Agregar imagen
                    </a>
                </div>
            </div>
            <div class="col-12">
                @if ($producto->publicado == 0)
                    <h2 class="red-text">No publicado</h2>
                @endif
            </div>
        @endif

        <div class="row">
            <h1 class="mb-4 text-center text-success">{{ $producto->nombre }}</h1>
            {{-- galeria --}}
            <div class="col-sm-4 mb-3">
                <product-image-slider :imagenes='@json($producto->imagenes)' :url-tiktok='@json($producto->url_tiktok)'
                    :producto-nombre='@json($producto->nombre)' />
            </div>

            <div class="col-sm-3 mb-3">
                <span class="fs-3 fw-bold" style="color: rgb(191, 73, 73)">
                    ¢{{ number_format($producto->precio_venta) }}
                </span>
                <br>
                @if ($producto->precio_sugerido)
                    <span class="font-weight-bold" style="color: #8a8a8a;">Precio sugerido:</span><span
                        style="font-family: georgia,sans-serif; color: #8a8a8a;">
                        ¢{{ number_format($producto->precio_sugerido) }}</span>
                    <br>
                @endif
                @if ($producto->precio_anterior && $producto->precio_anterior > $producto->precio_venta)
                    <span class="font-weight-bold" style="color: #8a8a8a;">Antes:</span> <span
                        style="color: #8a8a8a; textDecoration: line-through; font-family: georgia,sans-serif">¢{{ $producto->precio_anterior }}.</span>
                @endif
                @if ($admin)
                    <br>
                    Costo: ¢{{ number_format($producto->costo) }} <br>
                    Mayorista: ¢{{ number_format($producto->precio_mayorista) }} <br>
                @endif
                @if ($revendedor)
                    Precio mayorista: ¢{{ number_format($producto->precio_mayorista) }}
                @endif
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0">
                        <span class="font-weight-bold">Marca: </span>
                        <a href="/catalogo/relojes?marca={{ $producto->marca->id }}&genero=0" class="text-success">
                            {{ $producto->marca->nombre }}
                        </a>
                    </li>
                    <li class="list-group-item px-0">
                        <span class="font-weight-bold">Modelo: </span> {{ $producto->modelo }}
                    </li>
                    <li class="list-group-item px-0">
                        <span class="font-weight-bold">Género: </span>
                        <a href="/catalogo/relojes?marca=0&genero={{ $producto->genero }}" class="text-success">
                            {{ $producto->generoTexto }}
                        </a>
                    </li>
                    <li class="list-group-item px-0">
                        <span class="font-weight-bold">Disponibilidad: </span>
                        <span class="@if ($producto->disponibilidad == 3) text-danger @else text-success @endif">
                            {{ $producto->disponibilidadTexto }}
                        </span>
                    </li>
                    <li class="list-group-item px-0">
                        <span class="font-weight-bold">Stock:</span> {{ $producto->stock }}
                    </li>
                </ul>

            </div>
            <div class="col-sm-5">{!! $producto->descripcion !!}</div>

            <div class="row mt-4">
                <h3 class="text-center mb-4">Compartir</h3>
                <div class="d-flex justify-content-center gap-4">
                    <a href="http://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank"
                        class="btn btn-lg bg-primary text-white social-link">
                        <i class="fab fa-facebook fa-lg"></i>
                    </a>
                    <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" target="_blank"
                        class="btn btn-lg bg-info text-white social-link">
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>
                    <a href="whatsapp://send?text={{ url()->current() }}" target="_blank"
                        class="btn btn-lg bg-success text-white social-link">
                        <i class="fab fa-whatsapp fa-lg"></i>
                    </a>
                    <a href="https://www.instagram.com/share?url={{ url()->current() }}" target="_blank"
                        class="btn btn-lg bg-danger text-white social-link">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <x-slider-productos :products="$more_products" :titulo="'Más relojes ' . $producto->marca->nombre" />
        <x-slider-productos :products="$new_products" :titulo="'Productos nuevos'" />
    </div>

@endsection
@section('script')
    <script async src="https://www.tiktok.com/embed.js"></script>
@endsection
