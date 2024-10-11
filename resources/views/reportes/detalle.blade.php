@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle de Producto</h1>

    <table class="table table-striped">
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
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Fecha Entrada</th>
                    <th>Descripción</th>
                    <th>Proveedor</th>
                    <th>Entradas</th>
                    <th>Salidas</th>
                    <th>Stock</th>
                    <th>Unidad medida</th>
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
                        <td>{{ $entrada['unidad_medida'] }}</td>
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
                    <td><strong> </strong></td>
                    <td><strong>${{ number_format($promedioPrecioCompra, 2) }}</strong></td>
                    <td><strong>${{ $totalSaldoCompra }}</strong></td>
                </tr>
            </tfoot>
        </table>
    @endif

    <br>
    <div class="mt-3">
        <a href="{{ route('reportes.detalle') }}" class="btn btn-secondary">Volver</a>
        <a href="#" class="btn btn-primary">Descargar PDF</a>
    </div>

</div>
@endsection
