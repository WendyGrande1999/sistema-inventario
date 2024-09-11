<!-- resources/views/categories/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Categorías</h1>

    <!-- Formulario de búsqueda -->
    <form action="{{ route('categories.search') }}" method="GET" class="d-flex mb-3">
        <input type="text" name="query" id="search" class="form-control me-2" placeholder="Buscar por nombre o ID">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>


  

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirmDelete()" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No se encontraron categorías.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Script para confirmar eliminación -->
<script>
    function confirmDelete() {
        return confirm('¿Estás seguro de que deseas eliminar esta categoría?');
    }
</script>
@endsection
