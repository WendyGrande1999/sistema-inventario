@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Productos</h1>

    <a href="{{ route('productos.create') }}" class="btn btn-primary justify-content-end mt-3">Agregar Categoría</a>
    <br>
    <br>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table id="my-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Unidad medida</th>
                    <th>Categoría</th>
                    <th>Imagen</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productos as $producto)
                    <tr>
                        <td>{{ $producto->codigo }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->unidad_medida }}</td>
                        <td>{{ $producto->category->name }}</td>

                        <td>
                            @if ($producto->imagen)
                                <img src="{{ asset($producto->imagen) }}" alt="Imagen de {{ $producto->nombre }}"
                                    style="width: 100px; height: auto;"> <!-- Muestra la imagen -->
                            @else
                                Sin imagen
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('productos.edit', $producto) }}"
                                class="btn btn-sm btn-warning">Editar</a>

                        </td>
                        <td>
                            <form id="delete-entry-form-{{ $producto->id }}"
                                action="{{ route('categories.destroy', $producto->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="eliminarEntrada(event, {{ $producto->id }})" type="button"
                                    class="btn btn-danger btn-sm">Eliminar</button>
                            </form>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No se encontraron productos.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>




    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.0/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function eliminarEntrada(event, categoryId) {
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
                "pageLength": 10,
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

    <script>
        // Script para confirmar eliminación
        function confirmDelete() {
            return confirm('¿Estás seguro de que deseas eliminar este producto?');
        }
    </script>
</div>
@endsection
