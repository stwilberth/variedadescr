@extends('layouts.app')
@section('meta_tags')
    <meta name="description"
        content="Relojes originales en Costa Rica ✓ Perfumes  ✓ Garantía oficial ✓ Envíos a todo el país ✓ Los mejores precios en VariedadesCR.com">
    <meta name="keywords"
        content="relojes invicta costa rica, relojes originales costa rica, perfumes originales costa rica, comprar invicta costa rica, tienda oficial invicta">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection
@section('content')
    <div class="container">
        {{-- card link to products --}}
        <div class="row mb-5">
            <div class="col-md-6 mt-3">
                <a href="catalogo/relojes" class="text-decoration-none">
                    <div class="card h-100"
                        style="background-image: url('{{ asset('img/relojes.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="card-body bg-dark py-3 py-sm-5" style="opacity: 0.8">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <h5 class="text-white fs-1">Relojes</h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 mt-3">
                <a href="catalogo/perfumes" class="text-decoration-none">
                    <div class="card h-100"
                        style="background-image: url('{{ asset('img/perfumes.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="card-body bg-dark py-3 py-sm-5" style="opacity: 0.8">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <h5 class="text-white fs-1">Perfumes</h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Sección de Beneficios -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h3>100% Originales</h3>
                        <p>Garantía de autenticidad en todos nuestros relojes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                        <h3>Envío a Todo CR</h3>
                        <p>Entrega rápida y segura a cualquier parte del país*</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-shield-alt fa-3x text-warning mb-3"></i>
                        <h3>Garantía Total</h3>
                        <p>Respaldo completo en todos nuestros productos</p>
                    </div>
                </div>
            </div>
        </div>

        @if ($invicta->count() > 0)
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center" style="margin-bottom: 1.5rem; font-size: 1.5rem; font-weight: bold;">
                        <a href="/catalogo/relojes?marca=67&genero=0&orden=&descuento=0" class="text-decoration-none"
                            style="color: #4caf50;">Relojes
                            Invicta (Ver más)</a>
                    </h2>
                    <products-slider :products="{{ $invicta }}" titulo="" />
                </div>
            </div>
        @endif
        @if ($ofertas->count() > 0)
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center" style="margin-bottom: 1.5rem; font-size: 1.5rem; font-weight: bold;">
                        <a href="/catalogo/relojes?marca=0&genero=0&orden=&descuento=1" class="text-decoration-none"
                            style="color: #4caf50;">Ofertas (Ver más)</a>
                    </h2>
                    <products-slider :products="{{ $ofertas }}" titulo="" />
                </div>
            </div>
        @endif
        @if ($nixon->count() > 0)
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center" style="margin-bottom: 1.5rem; font-size: 1.5rem; font-weight: bold;">
                        <a href="/catalogo/relojes?marca=63&genero=0&orden=&descuento=0" class="text-decoration-none"
                            style="color: #4caf50;">Relojes
                            Nixon (Ver más)</a>
                    </h2>
                    <products-slider :products="{{ $nixon }}" titulo="" />
                </div>
            </div>
        @endif
        @if ($fossil->count() > 0)
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center" style="margin-bottom: 1.5rem; font-size: 1.5rem; font-weight: bold;">
                        <a href="/catalogo/relojes?marca=66&genero=0&orden=&descuento=0" class="text-decoration-none"
                            style="color: #4caf50;">Relojes
                            Fossil (Ver más)</a>
                    </h2>
                    <products-slider :products="{{ $fossil }}" titulo="" />
                </div>
            </div>
        @endif

    </div>
@endsection
@section('script')
@endsection
