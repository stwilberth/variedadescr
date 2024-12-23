@php
// sirve para hacer los productos en grupos de 4
    $fossiles = array();
    $gruposDe4 = array();
    $conteoDe4 = 0;
    for($i = 0; $i < count($fossil); ++$i) {
      $conteoDe4 = $conteoDe4 + 1;
      if ($conteoDe4 <= 4) {
        array_push($gruposDe4, $fossil[$i]);
      } else {
        array_push($fossiles, $gruposDe4);
        $gruposDe4 = array();
        $conteoDe4 = 0;
      }
    }
@endphp

<div class="container">
	<div class="row">


		<div class="col-12 d-none d-sm-none d-md-block">
			<div id="myCarousel" class="carouselreloj carousel slide" data-ride="carousel" data-interval="0">
        <ol class="carousel-indicators">
          @php
              $active = 'active';
          @endphp
          @foreach ($fossiles as $key => $team)
            <li data-target="#myCarousel" data-slide-to="{{$key}}" class="{{$active}}"></li>
            @php
                $active = '';
            @endphp
          @endforeach
        </ol>
        <div class="carousel-inner">
          @php
              $active = 'active';
          @endphp
          @foreach ($fossiles as $productos)
            <div class="item carousel-item {{$active}}">
              <div class="row">  
                @foreach ($productos as $producto)
                  @php
                    $msj_whatsapp = "Me interesa este articulo.";
                    if ($producto->moneda === 1) {$moneda_simbolo = '¢';} else {$moneda_simbolo = '$';}
                  @endphp
                  <div class="col-md-3">
                    <div class="thumb-wrapper">
                      <div class="img-box">
                        @if ($producto->imagenes->count() > 0)
                          <a href="/catalogo/{{$producto->categoria}}/{{$producto->slug}}">   
                            <img src="/storage/productos/thumb_{{$producto->imagenes->first()->ruta}}" class="img-responsive img-fluid" alt="Fotografia de {{$producto->nombre}}">
                          </a>
                        @else
                          <a href="/catalogo/{{$producto->categoria}}/{{$producto->slug}}">   
                            <img src="/img/sin_foto.png" class="card-img-top" alt="Producto sin imagen"> 
                          </a>
                        @endif
                      </div>
                      <div class="thumb-content">
                        <h4>{{$producto->nombre}}</h4>
                        <p class="item-price"><span>{{$moneda_simbolo}}{{$producto->precio_venta}}</span></p>
                        <a href="/catalogo/{{$producto->categoria}}/{{$producto->slug}}" class="btn btn-sm m-0 ml-1 stylish-color mdb-color white-text pl-3 pr-3">&nbsp;Ver&nbsp;</a>
                        <a href="{{config('ajustes.redes.whatsapp')}}?text=https://variedadescr.com/catalogo/{{$producto->categoria}}/{{$producto->slug}} {{$msj_whatsapp}}" class="btn btn-default btn-sm m-0 pl-3 pr-3">Pedir</a>
                      </div>						
                    </div>
                  </div> 
                @endforeach
              </div>
            </div>
            @php
                $active = '';
            @endphp
          @endforeach
        </div>
        <a class="carousel-control left carousel-control-prev" href="#myCarousel" data-slide="prev">
          <i class="fa fa-angle-left"></i>
        </a>
        <a class="carousel-control right carousel-control-next" href="#myCarousel" data-slide="next">
          <i class="fa fa-angle-right"></i>
        </a>
      </div>
		</div>

    <div class="col-12 d-block d-sm-block d-md-none">
			<div id="movilCarousel" class="carouselreloj carousel slide" data-ride="carousel" data-interval="0">
			  <div class="carousel-inner">
          @php
              $active = 'active';
          @endphp
          @foreach ($fossil as $producto)
            <div class="item carousel-item {{$active}}">
              <div class="row">  
                  @php
                    $msj_whatsapp = "Me interesa este articulo.";
                    if ($producto->moneda === 1) {$moneda_simbolo = '¢';} else {$moneda_simbolo = '$';}
                  @endphp
                  <div class="col-12">
                    <div class="thumb-wrapper">
                      <div class="img-box">
                        @if ($producto->imagenes->count() > 0)
                          <a href="/catalogo/{{$producto->categoria}}/{{$producto->slug}}">   
                            <img src="/storage/productos/thumb_{{$producto->imagenes->first()->ruta}}" class="img-responsive img-fluid" alt="Fotografia de {{$producto->nombre}}">
                          </a>
                        @else
                          <a href="/catalogo/{{$producto->categoria}}/{{$producto->slug}}">   
                            <img src="/img/sin_foto.png" class="card-img-top" alt="Producto sin imagen"> 
                          </a>
                        @endif
                      </div>
                      <div class="thumb-content">
                        <h4>{{$producto->nombre}}</h4>
                        <p class="item-price"><span>{{$moneda_simbolo}}{{$producto->precio_venta}}</span></p>
                        <a href="/catalogo/{{$producto->categoria}}/{{$producto->slug}}" class="btn btn-sm m-0 ml-1 stylish-color mdb-color white-text pl-3 pr-3">&nbsp;Ver&nbsp;</a>
                        <a href="{{config('ajustes.redes.whatsapp')}}?text=https://variedadescr.com/catalogo/{{$producto->categoria}}/{{$producto->slug}} {{$msj_whatsapp}}" class="btn btn-default btn-sm m-0 pl-3 pr-3">Pedir</a>
                      </div>						
                    </div>
                  </div> 
              </div>
            </div>
            @php
                $active = '';
            @endphp
          @endforeach
        </div>
        <a class="carousel-control left carousel-control-prev" href="#movilCarousel" data-slide="prev">
          <i class="fa fa-angle-left"></i>
        </a>
        <a class="carousel-control right carousel-control-next" href="#movilCarousel" data-slide="next">
          <i class="fa fa-angle-right"></i>
        </a>
      </div>
    </div>
    

	</div>
</div>