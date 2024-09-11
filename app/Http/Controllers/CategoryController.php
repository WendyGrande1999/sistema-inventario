<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

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
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoría eliminada exitosamente.');
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


    public function buscar(Request $request){
        $response= [
            "success"=>false,
            "message"=>"Hubo un error"
        ];
        if($request->ajax()){
            $data = Category::where("name","like",$request->texto."%")->take(10)->get();
            $response= [
                "success"=>true,
                "message"=>"Consulta Correcta",
                "data"=>$data
            ];
        }
        return response()->json($response);
    }


    public function indexx(){
        return view("welcome");
      }


}
