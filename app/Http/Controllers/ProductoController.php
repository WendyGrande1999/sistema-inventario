<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Category;
use App\Models\Entrada;
use App\Models\Salida;
use Illuminate\Http\Request;

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

    return response()->json(['existencia' => $existenciaActual]);
}

public function stockReport()
{
    $productos = Producto::with(['entradas', 'salidas'])->get();

    $data = $productos->map(function ($producto) {
        $cantidadEntradas = $producto->entradas->sum('cantidad');
        $cantidadSalidas = $producto->salidas->sum('cantidad');
        $stock = $cantidadEntradas - $cantidadSalidas;

        return [
            'codigo' => $producto->codigo,
            'nombre_producto' => $producto->nombre,
            'cantidad_entradas' => $cantidadEntradas,
            'cantidad_salidas' => $cantidadSalidas,
            'stock' => $stock,
        ];
    });

    return view('productos.stock', compact('data'));
}


}
