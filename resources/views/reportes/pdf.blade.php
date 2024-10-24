<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Producto {{ $codigo }}</title>
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
    <h1>Detalle de Producto</h1>

    <table>
        <tr>
            <td><strong>Producto:</strong></td>
            <td>{{ $producto->nombre }}</td>
        </tr>
        <tr>
            <td><strong>Código:</strong></td>
            <td>{{ $producto->codigo }}</td>
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
        <table>
            <thead>
                <tr>
                    <th>Fecha Entrada</th>
                    <th>Descripción</th>
                    <th>Proveedor</th>
                    <th>Entradas</th>
                    <th>Salidas</th>
                    <th>Stock</th>
                    <th>Precio de Compra</th>
                    <th>Saldo Compra</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entradas as $entrada)
                    <tr>
                        <td>{{ $entrada['fecha_ingreso'] }}</td>
                        <td>{{ $entrada['descripcion'] }}</td>
                        <td>{{ $entrada['proveedor'] }}</td>
                        <td>{{ $entrada['entradas'] }}</td>
                        <td>{{ $entrada['salidas'] }}</td>
                        <td>{{ $entrada['stock'] }}</td>
                        <td>${{ $entrada['precio_compra'] }}</td>
                        <td>${{ $entrada['saldo_compra'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Totales:</strong></td>
                    <td><strong>{{ $totalEntradas }}</strong></td>
                    <td><strong>{{ $totalSalidas }}</strong></td>
                    <td><strong>{{ $totalStock }}</strong></td>
                    <td><strong>${{ number_format($promedioPrecioCompra, 2) }}</strong></td>
                    <td><strong>${{ $totalSaldoCompra }}</strong></td>
                </tr>
            </tfoot>
        </table>
    @endif
</body>
</html>
