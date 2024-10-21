@extends('layouts.app')

@section('content')
    <div class="container">

        <form action="{{ route('productos.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Código</label>
                <input type="number" name="codigo" class="form-control" id="codigo">
                @error('codigo')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" id="nombre" value="{{ old('nombre') }}">
                @error('nombre')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" id="descripcion">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <strong>
                        <label for="unidad_medida">Unidad de Medida</label>
                    </strong>
                    <select name="unidad_medida" id="unidad_medida" class="form-control" required>
                        <option value="">Seleccione unidad de medida</option>
                        <option value="Libra">Libras</option>
                        <option value="Onza">Onzas</option>
                        <option value="Unidad">Unidades</option>
                        <option value="Cajas">Cajas</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Categoría</label>
                    <select name="category_id" class="form-control" id="category_id">
                        @foreach ($categories as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="imagen">Imagen</label>
                    <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
                </div>

                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
