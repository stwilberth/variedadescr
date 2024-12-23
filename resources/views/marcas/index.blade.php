@extends('layouts.app')
@section('content')
<div class="container mt-5">

        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{session('status')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                {{session('error')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

    <h1>Marcas</h1>
    <div class="row mb-3">

        <div class="col-md-12">
            <div class="card mt-4 mb-4">
                <div class="card-body">
                    <h5 class="card-title">Agregar Marca:</h5>
                    <form class="form-row" method="POST" action="/marcas">
                        @csrf
                        <div class="col-6">
                            <input type="text" class="form-control" id="inlineFormInputName2" placeholder="Nombre Marca" name="nombre">
                        </div>
                        <div class="col-4">
                            <select id="inputState" class="custom-select" name="catalogo" placeholder="Catálogo">
                                @foreach ($catalogo as $item)
                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary btn-md mt-0">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h2>Relojes</h2>
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Cantidad Productos</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($relojes as $marca)
                        <tr>
                            <th scope="row">{{$marca->id}}</th>
                            <td>{{$marca->nombre}}</td>
                            <td>{{ $marca->productos->count() }}</td>
                            <td><a href="/marcas/{{$marca->id}}/edit" class="btn btn-link">Editar</a></td>
                            <td>
                                <form action="/marcas/{{$marca->id}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link" style="color:tomato" @if($marca->productos->count() > 0 ) disabled @endif>X</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2>Perfumes</h2>
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Cantidad Productos</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($perfumes as $marca)
                        <tr>
                            <th scope="row">{{$marca->id}}</th>
                            <td>{{$marca->nombre}}</td>
                            <td>{{ $marca->productos->count() }}</td>
                            <td><a href="/marcas/{{$marca->id}}/edit" class="btn btn-link">Editar</a></td>
                            <td>
                                <form action="/marcas/{{$marca->id}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link" style="color:tomato" @if($marca->productos->count() > 0 ) disabled @endif>X</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection