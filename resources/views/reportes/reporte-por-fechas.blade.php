@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Reporte de Inventario del {{ $fechaInicioTexto }} al {{ $fechaCierreTexto }}</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="bg-success">Código</th>
                <th class="bg-success">Producto</th>
                <th class="bg-success">Entradas</th>
                <th class="bg-success">Salidas</th>
                <th class="bg-success">Stock</th>
                <th class="bg-success">Unidad de Medida</th>
                <th class="bg-success">Costo Total Entradas</th>
                <th class="bg-success">Total Egreso</th>
                <th class="bg-success">Acciones</th> <!-- Nueva columna para "Ver" -->
            </tr>
        </thead>
        <tbody>
            @foreach($reporte as $item)
                <tr>
                    <td>{{ $item['codigo'] }}</td>
                    <td>{{ $item['producto'] }}</td>
                    <td>{{ $item['entradas'] }}</td>
                    <td>{{ $item['salidas'] }}</td>
                    <td>{{ $item['stock'] }}</td>
                    <td>{{ $item['unidad_medida'] }}</td>
                    <td>${{ number_format($item['costo_por_producto'], 2) }}</td>
                    <td>${{ number_format($item['total_egreso'], 2) }}</td>
                    <td>
                        <!-- Enlace para ver el detalle del producto en el rango de fechas -->
                        <a href="{{ route('entradas.detallee', ['codigo' => $item['codigo'], 'fecha_inicio' => request('fecha_inicio'), 'fecha_cierre' => request('fecha_cierre')]) }}" class="btn btn-info btn-sm">Ver</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Totales</th>
                <th>{{ $totalEntradas }}</th>
                <th>{{ $totalSalidas }}</th>
                <th></th>
                <th></th>
                <th>${{ number_format($totalCosto, 2) }}</th>
                <th>${{ number_format($totalEgresos, 2) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    <div class="mt-3">
        <a href="{{ route('reporte-diario.mostrar') }}" class="btn btn-secondary">Volver</a>
        <a href="{{ route('report-porr-fechas.pdf', ['fecha_inicio' => request('fecha_inicio'), 'fecha_cierre' => request('fecha_cierre')]) }}" class="btn btn-primary">Descargar PDF</a>
    </div>
</div>
@endsection
