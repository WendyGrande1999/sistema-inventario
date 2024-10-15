@extends('layouts.app')

@section('content')
<div class="container">
<h3>Reporte Diario de Inventario - {{ $fechaTexto }}</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Entradas</th>
                <th>Salidas</th>
                <th>Stock</th>
                <th>Unit de medida</th>
                <th>Costo total entradas</th>
                <th>Total Egreso</th>
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
                <th>${{ number_format($totalCosto, 2) }}</th>
                <th>${{ number_format($totalEgresos, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
