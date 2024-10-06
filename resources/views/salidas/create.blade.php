@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Nueva Salida</h1>
    <form action="{{ route('salidas.store') }}" method="POST">
        @csrf

        <br>
        <div class="row">
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

            <div class="col-md-6">
                <div class="card bg-warning text-dark mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Existencia Actual</strong></h5>
                        <input type="text" name="existencia" id="existencia" class="form-control" readonly>
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
        const cantidadInput = document.getElementById('cantidad');

        if (productoId) {
            // Habilitar el campo cantidad al seleccionar un producto
            cantidadInput.disabled = false;

            // Obtener la unidad de medida del producto
            fetch(`/api/productos/${productoId}`)
                .then(response => response.json())
                .then(data => {
                    unidadMedidaInput.value = data ? data.unidad_medida : '';
                })
                .catch(error => console.error('Error:', error));

            // Obtener la existencia actual del producto
            fetch(`/productos/${productoId}/existencia`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al obtener la existencia del producto');
                    }
                    return response.json();
                })
                .then(data => {
                    existenciaInput.value = data ? data.existencia : '';
                })
                .catch(error => console.error('Error:', error));
        } else {
            // Limpiar campos y deshabilitar el campo cantidad si no hay producto seleccionado
            unidadMedidaInput.value = '';
            existenciaInput.value = '';
            cantidadInput.disabled = true;
            cantidadInput.value = '';
        }
    });

    // Validar el campo cantidad al ingresar un valor
    document.getElementById('cantidad').addEventListener('input', function () {
        const cantidadSalida = parseInt(this.value);
        const existenciaActual = parseInt(document.getElementById('existencia').value);

        // Validar si la cantidad es igual a 0
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

        // Validar si la cantidad es mayor que la existencia actual
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
