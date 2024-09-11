@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestión de Usuarios</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">Editar Roles</a>
                </td>

                <td>
                <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirmDelete()" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>

                        <!-- Script para confirmar eliminación -->
<script>
    function confirmDelete() {
        return confirm('¿Estás seguro de que deseas eliminar esta categoría?');
    }
</script>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
