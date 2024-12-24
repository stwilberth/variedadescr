@extends('layouts.app')
@section('content')
<div class="container">
      
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
