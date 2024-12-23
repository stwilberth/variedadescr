@extends('layouts.app')
@section('content')
<div class="container mt-5">
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            {{session('error')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <h1>Marca: {{ $marca->nombre }}</h1>
    <div class="row">
        <div class="col-md-6">
            <h2>Catálogo: {{ $marca->catalogoM->nombre }}</h2>
        </div>
    </div>
    <div class="col-md-6">
        {{-- <form class="form-row" method="POST" action="/marcas/{{ $marca->id }}"> --}}
        <form class="form-row" method="POST" action="{{ route('marcas.update', ['marca' => $marca->id]) }}">
            @csrf
             @method('PUT')
            <div class="col-6">
                <input type="text" class="form-control" id="inlineFormInputName2" placeholder="Nombre Marca" name="nombre" value="{{$marca->nombre}}">
            </div>
            <div class="col-4">
                <select id="inputState" class="custom-select" name="catalogo" placeholder="Catálogo" disabled>
                    @foreach ($catalogo as $item)
                    <option value="{{$item->id}}" 
                        @if($item->id == $marca->catalogo) selected @endif>
                        {{ $item->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary btn-md mt-0">Actualizar</button>
            </div>
        </form>
    </div>
</div>
</div>

@endsection