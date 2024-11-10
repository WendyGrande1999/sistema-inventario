@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle de compra </h1>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Fecha de Ingreso: {{ $entrada->fecha_ingreso }}</h4>

            <p class="card-text"><strong>Producto:</strong> {{ $entrada->producto->nombre }}</p>
            <p class="card-text"><strong>Proveedor:</strong> {{ $entrada->proveedor->name }}</p>
            <p class="card-text"><strong>Usuario:</strong> {{ $entrada->usuario->name }}</p>
            
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Cantidad Entrante</th>
                        <th>Salidas</th>
                        <th>Cantidad Disponible</th>
                        <th>Unidad de Medida</th>
                        <th>Precio por Unidad</th>
                        <th>Saldo Compra</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $entrada->cantidad_entrante }}</td>
                        <td>{{ $entrada->salida }}</td>
                        <td>{{ $entrada->cantidad }}</td>
                        <td>{{ $entrada->unidad_medida }}</td>
                        <td>${{ $entrada->precio_unidad }}</td>
                        <td>${{ $entrada->saldo_compra }}</td>
                    </tr>

                </tbody>
            </table>

            <br>

            <h4 class="card-title">Detalle de salidas</h4>

            <!-- Tabla con el registro de todas las salidas de esta entrada -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Fecha de Salida</th>
                        <th>Cantidad</th>
                        <th>Unidad de Medida</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($entrada->salidas as $salida)
                        <tr>
                            <td>{{ $salida->fecha_salida }}</td>
                            <td>{{ $salida->cantidad }}</td>
                            <td>{{ $salida->unidad_medida }}</td>
                            <td>{{ $salida->usuario->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay salidas registradas para esta entrada.</td>
                        </tr>
                    @endforelse

                    <tr>
                        <td>
                        <p><strong>Total:</strong></p>
                        </td>
                        <td>
                         {{ $sumSalida }}
                        </td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>

    <br>
    <div class="mt-3">
      <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>

        <a href="{{ route('entradas.pdf', $entrada->id) }}" class="btn btn-primary">Descargar PDF</a>
    </div>
</div>
@endsection
