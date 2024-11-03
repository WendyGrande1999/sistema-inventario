<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
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

    public function seleccionarFechas()
    {
        return view('reportes.seleccionar-fechas');
    }


    // Método para generar el reporte basado en el rango de fechas

    public function generarReportePorFechas(Request $request)
    {
        // Validar las fechas
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_cierre' => 'required|date',
        ]);

        // Obtener las fechas
        $fechaInicio = Carbon::createFromFormat('Y-m-d', $request->input('fecha_inicio'));
        $fechaCierre = Carbon::createFromFormat('Y-m-d', $request->input('fecha_cierre'));

        // Obtener los productos
        $productos = Producto::all();

        // Crear el arreglo para el reporte
        $reporte = [];

        foreach ($productos as $producto) {
            // Obtener las entradas y salidas en el rango de fechas
            $entradasProducto = Entrada::where('idproducto', $producto->id)
                ->whereBetween('fecha_ingreso', [$fechaInicio, $fechaCierre])
                ->get();





            // Calcular totales
            $cantidadEntradas = $entradasProducto->sum('cantidad_entrante');
            $cantidadSalidas = $entradasProducto->sum('salida');
            $stockActual = $entradasProducto->sum('cantidad');

            $stockActualll = $cantidadEntradas - $cantidadSalidas;

            // Calcular costo total de entradas
            $costoPorProducto = $entradasProducto->sum(function ($entrada) {
                return $entrada->cantidad_entrante * $entrada->precio_unidad;
            });

            // Calcular total egreso
            $totalEgreso = $entradasProducto->sum(function ($entrada) use ($producto) {

                return $entrada->salida * $entrada->precio_unidad;
            });

            // Agregar los datos al reporte
            $reporte[] = [
                'codigo' => $producto->codigo,
                'producto' => $producto->nombre,
                'entradas' => $cantidadEntradas,
                'salidas' => $cantidadSalidas,
                'stock' => $stockActual,
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

        // Pasar los datos a la vista
        $fechaInicioTexto = $fechaInicio->format('d-m-Y');
        $fechaCierreTexto = $fechaCierre->format('d-m-Y');

        return view('reportes.reporte-por-fechas', compact('reporte', 'fechaInicioTexto', 'fechaCierreTexto', 'totalEntradas', 'totalSalidas', 'totalCosto', 'totalEgresos'));
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

public function generarPdfDia($fechaTexto)
{
    Carbon::setLocale('es');

    // Define el formato exacto de la fecha que estás recibiendo
    $formato = 'l, d \d\e F \d\e Y';

    // Convertir la fecha de texto a un objeto Carbon
    try {
        $fechaSeleccionada = Carbon::createFromFormat($formato, $fechaTexto);
    } catch (\Exception $e) {
        return back()->withErrors(['fecha' => 'Formato de fecha no válido.']);
    }

    // Obtener los datos de entradas y salidas para la fecha seleccionada
    $entradas = Entrada::whereDate('fecha_ingreso', $fechaSeleccionada)->get();
    $salidas = Salida::whereDate('fecha_salida', $fechaSeleccionada)->get();

    if ($entradas->isEmpty() && $salidas->isEmpty()) {
        return back()->withErrors(['reporte' => 'No se encontraron datos para la fecha seleccionada.']);
    }

    // Generar el reporte basado en las entradas y salidas
    $reporte = [];
    $productos = Producto::all();
    foreach ($productos as $producto) {
        $entradasProducto = $entradas->where('idproducto', $producto->id);
        $salidasProducto = $salidas->where('idproducto', $producto->id);

        $cantidadEntradas = $entradasProducto->sum('cantidad_entrante');
        $cantidadSalidas = $salidasProducto->sum('cantidad');
        $stock = $producto->stock_actual; // o ajusta según tu lógica

        $costoPorProducto = $entradasProducto->sum(function ($entrada) {
            return $entrada->cantidad_entrante * $entrada->precio_unidad;
        });

        $totalEgreso = $salidasProducto->sum(function ($salida) {
            return $salida->cantidad * $salida->precio_unidad;
        });

        $reporte[] = [
            'codigo' => $producto->codigo,
            'producto' => $producto->nombre,
            'entradas' => $cantidadEntradas,
            'salidas' => $cantidadSalidas,
            'stock' => $stock,
            'unidad_medida' => $producto->unidad_medida,
            'costo_por_producto' => $costoPorProducto,
            'total_egreso' => $totalEgreso,
        ];
    }

    // Calcular totales
    $totalEntradas = array_sum(array_column($reporte, 'entradas'));
    $totalSalidas = array_sum(array_column($reporte, 'salidas'));
    $totalCosto = array_sum(array_column($reporte, 'costo_por_producto'));
    $totalEgresos = array_sum(array_column($reporte, 'total_egreso'));

    // Generar el PDF
    $pdf = PDF::loadView('reportes.reporte-diario', compact(
        'reporte',
        'totalEntradas',
        'totalSalidas',
        'totalCosto',
        'totalEgresos',
        'fechaSeleccionada',
        'fechaTexto'
    ));

    // Descargar el PDF
    return $pdf->download('reporte_diario_' . $fechaTexto . '.pdf');
}

public function generarPDF3($codigo)
    {
        // Obtener los detalles del producto utilizando el código proporcionado
        $producto = Producto::where('codigo', $codigo)->first();

        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        // Lógica para calcular los detalles necesarios
        $entradas = $producto->entradas; // Suponiendo que tienes una relación definida en el modelo Producto
        $totalEntradas = $entradas->sum('cantidad_entrante');
        $totalSalidas = $entradas->sum('salidas');
        $totalStock = $totalEntradas - $totalSalidas;
        $totalSaldoCompra = $entradas->sum('saldo_compra');
        $precioCompraSum = $entradas->sum('precio_compra');
        $promedioPrecioCompra = $entradas->count() > 0 ? $precioCompraSum / $entradas->count() : 0;

        // Preparar datos para la vista PDF
        $data = [
            'nombre_producto' => $producto->nombre,
            'codigo' => $producto->codigo,
            'promedioPrecioCompra' => $promedioPrecioCompra,
            'totalSaldoCompra' => $totalSaldoCompra,
            'totalStock' => $totalStock,
            'entradas' => $entradas,
            'totalEntradas' => $totalEntradas,
            'totalSalidas' => $totalSalidas
        ];

        // Cargar la vista y generar el PDF
        $pdf = PDF::loadView('reportes_pdf.pdf-detalle', $data);

        // Descargar el PDF con un nombre dinámico basado en el producto
        return $pdf->download('detalle_producto_' . $producto->codigo . '.pdf');
    }



public function generarPDF2($codigo)
{
    // Verificar que el código se esté recibiendo correctamente
    if (!$codigo) {
        return redirect()->back()->with('error', 'No se proporcionó el código del producto.');
    }

    // Obtener los detalles del producto utilizando el código proporcionado
    $producto = Producto::where('codigo', $codigo)->first();

    if (!$producto) {
        return redirect()->back()->with('error', 'Producto no encontrado.');
    }

    // Obtener todas las entradas relacionadas con el producto
    $entradas = $producto->entradas; 

    // Inicializar variables para calcular los totales
    $totalEntradas = 0;
    $totalSalidas = 0;
    $totalStock = 0;
    $totalSaldoCompra = 0;
    $precioCompraSum = 0;

    // Mapear y procesar las entradas para enviar los datos correctamente al PDF
    $entradasData = $entradas->map(function ($entrada) use (&$totalEntradas, &$totalSalidas, &$totalStock, &$totalSaldoCompra, &$precioCompraSum) {
        // Obtener el total de salidas para esta entrada
        $salidas = $entrada->salidas->sum('cantidad'); 

        // Calcular el stock restante
        $stock = $entrada->cantidad; 

         // Convertir fecha_ingreso a Carbon si es un string para asegurar el formato correcto
        $fechaIngreso = is_string($entrada->fecha_ingreso) ? Carbon::parse($entrada->fecha_ingreso) : $entrada->fecha_ingreso;

        // Acumular los totales
        $totalEntradas += $entrada->cantidad_entrante;
        $totalSalidas += $salidas;
        $totalStock += $stock;
        $totalSaldoCompra += $entrada->saldo_compra;
        $precioCompraSum += $entrada->precio_unidad;

        // Devolver el array con los datos necesarios
        return [
            
            'fecha_ingreso' => $fechaIngreso->format('d-m-Y'), // Formatear fecha correctamente
     
            'proveedor' => $entrada->proveedor->name ?? 'Proveedor no asignado',
            'entradas' => $entrada->cantidad_entrante,
            'salidas' => $salidas,
            'stock' => $stock,
            'unidad_medida' => $entrada->unidad_medida,
            'precio_compra' => $entrada->precio_unidad,
            'saldo_compra' => $entrada->saldo_compra,
        ];
    });

    // Calcular el promedio del precio de compra
    $promedioPrecioCompra = $entradas->count() > 0 ? $precioCompraSum / $entradas->count() : 0;

    // Preparar datos para la vista PDF
    $data = [
        'nombre_producto' => $producto->nombre,
        'codigo' => $producto->codigo,
        'promedioPrecioCompra' => $promedioPrecioCompra,
        'totalSaldoCompra' => $totalSaldoCompra,
        'totalStock' => $totalStock,
        'entradas' => $entradasData, // Asegurarse de enviar el array de entradas procesado
        'totalEntradas' => $totalEntradas,
        'totalSalidas' => $totalSalidas
    ];

    // Cargar la vista y generar el PDF
    $pdf = PDF::loadView('reportes_pdf.pdf-detalle', $data);

    // Descargar el PDF con un nombre dinámico basado en el producto
    return $pdf->download('detalle_producto_' . $producto->codigo . '.pdf');
}

}

