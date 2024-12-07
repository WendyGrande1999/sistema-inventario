@extends('layouts.app')

@section('content')
    @role('admin')
        <div class="container">
            <h1>Lista de Entradas</h1>
            <a href="{{ route('entradas.create') }}" class="btn btn-primary mb-3">Agregar Entrada</a>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Tabla de Entradas Activas desde el Último Cierre -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Entradas Activas desde el Último Cierre</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabla-activa" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Fecha Ingreso</th>
                                    <th>Producto</th>
                                    <th>Proveedor</th>
                                    <th>Usuario</th>
                                    <th>Cantidad entrante</th>
                                    <th>Cantidad disponible</th>
                                    <th>Salida</th>
                                    <th>Precio por Unidad</th>
                                    <th>Saldo Compra</th>
                                    <th>Ver</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entradasDesdeUltimoCierre as $entrada)
                                    <tr>
                                        <td>{{ $entrada->fecha_ingreso }}</td>
                                        <td>{{ $entrada->producto->nombre }}</td>
                                        <td>{{ $entrada->proveedor->name }}</td>
                                        <td>{{ $entrada->usuario->name }}</td>
                                        <td>{{ $entrada->cantidad_entrante }}</td>
                                        <td>{{ $entrada->cantidad }} {{ $entrada->unidad_medida }}</td>
                                        <td>{{ $entrada->salida }}</td>
                                        <td>${{ $entrada->precio_unidad }}</td>
                                        <td>${{ $entrada->saldo_compra }}</td>
                                        <td><a href="{{ route('entradas.show', $entrada->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
                                        <td><a href="{{ route('entradas.edit', $entrada->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a></td>
                                        <td>
                                            <form action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="eliminarEntrada(event)" type="button" class="btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tabla de Entradas Inactivas desde el Último Cierre -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h3 class="mb-0">Entradas Inactivas desde el Último Cierre</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabla-inactiva" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Fecha Ingreso</th>
                                    <th>Producto</th>
                                    <th>Proveedor</th>
                                    <th>Usuario</th>
                                    <th>Cantidad entrante</th>
                                    <th>Cantidad disponible</th>
                                    <th>Salida</th>
                                    <th>Precio por Unidad</th>
                                    <th>Saldo Compra</th>
                                    <th>Ver</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entradasDesdeUltimoCierreInactivas as $entrada)
                                    <tr>
                                        <td>{{ $entrada->fecha_ingreso }}</td>
                                        <td>{{ $entrada->producto->nombre }}</td>
                                        <td>{{ $entrada->proveedor->name }}</td>
                                        <td>{{ $entrada->usuario->name }}</td>
                                        <td>{{ $entrada->cantidad_entrante }}</td>
                                        <td>{{ $entrada->cantidad }} {{ $entrada->unidad_medida }}</td>
                                        <td>{{ $entrada->salida }}</td>
                                        <td>${{ $entrada->precio_unidad }}</td>
                                        <td>${{ $entrada->saldo_compra }}</td>
                                        <td><a href="{{ route('entradas.show', $entrada->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
                                        <td><a href="{{ route('entradas.edit', $entrada->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a></td>
                                        <td>
                                            <form action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="eliminarEntrada(event)" type="button" class="btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Scripts -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.0/js/dataTables.bootstrap5.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                function eliminarEntrada(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro de eliminar este registro?',
                        text: '¡No podrás revertir esta acción!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            event.target.closest('form').submit();
                        }
                    });
                }

                $(document).ready(function() {
                    $('#tabla-activa, #tabla-inactiva').DataTable({
                        paging: true,
                        searching: true,
                        ordering: true,
                        info: true,
                        lengthChange: true,
                        pageLength: 4,
                        language: {
                            processing: "Procesando...",
                            lengthMenu: "Mostrar _MENU_ registros por página",
                            zeroRecords: "No se encontraron resultados",
                            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                            infoEmpty: "Mostrando 0 registros",
                            infoFiltered: "(filtrado de _MAX_ registros)",
                            paginate: {
                                first: "Primero",
                                last: "Último",
                                next: "Siguiente",
                                previous: "Anterior"
                            },
                            search: "Buscar:"
                        }
                    });
                });
            </script>
        </div>
    @endrole

    @role('editor')
        <div class="container">
            <h1>Lista de Entradas</h1>
            <a href="{{ route('entradas.create') }}" class="btn btn-primary mb-3">Agregar Entrada</a>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Tabla de Entradas Activas desde el Último Cierre -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Entradas Activas desde el Último Cierre</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabla-activa" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Fecha Ingreso</th>
                                    <th>Producto</th>
                                    <th>Proveedor</th>
                                    <th>Usuario</th>
                                    <th>Cantidad entrante</th>
                                    <th>Cantidad disponible</th>
                                    <th>Salida</th>
                                    <th>Precio por Unidad</th>
                                    <th>Saldo Compra</th>
                                    <th>Ver</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entradasDesdeUltimoCierre as $entrada)
                                    <tr>
                                        <td>{{ $entrada->fecha_ingreso }}</td>
                                        <td>{{ $entrada->producto->nombre }}</td>
                                        <td>{{ $entrada->proveedor->name }}</td>
                                        <td>{{ $entrada->usuario->name }}</td>
                                        <td>{{ $entrada->cantidad_entrante }}</td>
                                        <td>{{ $entrada->cantidad }} {{ $entrada->unidad_medida }}</td>
                                        <td>{{ $entrada->salida }}</td>
                                        <td>${{ $entrada->precio_unidad }}</td>
                                        <td>${{ $entrada->saldo_compra }}</td>
                                        <td><a href="{{ route('entradas.show', $entrada->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
                                        
                                       
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tabla de Entradas Inactivas desde el Último Cierre -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h3 class="mb-0">Entradas Inactivas desde el Último Cierre</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabla-inactiva" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Fecha Ingreso</th>
                                    <th>Producto</th>
                                    <th>Proveedor</th>
                                    <th>Usuario</th>
                                    <th>Cantidad entrante</th>
                                    <th>Cantidad disponible</th>
                                    <th>Salida</th>
                                    <th>Precio por Unidad</th>
                                    <th>Saldo Compra</th>
                                    <th>Ver</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entradasDesdeUltimoCierreInactivas as $entrada)
                                    <tr>
                                        <td>{{ $entrada->fecha_ingreso }}</td>
                                        <td>{{ $entrada->producto->nombre }}</td>
                                        <td>{{ $entrada->proveedor->name }}</td>
                                        <td>{{ $entrada->usuario->name }}</td>
                                        <td>{{ $entrada->cantidad_entrante }}</td>
                                        <td>{{ $entrada->cantidad }} {{ $entrada->unidad_medida }}</td>
                                        <td>{{ $entrada->salida }}</td>
                                        <td>${{ $entrada->precio_unidad }}</td>
                                        <td>${{ $entrada->saldo_compra }}</td>
                                        <td><a href="{{ route('entradas.show', $entrada->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
                                                                              
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Scripts -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.0/js/dataTables.bootstrap5.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                function eliminarEntrada(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro de eliminar este registro?',
                        text: '¡No podrás revertir esta acción!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            event.target.closest('form').submit();
                        }
                    });
                }

                $(document).ready(function() {
                    $('#tabla-activa, #tabla-inactiva').DataTable({
                        paging: true,
                        searching: true,
                        ordering: true,
                        info: true,
                        lengthChange: true,
                        pageLength: 4,
                        language: {
                            processing: "Procesando...",
                            lengthMenu: "Mostrar _MENU_ registros por página",
                            zeroRecords: "No se encontraron resultados",
                            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                            infoEmpty: "Mostrando 0 registros",
                            infoFiltered: "(filtrado de _MAX_ registros)",
                            paginate: {
                                first: "Primero",
                                last: "Último",
                                next: "Siguiente",
                                previous: "Anterior"
                            },
                            search: "Buscar:"
                        }
                    });
                });
            </script>
        </div>
    @endrole
@endsection
