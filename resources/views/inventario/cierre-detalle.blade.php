@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle del Cierre de Inventario</h1>

    @if($productosDetalle->isEmpty())
        <p>No hay datos disponibles para el cierre seleccionado.</p>
    @else
        
       <!-- Mostrar el rango de fechas entre el último cierre y el cierre seleccionado -->
       <p><strong>Rango de Cierre:</strong> Desde {{ $fechaInicioTexto }} hasta {{ $fechaCierreTexto }}</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Entradas</th>
                    <th>Salidas</th>
                    <th>Ver detalles</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productosDetalle as $producto)
                    <tr>
                        <td>{{ $producto['codigo'] }}</td>
                        <td>{{ $producto['nombre'] }}</td>
                        <td>{{ $producto['entradas'] }}</td>
                        <td>{{ $producto['salidas'] }}</td>
                        <td>
                    <a href="" class="btn btn-info btn-sm">Ver</a>
              
                </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
