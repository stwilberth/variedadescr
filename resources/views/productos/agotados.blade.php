@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Productos Agotados</h2>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Modelo</th>
                                    <th>Marca</th>
                                    <th>Catálogo</th>
                                    <th>Stock</th>
                                    <th>Precio</th>
                                    <th>Publicado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $producto)
                                <tr>
                                    <td>{{ $producto->id }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->modelo }}</td>
                                    <td>{{ $producto->marca ? $producto->marca->nombre : 'Sin marca' }}</td>
                                    <td>{{ $producto->catalogoM ? $producto->catalogoM->nombre : 'Sin catálogo' }}</td>
                                    <td>{{ $producto->stock }}</td>
                                    <td>{{ $producto->precio_venta }}</td>
                                    <td>
                                        @if($producto->publicado)
                                            <span class="badge" style="color: #28a745; border: 1px solid #28a745; background: #fff;">Sí</span>
                                        @else
                                            <span class="badge" style="color: #dc3545; border: 1px solid #dc3545; background: #fff;">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- ver --}}
                                        <a href="{{ route('productoShow', ['categoria' => $producto->catalogoM ? $producto->catalogoM->slug : 'relojes', 'slug' => $producto->slug]) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                            Ver
                                        </a>
                                        {{-- editar --}}
                                        <a href="{{ route('productoEdit', $producto->slug) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 