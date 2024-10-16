@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Entradas de {{ $producto->nombre }}</h1>

    <p><strong>Rango de Fechas:</strong> 
        Desde {{ $fechaInicio }}
        hasta {{ \Carbon\Carbon::parse($fecha_cierre)->format('d-m-Y') }}
    </p>

    @if($entradas->isEmpty())
        <p>No hay entradas para este producto en el rango de fechas seleccionado.</p>
    @else

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
                <table id="my-table" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Fecha Ingreso</th>
                            <th>Producto</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Unidad de Medida</th>
                            <th>Cantidad Entrante</th>
                            <th>Cantidad Disponible</th>
                            <th>Salida</th>
                            <th>Precio por Unidad</th>
                            <th>Saldo Compra</th>
                            <th>Ver</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entradas as $entrada)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($entrada->fecha_ingreso)->format('d-m-Y') }}</td>
                                <td>{{ $entrada->producto->nombre }}</td>
                                <td>{{ $entrada->proveedor->name }}</td>
                                <td>{{ $entrada->usuario->name }}</td>
                                <td>{{ $entrada->unidad_medida }}</td>
                                <td>{{ $entrada->cantidad_entrante }}</td>
                                <td>{{ $entrada->cantidad }}</td>
                                <td>{{ $entrada->salida }}</td>
                                <td>${{ number_format($entrada->precio_unidad, 2) }}</td>
                                <td>${{ number_format($entrada->saldo_compra, 2) }}</td>
                                <td>
                                    <a href="{{ route('entradas.show', $entrada->id) }}" class="btn btn-info btn-sm">Ver</a>
                                </td>
                                <td>
                                    <a href="{{ route('entradas.edit', $entrada->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                </td>
                                <td>
                                    <form action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" style="display: inline;">
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
    @endif
</div>

<script>
    function eliminarEntrada(event) {
        if (!confirm('¿Está seguro de que desea eliminar esta entrada?')) {
            event.preventDefault();
        }
    }
</script>
@endsection
