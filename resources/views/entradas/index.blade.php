@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Entradas</h1>
    <a href="{{ route('entradas.create') }}" class="btn btn-primary mb-3">Agregar Entrada</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
              
                <th>Fecha Ingreso</th>
                <th>Producto</th>
                <th>Proveedor</th>
                <th>Usuario</th>
                <th>Unidad de Medida</th>
                <th>Cantidad</th>
                <th>Precio por Unidad</th>
                <th>Saldo Compra</th>
                <th>Ver</th>
                <th>Edit</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entradas as $entrada)
            <tr>
              
                <td>{{ $entrada->fecha_ingreso }}</td>
                <td>{{ $entrada->producto->nombre }}</td>
                <td>{{ $entrada->proveedor->name }}</td>
                <td>{{ $entrada->usuario->name }}</td>
                <td>{{ $entrada->unidad_medida }}</td>
                <td>{{ $entrada->cantidad }}</td>
                <td>$<span>{{ $entrada->precio_unidad }}</span> 
                
                <td>$<span>{{ $entrada->saldo_compra }}</span></td>
                
                <td>
                    <a href="{{ route('entradas.show', $entrada->id) }}" class="btn btn-info btn-sm">Ver</a>
              
                </td>

                <td>
                <a href="{{ route('entradas.edit', $entrada->id) }}" class="btn btn-warning btn-sm">Editar</a>
                </td>

                <td>

                <form action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta entrada?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
