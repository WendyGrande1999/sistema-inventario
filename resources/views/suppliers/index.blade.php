<!-- resources/views/suppliers/index.blade.php -->
@extends('layouts.app')

@section('title', 'Proveedores')

@section('content')
    @role('admin')
        <div class="container my-4">
            <h2>Lista de Proveedores</h2>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary mb-3">Agregar Proveedor</a>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card-body">
                <div class="table-responsive">
                    <table id="my-table" class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{ $supplier->id }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->address }}</td>
                                    <td>
                                        <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                            class="btn btn-sm btn-warning"><i class="bi bi-pencil-fill"></i></a>

                                    </td>
                                    <td>


                                        <form id="delete-entry-form-{{ $supplier->id }}"
                                            action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="eliminarEntrada(event, {{ $supplier->id }})" type="button"
                                                class="btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></button>
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
                function eliminarEntrada(event, suplierId) {
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
                            document.getElementById(`delete-entry-form-${suplierId}`).submit();
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
        </div>
    @endrole

    @role('editor')
        <div class="container my-4">
            <h2>Lista de Proveedores</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card-body">
                <div class="table-responsive">
                    <table id="my-table" class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{ $supplier->id }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->address }}</td>
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
                function eliminarEntrada(event, suplierId) {
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
                            document.getElementById(`delete-entry-form-${suplierId}`).submit();
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
        </div>
    @endrole
@endsection
