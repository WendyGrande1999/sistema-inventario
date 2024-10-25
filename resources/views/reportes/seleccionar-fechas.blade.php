@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Seleccionar Fechas para el Reporte de Inventario</h3>
    <form action="{{ route('reportes.reportePorFechas') }}" method="GET">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label for="fecha_inicio">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="fecha_cierre">Fecha de Cierre</label>
                <input type="date" name="fecha_cierre" class="form-control" required>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Generar Reporte</button>
    </form>
</div>
@endsection
