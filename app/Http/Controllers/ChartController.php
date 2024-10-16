<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index()
    {
        // Ejemplo de datos que se enviarán al gráfico
        $productos = ['Producto A', 'Producto B', 'Producto C', 'Producto D'];
        $cantidades = [150, 200, 100, 300];

        // Enviar los datos a la vista
        return view('grafico.chart', compact('productos', 'cantidades'));
    }
}
