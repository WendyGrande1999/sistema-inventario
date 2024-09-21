<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Muestra la lista de usuarios
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }


    public function create()
    {
        // Obtener roles disponibles si deseas asignar uno al nuevo usuario
        $roles = Role::all();
        
        // Retornar la vista con los roles
        return view('admin.users.create', compact('roles'));
    }


    // Muestra la vista para editar roles de un usuario
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // Asigna roles al usuario
    public function assignRoles(Request $request, User $user)
    {
        $user->syncRoles($request->roles);
        return redirect()->route('admin.users.index')->with('success', 'Roles asignados correctamente.');
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminada exitosamente.');
    }


    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear el nuevo usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);


        // Redireccionar con un mensaje de éxito
        return redirect()->route('admin.users.index')->with('success', 'usuario creado con éxito.');
    }
}

