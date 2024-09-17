@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Producto</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $producto->nombre }}</h5>
            <p class="card-text"><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
            <p class="card-text"><strong>Categoría:</strong> {{ $producto->category->name }}</p>
        </div>
    </div>

    <a href="{{ route('productos.index') }}" class="btn btn-primary mt-3">Volver a la lista</a>
</div>
@endsection
