<!DOCTYPE html>
<html>
<head>
    <title>Detalle de Producto</title>
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

    <table>
        <tr>
            <td><strong>Producto:</strong></td>
            <td>{{ $nombre_producto }}</td>
        </tr>
        <tr>
            <td><strong>Código:</strong></td>
            <td>{{ $codigo }}</td>
        </tr>
        <tr>
            <td><strong>Costo Promedio:</strong></td>
            <td>${{ number_format($promedioPrecioCompra, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Saldo Monetario:</strong></td>
            <td>${{ $totalSaldoCompra }}</td>
        </tr>
        <tr>
            <td><strong>Stock:</strong></td>
            <td>{{ $totalStock }}</td>
        </tr>
    </table>

    @if (!empty($entradas) && count($entradas) > 0)
        <table class="mt-4">
            <thead>
                <tr>
                    <th class="bg-success">Fecha Entrada</th>
                
                    <th class="bg-success">Proveedor</th>
                    <th class="bg-success">Entradas</th>
                    <th class="bg-success">Salidas</th>
                    <th class="bg-success">Stock</th>
                    <th class="bg-success">Unidad medida</th>
                    <th class="bg-success">Precio de Compra</th>
                    <th class="bg-success">Saldo Compra</th>
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
