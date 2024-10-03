@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Producto</h1>

    <form action="{{ route('productos.update', $producto->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre" class="form-label">Código</label>
            <input type="number" name="codigo" class="form-control" id="codigo" value="{{ old('codigo', $producto->codigo) }}">
            @error('codigo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <br>
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

        <div class="form-group">
                    <strong>
                    <label for="unidad_medida">Unidad de Medida</label>
                    </strong>
                    <select name="unidad_medida" id="unidad_medida" class="form-control" required>
                        <option value="Libra" {{ $producto->unidad_medida == 'Libra' ? 'selected' : '' }}>Libra</option>
                        <option value="Onza" {{ $producto->unidad_medida == 'Onza' ? 'selected' : '' }}>Onza</option>
                        <option value="Unidad" {{ $producto->unidad_medida == 'Unidad' ? 'selected' : '' }}>Unidad</option>
                        <option value="Cajas" {{ $producto->unidad_medida == 'Cajas' ? 'selected' : '' }}>Cajas</option>
                    </select>
                </div>
                <br>


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
