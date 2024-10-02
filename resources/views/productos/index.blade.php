@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Crear Producto</a>

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
    <div class="table responsive">
    <table id="my-table"  class="table table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
            <tr>
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->descripcion }}</td>
                <td>{{ $producto->category->name }}</td>
                <td>
                    @if($producto->imagen)
                        <img src="{{ asset($producto->imagen) }}" alt="Imagen de {{ $producto->nombre }}" style="width: 100px; height: auto;"> <!-- Muestra la imagen -->
                    @else
                        Sin imagen
                    @endif
                </td>
                <td>
                    <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form id="delete-entry-form-{{ $producto->id }}" action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display: inline;">
                 @csrf
               @method('DELETE')
               <button onclick="eliminarEntrada(event, {{ $producto->id }})" type="button" class="btn btn-danger btn-sm">Eliminar</button>
               </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <!-- Scripts -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.0/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


   <script>
function eliminarEntrada(event, productoId) {
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
            document.getElementById(`delete-entry-form-${productoId}`).submit();
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
    </div>
   
    


   

        


</div>
@endsection
