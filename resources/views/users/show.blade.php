@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Detalles del Usuario</div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" class="form-control" value="{{ $user->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input type="text" id="email" class="form-control" value="{{ $user->email }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="roles">Roles:</label>
                        <select multiple class="form-control" id="roles" name="roles[]" disabled>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ in_array($role->id, $userRoles) ? 'selected' : '' }}>
                                    {{ $role->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Volver</a>
                    <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-primary">Editar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
