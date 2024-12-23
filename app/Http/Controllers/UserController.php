<?php

namespace anuncielo\Http\Controllers;

use Illuminate\Http\Request;
use anuncielo\User;
use anuncielo\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(50);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validación de los datos proporcionados por el usuario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Creación de un nuevo usuario
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']); // Se recomienda cifrar la contraseña

        // Guardar el usuario en la base de datos
        $user->save();

        // Redireccionar a la vista de detalles del usuario recién creado
        return redirect()->route('users.show', ['user' => $user->id])
            ->with('success', 'Usuario creado exitosamente');
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();

        return view('users.show', compact('user', 'roles', 'userRoles'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();

        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }


    public function update(Request $request, $id)
    {
        // Validación de los datos proporcionados por el usuario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Obtener el usuario existente por su ID
        $user = User::findOrFail($id);

        // Actualizar los datos del usuario
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Actualizar la contraseña si se proporcionó una nueva contraseña
        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        // Actualizar los roles asignados al usuario
        $user->roles()->sync($request->input('roles'));

        // Guardar los cambios en la base de datos
        $user->save();

        // Redireccionar a la vista de detalles del usuario actualizado
        return redirect()->route('users.show', ['user' => $user->id])
            ->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        // Buscar el usuario por su ID
        $user = User::findOrFail($id);

        // Eliminar los roles asociados al usuario
        $user->roles()->detach();

        // Eliminar el usuario
        $user->delete();

        // Redireccionar a la lista de usuarios con un mensaje de éxito
        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }

}
