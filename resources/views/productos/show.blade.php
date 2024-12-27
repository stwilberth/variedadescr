@extends('layouts.app')
@section('meta_tags')
    @if ($producto)
        <title>{{ $producto->nombre }} | VariedadesCR.com</title>
        <meta property='article:published_time' content='{{ $producto->created_at }}' />
        <meta property='article:section' content='event' />
        @if ($producto->descripcion_social)
            <meta name='description' itemprop='description' content='{{ $producto->descripcion_social }}' />
            <meta property="og:description" content="{{ $producto->descripcion_social }}" />
        @else
            <meta name='description' itemprop='description' content='{{ $producto->descripcion }}' />
            <meta property="og:description" content="{{ $producto->descripcion }}" />
        @endif
        <meta property="og:title" content="{{ $producto->nombre }}" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:type" content="article" />
        <meta property="og:locale" content="es-cr" />
        <meta property="og:locale:alternate" content="es-us" />
        <meta property="og:site_name" content="{{ config('ajustes.sitio_web.nombre') }}" />
        @if ($producto->imagenes->count() > 0)
            <meta property="og:image"
                content="https://variedadescr.com/storage/productos/{{ $producto->imagenes->first()->ruta }}" />
            <meta property="og:image:secure_url"
                content="https://variedadescr.com/storage/productos/{{ $producto->imagenes->first()->ruta }}" />
        @endif
        <meta property="og:image:size" content="300" />

        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="{{ $producto->nombre }}" />
        <meta name="twitter:site" content="@BrnBhaskar" />
    @endif
@endsection

@section('content')
    @php
        $revendedor = auth()->check() && auth()->user()->AutorizaRoles('revendedor');
        $msj_whatsapp = 'Me interesa este articulo.';

        switch ($producto->disponibilidad) {
            case 0:
                $disponibilidad = 'Inmediata';
                $color_dispo = 'text-success';
                break;

            case 1:
                $disponibilidad = 'Una semana';
                $color_dispo = 'text-success';
                break;

            case 2:
                $disponibilidad = 'Dos semanas';
                $color_dispo = 'text-success';
                break;

            case 3:
                $disponibilidad = 'Agotado';
                $color_dispo = 'text-danger';
                break;
            default:
                $disponibilidad = '';
                $color_dispo = '';
        }
        $agotado = false;
        $disableAgotado = '';
        if ($producto->stock == 0 || $producto->disponibilidad == 3) {
            $agotado = true;
            $disableAgotado = 'disabled';
        }
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
                @if ($producto->imagenes->count() > 0)
                    <div id="carousel-example-1z" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($producto->imagenes as $i => $imagen)
                                <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                                    <a href="/storage/productos/{{ $imagen->ruta }}" data-lightbox="roadtrip">
                                        <img class="d-block w-100" src="/storage/productos/{{ $imagen->ruta }}"
                                            alt="Slide">
                                    </a>
                                </div>
                            @endforeach
                            @if ($producto->url_tiktok)
                                <div class="carousel-item">
                                    {!! $producto->url_tiktok !!}
                                </div>
                            @endif
                        </div>
                        <button class="carousel-control-prev text-dark" type="button" data-bs-target="#carousel-example-1z"
                            data-bs-slide="prev">
                            <i class="fa fa-2x fa-chevron-left"></i>
                        </button>
                        <button class="carousel-control-next text-dark" type="button" data-bs-target="#carousel-example-1z"
                            data-bs-slide="next">
                            <i class="fa fa-2x fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="d-flex justify-content-center gap-2">
                        @foreach ($producto->imagenes as $i => $imagen)
                            <img src="/storage/productos/{{ $imagen->ruta }}" alt="{{ $producto->nombre }}"
                                class="img-thumbnail carousel-thumbnail social-link" data-bs-target="#carousel-example-1z"
                                data-bs-slide-to="{{ $i }}"
                                style="height: 60px; width: 60px; cursor: pointer; margin: 0 5px;">
                        @endforeach
                    </div>
                    @if ($producto->url_tiktok)
                        <img src="/img/tik-tok.png" alt="tiktok" class="img-thumbnail carousel-thumbnail"
                            data-bs-target="#carousel-example-1z" data-bs-slide-to="{{ $producto->imagenes->count() }}"
                            style="height: 80px; width: 80px; cursor: pointer; margin: 0 5px;">
                    @endif
                @else
                    <img src="/img/sin_foto.png" alt="Producto sin imagen">
                @endif

            </div>

            <div class="col-sm-3 mb-3">
                <span class="fs-3 fw-bold" style="color: rgb(191, 73, 73)">
                    ₡{{ number_format($producto->precio_venta) }}
                </span>
                <br>
                @if ($producto->precio_sugerido)
                    <span class="font-weight-bold" style="color: #8a8a8a;">Precio sugerido:</span><span
                        style="font-family: georgia,sans-serif; color: #8a8a8a;">
                        ₡{{ number_format($producto->precio_sugerido) }}</span>
                    <br>
                @endif
                @if ($producto->precio_anterior && $producto->precio_anterior > $producto->precio_venta)
                    <span class="font-weight-bold" style="color: #8a8a8a;">Antes:</span> <span
                        style="color: #8a8a8a; textDecoration: line-through; font-family: georgia,sans-serif">{{ $producto->currency_symbol }}{{ $producto->precio_anterior }}.</span>
                @endif
                @if ($admin)
                    <br>
                    Costo: ₡{{ number_format($producto->costo) }} <br>
                    Mayorista: ₡{{ number_format($producto->precio_mayorista) }} <br>
                @endif
                @if ($revendedor)
                    Precio mayorista: ₡{{ number_format($producto->precio_mayorista) }}
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
                        <span class="{{ $color_dispo }}">{{ $disponibilidad }}</span>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var carousel = new bootstrap.Carousel(document.querySelector('#carousel-example-1z'), {
                interval: false
            });

            document.querySelectorAll('.carousel-thumbnail').forEach(function(thumbnail) {
                thumbnail.addEventListener('click', function() {
                    var slideIndex = this.getAttribute('data-slide-index');
                    carousel.to(parseInt(slideIndex));
                });
            });

            document.querySelector('#carousel-example-1z').addEventListener('slide.bs.carousel', function(e) {
                document.querySelectorAll('.carousel-thumbnail').forEach(function(thumb) {
                    thumb.classList.remove('active-thumbnail');
                });
                document.querySelector('.carousel-thumbnail[data-slide-index="' + e.to + '"]').classList
                    .add('active-thumbnail');
            });
        });
    </script>

    <style>
        .carousel {
            max-height: 350px;
            /* Ajusta este valor según necesites */
            margin-bottom: 20px;
        }

        .carousel-inner {
            max-height: 350px;
            /* Debe coincidir con el max-height del carousel */
        }

        .carousel-item {
            height: 350px;
            /* Debe coincidir con los max-height anteriores */
        }

        .carousel-item img {
            object-fit: contain;
            /* Esto mantendrá la proporción de la imagen */
            height: 100%;
            width: 100%;
        }

        .carousel-thumbnail {
            transition: all 0.3s ease;
            opacity: 0.6;
        }

        .carousel-thumbnail:hover {
            opacity: 1;
        }

        .active-thumbnail {
            opacity: 1;
            border: 2px solid #007bff;
        }
    </style>
@endsection
