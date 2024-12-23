@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-1">
        <div class="col-md-8">
        <!-- Card -->
<div class="card">
    <!-- Card content -->
    <div class="card-body">
  
      <!-- Title -->
      <h1 class="card-title">Contáctenos</h1>
      <!-- Text -->
      <p>Elije cualquiera de estos medios y pronto un agente te estará contactando</p>
      <!-- Button -->
      <a href="{{config('ajustes.redes.whatsapp')}}?text=" class="btn btn-success">WhatsApp</a>
      <a href="{{config('ajustes.redes.facebook')}}" class="btn btn-primary">Facebook</a>
      <a href="mailto:{{config('ajustes.sitio_web.correos.info')}}" class="btn btn-secondary">{{config('ajustes.sitio_web.correos.info')}}</a>
    </div>
  
  </div>
  <!-- Card -->
        </div>
    </div>
</div>
@endsection