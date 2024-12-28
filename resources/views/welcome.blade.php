@extends('layouts.app')
@section('meta_tags')
    <meta name="description"
        content="Relojes, perfumes, accesorios y más. Encuentra los mejores productos en nuestra tienda online. Descubre nuestra amplia gama de productos y encuentra el que mejor se adapte a tus necesidades.">
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

        @if ($ofertas->count() > 0)
            <div class="row">
                <div class="col-12">
                    <products-slider :products="{{ $ofertas }}" titulo="Relojes con descuentos" />
                </div>
            </div>
        @endif
        @if ($nixon->count() > 0)
            <div class="row">
                <div class="col-12">
                    <products-slider :products="{{ $nixon }}" titulo="Relojes Nixon" />
                </div>
            </div>
        @endif
        @if ($fossil->count() > 0)
            <div class="row">
                <div class="col-12">
                    <products-slider :products="{{ $fossil }}" titulo="Relojes Fossil" />
                </div>
            </div>
        @endif
        @if ($invicta->count() > 0)
            <div class="row">
                <div class="col-12">
                    <products-slider :products="{{ $invicta }}" titulo="Relojes Invicta" />
                </div>
            </div>
        @endif

    </div>
@endsection
@section('script')
@endsection
