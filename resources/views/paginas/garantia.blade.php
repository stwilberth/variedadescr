@extends('layouts.app')
@php 
  $title = 'Autenticidad y garantía';
@endphp

@section('meta_tags')
    <x-meta-ttags
        :title="$title"
        description="Todos los productos vendidos en Variedadescr.com están garantizados para ser auténticos"
        type="website"
        section="garantia"
    />
@endsection

@section('content')

<div class="container">  
  <div class="row">
    <div class="col-md-5">
      <h1 class="card-title mt-2 mb-5">Autenticidad y garantía</h1>
          <p>
            Todos los productos vendidos en Variedadescr.com están garantizados para ser auténticos. Nuestro objetivo es proporcionar el mejor servicio con el mejor precio posible. Como Variedadescr.com no sigue los precios de venta al público sugeridos por los fabricantes (MSRP), no estamos autorizados a proporcionar una garantía del fabricante. Entendemos que tener una garantía es muy importante al comprar un reloj, por lo tanto, Variedadescr.com proporciona su propia garantía para reemplazar la garantía del fabricante.
          </p>
        </div>
        <div class="col-md-7">
          <img src="img/garantia.jpg" class="img-fluid" alt="">
        </div>
    </div>
</div>
@endsection