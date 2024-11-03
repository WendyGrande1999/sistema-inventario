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

    public function generarPdfPorFechas(Request $request)
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
        $stockActual = $cantidadEntradas - $cantidadSalidas;

        // Calcular costo total de entradas
        $costoPorProducto = $entradasProducto->sum(function ($entrada) {
            return $entrada->cantidad_entrante * $entrada->precio_unidad;
        });

        // Calcular total egreso
        $totalEgreso = $entradasProducto->sum(function ($entrada) {
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

    // Pasar los datos a la vista para el PDF
    $fechaInicioTexto = $fechaInicio->format('d-m-Y');
    $fechaCierreTexto = $fechaCierre->format('d-m-Y');

    try {
        $pdf = PDF::loadView('reportes_pdf.pdf_porfechas', [
            'reporte' => $reporte,
            'fechaInicioTexto' => $fechaInicioTexto,
            'fechaCierreTexto' => $fechaCierreTexto,
            'totalEntradas' => $totalEntradas,
            'totalSalidas' => $totalSalidas,
            'totalCosto' => $totalCosto,
            'totalEgresos' => $totalEgresos,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Reporte_Por_Fechas_' . $fechaInicio->format('Y_m_d') . '_a_' . $fechaCierre->format('Y_m_d') . '.pdf');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
    }
}

    public function generarPdfDia($fechaTexto)
    {
        try {
            $fecha = Carbon::parse($fechaTexto);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Fecha inválida proporcionada.');
        }

        // Filtrar productos con entradas registradas en la fecha especificada
        $productos = Producto::whereHas('entradas', function ($query) use ($fecha) {
            $query->whereDate('fecha_ingreso', $fecha->format('Y-m-d'));
        })->get();

        if ($productos->isEmpty()) {
            return redirect()->back()->with('error', 'No se encontraron registros para la fecha especificada.');
        }

        $reportData = [];
        foreach ($productos as $producto) {
            $entradas = $producto->entradas()->whereDate('fecha_ingreso', $fecha->format('Y-m-d'))->get();

            $totalEntradas = 0;
            $totalSalidas = 0;
            $totalStock = 0;
            $totalSaldoCompra = 0;
            $precioCompraSum = 0;

            $entradasData = $entradas->map(function ($entrada) use (&$totalEntradas, &$totalSalidas, &$totalStock, &$totalSaldoCompra, &$precioCompraSum) {
                $salidas = $entrada->salidas->sum('cantidad');
                $stock = $entrada->cantidad;

                $fechaIngreso = is_string($entrada->fecha_ingreso) ? Carbon::parse($entrada->fecha_ingreso) : $entrada->fecha_ingreso;

                $totalEntradas += $entrada->cantidad_entrante;
                $totalSalidas += $salidas;
                $totalStock += $stock;
                $totalSaldoCompra += $entrada->saldo_compra;
                $precioCompraSum += $entrada->precio_unidad;

                return [
                    'fecha_ingreso' => $fechaIngreso->format('d-m-Y'),
                    'proveedor' => $entrada->proveedor->name ?? 'Proveedor no asignado',
                    'entradas' => $entrada->cantidad_entrante,
                    'salidas' => $salidas,
                    'stock' => $stock,
                    'unidad_medida' => $entrada->unidad_medida,
                    'precio_compra' => $entrada->precio_unidad,
                    'saldo_compra' => $entrada->saldo_compra,
                ];
            });

            $promedioPrecioCompra = $entradas->count() > 0 ? $precioCompraSum / $entradas->count() : 0;

            $data[] = [
                      'fecha' => $fecha->format('d-m-Y'),
                'nombre_producto' => $producto->nombre,
                'codigo' => $producto->codigo,
                'promedioPrecioCompra' => $promedioPrecioCompra,
                'totalSaldoCompra' => $totalSaldoCompra,
                'totalStock' => $totalStock,
                'entradas' => $entradasData,
                'totalEntradas' => $totalEntradas,
                'totalSalidas' => $totalSalidas,
            ];
        }

        $data = [
            'fecha' => $fecha->format('d-m-Y'),
            'productos' => $reportData,
        ];

        try {
            $pdf = PDF::loadView('reportes_pdf.pdf_diario', $data);
            return $pdf->download('Reporte_Diario_' . $fecha->format('Y_m_d') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al generar el PDF.');
        }
    }

    public function generarPdfDia2($fechaTexto)
    {
        // Validar y formatear la fecha ingresada
        try {
            $fecha = Carbon::parse($fechaTexto);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Fecha inválida proporcionada.');
        }

        // Filtrar productos con entradas registradas en la fecha especificada
        $productos = Producto::whereHas('entradas', function ($query) use ($fecha) {
            $query->whereDate('fecha_ingreso', $fecha->format('Y-m-d'));
        })->get();

        // Verificar si existen registros para la fecha
        if ($productos->isEmpty()) {
            return redirect()->back()->with('error', 'No se encontraron registros para la fecha especificada.');
        }

        // Estructurar datos para el reporte
        $reportData = [];
        foreach ($productos as $producto) {
            $entradas = $producto->entradas()->whereDate('fecha_ingreso', $fecha->format('Y-m-d'))->get();

            // Calcular totales
            $totalEntradas = $entradas->sum('cantidad_entrante');
            $totalSalidas = $entradas->flatMap->salidas->sum('cantidad');
            $totalSaldoCompra = $entradas->sum('saldo_compra');
            $totalStock = $totalEntradas - $totalSalidas;

            // Preparar datos de entradas
            $entradasData = $entradas->map(function ($entrada) {
                return [
                    'fecha_ingreso' => Carbon::parse($entrada->fecha_ingreso)->format('d-m-Y'),
                    'proveedor' => $entrada->proveedor->name ?? 'Proveedor no asignado',
                    'entradas' => $entrada->cantidad_entrante,
                    'salidas' => $entrada->salidas->sum('cantidad'),
                    'stock' => $entrada->cantidad_entrante - $entrada->salidas->sum('cantidad'),
                    'unidad_medida' => $entrada->unidad_medida,
                    'precio_compra' => $entrada->precio_unidad,
                    'saldo_compra' => $entrada->saldo_compra,
                ];
            });

            // Promedio de precio de compra
            $promedioPrecioCompra = $entradas->count() > 0 ? $entradas->avg('precio_unidad') : 0;

            $reportData[] = [
                'fecha' => $fecha->format('d-m-Y'),
                'nombre_producto' => $producto->nombre,
                'codigo' => $producto->codigo,
                'promedioPrecioCompra' => $promedioPrecioCompra,
                'totalSaldoCompra' => $totalSaldoCompra,
                'totalStock' => $totalStock,
                'entradas' => $entradasData,
                'totalEntradas' => $totalEntradas,
                'totalSalidas' => $totalSalidas,
            ];
        }

        // Generar y descargar PDF
        try {
            $pdf = PDF::loadView('reportes_pdf.pdf_diario',  $reportData);
            return $pdf->download('Reporte_Diario_' . $fecha->format('Y_m_d') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }


}

