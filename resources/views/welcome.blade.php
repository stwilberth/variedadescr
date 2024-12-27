@extends('layouts.app')
@section('content')
    <div class="container">



        {{-- card link to products --}}
        <div class="row mb-5">
            <div class="col-md-6 mt-3">
                <a href="catalogo/relojes" class="text-decoration-none">
                    <div class="card h-100" style="background-image: url('{{ asset('img/relojes.jpg') }}'); background-size: cover; background-position: center;">
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
                    <div class="card h-100" style="background-image: url('{{ asset('img/perfumes.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="card-body bg-dark py-3 py-sm-5" style="opacity: 0.8">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <h5 class="text-white fs-1">Perfumes</h5>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    <x-slider-productos :products="$ofertas" titulo="Relojes con descuentos" />
    <x-slider-productos :products="$nixon" titulo="Relojes Nixon" />
    <x-slider-productos :products="$fossil" titulo="Relojes Fossil" />
    <x-slider-productos :products="$invicta" titulo="Relojes Invicta" />
    <x-slider-productos :products="$perfumes" titulo="Perfumes" />
    </div>
@endsection

