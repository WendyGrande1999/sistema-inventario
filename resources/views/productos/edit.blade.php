@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Producto</h1>

    <form action="{{ route('productos.update', $producto->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" id="nombre" value="{{ old('nombre', $producto->nombre) }}">
            @error('nombre')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" id="descripcion">{{ old('descripcion', $producto->descripcion) }}</textarea>
            @error('descripcion')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="category_id" class="form-label">Categoría</label>
            <select name="category_id" class="form-control" id="category_id">
                @foreach ($categories as $supplier)
                    <option value="{{ $supplier->id }}" {{ $producto->supplier_id == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
