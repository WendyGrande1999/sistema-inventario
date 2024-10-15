<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Entrada;
use App\Models\Salida;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function mostrarReporteDiario()
    {
        // Muestra la vista con el formulario de selección de fecha
        return view('reportes.diario');
    }

    public function generarReporteDiario(Request $request)
    {

        Carbon::setLocale('es');

        $request->validate([
            'fecha' => 'required|date',
        ]);

        // Convertir la fecha seleccionada a un formato Carbon
        $fechaSeleccionada = Carbon::createFromFormat('Y-m-d', $request->input('fecha'));

        // Obtener la fecha en texto con el día de la semana (Ejemplo: "sábado, 12 de octubre de 2024")
        $fechaTexto = $fechaSeleccionada->translatedFormat('l, d \d\e F \d\e Y');

        // Obtener todas las entradas y salidas del día seleccionado
        $entradas = Entrada::whereDate('fecha_ingreso', $fechaSeleccionada)->get();
        $salidas = Salida::whereDate('fecha_salida', $fechaSeleccionada)->get();

        // Crear un arreglo para el reporte diario
        $reporte = [];

        // Iterar sobre los productos
        $productos = Producto::all();
        foreach ($productos as $producto) {
            $entradasProducto = $entradas->where('idproducto', $producto->id);
            $salidasProducto = $salidas->where('idproducto', $producto->id);

            // Calcular las cantidades y los costos
            $cantidadEntradas = $entradasProducto->sum('cantidad_entrante');
            $cantidadStock = $entradasProducto->sum('cantidad');
            $cantidadSalidas = $entradasProducto->sum('salida');
            $costoPorProducto = $entradasProducto->sum(function ($entrada) {
                return $entrada->cantidad_entrante * $entrada->precio_unidad;
            });

            $totalEgreso = $entradasProducto->sum(function ($entrada) {
                return $entrada->salida * $entrada->precio_unidad;
            });

            $totalEgresooo = $salidasProducto->sum(function ($salida) use ($producto) {
                $entrada = $salida->entrada; // Obtener la entrada asociada
                return $salida->cantidad * $entrada->precio_unidad;
            });

            // Agregar los datos al reporte
            $reporte[] = [
                'codigo' => $producto->codigo,
                'producto' => $producto->nombre,
                'entradas' => $cantidadEntradas,
                'salidas' => $cantidadSalidas,
                'stock' => $cantidadStock,
                'unidad_medida' => $producto->unidad_medida,
                'costo_por_producto' => $costoPorProducto,
                'total_egreso' => $totalEgreso,
            ];
        }

        // Calcular los totales
        $totalEntradas = array_sum(array_column($reporte, 'entradas'));
        $totalSalidas = array_sum(array_column($reporte, 'salidas'));
        $totalCosto = array_sum(array_column($reporte, 'costo_por_producto'));
        $totalEgresos = array_sum(array_column($reporte, 'total_egreso'));

        // Enviar los datos a la vista
        return view('reportes.reporte-diario', compact('reporte', 'totalEntradas', 'totalSalidas', 'totalCosto', 'totalEgresos', 'fechaSeleccionada', 'fechaTexto'));
    }
}

