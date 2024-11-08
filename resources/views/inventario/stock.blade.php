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
                    <th>Stock Actual</th>
                    <th>Unidad de Medida</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No hay datos disponibles.</td>
                    </tr>
                @else
                    @foreach ($data as $producto)
                        <tr>
                            <td>{{ $producto['codigo'] }}</td>
                            <td>{{ $producto['nombre_producto'] }}</td>
                            <td>{{ $producto['stock_ultimo_cierre'] }}</td>
                            <td>{{ $producto['cantidad_entradas_desde_cierre'] }}</td>
                            <td>{{ $producto['cantidad_salidas_desde_cierre'] }}</td>

                            @if ($producto['stockTotalActual'] <= 15)
                                <td class="bg-danger text-white">{{ $producto['stockTotalActual'] }}</td>
                            @elseif ($producto['stockTotalActual'] > 15)
                                <td class="bg-warning">{{ $producto['stockTotalActual'] }}</td>
                            @endif
                            
                            <td>{{ $producto['unidad_medida'] }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

     <!-- Leyenda de colores para el stock -->
     <div class="mb-3">
            
            <ul>
                <br>
                <li><span class="badge bg-danger">Rojo</span>: Nivel bajo de stock (15 o menos unidades)</li>
                <br>
                <li><span class="badge bg-warning text-dark">Amarillo</span>: Nivel moderado de stock (más de 15 unidades)</li>
            </ul>
        </div>
@endsection
