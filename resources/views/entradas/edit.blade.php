@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Entrada</h1>

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
                    <label for="cantidad">Cantidad</label>
                    </strong>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ $entrada->cantidad }}" step="0.01" required>
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
                    <input type="number" name="saldo_compra" id="saldo_compra" class="form-control" value="{{ $entrada->saldo_compra }}" step="0.01" required>
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
      document.addEventListener('DOMContentLoaded', function() {
          const cantidadInput = document.getElementById('cantidad');
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
