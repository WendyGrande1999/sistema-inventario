@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Agregar Nueva Entrada</h1>
  <br>

  <form action="{{ route('entradas.store') }}" method="POST">
    @csrf

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
            <strong>
            <label for="fecha_ingreso">Fecha:</label>
            </strong>
            <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" required>
        </div>
        <br>

        <div class="form-group">
          <strong>
          <label for="idproducto">Producto</label>
          </strong>
          <select name="idproducto" id="idproducto" class="form-control" required>
              <option value="">Seleccione un producto</option>
              @foreach ($productos as $producto)
                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
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
                <option value="{{ $proveedor->id }}">{{ $proveedor->name }}</option>
              @endforeach
            </select>
        </div>
        <br>

        <div class="form-group">
            <strong>
            <label for="idusuario">Usuario</label>
            </strong>
            <div class="form-group">
            <input type="text" name="usuario_mostrar" id="usuario_mostrar" class="form-control" value="{{ $user->name }}" disabled>
            <input type="hidden" name="idusuario" value="{{ $user->id }}">
            </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
            <strong>
            <label for="unidad_medida">Unidad de Medida</label>
            </strong>
            <select name="unidad_medida" id="unidad_medida" class="form-control" required>
              <option value="">Seleccione unidad de medida</option>
              <option value="Libra">Libra</option>
              <option value="Onza">Onza</option>
              <option value="Unidad">Unidad</option>
              <option value="Cajas">Cajas</option>
            </select>
        </div>
        <br>

        <div class="form-group">
            <strong>
            <label for="cantidad">Cantidad</label>
            </strong>
            <input type="number" name="cantidad" id="cantidad" class="form-control" step="0.01" required>
        </div>
        <br>

        <div class="form-group">
            <strong>
            <label for="precio_unidad">Precio por Unidad</label>
            </strong>
            <input type="number" name="precio_unidad" id="precio_unidad" class="form-control" step="0.01" required>
        </div>
        <br>

        <div class="form-group">
            <strong>
            <label for="saldo_compra">Saldo Compra</label>
            </strong>
            <input type="number" name="saldo_compra" id="saldo_compra" class="form-control" step="0.01" readonly>
        </div>
      </div>
    </div>

    <br>
    <button type="submit" class="btn btn-primary">Guardar Entrada</button>
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
