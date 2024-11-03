@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Nueva Salida</h1>
    <form action="{{ route('salidas.store') }}" method="POST">
        @csrf
        <br>
        <div class="row">
            <!-- Primera Columna -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fecha_salida"><strong>Fecha de Salida</strong></label>
                    <input type="date" name="fecha_salida" id="fecha_salida" class="form-control" required>
                </div>
                <br>

                <div class="form-group">
                    <label for="idproducto"><strong>Producto</strong></label>
                    <select name="idproducto" id="idproducto" class="form-control" required>
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <br>

                <div class="form-group">
                    <label for="identrada"><strong>Entrada</strong></label>
                    <select name="identrada" id="identrada" class="form-control" required>
                        <option value="">Seleccione una entrada</option>
                    </select>
                </div>
                <br>

                <div class="form-group">
                    <label for="unidad_medida"><strong>Unidad de Medida</strong></label>
                    <input type="text" name="unidad_medida" id="unidad_medida" class="form-control" readonly required>
                </div>
                <br>

                <div class="form-group">
                    <label for="cantidad"><strong>Cantidad</strong></label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" disabled required>
                </div>
                <br>

                <div class="form-group">
                    <label for="idusuario"><strong>Usuario</strong></label>
                    <input type="text" name="idusuario" id="idusuario" class="form-control" value="{{ $user->name }}" disabled>
                    <input type="hidden" name="idusuario" value="{{ $user->id }}">
                </div>
            </div>

            <!-- Segunda Columna -->
            <div class="col-md-6">
                <!-- Tarjeta para mostrar el stock total del producto seleccionado -->
               <div class="form-group">
                   <div id="stock-total-card" class="card bg-warning text-dark mb-3">
                     <div class="card-body">
                      <h5 class="card-title"><strong>Stock Total del Producto</strong></h5>
                <!-- Elemento donde se muestra el stock total -->
                      <p id="stock-total" class="card-text">N/A</p>
                   </div>
                </div>
             </div>
                <br>
                <!-- Tarjeta para mostrar la cantidad disponible en amarillo estático -->
                <div class="form-group">
                    <div class="card bg-warning text-dark mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><strong>Cantidad disponible</strong></h5>
                            <input type="text" name="existencia" id="existencia" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Registrar Salida</button>
    </form>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.0/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('idproducto').addEventListener('change', function () {
        const productoId = this.value;

        // Elementos a actualizar
        const unidadMedidaInput = document.getElementById('unidad_medida');
        const existenciaInput = document.getElementById('existencia');
        const entradaSelect = document.getElementById('identrada');
        const cantidadInput = document.getElementById('cantidad');

        const stockTotalText = document.getElementById('stock-total');
        const stockTotalCard = document.getElementById('stock-total-card');
       

        if (productoId) {
            // Obtener la unidad de medida del producto
            fetch(`/api/productos/${productoId}`)
                .then(response => response.json())
                .then(data => {
                    unidadMedidaInput.value = data ? data.unidad_medida : '';
                })
                .catch(error => console.error('Error:', error));

            // Obtener el stock total del producto y actualizar la tarjeta de stock
            fetch(`/prod/producto/${productoId}/existencia`)
            
             .then(response => response.json())
            .then(data => {
                const stockTotal = data.stock_total; // Valor del stock total desde el backend
                stockTotalText.textContent = stockTotal; // Mostrar el stock total en el card

                // Cambiar el color de la tarjeta según el stock total
                stockTotalCard.classList.remove('bg-warning', 'bg-danger');
                if (stockTotal <= 15) {
                    stockTotalCard.classList.add('bg-danger', 'text-white');
                } else {
                    stockTotalCard.classList.add('bg-warning', 'text-dark');
                }
            })
            .catch(error => console.error('Error:', error));

            // Obtener las entradas asociadas al producto
            fetch(`/salida/entrada/${productoId}`)
                .then(response => response.json())
                .then(data => {
                    entradaSelect.innerHTML = '<option value="">Seleccione una entrada</option>';
                    if (data.length === 0) {
                        entradaSelect.innerHTML += '<option value="">No hay entradas disponibles para este producto</option>';
                    } else {
                        data.forEach(entrada => {
                            entradaSelect.innerHTML += `<option value="${entrada.id}" data-cantidad="${entrada.cantidad}">Fecha: ${entrada.fecha_ingreso} - Cantidad: ${entrada.cantidad}</option>`;
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            // Limpiar campos si no hay producto seleccionado
            unidadMedidaInput.value = '';
            existenciaInput.value = '';
            entradaSelect.innerHTML = '<option value="">Seleccione una entrada</option>';
            cantidadInput.disabled = true;
            cantidadInput.value = '';
            stockTotalText.textContent = 'N/A';
            stockTotalCard.classList.remove('bg-danger', 'text-white', 'bg-warning', 'text-dark');
            stockTotalCard.classList.add('bg-warning', 'text-dark');
        }
    });

    // Escuchar cambios en el select de entradas para habilitar el campo cantidad y actualizar el input de existencia
    document.getElementById('identrada').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const cantidad = selectedOption.getAttribute('data-cantidad');
        const existenciaInput = document.getElementById('existencia');
        const cantidadInput = document.getElementById('cantidad');

        if (cantidad) {
            existenciaInput.value = cantidad;
            cantidadInput.disabled = false; // Habilitar el campo cantidad solo cuando se selecciona una entrada
        } else {
            existenciaInput.value = '';
            cantidadInput.disabled = true;
            cantidadInput.value = '';
        }
    });

    // Validar el campo cantidad al ingresar un valor
    document.getElementById('cantidad').addEventListener('input', function () {
        const cantidadSalida = parseInt(this.value);
        const existenciaActual = parseInt(document.getElementById('existencia').value);

        if (cantidadSalida === 0) {
            Swal.fire({
                title: 'Cantidad inválida',
                text: 'La cantidad no puede ser 0. Por favor ingrese un valor mayor a 0.',
                icon: 'warning',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#3085d6',
            }).then(() => {
                this.value = ''; // Vaciar el campo después de mostrar el mensaje
            });
        }

        if (cantidadSalida > existenciaActual) {
            Swal.fire({
                title: 'Error',
                text: 'La cantidad de salida no puede ser mayor a la existencia actual.',
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#d33',
            }).then(() => {
                this.value = ''; // Vaciar el campo después de mostrar el mensaje
            });
        }
    });
</script>

@endsection
