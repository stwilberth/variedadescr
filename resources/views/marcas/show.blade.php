@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h1>Marca: {{ $marca->nombre }}</h1>
    <div class="row">
        <div class="col-md-6"><h2>Catálogo: {{ $marca->catalogoM->nombre }}</h2></div>
        </div>
        <div class="col-md-6">
        </div>
    </div>
</div>

@endsection