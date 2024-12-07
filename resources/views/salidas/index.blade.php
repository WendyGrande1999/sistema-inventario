@extends('layouts.app')

@section('content')
@role('admin')
<div class="container">
    <h1 class="text-dark">Listado de Salidas</h1>
    <a href="{{ route('salidas.create') }}" class="btn btn-primary mb-3">Agregar Nueva Salida</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h2 class="text-dark">Salidas Activas</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Fecha Salida</th>
                <th>Producto</th>
                <th>Unidad de Medida</th>
                <th>Cantidad</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salidasActivass as $salida)
                <tr>
                    <td>{{ $salida->fecha_salida }}</td>
                    <td>{{ $salida->producto->nombre }}</td>
                    <td>{{ $salida->unidad_medida }}</td>
                    <td>{{ $salida->cantidad }}</td>
                    <td>{{ $salida->usuario->name }}</td>
                    <td>
                        <a href="{{ route('salidas.edit', $salida->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <form id="delete-entry-form-{{ $salida->id }}" 
                              action="{{ route('salidas.destroy', $salida->id) }}" 
                              method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="eliminarSalida(event, {{ $salida->id }})" 
                                    type="button" 
                                    class="btn btn-danger btn-sm">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-dark mt-5">Salidas Inactivas</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Fecha Salida</th>
                <th>Producto</th>
                <th>Unidad de Medida</th>
                <th>Cantidad</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salidasInactivass as $salida)
                <tr>
                    <td>{{ $salida->fecha_salida }}</td>
                    <td>{{ $salida->producto->nombre }}</td>
                    <td>{{ $salida->unidad_medida }}</td>
                    <td>{{ $salida->cantidad }}</td>
                    <td>{{ $salida->usuario->name }}</td>
                    <td>
                        <a href="{{ route('salidas.edit', $salida->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <form id="delete-entry-form-{{ $salida->id }}" 
                              action="{{ route('salidas.destroy', $salida->id) }}" 
                              method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="eliminarSalida(event, {{ $salida->id }})" 
                                    type="button" 
                                    class="btn btn-danger btn-sm">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endrole

@role('editor')
<div class="container">
    <h1 class="text-dark">Listado de Salidas</h1>
    <a href="{{ route('salidas.create') }}" class="btn btn-primary mb-3">Agregar Nueva Salida</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h2 class="text-dark">Salidas Activas</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Fecha Salida</th>
                <th>Producto</th>
                <th>Unidad de Medida</th>
                <th>Cantidad</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salidasActivass as $salida)
                <tr>
                    <td>{{ $salida->fecha_salida }}</td>
                    <td>{{ $salida->producto->nombre }}</td>
                    <td>{{ $salida->unidad_medida }}</td>
                    <td>{{ $salida->cantidad }}</td>
                    <td>{{ $salida->usuario->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-dark mt-5">Salidas Inactivas</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Fecha Salida</th>
                <th>Producto</th>
                <th>Unidad de Medida</th>
                <th>Cantidad</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salidasInactivass as $salida)
                <tr>
                    <td>{{ $salida->fecha_salida }}</td>
                    <td>{{ $salida->producto->nombre }}</td>
                    <td>{{ $salida->unidad_medida }}</td>
                    <td>{{ $salida->cantidad }}</td>
                    <td>{{ $salida->usuario->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endrole

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function eliminarSalida(event, id) {
        event.preventDefault();

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
                document.getElementById(`delete-entry-form-${id}`).submit();
            }
        });
    }
</script>
@endsection
