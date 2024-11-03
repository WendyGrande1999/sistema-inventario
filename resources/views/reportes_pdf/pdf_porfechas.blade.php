<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Inventario del {{ $fechaInicioTexto }} al {{ $fechaCierreTexto }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .bg-success {
            background-color: #d4edda;
        }
        .mt-4 {
            margin-top: 20px;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <h1>Detalle de Producto</h1>

     <table >
        <thead>
            <tr>
                <th >Código</th>
                <th >Producto</th>
                <th>Entradas</th>
                <th >Salidas</th>
                <th >Stock</th>
                <th >Unidad de Medida</th>
                <th >Costo Total Entradas</th>
                <th >Total Egreso</th>
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

    @if (!empty($entradas) && count($entradas) > 0)
        <table class="mt-4">
            <thead>
                <tr>
                    <th>Fecha Entrada</th>
                    <th >Proveedor</th>
                    <th >Entradas</th>
                    <th >Salidas</th>
                    <th >Stock</th>
                    <th >Unidad medida</th>
                    <th >Precio de Compra</th>
                    <th >Saldo Compra</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entradas as $entrada)
                    <tr>
                        <td>{{ $entrada['fecha_ingreso'] }}</td>

                        <td>{{ $entrada['proveedor'] }}</td>
                        <td>{{ $entrada['entradas'] }}</td>
                        <td>{{ $entrada['salidas'] }}</td>
                        <td>{{ $entrada['stock'] }}</td>
                        <td>{{ $entrada['unidad_medida'] }}</td>
                        <td>${{ $entrada['precio_compra'] }}</td>
                        <td>${{ $entrada['saldo_compra'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>Totales:</strong></td>
                    <td><strong>{{ $totalEntradas }}</strong></td>
                    <td><strong>{{ $totalSalidas }}</strong></td>
                    <td><strong>{{ $totalStock }}</strong></td>
                    <td><strong> </strong></td>
                    <td><strong>${{ number_format($promedioPrecioCompra, 2) }}</strong></td>
                    <td><strong>${{ $totalSaldoCompra }}</strong></td>
                </tr>
            </tfoot>
        </table>
    @endif
</body>
</html>
