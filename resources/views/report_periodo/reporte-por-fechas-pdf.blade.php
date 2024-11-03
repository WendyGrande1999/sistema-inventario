<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }
        th.bg-success {
            background-color: #4CAF50;
            color: white;
        }
        tfoot th {
            font-weight: bold;
        }
    </style>
</head>
<body>
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
</body>
</html>
