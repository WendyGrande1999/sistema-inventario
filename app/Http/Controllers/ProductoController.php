<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Listar productos con sus categorías
    public function index()
    {
        // Asegúrate de usar la relación correcta 'category'
        $productos = Producto::with('category')->get();
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
           
            'category_id' => 'required|exists:categories,id'
        ]);

        // Crear el producto
        Producto::create($request->all());

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
    
            'category_id' => 'required|exists:categories,id'
        ]);

        // Actualizar el producto
        $producto->update($request->all());

        // Redirigir a la lista de productos
        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    // Eliminar un producto
    public function destroy(Producto $producto)
    {
        // Eliminar el producto
        $producto->delete();

        // Redirigir a la lista de productos
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
