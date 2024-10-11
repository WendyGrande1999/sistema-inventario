@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle del Cierre de Inventario</h1>

    @if($productosCierre->isEmpty())
        <p>No hay datos disponibles para el cierre seleccionado.</p>
    @else
        <p><strong>Fecha de cierre: </strong>{{ \Carbon\Carbon::parse($productosCierre->first()->fecha_cierre)->format('d-m-Y') }}</p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Entradas</th>
                    <th>Salidas</th>
                    <th>Stock saliente</th>
                    <th>Fecha de Cierre</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productosCierre as $cierre)
                    <tr>
                        <td>{{ $cierre->producto->codigo }}</td>
                        <td>{{ $cierre->producto->nombre }}</td>
                        <td>{{ $cierre->producto->entradas->sum('cantidad_entrante') }}</td>
                        <td>{{ $cierre->producto->salidas->sum('cantidad') }}</td>
                        <td>{{ $cierre->cantidad_total }}</td>
                        <td>{{ \Carbon\Carbon::parse($cierre->fecha_cierre)->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
