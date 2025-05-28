@extends('layouts.app')

@section('meta_tags')
    <x-meta-ttags
        :title="$producto->nombre"
        :description="$producto->descripcion_social ? $producto->descripcion_social . ' - Precio: ¢' . number_format($producto->precio_venta) : null"
        :image="$producto->imagenes->count() > 0 ? 'https://variedadescr.com/storage/productos/' . $producto->imagenes->first()->ruta : null"
        type="article"
        :published-time="$producto->created_at"
        section="event"
        :schema="[
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $producto->nombre,
            'description' => $producto->descripcion_social,
            'image' => $producto->imagenes->count() > 0 ? 'https://variedadescr.com/storage/productos/' . $producto->imagenes->first()->ruta : null,
            'sku' => $producto->sku,
            'brand' => [
                '@type' => 'Brand',
                'name' => $producto->marca->nombre
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => $producto->precio_venta,
                'priceCurrency' => 'CRC',
                'availability' => $producto->disponibilidad == 3 ? 'https://schema.org/OutOfStock' : 'https://schema.org/InStock'
            ]
        ]"
    />
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
                    {{-- notificar --}}
                    @if($producto->publicado == 1 && $producto->imagenes->count() > 0)
                    <form action="{{ route('productoNotificar', $producto->slug) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="fa fa-envelope"></i>
                            Notificar
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            <div class="col-12 text-center">
                @if ($producto->publicado == 0)
                    <h2 class="text-danger">No publicado</h2>
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
                
                <!-- Botón de consulta por WhatsApp (visible solo en móvil) -->
                <div class="mt-3 mb-3 d-md-none">
                    <a href="https://wa.me/50687811054?text=Hola, me interesa este producto: {{ $producto->nombre }} {{ url()->current() }}" 
                       class="btn btn-success w-100" 
                       target="_blank">
                        <i class="fab fa-whatsapp me-2"></i>Consultar por WhatsApp
                    </a>
                </div>
                
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
                    <!-- Botón de consulta por WhatsApp (visible solo en escritorio) -->
                    <li class="list-group-item px-0 d-none d-md-block">
                        <a href="https://wa.me/50687811054?text=Hola, me interesa este producto: {{ $producto->nombre }} {{ url()->current() }}" 
                           class="btn btn-success w-100" 
                           target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>Consultar por WhatsApp
                        </a>
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
