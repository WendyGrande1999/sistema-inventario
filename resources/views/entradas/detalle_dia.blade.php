@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Entradas del Producto {{ $nombre }} para la Fecha {{ $fecha }}</h3>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Fecha Entrada</th>
                <th>Descripción</th>
                <th>Proveedor</th>
                <th>Entradas</th>
                <th>Salidas</th>
                <th>Stock</th>
                <th>Unidad Medida</th>
                <th>Precio de Compra</th>
                <th>Saldo Compra</th>
                <th>Estado</th>
                <th>Acciones</th> <!-- Nueva columna para el menú de acciones -->
            </tr>
        </thead>
        <tbody>
            @foreach ($entradas as $entrada)
                <tr>
                    <td>{{ $entrada->fecha_ingreso }}</td>
                    <td>{{ $entrada->producto->descripcion }}</td>
                    <td>{{ $entrada->proveedor->name }}</td>
                    <td>{{ $entrada->cantidad_entrante }}</td>
                    <td>{{ $entrada->salida }}</td>
                    <td>{{ $entrada->cantidad }}</td>
                    <td>{{ $entrada->unidad_medida }}</td>
                    <td>${{ number_format($entrada->precio_unidad, 2) }}</td>
                    <td>${{ number_format($entrada->saldo_compra, 2) }}</td>
                    <td>{{ $entrada->estado }}</td>
                    <td>
                        <!-- Menú desplegable de tres puntos -->
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton{{ $entrada->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i> <!-- Icono de tres puntos -->
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $entrada->id }}">
                                <li><a class="dropdown-item" href="{{ route('entradas.show', $entrada->id) }}">Ver</a></li>
                                <li><a class="dropdown-item" href="{{ route('entradas.edit', $entrada->id) }}">Editar</a></li>
                                <li>
                                    <form action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta entrada?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item" type="submit">Eliminar</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('reporte-diario.mostrar') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection

@push('scripts')
<!-- Agregar enlace a FontAwesome para los iconos (si no está agregado en tu proyecto) -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endpush
