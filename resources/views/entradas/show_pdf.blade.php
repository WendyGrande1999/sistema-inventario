<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Entrada {{ $entrada->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .card {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .summary {
            margin-top: 20px;
            font-size: 18px;
        }
        .text-center {
            text-align: center;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            Detalle de Compra 
        </div>
        
        <div class="card">
            <h3>Información General</h3>
            <p><strong>Fecha de Ingreso:</strong> {{ $entrada->fecha_ingreso }}</p>
            <p><strong>Producto:</strong> {{ $entrada->producto->nombre }}</p>
            <p><strong>Proveedor:</strong> {{ $entrada->proveedor->name }}</p>
            <p><strong>Usuario Responsable:</strong> {{ $entrada->usuario->name }}</p>
        </div>

        <div class="card">
            <h3>Detalles de la Entrada</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Cantidad Entrante</th>
                        <th>Salidas</th>
                        <th>Cantidad Disponible</th>
                        <th>Unidad de Medida</th>
                        <th>Precio por Unidad</th>
                        <th>Saldo Compra</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $entrada->cantidad_entrante }}</td>
                        <td>{{ $entrada->salida }}</td>
                        <td>{{ $entrada->cantidad }}</td>
                        <td>{{ $entrada->unidad_medida }}</td>
                        <td>${{ $entrada->precio_unidad }}</td>
                        <td>${{ $entrada->saldo_compra }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Detalle de Salidas</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha de Salida</th>
                        <th>Cantidad</th>
                        <th>Unidad de Medida</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($entrada->salidas as $salida)
                        <tr>
                            <td>{{ $salida->fecha_salida }}</td>
                            <td>{{ $salida->cantidad }}</td>
                            <td>{{ $salida->unidad_medida }}</td>
                            <td>{{ $salida->usuario->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay salidas registradas para esta entrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <p class="summary total">Total de Salidas: {{ $entrada->salidas->sum('cantidad') }}</p>
        </div>

    </div>
</body>
</html>
