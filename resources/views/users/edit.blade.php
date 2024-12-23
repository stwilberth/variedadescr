@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Usuario</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', ['user' => $user->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Nueva Contraseña:</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Deja en blanco para mantener la contraseña actual">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contraseña:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Deja en blanco para mantener la contraseña actual">
                        </div>

                        <div class="form-group">
                            <label for="roles">Roles:</label>
                            <select multiple class="form-control" id="roles" name="roles[]">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ in_array($role->id, $userRoles) ? 'selected' : '' }}>
                                        {{ $role->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Volver</a>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
