@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gráfico de Productos</h1>
    <canvas id="miGrafico"></canvas>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Obtener los datos del backend
    const productos = @json($productos);
    const cantidades = @json($cantidades);

    // Configurar el gráfico
    const ctx = document.getElementById('miGrafico').getContext('2d');
    const miGrafico = new Chart(ctx, {
        type: 'bar', // Tipo de gráfico (puede ser 'bar', 'line', 'pie', etc.)
        data: {
            labels: productos,
            datasets: [{
                label: 'Cantidad de Productos',
                data: cantidades,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Productos en Inventario'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
