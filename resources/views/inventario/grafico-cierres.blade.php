@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gráfico de Cierres de Inventario</h1>

    <canvas id="graficoCierres" width="400" height="200"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const dataCierres = @json($dataCierres);

            // Preparar las fechas y los datos de las entradas y salidas
            const fechas = dataCierres.map(cierre => cierre.fecha);
            const totalEntradas = dataCierres.map(cierre => cierre.total_entradas);
            const totalSalidas = dataCierres.map(cierre => cierre.total_salidas);

            // Crear gráfico usando Chart.js
            const ctx = document.getElementById('graficoCierres').getContext('2d');
            const graficoCierres = new Chart(ctx, {
                type: 'line', // O 'bar' si prefieres barras
                data: {
                    labels: fechas, // Fechas de los cierres
                    datasets: [
                        {
                            label: 'Total Entradas',
                            data: totalEntradas,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 1
                        },
                        {
                            label: 'Total Salidas',
                            data: totalSalidas,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</div>
@endsection
