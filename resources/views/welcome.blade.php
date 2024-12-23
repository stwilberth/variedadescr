@extends('layouts.app')
@section('content')
<div class="container">
    <div class="container">
        <div class="row">
          {{-- <div id="carousel-example-2" class="carousel slide carousel-fade" data-ride="carousel">
        
            <ol class="carousel-indicators">
              <li data-target="#carousel-example-2" data-slide-to="0" class="active"></li>
              <li data-target="#carousel-example-2" data-slide-to="1"></li>
            </ol>
        
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <div class="view">
                  <img class="d-block w-100" src="img/slider/fossil.jpg"
                    alt="First slide">
                  <div class="mask rgba-black-light"></div>
                </div>
                <div class="carousel-caption">
                  <h3 class="h3-responsive">Fossil</h3>
                  <p>SmartWatch</p>
                </div>
              </div>
              <div class="carousel-item">
                <!--Mask color-->
                <div class="view">
                  <img class="d-block w-100" src="img/slider/invicta.jpg"
                    alt="Second slide">
                  <div class="mask rgba-black-light"></div>
                </div>
                <div class="carousel-caption">
                  <h3 class="h3-responsive">Invicta</h3>
                  <p>Chapado en Oro 23 k</p>
                </div>
              </div>
            </div>
        
            <a class="carousel-control-prev" href="#carousel-example-2" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-example-2" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
        
          </div> --}}
        </div>
    </div>
      
    @php
        $lista = array(
            array('imgUrl' => 'img/relojes.jpg', 
                'titulo' => 'Relojes', 
                'url' => 'catalogo/relojes', 
                'style' => 'margin: 13%'
            ),
            array(
                'imgUrl' => 'img/perfumes.jpg', 
                'titulo' => 'Perfumes', 
                'url' => 'catalogo/perfumes', 
                'style' => 'margin-bottom: 13%; margin-left: 8%; margin-top: 13%;'
            )
        )
    @endphp
    <div class="row mt-5">
        @for ($i = 0; $i < count($lista); $i++)

        <div class="col-6 d-none d-sm-none d-md-block">
            <div class="card card-image" style="background-image: url({{$lista[$i]['imgUrl']}});">
            <div class="text-white text-center d-flex align-items-center p-5 px-4" style="background-color: rgba(5, 29, 0, 0.79)">
                <div>
                <h3 class="card-title pt-2"><strong>{{$lista[$i]['titulo']}}</strong></h3>
                <p></p>
                <a class="btn btn-default" href="{{$lista[$i]['url']}}"><i class="fa fa-arrow-right" aria-hidden="true"></i>Ir</a>
                </div>
            </div>
            </div>
        </div>

        <div class="col-6 d-block d-sm-block d-md-none">
            <div class="card card-image" style="background-image: url({{$lista[$i]['imgUrl']}});">
            <div class="text-white" style="background-color: rgba(5, 29, 0, 0.79)">
            <h3 style="{{$lista[$i]['style']}}">
                    <a href="{{$lista[$i]['url']}}">
                        <strong style="color: white">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            {{$lista[$i]['titulo']}} 
                        </strong>
                    </a>
                </h3>
            </div>
            </div>
        </div>

        @endfor
    </div>

    <x-slider-productos :products="$ofertas" titulo="Relojes con descuentos"/>
    <x-slider-productos :products="$nixon" titulo="Relojes Nixon"/>
    <x-slider-productos :products="$fossil" titulo="Relojes Fossil"/>
    <x-slider-productos :products="$invicta" titulo="Relojes Invicta"/>
    <x-slider-productos :products="$perfumes" titulo="Perfumes"/>
</div>
@endsection
