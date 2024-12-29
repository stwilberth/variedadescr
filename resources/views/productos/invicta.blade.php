@extends('layouts.app')
@section('meta_tags')
    <meta name="description" 
        content="Relojes Invicta originales en Costa Rica ✓ Garantía oficial ✓ Precios mayoristas ✓ Envíos a todo Costa Rica*">
    <meta name="keywords" 
        content="relojes invicta costa rica, invicta original, relojes invicta hombre, relojes invicta mujer, pro diver, speedway, precios invicta costa rica">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    
    {{-- Open Graph Tags --}}
    <meta property="og:title" content="Relojes Invicta Originales en Costa Rica - VariedadesCR">
    <meta property="og:description" content="Distribuidor autorizado de Relojes Invicta en Costa Rica ✓ Garantía oficial ✓ Envíos a todo el país ✓ Las mejores colecciones">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    @if(isset($productos[0]->imagenes[0]))
    <meta property="og:image" content="{{ asset('storage/productos/'.$productos[0]->imagenes[0]->ruta) }}">
    @endif
@endsection
@section('content')
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
                <form action="{{ route('relojesInvicta') }}" method="GET" class="col-12">
                    <div class="row mb-3">
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
                        <div class="col-12 col-sm-6 col-md-3 mb-3">
                            <div class="d-flex justify-content-between gap-2">
                                <button type="submit" class="btn btn-success w-100">Filtrar</button>
                                <a href="{{ route('relojesInvicta') }}" class="btn btn-outline-success w-100">Limpiar</a>
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
                    <h1 class="text-center text-success fw-bold fs-4 mt-4">Relojes Invicta Costa Rica</h1>
                    <h2 class="text-center text-success fw-bold fs-6">Originales con Garantía</h2>
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
                                <a href="/catalogo/relojes/{{ $producto->slug }}"
                                    class="position-relative d-block">
                                    <img class="card-img-top" loading="lazy"
                                        src="/storage/productos/thumb_{{ $producto->imagenes->first()->ruta }}"
                                        alt="Fotograía del {{ $producto->nombre }}">
                                    @php
                                        // Obtén la fecha de creación del producto (de tu modelo, supongamos que es una propiedad llamada 'created_at')
                                        $fechaCreacion = strtotime($producto->created_at);
                                        // Calcula la fecha límite (hace un mes)
                                        $fechaLimite = strtotime('-1 month');
                                        // Compara las fechas
                                        $productoAntiguo = $fechaCreacion < $fechaLimite;
                                    @endphp

                                    @if ($producto->nuevo && !$productoAntiguo)
                                        <img class="etiqueta-overlay" loading="lazy" src="/img/nuevo.png">
                                    @else
                                        @if ($producto->oferta == 1 || $producto->oferta == 2)
                                            <img class="etiqueta-overlay" loading="lazy" src="/img/oferta.png">
                                        @endif
                                    @endif
                                </a>
                            @else
                                <a href="/catalogo/relojes/{{ $producto->slug }}">
                                    <img class="card-img-top" loading="lazy" src="/img/sin_foto.png"
                                        alt="Fotografía del {{ $producto->nombre }}">
                                </a>
                            @endif
                            <!-- Card content -->
                            <div class="text-center">
                                <!-- Title -->
                                <a href="/catalogo/relojes/{{ $producto->slug }}"
                                    class="text-decoration-none text-dark">
                                    <h6 class="card-title mt-2 text-truncate">{{ $producto->nombre }}</h6>
                                </a>
                            </div>
                            <!-- Button -->
                            <div class="d-flex justify-content-center gap-3 mt-2">
                                <span class="fs-5 font-monospace" style="color: rgb(191 73 73)">
                                    @if (auth()->user() && auth()->user()->AutorizaRoles('revendedor'))
                                        @if ($producto->precio_mayorista)
                                            M: ¢{{ $producto->precio_mayorista }}
                                            <br>
                                        @endif
                                        V: ¢{{ $producto->precio_venta }}
                                    @else
                                        ¢{{ number_format($producto->precio_venta, 0, '.', ',') }}
                                    @endif
                                </span>
                                <a href="{{ config('ajustes.redes.whatsapp') }}?text=https://variedadescr.com/catalogo/relojes/{{ $producto->slug }} {{ $msj_whatsapp }}"
                                    class="text-decoration-none fs-5 btn-sm btn-outline-success d-none d-sm-inline-block" style="color: rgb(14 82 51)">
                                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                                    <span class="d-none d-sm-inline">Chat</span>
                                </a>
                                <a href="{{ config('ajustes.redes.whatsapp') }}?text=https://variedadescr.com/catalogo/relojes/{{ $producto->slug }} {{ $msj_whatsapp }}"
                                    class="text-decoration-none fs-5 btn btn-sm btn-outline-success d-inline-block d-sm-none" style="color: rgb(14 82 51)">
                                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif









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
