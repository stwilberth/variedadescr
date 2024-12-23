@if (isset($products) && $products->count() > 3)
  @php
      // sirve para hacer los productos en grupos de 4
      $groups = array();
      $gruposDe4 = array();
      $conteoDe4 = 0;
      for($i = 0; $i < count($products); ++$i) {
        $conteoDe4 = $conteoDe4 + 1;
        if ($conteoDe4 <= 4) {
          array_push($gruposDe4, $products[$i]);
        } else {
          array_push($groups, $gruposDe4);
          $gruposDe4 = array();
          $conteoDe4 = 0;
        }
      }
      //crear id unico con timestap aleatorio para el slider y convertirlo en letras
      $sliderid = str_shuffle(strtotime("now") . rand(1, 10000));
      //convertir $sliderid en letras
      $sliderid = base_convert($sliderid, 10, 36);
  @endphp

    <div class="row mt-5">
      <div class="col-12">  
        <h2>
          <strong>
              {{$titulo}}
          </strong> 
        </h2>     
      </div>
    </div>

  <div class="container">
    <div class="row">


      <div class="col-12 d-none d-sm-none d-md-block">
        <div id="{{$sliderid}}" class="carouselreloj carousel slide" data-ride="carousel" data-interval="0">
          <ol class="carousel-indicators">
            @php
                $active = 'active';
            @endphp
            @foreach ($groups as $key => $team)
              <li data-target="#{{$sliderid}}" data-slide-to="{{$key}}" class="{{$active}}"></li>
              @php
                  $active = '';
              @endphp
            @endforeach
          </ol>
          <div class="carousel-inner">
            @php
                $active = 'active';
            @endphp
            @foreach ($groups as $productos)
              <div class="item carousel-item {{$active}}">
                <div class="row">  
                  @foreach ($productos as $producto)
                    @php
                      $msj_whatsapp = "Me interesa este articulo.";
                    @endphp
                    <div class="col-md-3">
                      <div class="thumb-wrapper">
                        <div class="img-box">
                          @if ($producto->imagenes->count() > 0)
                            <a href="/catalogo/relojes/{{$producto->slug}}">   
                              <img src="/storage/productos/thumb_{{$producto->imagenes->first()->ruta}}" class="img-responsive img-fluid" alt="Fotografia de {{$producto->nombre}}">
                            </a>
                          @else
                            <a href="/catalogo/relojes/{{$producto->slug}}">   
                              <img src="/img/sin_foto.png" class="card-img-top" alt="Producto sin imagen"> 
                            </a>
                          @endif
                        </div>
                        <div class="thumb-content">
                          <h4>{{$producto->nombre}}</h4>
                          <p class="item-price"><span>{{$producto->currency_symbol}}{{$producto->precio_venta}}</span></p>
                          <a href="/catalogo/relojes/{{$producto->slug}}" class="btn btn-sm m-0 ml-1 stylish-color mdb-color white-text pl-3 pr-3">&nbsp;Ver&nbsp;</a>
                          <a href="https://wa.me/+50687811054?text=https://variedadescr.com/catalogo/relojes/{{$producto->slug}} {{$msj_whatsapp}}" class="btn btn-default btn-sm m-0 pl-3 pr-3">Pedir</a>
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
          <a class="carousel-control left carousel-control-prev" href="#{{$sliderid}}" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a class="carousel-control right carousel-control-next" href="#{{$sliderid}}" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-12 d-block d-sm-block d-md-none">

        <div id="{{$sliderid}}_movil" class="carouselreloj carousel slide" data-ride="carousel" data-interval="0">
          <div class="carousel-inner">
            @php
                $active = 'active';
            @endphp
            @foreach ($products as $producto)
              <div class="item carousel-item {{$active}}">
                <div class="row">  
                    @php
                      $msj_whatsapp = "Me interesa este articulo.";
                    @endphp
                    <div class="col-12">
                      <div class="thumb-wrapper">
                        <div class="img-box">
                          @if ($producto->imagenes->count() > 0)
                            <a href="/catalogo/relojes/{{$producto->slug}}">   
                              <img src="/storage/productos/thumb_{{$producto->imagenes->first()->ruta}}" class="img-responsive img-fluid" alt="Fotografia de {{$producto->nombre}}">
                            </a>
                          @else
                            <a href="/catalogo/relojes/{{$producto->slug}}">   
                              <img src="/img/sin_foto.png" class="card-img-top" alt="Producto sin imagen"> 
                            </a>
                          @endif
                        </div>
                        <div class="thumb-content">
                          <h4>{{$producto->nombre}}</h4>
                          <p class="item-price"><span>{{ $producto->currency_symbol }}{{$producto->precio_venta}}</span></p>
                          <a href="/catalogo/relojes/{{$producto->slug}}" class="btn btn-sm m-0 ml-1 stylish-color mdb-color white-text pl-3 pr-3">&nbsp;Ver&nbsp;</a>
                          <a href="https://wa.me/+506-87811054?text=https://variedadescr.com/catalogo/relojes/{{$producto->slug}} {{$msj_whatsapp}}" class="btn btn-default btn-sm m-0 pl-3 pr-3">Pedir</a>
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
          <a class="carousel-control left carousel-control-prev" href="#{{$sliderid}}_movil" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a class="carousel-control right carousel-control-next" href="#{{$sliderid}}_movil" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a>
        </div>
      </div>
      

    </div>
  </div>
@endif