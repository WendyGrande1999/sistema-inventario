@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Seleccionar Cierre de Inventario</h1>

    <form action="{{ route('inventario.cierre-detalle') }}" method="GET">
        <div class="form-group">
            <label for="fecha_cierre">Seleccione una fecha de cierre:</label>
            <select name="fecha_cierre" id="fecha_cierre" class="form-control" required>
                <option value="">Seleccione una fecha</option>
                @foreach($fechasCierres as $fecha)
                    <option value="{{ $fecha->fecha_cierre }}">{{ \Carbon\Carbon::parse($fecha->fecha_cierre)->format('d-m-Y') }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Ver Cierre</button>
    </form>
</div>
@endsection
