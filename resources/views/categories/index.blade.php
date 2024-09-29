@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Categorías</h1>

    <a href="{{ route('categories.create') }}" class="btn btn-primary justify-content-end mt-3">Agregar Categoría</a>
<br>
<br>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

<div class="card-body">
    <div class="table-responsive">
    <table id="my-table"  class="table table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Editar</a>

                        </td>
                    <td>
                     
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirmDelete()" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
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
</div>

   


     <!-- Scripts -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.0/js/dataTables.bootstrap5.min.js"></script>

    
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
            return confirm('¿Estás seguro de que deseas eliminar esta categoría?');
        }
    </script>
</div>
@endsection
