<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'estado' => true, // Asegúrate de tener este campo en tu tabla

        ]);

        // Asignar roles
        $user->syncRoles($request->roles);

        // Redireccionar con mensaje
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'roles' => 'required|array',
        ]);

        $usuario = User::findOrFail($id);

        // Actualiza los campos básicos
        $usuario->name = $request->name;
        $usuario->email = $request->email;

        // Solo actualiza la contraseña si se proporcionó
        if ($request->filled('password')) {
            $usuario->password = bcrypt($request->password);
        }

        $usuario->save();

        // Asignar roles (si estás usando Spatie)
        $usuario->syncRoles($request->roles);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        try {
            $usuario = User::findOrFail($id);

            // Elimina los roles asignados (opcional pero recomendable si usas Spatie)
            $usuario->syncRoles([]);

            // Elimina el usuario
            $usuario->delete();

            return redirect()->route('admin.usuarios.index')
                ->with('success', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.usuarios.index')
                ->with('error', 'Ocurrió un error al eliminar el usuario.');
        }
    }


}
