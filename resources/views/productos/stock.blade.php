@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reporte de Stock</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código Producto</th>
                <th>Nombre Producto</th>
                <th>Cantidad Entradas</th>
                <th>Cantidad Salidas</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>

        @if($data->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">No hay datos disponibles.</td>
                </tr>
            @else
            @foreach($data as $item)
            <tr>
                <td>{{ $item['codigo'] }}</td>
                <td>{{ $item['nombre_producto'] }}</td>
                <td>{{ $item['cantidad_entradas'] }}</td>
                <td>{{ $item['cantidad_salidas'] }}</td>
                <td>{{ $item['stock'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
