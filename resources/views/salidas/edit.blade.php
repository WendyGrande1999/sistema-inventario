@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Salida</h1>
    <form action="{{ route('salidas.update', $salida->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="fecha_salida"><strong>Fecha de Salida</strong></label>
            <input type="date" name="fecha_salida" id="fecha_salida" class="form-control" value="{{ $salida->fecha_salida }}" required>
        </div>
        <br>

       
    
      
        <div class="form-group">
            <label for="cantidad"><strong>Cantidad</strong></label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ $salida->cantidad }}" required>
        </div>
        <br>

        <button type="submit" class="btn btn-primary">Actualizar Salida</button>
        <a href="{{ route('salidas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
