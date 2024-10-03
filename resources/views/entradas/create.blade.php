@extends('layouts.app')

@section('content')
<div class="container">
 
  <h1>Agregar Nueva Entrada</h1>
  <br>

  <form action="{{ route('entradas.store') }}" method="POST">
    @csrf

    <div class="row">
      <!-- Primera columna -->
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
            <label for="category_id">Categoría</label>
          </strong>
          <select name="category_id" id="category_id" class="form-control" required>
            <option value="">Seleccione una categoría</option>
            @foreach ($categorias as $categoria)
              <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
            @endforeach
          </select>
        </div>
        <br>

        <div class="form-group">
          <strong>
            <label for="idproducto">Producto</label>
          </strong>
          <select name="idproducto" id="idproducto" class="form-control" required>
            <option value="">Seleccione un producto</option>
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

      <!-- Segunda columna -->
      <div class="col-md-6">
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
  <script>
    document.getElementById('category_id').addEventListener('change', function () {
        const categoryId = this.value;

        if (categoryId) {
            fetch(`/productos/categoria/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    let productSelect = document.getElementById('idproducto');
                    productSelect.innerHTML = '<option value="">Seleccione un producto</option>';
                    // Verificamos si el arreglo de productos está vacío
                    if (data.length === 0) {
                        // Agregamos una opción indicando que no hay productos
                        productSelect.innerHTML += '<option value="">No hay productos disponibles para esta categoría</option>';
                    } else {
                        // Si hay productos, los agregamos normalmente
                        data.forEach(product => {
                            productSelect.innerHTML += `<option value="${product.id}">${product.nombre}</option>`;
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
  </script>
</div>
@endsection
