@extends('layouts.app')
    @section('meta_tags')
        @if($producto)
            <title>{{$producto->nombre}} | VariedadesCR.com</title>
            <meta property='article:published_time' content='{{$producto->created_at}}' />
            <meta property='article:section' content='event' />
            @if ($producto->descripcion_social)
                <meta name='description' itemprop='description' content='{{$producto->descripcion_social}}' />
                <meta property="og:description" content="{{$producto->descripcion_social}}" />
            @else
                <meta name='description' itemprop='description' content='{{$producto->descripcion}}' />
                <meta property="og:description" content="{{$producto->descripcion}}" />
            @endif
            <meta property="og:title" content="{{$producto->nombre}}" />
            <meta property="og:url" content="{{url()->current()}}" />
            <meta property="og:type" content="article" />
            <meta property="og:locale" content="es-cr" />
            <meta property="og:locale:alternate" content="es-us" />
            <meta property="og:site_name" content="{{config('ajustes.sitio_web.nombre')}}" />
            @if ($producto->imagenes->count() > 0)
            <meta property="og:image" content="https://variedadescr.com/storage/productos/{{$producto->imagenes->first()->ruta}}" />
            <meta property="og:image:secure_url" content="https://variedadescr.com/storage/productos/{{$producto->imagenes->first()->ruta}}" />   
            @endif
            <meta property="og:image:size" content="300" />
    
            <meta name="twitter:card" content="summary" />
            <meta name="twitter:title" content="{{$producto->nombre}}" />
            <meta name="twitter:site" content="@BrnBhaskar" />
        @endif
    @endsection
@section('content')
    @php
        $revendedor = (auth()->check() && auth()->user()->AutorizaRoles('revendedor'));
        $msj_whatsapp = "Me interesa este articulo.";
 

    switch ($producto->disponibilidad) {
        case 0:
            $disponibilidad = "Inmediata";
            $color_dispo = "text-success";
            break;

        case 1:
            $disponibilidad = "Una semana";
            $color_dispo = "text-success";
            break;

        case 2:
            $disponibilidad = "Dos semanas";
            $color_dispo = "text-success";
            break;

        case 3:
            $disponibilidad = "Agotado";
            $color_dispo = "text-danger";
            break;
        default:
            $disponibilidad = "";
            $color_dispo = "";
    }
    $agotado = false;
    $disableAgotado = '';
    if ($producto->stock == 0 || $producto->disponibilidad == 3) {
        $agotado = true;
        $disableAgotado = 'disabled';
    }
    @endphp

    <div class="container">

        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{session('status')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($admin)
            <panel-admin slug-data="{{$producto->slug}}"></panel-admin>
        @endif
        <div class="row mt-1 mb-1">
        </div>
        <div class="row">
            {{-- galeria --}}
            <div class="col-12 col-sm-6 mb-3">   
                <div class="row">
                    <div class="col-12">
                        @if ($producto->imagenes->count() > 0)
                        <div id="carousel-example-1z" class="carousel slide carousel-fade" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @php
                                    $active = 'active';
                                @endphp
                                @for ($i = 0; $i < $producto->imagenes->count(); $i++)
                                    <li data-target="#carousel-example-1z" data-slide-to="{{$i}}" class="{{$active}}"></li>
                                    @php
                                        $active = '';
                                    @endphp
                                @endfor
                                @if($producto->url_tiktok)
                                    <li data-target="#carousel-example-1z" data-slide-to="{{ $producto->imagenes->count() }}"></li>
                                @endif
                            </ol>
                            <div class="carousel-inner" role="listbox">
                                @php
                                    $active = 'active';
                                @endphp
                                @foreach ($producto->imagenes as $imagen)
                                    
                                    <div class="carousel-item {{$active}}">
                                        <a href="/storage/productos/{{$imagen->ruta}}" data-lightbox="roadtrip">
                                            <img class="d-block w-100" src="/storage/productos/{{$imagen->ruta}}" alt="First slide">
                                        </a>
                                    </div>
                                    @php
                                        $active = '';
                                    @endphp
                                @endforeach
                                @if($producto->url_tiktok)
                                    <div class="carousel-item">
                                        {!! $producto->url_tiktok !!}
                                    </div>
                                @endif
                            </div>
                            <a class="carousel-control-prev" href="#carousel-example-1z" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel-example-1z" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>  
                        @else
                            <img src="/img/sin_foto.png" alt="Producto sin imagen">
                        @endif
                    </div>
                </div>

                @if ($producto->imagenes->count() > 0)
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        @foreach ($producto->imagenes as $i => $imagen)
                                <img 
                                    src="/storage/productos/{{$imagen->ruta}}" 
                                    alt="{{$producto->nombre}}" 
                                    data-target="#carousel-example-1z" 
                                    data-slide-to="{{$i}}" 
                                    class="img-thumbnail" 
                                    style="height: 100px; width:100px; margin-left:2%; margin-top:1%">
                        @endforeach
                        @if($producto->url_tiktok)
                            <img 
                                src="/img/tik-tok.png" 
                                alt="tiktok" 
                                data-target="#carousel-example-1z" 
                                data-slide-to="{{ $producto->imagenes->count() }}" 
                                class="img-thumbnail" 
                                style="height: 100px; width:100px; margin-left:2%; margin-top:1%">
                        @endif
                    </div>
                </div> 
                @endif

            </div>
            {{-- fin galeria --}}
            <div class="col-12 col-sm-6 mb-3">
                <div class="row">
                    <div class="col-12 mb-3">
                        <h1>{{$producto->nombre}}</h1>
                    </div>
                    
                    <div class="col-12 pl-4 pr-4">
                        <div class="row">
                            <div class="col-12">
                                @if ($producto->publicado == 0)
                                    <h2 class="red-text">No publicado</h2>
                                @endif
                            </div>
                            <div class="col-12 col-sm-6">
                                <span class="font-weight-bold">Marca:</span>
                                <a href="/catalogo/relojes?marca={{$producto->marca->id}}&genero=0" class="text-blue">
                                    {{$producto->marca->nombre}}.
                                </a>
                                <br>
                                <span class="font-weight-bold">Modelo:</span> {{$producto->modelo}}.
                                <br>
                                <span class="font-weight-bold">Género:</span>
                                <a href="/catalogo/relojes?marca=0&genero={{ $producto->genero }}" class="text-blue">
                                    {{ $producto->generoTexto }}.
                                </a>
                                <br>
                                <span class="font-weight-bold">Disponibilidad:</span> <span class="{{$color_dispo}}">{{$disponibilidad}}.</span>
                                <br>
                                <span class="font-weight-bold">Stock:</span> {{$producto->stock}}.
                            </div>
                            <div class="col-12 col-sm-6 mt-3">
                                <a href="{{config('ajustes.redes.whatsapp')}}?text={{Request::url()}} {{$msj_whatsapp}}" class="btn btn-success btn-lg btn-block" style="border-radius:30px">
                                    <span style="font-size:1rem">Pedir</span>
                                    <i class="fa fa-whatsapp fa-5"></i> 
                                </a>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <span class="font-weight-bold"></span>
                                 <span class="font-weight-bold" style="color: #d5312c; font-size: 25px">
                                    {{ $producto->currency_symbol }}
                                    @if ($revendedor)
                                        {{$producto->precio_mayorista}}
                                    @else
                                        {{$producto->precio_venta}}
                                    @endif
                                </span>
                                @if ($admin)
                                    <br>
                                    Mayorista:
                                    {{ $producto->currency_symbol }}{{$producto->precio_mayorista}}
                                @endif
                                <br>
                                @if ($producto->precio_anterior)
                                <span class="font-weight-bold" style="color: #8a8a8a;" >Antes:</span> <span style="color: #8a8a8a; textDecoration: line-through; font-family: georgia,sans-serif">{{ $producto->currency_symbol }}{{$producto->precio_anterior}}.</span> 
                                <br>
                                @endif
                            </div>
                            <div class="col">
                                @if ($producto->precio_sugerido)
                                    <span class="font-weight-bold" style="color: #8a8a8a;">Precio sugerido:</span><span style="font-family: georgia,sans-serif; color: #8a8a8a;"> {{ $producto->currency_symbol }}{{$producto->precio_sugerido}}.</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-4">
                                <div class="col-12 col-sm-12">{!! $producto->descripcion !!}</div>
                        </div>
                        {{-- <div class="col-12 col-sm-6 mt-3">
                            @if (!$agotado) 
                                <div class="text-center">
                                    <span onclick="formasPagoShow()" class="btn btn-primary" style="border-radius:30px">
                                        <span style="font-size:1rem">Comprar</span>
                                        <i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>
                                    </span>        
                                </div>
                                <div class="col-12">
                                    @if ($producto->envio)
                                        <p class="text-muted text-center">Envío Gratis</p>
                                    @endif
                                </div>
                            @endif
                        </div> --}}
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <a href="http://www.facebook.com/sharer/sharer.php?u={{url()->current()}}" target="_blank" class="btn primary-color-dark text-white">
                                    <i class="fa fa-facebook fa-lg"></i>
                                </a>
                                <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" target="_blank" class="btn info-color text-white" data-show-count="false">
                                    <i class="fa fa-twitter fa-lg"></i>
                                </a>
                                <a href="whatsapp://send?text={{url()->current()}}" target="_blank" class="btn btn-success text-white">
                                    <i class="fa fa-whatsapp fa-lg"></i>
                                </a>
                            </div>
                        </div>
        
                    </div>
    
                </div>
            </div>
          
            <x-slider-productos 
                :products="$more_products"
                :titulo="'Más relojes '. $producto->marca->nombre"/>

            <x-slider-productos 
                :products="$new_products"
                :titulo="'Nuevos productos'"/>
        </div>
    </div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js" defer></script>
<script async src="https://www.tiktok.com/embed.js"></script>

<script>
    $(document).ready(function(){
    $('.carousel').carousel({
        interval: false
    });
    });
</script>
@endsection