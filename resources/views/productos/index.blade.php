@extends('layouts.app')
@section('meta_tags')
    <x-meta-ttags 
        :title="$title" 
        :description="$title . ' ✓ Marcas originales ✓ Precios mayoristas ✓ Envíos a todo Costa Rica'" 
        :image="isset($productos[0]->imagenes[0]) ? 'https://variedadescr.com/storage/productos/'.$productos[0]->imagenes[0]->ruta : null" 
        publishedTime="2019-01-01" 
        :section="$title" 
        :schema="[
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $title,
            'description' => $title . ' ✓ Marcas originales ✓ Precios mayoristas ✓ Envíos a todo Costa Rica',
            'image' => isset($productos[0]->imagenes[0]) ? 'https://variedadescr.com/storage/productos/'.$productos[0]->imagenes[0]->ruta : null,
            'sku' => 'SKU-123456',
            'brand' => 'VariedadesCR',
            'offers' => [
                '@type' => 'Offer',
                'price' => '100.00',
                'priceCurrency' => 'CRC',
                'availability' => 'https://schema.org/InStock'
            ]
        ]" />
@endsection
@section('content')

    @php
        $revendedor = auth()->user() && auth()->user()->AutorizaRoles('revendedor');
    @endphp

    <div class="container">
        {{-- Botón para colapsar filtros --}}
        <div class="d-flex justify-content-center mb-3">
            <button class="btn btn-outline-success" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse"
                aria-expanded="true" aria-controls="filtrosCollapse">
                <i class="fas fa-filter"></i> Mostrar/Ocultar Filtros
            </button>
        </div>


        {{-- Filtros colapsables --}}
        <div class="collapse show" id="filtrosCollapse">
            <div class="row">
                <form action="{{ route('catalogoIndex', $catalogo_slug) }}" method="GET" class="col-12">
                    <div class="row mb-3">
                        {{-- Filtro Marcas --}}
                        <div class="col-12 col-sm-6 col-md-2 mb-2">
                            <select class="form-select" name="marca">
                                <option value="0">Marcas</option>
                                @foreach ($marcas as $item)
                                        <option value="{{ $item->id }}"
                                            @if ($marca_id == $item->id) selected @endif>
                                            {{ $item->nombre }}
                                        </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Filtro Género --}}
                        <div class="col-12 col-sm-6 col-md-2 mb-2">
                            <select class="form-select" name="genero">
                                @foreach (config('options.generos') as $item)
                                    <option value="{{ $item['value'] }}" @if ($item['value'] == $genero) selected @endif>
                                        {{ $item['nombre'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Filtro Orden --}}
                        <div class="col-12 col-sm-6 col-md-2 mb-2">
                            <select class="form-select" name="orden">
                                <option value="">Orden por fecha</option>
                                <option value="asc" @if (request('orden') == 'asc') selected @endif>Menor precio</option>
                                <option value="desc" @if (request('orden') == 'desc') selected @endif>Mayor precio </option>
                            </select>
                        </div>
                        {{-- Filtro Liquidación --}}
                        <div class="col-12 col-sm-6 col-md-4 mb-2">
                            <select class="form-select" name="descuento">
                                <option value="0">Todos los productos</option>
                                <option value="1" @if (request('descuento') == '1') selected @endif>En oferta</option>
                                <option value="2" @if (request('descuento') == '2') selected @endif>En liquidación
                                </option>
                            </select>
                        </div>
                        {{-- Botón Filtrar --}}
                        <div class="col-12 col-sm-6 col-md-2 mb-2">
                            <div class="d-flex justify-content-between gap-2">
                                <button type="submit" class="btn btn-success w-100">Filtrar</button>
                                <a href="{{ route('catalogoIndex', $catalogo_slug) }}" class="btn btn-outline-success w-100">Limpiar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- sin resultados --}}
        @if (count($productos) <= 0)
            <div class="row">
                <div class="col-12">
                    <div class="row d-flex justify-content-center">
                        <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                            La consulta no generó resultados.
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                {{-- $title --}}
                <div class="col-12">
                    <h1 class="text-center text-success fw-bold fs-2 logo-text mt-4">{{ $title }}</h1>
                </div>

                @foreach ($productos as $producto)
                    @php
                        $msj_whatsapp = 'Me interesa este articulo.';
                    @endphp
                    {{-- reloj --}}
                    <div class="col-6 col-md-2 mt-5">
                        <!-- Card -->
                        <div class="m-0 text-center">
                            <!-- Card image -->
                            @if ($producto->imagenes->count() > 0)
                                <a href="/catalogo/{{ $catalogo_slug }}/{{ $producto->slug }}"
                                    class="position-relative d-block">
                                    <img class="card-img-top" loading="lazy"
                                        src="/storage/productos/thumb_{{ $producto->imagenes->first()->ruta }}"
                                        alt="Fotograía del {{ $producto->nombre }}">
                                    @php
                                        $fechaCreacion = $producto->created_at ? strtotime($producto->created_at) : 0;
                                        $fechaLimite = strtotime('-1 month');
                                    @endphp

                                    @if ($fechaCreacion >= $fechaLimite)
                                        <img class="etiqueta-overlay" loading="lazy" src="/img/nuevo.png" alt="Etiqueta de producto nuevo">
                                    @elseif ($producto->oferta == 1 || $producto->oferta == 2)
                                        <img class="etiqueta-overlay" loading="lazy" src="/img/oferta.png" alt="Etiqueta de oferta">
                                    @endif
                                </a>
                            @else
                                <a href="/catalogo/{{ $catalogo_slug }}/{{ $producto->slug }}">
                                    <img class="card-img-top" loading="lazy" src="/img/sin_foto.png"
                                        alt="Fotografía del {{ $producto->nombre }}">
                                </a>
                            @endif
                            <!-- Card content -->
                            <div class="text-center">
                                <!-- Title -->
                                <a href="/catalogo/{{ $catalogo_slug }}/{{ $producto->slug }}"
                                    class="text-decoration-none text-dark">
                                    <h6 class="card-title mt-2 text-truncate">{{ $producto->nombre }}</h6>
                                </a>
                            </div>
                            <!-- Button -->
                            <div class="d-flex justify-content-center gap-3 mt-2">
                                <span class="fs-5 font-monospace" style="color: rgb(191 73 73)">
                                    @if ($revendedor)
                                        @if ($producto->precio_mayorista)
                                            M: ¢{{ $producto->precio_mayorista }}
                                            <br>
                                        @endif
                                        V: ¢{{ $producto->precio_venta }}
                                    @else
                                        ¢{{ number_format($producto->precio_venta, 0, '.', ',') }}
                                    @endif
                                </span>
                                <a href="{{ config('ajustes.redes.whatsapp') }}?text=https://variedadescr.com/catalogo/{{ $catalogo_slug }}/{{ $producto->slug }} {{ $msj_whatsapp }}"
                                    class="text-decoration-none fs-5 btn-sm btn-outline-success d-none d-sm-inline-block" style="color: rgb(14 82 51)">
                                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                                    <span class="d-none d-sm-inline">Chat</span>
                                </a>
                                <a href="{{ config('ajustes.redes.whatsapp') }}?text=https://variedadescr.com/catalogo/{{ $catalogo_slug }}/{{ $producto->slug }} {{ $msj_whatsapp }}"
                                    class="text-decoration-none fs-5 btn btn-sm btn-outline-success d-inline-block d-sm-none" style="color: rgb(14 82 51)">
                                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Agregar los enlaces de paginación --}}
        <div class="mt-5 d-flex justify-content-center">
            {{ $productos->withQueryString()->links() }}
        </div>

    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filtrosCollapse = document.getElementById('filtrosCollapse');
        const filtrosBtn = document.querySelector('[data-bs-target="#filtrosCollapse"]');

        function adjustCollapse() {
            if (window.innerWidth < 576) { // Bootstrap's sm breakpoint
                filtrosCollapse.classList.remove('show');
                filtrosBtn.setAttribute('aria-expanded', 'false');
            } else {
                filtrosCollapse.classList.add('show');
                filtrosBtn.setAttribute('aria-expanded', 'true');
            }
        }

        // Ejecutar al cargar y cuando cambie el tamaño de la ventana
        adjustCollapse();
        window.addEventListener('resize', adjustCollapse);
    });
</script>
