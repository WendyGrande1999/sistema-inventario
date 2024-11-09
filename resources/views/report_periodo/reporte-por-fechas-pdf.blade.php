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
        /* Tabla sin borde para el encabezado */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .header-table td {
            border: none; /* Quitar bordes en celdas del encabezado */
            padding: 8px;
        }
        .header-table .logo {
            width: 150px;
        }
        .header-table .details {
            text-align: right;
        }
        hr {
            border: none;
            border-top: 1px solid #000;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        /* Tabla del cuerpo con bordes */
        .body-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .body-table, .body-table th, .body-table td {
            border: 1px solid #333; /* Bordes para la tabla del cuerpo */
            padding: 8px;
            text-align: center;
        }
        .body-table th.bg-success {
            background-color: #4CAF50;
            color: white;
        }
        .body-table tfoot th {
            font-weight: bold;
        }
    </style>
</head>
<body>

<table class="header-table">
    <tr>
        <td class="logo">
            <img src="{{ public_path('images/logo_eco.png') }}" alt="Logo de la Empresa" style="max-width: 150px; height: auto;">
        </td>
        <td class="details">
            <div class="company-name">Hostal Hojas Eco Villa</div>
            <div>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
            <div>Playa Las Hojas, San Pedro Masahuat, La Paz, El Salvador C.A</div>
        </td>
    </tr>
</table>

<hr>
<div class="container">
    <h3>Reporte de Inventario del {{ $fechaInicioTexto }} al {{ $fechaCierreTexto }}</h3>

    <table class="body-table">
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
