<?php

namespace App\Http\Controllers;

use App\Models\Salida;
use App\Models\Category;
use App\Models\Producto;
use App\Models\Entrada;
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
        $entradas = Entrada::all();
        $productos = Producto::all();
        $categorias = Category::all();
        $user = auth()->user();
        return view('salidas.create', compact('productos', 'user', 'categorias', 'entradas'));
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'fecha_salida' => 'required|date',
            'idproducto' => 'required|exists:productos,id',
            'identrada' => 'required|exists:entradas,id', // Referencia a la entrada
            'unidad_medida' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'idusuario' => 'required|exists:users,id',
        ]);
    
        // Obtener la entrada seleccionada
        $entrada = Entrada::findOrFail($request->identrada);
    
        // Verificar si la cantidad de salida es válida (no puede ser mayor a la cantidad disponible)
        if ($request->cantidad > $entrada->cantidad) {
            return redirect()->back()->withErrors('La cantidad de salida no puede ser mayor a la cantidad disponible en la entrada.');
        }
    
        // Convertir la fecha a formato Carbon
        $fecha_salida = Carbon::parse($request->input('fecha_salida'));
    
        // Registrar la nueva salida en la tabla 'salida'
        Salida::create([
            'fecha_salida' => $fecha_salida,
            'idproducto' => $request->input('idproducto'),
            'identrada' => $request->input('identrada'), // Aquí estás guardando el identrada
            'idusuario' => $request->input('idusuario'),
            'unidad_medida' => $request->input('unidad_medida'),
            'cantidad' => $request->input('cantidad'),
        ]);
    
        // Actualizar el campo 'cantidad' en la tabla 'entrada'
        $entrada->cantidad -= $request->cantidad;
    
        // Actualizar el campo 'salida' en la tabla 'entrada' sumando la nueva salida
        $entrada->salida += $request->cantidad;
    
        // Verificar si la cantidad llega a 0, y cambiar el estado a "inactivo"
        if ($entrada->cantidad == 0) {
            $entrada->estado = 'inactivo';
        }
    
        // Guardar la entrada actualizada
        $entrada->save();
    
        // Redirigir con mensaje de éxito
        return redirect()->route('salidas.index')->with('success', 'Salida registrada exitosamente. La entrada ha sido actualizada.');
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

