<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Entrada;
use App\Models\CierreInventario;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $productos = \App\Models\Producto::with('entradas', 'cierresInventario')->get();
            $umbral = 10;
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
                    'unidad_medida' => $producto->unidad_medida,
                    'stockTotalActual' => $stockTotalActual,
                    'stockUltimoCierre' => $stockUltimoCierre,
                ];
            });

            // Filtrar productos por agotarse
            $productosAgotandose = $dataProductos->filter(function ($producto) use ($umbral) {
                return $producto['stockTotalActual'] < $umbral;
            });

            // Contar productos por agotarse correctamente
            $productosPorAgotarse = $productosAgotandose->count();

            // Calcular el stock restante de productos por agotarse
            $stockRestantePorAgotarse = $productosAgotandose->sum(function ($producto) {
                return $producto['stockTotalActual'];
            });
            // Pasar datos al 'nav'
            $view->with('productosPorAgotarse', $productosPorAgotarse)
                ->with('stockRestantePorAgotarse', $stockRestantePorAgotarse)
                ->with('produc', $productos)
                ->with('umbral', $umbral)
                ->with('dataProductos', $dataProductos);
        });
    }
    // Generar el cierre manual
    public function generarCierreManual(Request $request)
    {

        $request->validate([
            'fecha_cierre' => 'required|date',
        ]);

        $fechaCierre = $request->input('fecha_cierre');

        // Convertir la fecha de cierre a un objeto Carbon
        $fechaCierre = Carbon::createFromFormat('Y-m-d', $request->input('fecha_cierre'));
        $fechaSiguiente = $fechaCierre->copy()->addDay(); // Fecha del día siguiente


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
        return redirect()->route('partials.nav')->with('success', 'Cierre de inventario generado correctamente. Las entradas activas se han actualizado.');
    }

    public function mostrarCierres()
    {


        // Obtener todas las fechas de los cierres
        $fechasCierres = CierreInventario::select('fecha_cierre')->distinct()->get();

        // Retornar la vista con las fechas de los cierres
        return view('partials.nav', compact('fechasCierres'));
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
                'id' => $cierre->producto->id,  // Incluye el ID del producto
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
        return view('partials.nav', compact('productosDetalle', 'fechaCierre', 'fechaInicioTexto', 'fechaCierreTexto'));
    }

    public function mostrarCierreGrafico()
    {
        // Obtener todos los cierres de inventario
        $cierres = CierreInventario::with('producto')->get();

        // Preparar datos para la gráfica
        $dataCierres = $cierres->groupBy('fecha_cierre')->map(function ($cierre) {
            return [
                'fecha' => $cierre->first()->fecha_cierre,
                'total_entradas' => $cierre->sum('producto.entradas.sum.cantidad_entrante'),
                'total_salidas' => $cierre->sum('producto.entradas.sum.salida')
            ];
        });

        // Debug para ver el contenido de dataCierres
        // <- Esto mostrará los datos en el navegador

        return view('partials.nav', compact('dataCierres'));
    }
    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
