@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reporte de Stock</h1>

     <!-- Mostrar la fecha del último cierre -->
     @if ($fechaUltimoCierre !== 'No hay cierres anteriores')
        <p><strong>Último cierre realizado:</strong> {{ $fechaUltimoCierre }}</p>
        <p>El stock mostrado refleja los movimientos desde el último cierre hasta la fecha actual.</p>
    @else
        <p>No se ha realizado ningún cierre de inventario hasta la fecha.</p>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
            <th>Código</th>
            <th>Producto</th>
            <th>Stock entrante</th>
            <th>Entradas</th>
            <th>Salidas</th>
            <th class="bg-warning">Stock Actual</th>
           
            <th>Unidad de Medida</th>
           
            </tr>
        </thead>
        <tbody>
            @if($data->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">No hay datos disponibles.</td>
                </tr>
            @else
            @foreach($data as $producto)
            <tr>
                <td>{{ $producto['codigo'] }}</td>
                <td>{{ $producto['nombre_producto'] }}</td>
                <td>{{ $producto['stock_ultimo_cierre'] }}</td>
                <td>{{ $producto['cantidad_entradas_desde_cierre'] }}</td>
                <td>{{ $producto['cantidad_salidas_desde_cierre'] }}</td>
                <td class="bg-warning">{{ $producto['stockTotalActual'] }}</td>
                

                <td>{{ $producto['unidad_medida'] }}</td>
            </tr>
        @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection
