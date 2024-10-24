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
            </tr>
        </tfoot>
    </table>
</div>
@endsection
