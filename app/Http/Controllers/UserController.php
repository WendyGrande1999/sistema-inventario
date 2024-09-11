<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Muestra la lista de usuarios
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
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
}

