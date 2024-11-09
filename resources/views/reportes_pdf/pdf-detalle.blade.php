<!DOCTYPE html>
<html>
<head>
    <title>Detalle de Producto</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        /* Eliminamos los bordes en la tabla del encabezado */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border: none;  /* Eliminar borde en la tabla del encabezado */
        }
        .header-table td {
            vertical-align: middle;
            padding: 8px;
        }
        .header-table .logo {
            width: 150px; /* Ancho fijo para la imagen */
        }
        .header-table .details {
            text-align: right;
        }
        .header-table .details .company-name {
            font-weight: bold;
            font-size: 16px;
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
        hr {
            border: none;  /* Eliminar borde en la línea */
            border-top: 1px solid #000;  /* Agregar una línea divisora debajo del encabezado */
            margin-top: 10px;
            margin-bottom: 20px;
        }

        /* Estilos para las tablas del cuerpo del documento */
        .body-table, .body-table th, .body-table td {
            border: 1px solid #000; /* Bordes para la tabla del cuerpo */
        }

        .body-table th {
            background-color: #f2f2f2; /* Fondo gris claro para las celdas del encabezado */
            padding: 8px;
        }

        .body-table td {
            padding: 8px;
            vertical-align: middle;
        }
    </style>
</head>
<body>

<!-- Encabezado con la tabla sin borde -->
<table class="header-table">
    <tr>
        <td class="logo">
            <img src="{{ public_path('images/logo_eco.png') }}" alt="Logo de la Empresa" style="max-width: 150px; height: auto;">
        </td>
        <td class="details">
            <div class="company-name">Hostal Hojas Eco Villa</div>
            <div>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</div> <!-- Fecha actual -->
            <div>Playa Las Hojas, San Pedro Masahuat, La Paz, El Salvador C.A</div> <!-- Dirección de la empresa -->
        </td>
    </tr>
</table>

<!-- Línea divisora debajo del encabezado -->
<hr>

<h1>Detalle de Producto</h1>

<!-- Tabla del detalle de producto con bordes -->
<table class="body-table">
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
    <!-- Tabla de entradas con bordes -->
    <table class="body-table mt-4">
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
