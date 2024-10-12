@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Listado de Salidas</h1>
    <a href="{{ route('salidas.create') }}" class="btn btn-primary mb-3">Agregar Nueva Salida</a>
    @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    
    <table class="table table-bordered">
        <thead>
            <tr>
           
                <th>Fecha Salida</th>
                <th>Producto</th>
                <th>Unidad de Medida</th>
                <th>Cantidad</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salidasActivas as $salida)
                <tr>
                  
                    <td>{{ $salida->fecha_salida }}</td>
                    <td>{{ $salida->producto->nombre }}</td>
                   
                    <td>{{ $salida->unidad_medida }}</td>
                    <td>{{ $salida->cantidad }}</td>
                    <td>{{ $salida->usuario->name }}</td>
                    <td>
                        <a href="{{ route('salidas.edit', $salida->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('salidas.destroy', $salida->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
