@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Lista de Suscriptores</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Email</th>
                <th>
                    Verificado
                    <form action="{{ route('subscriptions.deleteUnverified') }}" method="POST" class="d-inline ms-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                onclick="return confirm('¿Estás seguro de eliminar todos los suscriptores no verificados?')">
                            <i class="fas fa-trash-alt"></i> Eliminar no verificados
                        </button>
                    </form>
                </th>
                <th>Fecha de suscripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subscribers as $subscriber)
            <tr>
                <td>{{ $subscriber->email }}</td>
                <td>
                    <span class="badge {{ $subscriber->is_confirmed ? 'bg-success' : 'bg-danger' }}">
                        {{ $subscriber->is_confirmed ? 'Sí' : 'No' }}
                    </span>
                </td>
                <td>{{ $subscriber->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <form action="{{ route('subscriptionsDestroy', $subscriber->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection