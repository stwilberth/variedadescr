@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($admin)
                        <p class="mb-3">Has iniciado sesión como administrador</p>
                        
                        <ul class="list-group">
                            <li class="list-group-item"><a class="text-primary text-decoration-none" href="/producto-create">Agregar producto</a></li>
                            <li class="list-group-item"><a class="text-primary text-decoration-none" href="/marcas">Marcas</a></li>
                            <li class="list-group-item"><a class="text-primary text-decoration-none" href="/users">Usuarios</a></li>
                            <li class="list-group-item"><a class="text-primary text-decoration-none" href="/inventario">Inventario</a></li>
                            <li class="list-group-item">
                                <span class="text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="cursor: pointer;">Cerrar sesión</span>
                            </li>
                        </ul>
                    @else
                        <span>Has iniciado sesión</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
