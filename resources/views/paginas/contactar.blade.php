@extends('layouts.app')
@php 
  $title = 'Contáctenos';
@endphp

@section('meta_tags')
    <x-meta-ttags
        :title="$title"
        description="Contáctenos para cualquier duda o consulta por medio de WhatsApp, Facebook o correo electrónico"
        type="website"
        section="contact"
    />
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Contáctenos</span>
                </div>
                <div class="card-body">
                    <p class="card-text">Elije cualquiera de estos medios y pronto un agente te estará contactando</p>
                    
                    <div class="d-grid gap-2 d-md-block">
                        <a href="{{config('ajustes.redes.whatsapp')}}?text=" class="btn btn-success w-100 mb-2">WhatsApp</a>
                        <a href="{{config('ajustes.redes.facebook')}}" class="btn btn-primary w-100 mb-2">Facebook</a>
                        <a href="mailto:{{config('ajustes.sitio_web.correos.info')}}" class="btn btn-secondary w-100">{{config('ajustes.sitio_web.correos.info')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection