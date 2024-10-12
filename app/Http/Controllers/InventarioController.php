<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Entrada;
use App\Models\CierreInventario;
use Carbon\Carbon;

class InventarioController extends Controller
{
    // Mostrar la vista del cierre manual con el stock desde el último cierre
    public function mostrarCierreManual()
    {
        // Obtener todos los productos
        $productos = Producto::with('entradas', 'cierresInventario')->get();

        // Crear un arreglo para almacenar los productos con el stock desde el último cierre
        $dataProductos = $productos->map(function ($producto) {
            // Obtener el último cierre de este producto
            $ultimoCierre = $producto->cierresInventario()->latest('fecha_cierre')->first();

            // Si no hay un cierre, tomamos todas las entradas antes del inicio del año
            $stockUltimoCierre = $ultimoCierre ? $ultimoCierre->cantidad_total : 0;

            // Calcular el stock total actual desde el último cierre
            $stockTotalActual = $producto->entradas()
                ->where('estado', 'activo')
                ->whereDate('fecha_ingreso', '>', $ultimoCierre ? $ultimoCierre->fecha_cierre : Carbon::now()->startOfYear())
                ->sum('cantidad');

            return [
                'codigo' => $producto->codigo,
                'nombre' => $producto->nombre,
                'stockTotalActual' => $stockTotalActual,
                'stockUltimoCierre' => $stockUltimoCierre,
            ];
        });

        // Pasar los datos a la vista
        return view('inventario.cierre-manual', ['dataProductos' => $dataProductos]);
    }

    // Generar el cierre manual
    public function generarCierreManual(Request $request)
    {
        // Definir la fecha del cierre (fecha actual)
        $fechaCierre = Carbon::now();
        $fechaSiguiente = $fechaCierre->copy()->addDay(); // Fecha del día siguiente al cierre
    
        // Obtener todos los productos
        $productos = Producto::all();
    
        // Iterar sobre los productos para generar el cierre de inventario
        foreach ($productos as $producto) {
            // Calcular el stock actual del producto (sumando las cantidades de todas las entradas activas)
            $stockActual = $producto->entradas->sum('cantidad');
    
            // Guardar el cierre de inventario en la tabla cierres_inventario
            CierreInventario::create([
                'producto_id' => $producto->id,
                'cantidad_total' => $stockActual, // Stock actual
                'fecha_cierre' => $fechaCierre,   // Fecha de cierre
            ]);
    
            // Obtener las entradas activas (cantidad > 0)
            $entradasActivas = Entrada::where('idproducto', $producto->id)
                ->where('cantidad', '>', 0) // Solo las entradas que tienen cantidad disponible
                ->get();
    
            // Actualizar la fecha de las entradas activas al día siguiente
            foreach ($entradasActivas as $entrada) {
                $entrada->fecha_ingreso = $fechaSiguiente;
                $entrada->save();
            }
        }
    
        // Redirigir al usuario con un mensaje de éxito
        return redirect()->route('inventario.cierre-manual')->with('success', 'Cierre de inventario generado correctamente. Las entradas activas se han actualizado.');
    }

    public function mostrarCierres()
{
    // Obtener todas las fechas de los cierres
    $fechasCierres = CierreInventario::select('fecha_cierre')->distinct()->get();

    // Retornar la vista con las fechas de los cierres
    return view('inventario.cierres', compact('fechasCierres'));
}

public function obtenerCierrePorFecha(Request $request)
{
    // Validar la fecha seleccionada
    $request->validate([
        'fecha_cierre' => 'required|date',
    ]);

    // Obtener todos los productos del cierre seleccionado
    $productosCierre = CierreInventario::where('fecha_cierre', $request->fecha_cierre)
        ->with('producto') // Relación con la tabla de productos
        ->get();

    // Retornar la vista con los productos del cierre
    return view('inventario.cierre-detalle', compact('productosCierre'));
}

public function mostrarEntradasPorCierre(Request $request)
{
    // Establecer el idioma español en Carbon
    Carbon::setLocale('es');
    // Obtener la fecha de cierre seleccionada por el usuario
    $fechaCierre = $request->input('fecha_cierre');

    if (!$fechaCierre) {
        return redirect()->back()->with('error', 'No se encontró el cierre seleccionado.');
    }

    // Obtener los productos que tienen un registro de cierre en la fecha seleccionada
    $productosCierre = CierreInventario::with('producto')
        ->where('fecha_cierre', $fechaCierre)
        ->get();

    // Obtener el último cierre antes del seleccionado
    $ultimoCierre = CierreInventario::where('fecha_cierre', '<', $fechaCierre)
        ->orderBy('fecha_cierre', 'desc')
        ->first();

    // Obtener el siguiente cierre después del seleccionado (si existe)
    $siguienteCierre = CierreInventario::where('fecha_cierre', '>', $fechaCierre)
        ->orderBy('fecha_cierre', 'asc')
        ->first();

    // Fecha del siguiente cierre o la fecha actual si no hay siguiente cierre
    $fechaSiguienteCierre = $siguienteCierre ? $siguienteCierre->fecha_cierre : Carbon::now();

    // Agrupar la información de cada producto con sus entradas, salidas y stock en la fecha del cierre
    $productosDetalle = $productosCierre->map(function ($cierre) use ($ultimoCierre, $fechaSiguienteCierre) {
        // Si no hay un último cierre, es la primera vez que se cierra, sumamos todas las entradas hasta la fecha de cierre
        if (!$ultimoCierre) {
            $entradas = $cierre->producto->entradas->where('fecha_ingreso', '<=', $cierre->fecha_cierre)->sum('cantidad_entrante');
            $salidas = $cierre->producto->entradas->where('fecha_ingreso', '<=', $cierre->fecha_cierre)->sum('salida');
        } else {
            // Si hay un último cierre, sumamos las entradas y salidas entre el último cierre y el cierre actual
            $entradas = $cierre->producto->entradas->whereBetween('fecha_ingreso', [$ultimoCierre->fecha_cierre, $cierre->fecha_cierre])->sum('cantidad_entrante');
            $salidas = $cierre->producto->entradas->whereBetween('fecha_ingreso', [$ultimoCierre->fecha_cierre, $cierre->fecha_cierre])->sum('salida');
        }

        // El stock se basa en la cantidad que quedó después de las salidas (actualizado)
        $stockSaliente = $cierre->cantidad_total; // Tomamos el stock del cierre de la tabla cierre_inventario

        return [
            'codigo' => $cierre->producto->codigo,
            'nombre' => $cierre->producto->nombre,
            'entradas' => $entradas,
            'salidas' => $salidas,
            'stock_saliente' => $stockSaliente,
        ];
    });

    // Formato de las fechas en letras para la vista
    $fechaInicioTexto = $ultimoCierre ? \Carbon\Carbon::parse($ultimoCierre->fecha_cierre)->translatedFormat('d F Y') : 'Primer Cierre';
    $fechaCierreTexto = \Carbon\Carbon::parse($fechaCierre)->translatedFormat('d F Y');
    // Retornar la vista con los productos y su información relacionada al cierre seleccionado
    return view('inventario.cierre-detalle', compact('productosDetalle', 'fechaCierre', 'fechaInicioTexto', 'fechaCierreTexto'));
}



    
}
