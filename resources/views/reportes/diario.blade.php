@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reporte Diario de Inventario</h1>

    <!-- Formulario para seleccionar la fecha -->
    <form action="{{ route('reporte-diario.generar') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="fecha">Seleccionar Fecha:</label>
            <input type="date" id="fecha" name="fecha" class="form-control" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Generar Reporte</button>
    </form>
</div>
@endsection
