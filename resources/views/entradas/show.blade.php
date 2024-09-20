@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle de compra </h1>
  
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Fecha de Ingreso: {{ $entrada->fecha_ingreso }}</h5>

            <p class="card-text"><strong>Producto:</strong> {{ $entrada->producto->nombre }}</p>
            <p class="card-text"><strong>Proveedor:</strong> {{ $entrada->proveedor->name }}</p>
            <p class="card-text"><strong>Usuario:</strong> {{ $entrada->usuario->name }}</p>
            <p class="card-text"><strong>Unidad de Medida:</strong> {{ $entrada->unidad_medida }}</p>
            <p class="card-text"><strong>Cantidad:</strong> {{ $entrada->cantidad }}</p>
            <p class="card-text"><strong>Precio por Unidad:</strong> ${{ $entrada->precio_unidad }}</p>
            <p class="card-text"><strong>Saldo Compra:</strong> ${{ $entrada->saldo_compra }}</p>

        </div>
    </div>

<br>
    <a href="{{ route('entradas.index') }}" class="btn btn-secondary mb-3">Volver a la Lista</a>


</div>
@endsection
