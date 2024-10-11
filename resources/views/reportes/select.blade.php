@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Seleccionar Producto</h1>

    <!-- Formulario para seleccionar el producto -->
    <form action="{{ route('reportes.detalle') }}" method="GET">
        <div class="form-group">
            <label for="idproducto"><strong>Seleccione un Producto:</strong></label>
            <select name="idproducto" id="idproducto" class="form-control">
                <option value="">Seleccione un producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">
                        {{ $producto->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Ver Detalle</button>
    </form>
</div>
@endsection
