<div class="row mt-5">
  <div class="col-12">  
      <h2>
        <strong>Relojes Neef</strong>
      </h2>     
  </div>
</div>
<div class="row mt-3">
  @foreach ($neef as $producto)
  @php
      $msj_whatsapp = "Me interesa este articulo.";
      $imgs = explode(",", $producto->img);
      if ($producto->moneda === 1) {$moneda_simbolo = '¢';} else {$moneda_simbolo = '$';}
  @endphp
<div class="col-6 col-md-3 mt-2">
  <!-- Card -->
  <div class=" m-0 text-center">        
      <!-- Card image -->
      @if ($imgs[0])
      <a href="/catalogo/relojes/{{$producto->slug}}">
          <img class="card-img-top" src="/storage/productos/thumb_{{$imgs[0]}}" alt="Fotograía del {{$producto->nombre}}">     
      </a>   
      @else
      <a href="/catalogo/relojes/{{$producto->slug}}">
          <img class="card-img-top" src="/img/sin_foto.png" alt="Fotograía del {{$producto->nombre}}">     
      </a>
      @endif  
      <!-- Card content -->
      <div class="card-body text-center p-2">          
          <!-- Title -->
          <h5 class="card-title m-0">{{$producto->nombre}}</h5>
          <!-- Text -->
          <span style="font-size:1.2rem;">{{$moneda_simbolo}}{{$producto->precio_venta}}</span>
          @if (false)
              <span style="font-size:1rem;textDecoration: line-through">{{$moneda_simbolo}}{{$producto->precio_anterior}}</span>
          @endif
          <br>
          <!-- Button -->
          <a  href="/catalogo/relojes/{{$producto->slug}}" class="btn btn-sm m-0 ml-1 stylish-color mdb-color white-text pl-3 pr-3">&nbsp;Ver&nbsp;</a>
          <a href="{{config('ajustes.redes.whatsapp')}}?text=https://variedadescr.com/catalogo/relojes/{{$producto->slug}} {{$msj_whatsapp}}" class="btn btn-default btn-sm p-2 m-0">Comprar</a>        
      </div>
  </div>
</div>
  @endforeach
</div>