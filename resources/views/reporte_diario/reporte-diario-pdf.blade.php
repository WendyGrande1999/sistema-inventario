<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Diario de Inventario - {{ $fechaTexto }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        
        /* Quitar borde de la tabla del encabezado */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border: none;
        }
        .header-table .logo {
            width: 150px; /* Ancho fijo para la imagen */
        }
        .header-table .details {
            text-align: right;
        }

        /* Agregar borde solo a la tabla del cuerpo */
        .cuerpo-tabla {
            width: 100%;
            border-collapse: collapse;
        }
        .cuerpo-tabla th, .cuerpo-tabla td {
            padding: 8px;
            border: 1px solid #000;
            text-align: left;
        }
        .cuerpo-tabla th {
            background-color: #28a745;
            color: #fff;
        }

        .totales { font-weight: bold; }

        hr {
            border: none;  /* Eliminar borde en la línea */
            border-top: 1px solid #000;  /* Agregar una línea divisora debajo del encabezado */
            margin-top: 10px;
            margin-bottom: 20px;
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
            <div>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</div> <!-- Fecha actual -->
            <div>Playa Las Hojas, San Pedro Masahuat, La Paz, El Salvador C.A</div> <!-- Dirección de la empresa -->
        </td>
    </tr>
</table>

<!-- Línea divisora debajo del encabezado -->
<hr>

<h3>Reporte Diario de Inventario - {{ $fechaTexto }}</h3>

<!-- Tabla del cuerpo con clase 'cuerpo-tabla' para aplicar borde -->
<table class="cuerpo-tabla">
    <thead>
        <tr>
            <th>Código</th>
            <th>Producto</th>
            <th>Entradas</th>
            <th>Salidas</th>
            <th>Stock</th>
            <th>Unidad de medida</th>
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
