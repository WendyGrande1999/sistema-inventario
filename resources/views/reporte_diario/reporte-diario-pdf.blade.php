<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Diario de Inventario - {{ $fechaTexto }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #000; text-align: left; }
        th { background-color: #28a745; color: #fff; }
        .totales { font-weight: bold; }
    </style>
</head>
<body>
    <h3>Reporte Diario de Inventario - {{ $fechaTexto }}</h3>
    <table>
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
            <tr class="totales">
                <td colspan="2">Totales</td>
                <td>{{ $totalEntradas }}</td>
                <td>{{ $totalSalidas }}</td>
                <td></td>
                <td></td>
                <td>${{ number_format($totalCosto, 2) }}</td>
                <td>${{ number_format($totalEgresos, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
