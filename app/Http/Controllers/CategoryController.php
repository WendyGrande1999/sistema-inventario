<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Entrada;
use App\Models\CierreInventario;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();


        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'nullable',
        ]);

        // Usar mass assignment con los campos permitidos en el modelo
        Category::create($request->only(['name', 'description']));

        return redirect()->route('categories.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable',
        ]);

        // Usar mass assignment con los campos permitidos en el modelo
        $category->update($request->only(['name', 'description']));

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Category $category)
    {

        try {
            $category->delete();

            return redirect()->route('categories.index')->with('success', 'Categoría eliminada exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('categories.index')->with('error', 'No se puede eliminar esta categoría porque está asociada a uno o más productos.');
        }
    }


    // Método de búsqueda
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Verifica si hay algún valor en el query antes de realizar la búsqueda
        if (empty($query)) {
            return response()->json(['message' => 'No se ha proporcionado una consulta.'], 400);
        }

        // Realiza la búsqueda
        $categories = Category::where('name', 'LIKE', "%{$query}%")
            ->orWhere('id', 'LIKE', "%{$query}%")
            ->get();

        // Verifica si hay resultados
        if ($categories->isEmpty()) {
            return response()->json(['message' => 'No se encontraron categorías.'], 404);
        }


        dd($categories);
        // Retorna la vista parcial con los resultados
        return view('categories.partials.search-results', compact('categories'));
    }


    public function buscar(Request $request)
    {
        $response = [
            "success" => false,
            "message" => "Hubo un error"
        ];
        if ($request->ajax()) {
            $data = Category::where("name", "like", $request->texto . "%")->take(10)->get();
            $response = [
                "success" => true,
                "message" => "Consulta Correcta",
                "data" => $data
            ];
        }
        return response()->json($response);
    }


    public function indexx()
    {
        return view("welcome");
    }

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

        // Redirigir al usuario con un de éxito
        return redirect()->route('partials.nav')->with('success', 'Cierre de inventario generado correctamente. Las entradas activas se han actualizado.');
    }
}
