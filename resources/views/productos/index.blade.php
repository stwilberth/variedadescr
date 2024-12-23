@extends('layouts.app')
@section('content')
<div class="container"> 
    {{-- filtro --}}
        <div class="row">
            <form action="{{ route('catalogoIndex', $catalogo_slug) }}" method="GET" class="col-12">
                <div class="row mb-3">
                    {{-- Filtro Marcas --}}
                    <div class="col-12 col-sm-6 col-md-2 mb-2">
                        <select class="custom-select" name="marca">
                            <option value="0">Marcas</option>
                            @foreach ($marcas as $item)
                                @if($item->cantidad > 0)
                                    <option value="{{$item->id}}" @if($marca_id == $item->id) selected @endif>
                                        {{$item->nombre}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    {{-- Filtro Género --}}
                    <div class="col-12 col-sm-6 col-md-2 mb-2">
                        <select class="custom-select" name="genero">
                            @foreach (config('options.generos') as $item)
                                <option value="{{$item['value']}}" @if($item['value'] == $genero) selected @endif>{{$item['nombre']}}</option>   
                            @endforeach
                        </select>
                    </div>
                    {{-- Filtro Orden --}}
                    <div class="col-12 col-sm-6 col-md-2 mb-2">
                        <select class="custom-select" name="orden">
                            <option value="">Ordenar por precio</option>
                            <option value="asc" @if(request('orden') == 'asc') selected @endif>Menor a mayor</option>
                            <option value="desc" @if(request('orden') == 'desc') selected @endif>Mayor a menor</option>
                        </select>
                    </div>
                    {{-- Filtro Liquidación --}}
                    <div class="col-12 col-sm-6 col-md-4 mb-2">
                        <select class="custom-select" name="descuento">
                            <option value="0">Todos los productos</option>
                            <option value="1" @if(request('descuento') == '1') selected @endif>En oferta</option>
                            <option value="2" @if(request('descuento') == '2') selected @endif>En liquidación</option>
                        </select>
                    </div>
                    {{-- Botón Filtrar --}}
                    <div class="col-12 col-sm-6 col-md-2 mb-2">
                        <button type="submit" class="btn btn-success w-100">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    {{-- fin filtro    --}}

    @if (auth()->user() && auth()->user()->AutorizaRoles('admin'))
        <panel-admin slug-data=""></panel-admin>
    @endif

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        {{session('status')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    @endif

    {{-- sin resultados --}}
    @if (count($productos)<=0)
        <div class="row">
            <div class="col-12">
                <div class="row d-flex justify-content-center">
                    <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                            La consulta no generó resultados.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
        {{-- $title --}}
            <div class="col-12">
                <h1 class="text-center">{{$title}}</h1>
            </div>

            @foreach ($productos as $producto)
                @php
                    $msj_whatsapp = "Me interesa este articulo.";
                @endphp
                {{-- reloj --}}
                <div class="col-6 col-md-2 mt-5">
                    <!-- Card -->
                    <div class="m-0 text-center">        
                        <!-- Card image -->
                        @if ($producto->imagenes->count() > 0)
                            <a href="/catalogo/{{$producto->catalogoM->slug}}/{{$producto->slug}}">
                                <img class="card-img-top" loading="lazy" src="/storage/productos/thumb_{{$producto->imagenes->first()->ruta}}" alt="Fotograía del {{$producto->nombre}}"> 
                                @php
                                    // Obtén la fecha de creación del producto (de tu modelo, supongamos que es una propiedad llamada 'created_at')
                                    $fechaCreacion = strtotime($producto->created_at);
                                    // Calcula la fecha límite (hace un mes)
                                    $fechaLimite = strtotime('-1 month');
                                    // Compara las fechas
                                    $productoAntiguo = $fechaCreacion < $fechaLimite;
                                @endphp

                                @if ($producto->nuevo && !$productoAntiguo)
                                    <img class="card-img-top nuevo-etiqueta" loading="lazy" src="/img/nuevo.png"> 
                                @else
                                    @if($producto->oferta == 1 || $producto->oferta == 2)
                                        <img class="card-img-top nuevo-etiqueta" loading="lazy" src="/img/oferta.png"> 
                                    @endif
                                @endif
                            </a>   
                        @else
                        <a href="/catalogo/{{$producto->catalogoM->slug}}/{{$producto->slug}}">
                            <img class="card-img-top" loading="lazy" src="/img/sin_foto.png" alt="Fotografía del {{$producto->nombre}}">     
                        </a>
                        @endif   
                        <!-- Card content -->
                        <div class="text-center">          
                            <!-- Title -->
                            <h6 class="card-title mt-2 text-truncate">{{$producto->nombre}}</h6>
                            @if ($producto->publicado == 0)
                                <h6 class="red-text">No publicado</h6>
                            @endif
                            <!-- Text -->
                            <span style="font-size:1.2rem; color: #86bd57;">
                                @if (auth()->user() && auth()->user()->AutorizaRoles('revendedor'))
                                    @if ($producto->precio_mayorista)
                                        {{$producto->moneda_simbolo}}{{$producto->precio_mayorista}}
                                    @else
                                        No disponible
                                    @endif
                                @else
                                    {{$producto->moneda_simbolo}}{{$producto->precio_venta}}
                                @endif
                            </span>
                            @if (false)
                                <span style="font-size:1rem;textDecoration: line-through">{{$producto->moneda_simbolo}}{{$producto->precio_anterior}}</span>
                            @endif
                            <br>
                            <!-- Button -->
                            <a  href="/catalogo/{{$producto->catalogoM->slug}}/{{$producto->slug}}" 
                                class="btn btn-sm stylish-color mdb-color white-text" style="padding-left: 15px; padding-right:15px">Ver</a>
                            <a href="{{config('ajustes.redes.whatsapp')}}?text=https://variedadescr.com/catalogo/{{$producto->catalogoM->slug}}/{{$producto->slug}} {{$msj_whatsapp}}" 
                                class="btn btn-default btn-sm" style="padding-left: 10px; padding-right:10px">Pedir</a>        
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    

    



    


</div>
@endsection