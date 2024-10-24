@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle de Producto</h1>

    <table class="table table-striped">

        <tr>
            <td><strong>Producto:</strong></td>
            <td>{{ $nombre_producto }}</td>
        </tr>
        <tr>
            <td><strong>Codigo:</strong></td>
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
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th class="bg-success">Fecha Entrada</th>
                    <th class="bg-success">Descripción</th>
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
        <a href="#"class="btn btn-secondary">Volver</a>
        <a href="{{ route('reportes.pdf' , $codigo) }}" class="btn btn-primary">Descargar PDF</a>
    </div>

</div>
@endsection
