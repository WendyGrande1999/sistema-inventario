<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Entrada {{ $entrada->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .data {
            font-size: 18px;
        }
        .card {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            Detalle de compra
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Fecha de Ingreso: {{ $entrada->fecha_ingreso }}</h5>
                <p class="card-text"><strong>Producto:</strong> {{ $entrada->producto->nombre }}</p>
                <p class="card-text"><strong>Proveedor:</strong> {{ $entrada->proveedor->name }}</p>
                <p class="card-text"><strong>Usuario:</strong> {{ $entrada->usuario->name }}</p>
                <p class="card-text"><strong>Unidad de Medida:</strong> {{ $entrada->unidad_medida }}</p>
                <p class="card-text"><strong>Cantidad:</strong> {{ $entrada->cantidad }}</p>
                <p class="card-text"><strong>Precio por Unidad:</strong> ${{ $entrada->precio_unidad }}</p>
                <p class="card-text"><strong>Saldo Compra:</strong> ${{ $entrada->saldo_compra }}</p>
            </div>
        </div>
    </div>
</body>
</html>
