@extends('layouts.app')

@section('content')
<div class="container">
<h3>Reporte Diario de Inventario - {{ $fechaTexto }}</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="bg-success">Código</th>
                <th class="bg-success">Producto</th>
                <th class="bg-success">Entradas</th>
                <th class="bg-success">Salidas</th>
                <th class="bg-success">Stock</th>
                <th class="bg-success">Unit de medida</th>
                <th class="bg-success">Costo total entradas</th>
                <th class="bg-success">Total Egreso</th>
                <th class="bg-success">Acciones</th>
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
                        <!-- Botón Ver que redirige a la vista de entradas del día para este producto -->
                        <a href="{{ route('entradas.dia', ['fecha' => $fechaSeleccionada->format('Y-m-d'), 'producto' => $item['producto']]) }}" class="btn btn-info btn-sm">Ver</a>
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
            </tr>
        </tfoot>
    </table>
    <br>
    <div class="mt-3">
        <a href="{{ route('reporte-diario.mostrar') }}"class="btn btn-secondary">Volver</a>
        <a href="{{ route('report-diarioo.pdf', ['fecha' => $fechaSeleccionada->format('Y-m-d')]) }}" class="btn btn-primary">Descargar PDF</a>
    </div>
</div>
@endsection
