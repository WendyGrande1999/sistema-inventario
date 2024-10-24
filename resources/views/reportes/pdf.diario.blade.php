<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Diario de Inventario - {{ $fechaTexto }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Detalle de Reporte diario</h1>

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
</body>
</html>
