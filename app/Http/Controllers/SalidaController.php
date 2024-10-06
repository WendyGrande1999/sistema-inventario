<?php

namespace App\Http\Controllers;

use App\Models\Salida;
use App\Models\Category;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

class SalidaController extends Controller
{
    public function index()
    {
        $salidas = Salida::with('producto', 'usuario')->get();
        return view('salidas.index', compact('salidas'));
    }

    public function create()
    {
        $productos = Producto::all();
        $categorias = Category::all();
        $user = auth()->user();
        return view('salidas.create', compact('productos', 'user', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_salida' => 'required|date',
            'idproducto' => 'required|exists:productos,id',
            'unidad_medida' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'idusuario' => 'required|exists:users,id',
        ]);

        
            // Convertir la fecha a formato Carbon
         $fecha_salida = Carbon::parse($request->input('fecha_salida'));

       

        Salida::create([
            'fecha_salida' => $fecha_salida,
            'idproducto' => $request->input('idproducto'),
            'idusuario' => $request->input('idusuario'),
            'unidad_medida' => $request->input('unidad_medida'),
            'cantidad' => $request->input('cantidad'),
        ]);

        return redirect()->route('salidas.index')->with('success', 'Salida registrada exitosamente.');
    }

    public function show(Salida $salida)
    {
        return view('salidas.show', compact('salida'));
    }

    public function edit(Salida $salida)
    {
        $productos = Producto::all();
        return view('salidas.edit', compact('salida', 'productos'));
    }

    public function update(Request $request, Salida $salida)
    {
        $request->validate([
            'fecha_salida' => 'required|date',
            'cantidad' => 'required|integer|min:1',
        ]);

        try {
            
            $salida->update([
               'fecha_salida' => $request->input('fecha_salida'),
                'cantidad' => $request->input('cantidad'),
                
            ]);

            return redirect()->route('salidas.index')->with('success', 'Salida actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la salida: ' . $e->getMessage());
        }

    }

    public function destroy(Salida $salida)
    {
        $salida->delete();

        return redirect()->route('salidas.index')->with('success', 'Salida eliminada exitosamente.');
    }

    public function getProductosByCategoria($category_id)
    {
     $productos = Producto::where('category_id', $category_id)->get();
     return response()->json($productos);
    }
}

