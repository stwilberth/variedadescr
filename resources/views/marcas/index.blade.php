@extends('layouts.app')
@section('content')
    <div class="container mt-5">

        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row mb-3">

            <form class="form-row" method="POST" action="/marcas">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <input type="text" class="form-control" id="inlineFormInputName2" placeholder="Nombre Marca"
                            name="nombre">
                    </div>
                    <div class="col-4">
                        <select id="inputState" class="form-control" name="catalogo" placeholder="Catálogo">
                            @foreach ($catalogo as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-success btn-md mt-0">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </form>


        </div>
        <div class="row">
            <h2>Relojes</h2>
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($relojes as $marca)
                            <tr>
                                <td>{{ $marca->nombre }}</td>
                                <td>{{ $marca->productos->count() }}</td>
                                <td>
                                    <a href="/marcas/{{ $marca->id }}/edit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button
                                        class="btn btn-sm @if ($marca->productos->count() > 0) btn-secondary @else btn-danger @endif"
                                        @if ($marca->productos->count() > 0) disabled @endif
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $marca->id }}').submit();">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $marca->id }}" action="/marcas/{{ $marca->id }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="display:none"></button>
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
                            <th scope="col">Nombre</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perfumes as $marca)
                            <tr>
                                <td>{{ $marca->nombre }}</td>
                                <td>{{ $marca->productos->count() }}</td>
                                <td>
                                    <a href="/marcas/{{ $marca->id }}/edit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button
                                        class="btn btn-sm @if ($marca->productos->count() > 0) btn-secondary @else btn-danger @endif"
                                        @if ($marca->productos->count() > 0) disabled @endif
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $marca->id }}').submit();">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $marca->id }}" action="/marcas/{{ $marca->id }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="display:none"></button>
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
