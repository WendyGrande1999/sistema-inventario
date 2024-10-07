@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Categorías</h1>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary justify-content-end mt-3">Agregar Usuario</a>
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
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="btn btn-sm btn-warning">Editar Roles</a>

                        </td>
                        <td>

                            <form id="delete-entry-form-{{ $user->id }}"
                                action="{{ route('user.destroy', $user->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="eliminarEntrada(event, {{ $user->id }})" type="button"
                                    class="btn btn-danger btn-sm">Eliminar</button>
                            </form>


                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No se encontraron categorías.</td>
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
        function eliminarEntrada(event, usersId) {
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
                    document.getElementById(`delete-entry-form-${usersId}`).submit();
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
            return confirm('¿Estás seguro de que deseas eliminar este usuario?');
        }
    </script>
</div>
@endsection
