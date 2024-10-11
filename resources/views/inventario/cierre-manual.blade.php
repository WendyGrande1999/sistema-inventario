@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cierre de Inventario</h1>


    <!-- Mostrar mensaje de éxito si el cierre se generó correctamente -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

     

    <br>
    <p>Haz clic en el botón para generar un cierre de inventario. Este proceso actualizará el stock de todos los productos en el sistema.</p>

    <!-- Mostrar la tabla de productos con su stock actual -->
    <table class="table table-bordered">
        <thead>
            <tr>
            <th>Código</th>
                <th>Nombre</th>
                <th>Stock Actual</th>
               
            </tr>
        </thead>
        <tbody>
        @foreach($dataProductos as $producto)
                <tr>
                    <td>{{ $producto['codigo'] }}</td>
                    <td>{{ $producto['nombre'] }}</td>
                    <td>{{ $producto['stockTotalActual'] }}</td>
                   
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <!-- Botón para generar el cierre manual -->
    <form action="{{ route('inventario.generar-cierre') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary btn-lg">Generar Cierre de Inventario</button>
    </form>
</div>
@endsection
