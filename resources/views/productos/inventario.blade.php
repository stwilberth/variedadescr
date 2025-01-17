@extends('layouts.app')
@section('content')

    @php
        $title = 'Inventario';
        $sumStock = 0;
        $sumCosto = 0;
        $sumMayorista = 0;
        $sumVenta = 0;
    @endphp

    <div class="ml-3 mr-5">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center my-5 text-success">{{ $title }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>

                            <th>Stock</th>
                            <th>Costo</th>
                            <th>Mayorista</th>
                            <th>Venta</th>

                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)

                            @php
                                $totalCosto = $producto->costo * $producto->stock;
                                $totalVenta = $producto->precio_venta * $producto->stock;
                                $totalMayorista = $producto->precio_mayorista * $producto->stock;
                                $sumStock += $producto->stock;
                                $sumCosto += $totalCosto;
                                $sumMayorista += $totalMayorista;
                                $sumVenta += $totalVenta;
                            @endphp
                            <tr>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->stock }}</td>
                                <td>¢{{ number_format($producto->costo) }}</td>
                                <td>¢{{ number_format($producto->precio_mayorista) }}</td>
                                <td>¢{{ number_format($producto->precio_venta) }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="/producto-edit/{{ $producto->slug }}" class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="/catalogo/{{ $producto->catalogoM->slug }}/{{ $producto->slug }}"
                                            class="btn btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
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
                            <td>{{ $sumStock }}</td>
                            <td>¢{{ number_format($sumCosto) }}</td>
                            <td>¢{{ number_format($sumMayorista) }}</td>
                            <td>¢{{ number_format($sumVenta) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
