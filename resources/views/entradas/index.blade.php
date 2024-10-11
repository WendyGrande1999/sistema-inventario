@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Entradas</h1>
    <a href="{{ route('entradas.create') }}" class="btn btn-primary mb-3">Agregar Entrada</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card-body">
        <div class="table-responsive">
        <table id="my-table"  class="table table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>

                <th>Fecha Ingreso</th>
                <th>Producto</th>
                <th>Proveedor</th>
                <th>Usuario</th>
                <th>Unidad de Medida</th>
                <th>Cantidad</th>
                <th>Precio por Unidad</th>
                <th>Saldo Compra</th>
                <th>Ver</th>
                <th>Edit</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entradas as $entrada)
            <tr>

                <td>{{ $entrada->fecha_ingreso }}</td>
                <td>{{ $entrada->producto->nombre }}</td>
                <td>{{ $entrada->proveedor->name }}</td>
                <td>{{ $entrada->usuario->name }}</td>
                <td>{{ $entrada->unidad_medida }}</td>
                <td>{{ $entrada->cantidad }}</td>
                <td>$<span>{{ $entrada->precio_unidad }}</span>

                <td>$<span>{{ $entrada->saldo_compra }}</span></td>

                <td>
                    <a href="{{ route('entradas.show', $entrada->id) }}" class="btn btn-info btn-sm">Ver</a>

                </td>

                <td>
                <a href="{{ route('entradas.edit', $entrada->id) }}" class="btn btn-warning btn-sm">Editar</a>
                </td>

                <td>

                <form id="delete-entry-form" action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" style="display: inline;">
               @csrf
             @method('DELETE')
             <button onclick="eliminarEntrada(event)" type="button" class="btn btn-danger btn-sm">Eliminar</button>
               </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
        </div>
    </div>

<!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.0/js/dataTables.bootstrap5.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
function eliminarEntrada(event) {
    event.preventDefault(); // Evitar el envío automático del formulario

    Swal.fire({
        title: '¿Estás seguro que deseas eliminar este registro?',
        text: '¡No podrás revertir esta acción!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar el formulario de eliminación
            document.getElementById('delete-entry-form').submit();
        }
    });
}
</script>

    <!-- Script para inicializar DataTables -->
    <script>
    $(document).ready(function() {
        $('#my-table').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true,
            "pageLength": 4,
            "language": {
                "processing": "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                "infoEmpty": "Mostrando 0 registros",
                "infoFiltered": "(filtrado de _MAX_ registros)",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "search": "Buscar:"
            }
        });
    });
</script>

</div>
@endsection
