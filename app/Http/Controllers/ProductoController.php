<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Producto;
use App\Models\Category;
use App\Models\Entrada;
use App\Models\Salida;
use App\Models\CierreInventario;
use Illuminate\Http\Request;
use Carbon\Carbon;



class ProductoController extends Controller
{
    // Listar productos con sus categorías
    public function index()
    {
        $productos = Producto::with('category')->paginate(10);

        return view('productos.index', compact('productos'));
    }

    // Mostrar formulario para crear un nuevo producto
    public function create()
    {
        // Obtener todas las categorías para el formulario de creación
        $categories = Category::all();
        return view('productos.create', compact('categories'));
    }

    // Guardar un nuevo producto
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'codigo' => 'required|string|unique:productos,codigo|max:255',
            'unidad_medida' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Inicializa el nombre de la imagen
        $imageName = null;

        // Manejo de la subida de imagen
        if ($request->hasFile('imagen')) {
            $imageName = time() . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('images'), $imageName); // Mueve la imagen a la carpeta 'images'
        }

        // Crear el producto
        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'category_id' => $request->category_id,
            'codigo' => $request->codigo,
            'unidad_medida' => $request->unidad_medida,
            'imagen' => $imageName ? 'images/' . $imageName : null, // Guarda la ruta relativa o null si no se subió una imagen
        ]);

        // Redirigir a la lista de productos
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function generarPdf($codigo)
    {
    $entrada = Entrada::with(['producto', 'proveedor', 'usuario'])->findOrFail($codigo);
    $pdf = PDF::loadView('reportes_pdf.pdf', compact('reportes'));

    return $pdf->download('reporte por producto_' . $codigo . '.pdf');
    }
    // Mostrar un producto específico
    public function show(Producto $producto)
    {
        // Mostrar la vista del producto con sus datos
        return view('productos.show', compact('producto'));
    }

    // Mostrar formulario para editar un producto existente
    public function edit(Producto $producto)
    {
        // Obtener todas las categorías para el formulario de edición
        $categories = Category::all();
        return view('productos.edit', compact('producto', 'categories'));
    }

    // Actualizar un producto existente
    public function update(Request $request, Producto $producto)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'codigo' => 'required|string|unique:productos,codigo,' . $producto->id . '|max:255', // Asegurar que sea único, excepto el propio registro
            'unidad_medida' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la imagen
        ]);

        // Manejo de la subida de imagen
        if ($request->hasFile('imagen')) {
            $imageName = time() . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('images'), $imageName);
        } else {
            $imageName = $producto->imagen; // Mantener la imagen actual si no se subió una nueva
        }

        // Actualizar el producto
        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'category_id' => $request->category_id,
            'codigo' => $request->codigo,
            'unidad_medida' => $request->unidad_medida,
            'imagen' => $imageName,
        ]);

        // Redirigir a la lista de productos
        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    // Eliminar un producto existente
    public function destroy(Producto $producto)
    {
        // Verificar si el producto está asociado a alguna entrada
        $entradasCount = $producto->entradas()->count();

        if ($entradasCount > 0) {
            return redirect()->route('productos.index')->with('error', 'No se puede eliminar este producto porque está asociado a una o más entradas.');
        }

        try {
            // Eliminar el producto
            $producto->delete();

            // Redirigir a la lista de productos
            return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            // Puedes mostrar el mensaje de error detallado para depuración
            return redirect()->route('productos.index')->with('error', 'Error al intentar eliminar el producto: ' . $e->getMessage());
        }
    }
    public function getProducto($id)
{
    $producto = Producto::find($id);
    if ($producto) {
        return response()->json($producto);
    }
    return response()->json(null, 404);
}

public function getExistencia($id)
{
    // Sumar todas las entradas del producto
    $totalEntradas = Entrada::where('idproducto', $id)->sum('cantidad');

    // Sumar todas las salidas del producto
    $totalSalidas = Salida::where('idproducto', $id)->sum('cantidad');

    // Calcular la existencia actual
    $existenciaActual = $totalEntradas - $totalSalidas;


    return view('salidas.create', ['existencia' => $existenciaActual]);

}

public function stockReport(Request $request)
{
    // Establecer el idioma español en Carbon
    Carbon::setLocale('es');
    // Obtener todos los productos con sus entradas, salidas y cierres de inventario
    $productos = Producto::with(['entradas', 'salidas', 'cierresInventario'])->get();

    // Obtener el último cierre realizado
    $ultimoCierree = CierreInventario::latest('fecha_cierre')->first();

    // Formatear la fecha del último cierre (puedes cambiar el formato según lo que necesites)

    $fechaUltimoCierre = $ultimoCierree ? Carbon::parse($ultimoCierree->fecha_cierre)->translatedFormat('l d F Y') : 'No hay cierres anteriores';

    // Mapear la data de cada producto

    $data = $productos->map(function ($producto) {
        // Obtener el último cierre manual
        $ultimoCierre = $producto->cierresInventario()->latest('fecha_cierre')->first();

        // Calcular las cantidades de las entradas posteriores al último cierre
        $cantidadEntradasDesdeCierre = $producto->entradas()
            ->whereDate('fecha_ingreso', '>', $ultimoCierre ? $ultimoCierre->fecha_cierre : Carbon::now()->startOfYear())
            ->sum('cantidad_entrante');

        // Calcular las cantidades de las salidas posteriores al último cierre
        $cantidadSalidasDesdeCierre = $producto->entradas()
            ->whereDate('fecha_ingreso', '>', $ultimoCierre ? $ultimoCierre->fecha_cierre : Carbon::now()->startOfYear())
            ->sum('salida');

        // Si no hay cierre, consideramos que el stock es el total de todas las entradas antes de este año
        $stockUltimoCierre = $ultimoCierre ? $ultimoCierre->cantidad_total : 0;

        // Stock total = stock del último cierre + entradas - salidas desde el último cierre


          // Calcular el stock total sumando el campo 'cantidad' de las entradas activas después del último cierre
        $stockTotalActual = $producto->entradas()
        ->where('estado', 'activo')
        ->whereDate('fecha_ingreso', '>', $ultimoCierre ? $ultimoCierre->fecha_cierre : Carbon::now()->startOfYear())
        ->sum('cantidad'); // Sumamos el campo 'cantidad' que se actualiza en función de las salidas// Solo las entradas activas

         $stockTotal = $stockUltimoCierre + $stockTotalActual;
        return [
            'codigo' => $producto->codigo,
            'nombre_producto' => $producto->nombre,
            'stock_ultimo_cierre' => $stockUltimoCierre,
            'cantidad_entradas_desde_cierre' => $cantidadEntradasDesdeCierre,
            'cantidad_salidas_desde_cierre' => $cantidadSalidasDesdeCierre,
            'stockTotalActual' => $stockTotalActual,
            'stock_total' => $stockTotal,
            'unidad_medida' => $producto->unidad_medida,
        ];
    });

    // Retornar la vista con los datos del reporte de stock
    return view('inventario.stock', [
        'data' => $data,
        'fechaUltimoCierre' => $fechaUltimoCierre // Pasar la variable correctamente
    ]);
}

// Método para mostrar el formulario de selección de producto
public function seleccionarProducto()
{
    // Obtener todos los productos
    $productos = Producto::all();

    return view('reportes.select', compact('productos'));
}

// Método para mostrar el detalle del producto
public function mostrarDetalleProducto(Request $request)
{
    // Verificar si se seleccionó un producto
    $productoSeleccionado = $request->input('idproducto');

    if ($productoSeleccionado) {
        // Cargar el producto seleccionado con sus entradas y salidas
        $producto = Producto::with(['entradas', 'entradas.proveedor', 'entradas.salidas'])->findOrFail($productoSeleccionado);

        $entradas = [];
        $totalEntradas = 0;
        $totalSalidas = 0;
        $totalStock = 0;
        $totalSaldoCompra = 0;
        $precioCompraSum = 0;
        $cantidadEntradas = 0;

        // Obtener el nombre del producto
        $nombre_producto = $producto->nombre;
        $codigo = $producto->codigo;
        // Obtener las entradas del producto

           $entradas = $producto->entradas->map(function($entrada) use (&$totalEntradas, &$totalSalidas, &$totalStock, &$totalSaldoCompra, &$precioCompraSum, &$cantidadEntradas) {
            $salidas = $entrada->salidas->sum('cantidad'); // Sumar todas las salidas de esa entrada
            $stock = $entrada->cantidad; // El stock es el campo que se actualiza automáticamente

            // Acumular los totales
            $totalEntradas += $entrada->cantidad_entrante;
            $totalSalidas += $salidas;
            $totalStock += $stock;
            $totalSaldoCompra += $entrada->saldo_compra;
            $precioCompraSum += $entrada->precio_unidad; // Sumar los precios para calcular el promedio
            $cantidadEntradas++; // Para contar el número de entradas y calcular el promedio

            return [
                'fecha_ingreso' => $entrada->fecha_ingreso,
                'descripcion' => $entrada->producto->descripcion,
                'proveedor' => $entrada->proveedor->name,
                'entradas' => $entrada->cantidad_entrante,
                'salidas' => $salidas,
                'stock' => $stock,
                'unidad_medida' => $entrada->unidad_medida,
                'precio_compra' => $entrada->precio_unidad,
                'saldo_compra' => $entrada->saldo_compra,
            ];
        });

        // Calcular el promedio del precio de compra
        $promedioPrecioCompra = $cantidadEntradas > 0 ? $precioCompraSum / $cantidadEntradas : 0;

        return view('reportes.detalle', compact('producto', 'entradas', 'totalEntradas', 'totalSalidas', 'totalStock', 'promedioPrecioCompra', 'totalSaldoCompra', 'nombre_producto', 'codigo'));
    }

    // Redirigir de vuelta si no se seleccionó un producto
    return redirect()->route('reportes.seleccionar')->with('error', 'Debe seleccionar un producto.');
}

public function obtenerExistenciaa($id)
{
   

       // Sumar todas las cantidades de entradas para obtener el stock total
       $stockTotal = Entrada::where('idproducto', $id)->sum('cantidad');

       // Devuelve el stock total en formato JSON
       return response()->json(['stock_total' => $stockTotal]);
}





}
