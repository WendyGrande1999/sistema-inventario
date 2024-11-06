@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Entrada</h1>

    <!-- Contenedor para mensajes de error con JavaScript -->
    <div id="error-message" class="alert alert-danger d-none"></div>

    <form action="{{ route('entradas.update', $entrada->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <strong>
                    <label for="fecha_ingreso">Fecha:</label>
                    </strong>
                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" value="{{ $entrada->fecha_ingreso }}" required>
                </div>
                <br>

                <div class="form-group">
                    <strong>
                    <label for="idproducto">Producto</label>
                    </strong>
                    <select name="idproducto" id="idproducto" class="form-control" required>
                        <option value="">Seleccione un producto</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}" {{ $producto->id == $entrada->idproducto ? 'selected' : '' }}>
                                {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <br>

                <div class="form-group">
                    <strong>
                    <label for="idproveedor">Proveedor</label>
                    </strong>
                    <select name="idproveedor" id="idproveedor" class="form-control" required>
                        <option value="">Seleccione un proveedor</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" {{ $proveedor->id == $entrada->idproveedor ? 'selected' : '' }}>
                                {{ $proveedor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <br>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <strong>
                    <label for="cantidad_entrante">Cantidad</label>
                    </strong>
                    <input type="number" name="cantidad_entrante" id="cantidad_entrante" class="form-control" value="{{ $entrada->cantidad_entrante }}" step="0.01" required>
                </div>
                <br>

                <div class="form-group">
                    <strong>
                    <label for="precio_unidad">Precio por Unidad</label>
                    </strong>
                    <input type="number" name="precio_unidad" id="precio_unidad" class="form-control" value="{{ $entrada->precio_unidad }}" step="0.01" required>
                </div>
                <br>

                <div class="form-group">
                    <strong>
                    <label for="saldo_compra">Saldo Compra</label>
                    </strong>
                    <input type="number" name="saldo_compra" id="saldo_compra" class="form-control" value="{{ $entrada->saldo_compra }}" step="0.01" required readonly>
                </div>
            </div>
        </div>

        <br>

        <div class="d-flex justify-content-start gap-2">
            <a href="{{ route('entradas.index') }}" class="btn btn-secondary">Volver a la Lista</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>

    <script>
        // Comprobar si existen errores en la sesión
        @if ($errors->any())
            let errorMessage = @json($errors->first()); // Obtener el primer mensaje de error
            let errorContainer = document.getElementById('error-message');
            
            // Mostrar el mensaje de error
            errorContainer.textContent = errorMessage;
            errorContainer.classList.remove('d-none'); // Hacer visible la alerta
        @endif
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cantidadInput = document.getElementById('cantidad_entrante');
            const precioUnidadInput = document.getElementById('precio_unidad');
            const saldoCompraInput = document.getElementById('saldo_compra');

            function calcularSaldoCompra() {
                const cantidad = parseFloat(cantidadInput.value) || 0;
                const precioUnidad = parseFloat(precioUnidadInput.value) || 0;
                saldoCompraInput.value = (cantidad * precioUnidad).toFixed(2);
            }

            cantidadInput.addEventListener('input', calcularSaldoCompra);
            precioUnidadInput.addEventListener('input', calcularSaldoCompra);
        });
    </script>
</div>
@endsection
