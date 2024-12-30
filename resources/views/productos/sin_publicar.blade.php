@extends('layouts.app')
@section('content')
    @php
        $title = 'Productos sin Publicar';
    @endphp

    <div class="ml-3 mr-5">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center my-5 text-danger">{{ $title }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Modelo</th>
                            <th>Catálogo</th>

                            <th>Stock</th>
                            <th>Costo</th>
                            <th>Mayorista</th>
                            <th>Venta</th>

                            <th>Total Costo</th>
                            <th>Total Venta</th>
                            <th>Total Mayorista</th>

                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->modelo }}</td>
                                <td>
                                    @if ($producto->catalogo == 1)
                                        <span class="text-primary">{{ $producto->catalogoM->nombre }}</span>
                                    @elseif ($producto->catalogo == 2)
                                        <span class="text-success">{{ $producto->catalogoM->nombre }}</span>
                                    @else
                                        <span class="text-info">Otros</span>
                                    @endif
                                </td>
                                <td>{{ $producto->stock }}</td>
                                <td>¢{{ number_format($producto->costo) }}</td>
                                <td>¢{{ number_format($producto->precio_mayorista) }}</td>
                                <td>¢{{ number_format($producto->precio_venta) }}</td>
                                <td>¢{{ number_format($producto->costo * $producto->stock) }}</td>
                                <td>¢{{ number_format($producto->precio_venta * $producto->stock) }}</td>
                                <td>¢{{ number_format($producto->precio_mayorista * $producto->stock) }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <form action="{{ route('productoPublicar', $producto->slug) }}" method="post"
                                            onsubmit="return confirmPublicar('{{ $producto->nombre }}')">
                                            @csrf
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <a href="/catalogo/{{ $producto->catalogoM->slug }}/{{ $producto->slug }}"
                                                    class="btn btn-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <h4 class="text-center my-3">------- Totales -------</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Stock</th>
                            <th>Costo</th>
                            <th>Mayorista</th>
                            <th>Venta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $productos->sum('stock') }}</td>
                            <td>¢{{ number_format($productos->sum('costo') * $productos->sum('stock')) }}</td>
                            <td>¢{{ number_format($productos->sum('precio_mayorista') * $productos->sum('stock')) }}</td>
                            <td>¢{{ number_format($productos->sum('precio_venta') * $productos->sum('stock')) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<script>
    function confirmPublicar(name) {
        return confirm('¿Estás seguro de que deseas publicar ' + name + '?');
    }
</script>
