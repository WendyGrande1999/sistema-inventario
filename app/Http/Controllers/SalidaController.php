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
        // Obtener solo las salidas con estado 'activo'
        $salidasInactivass = Salida::where('estado', 'inactivo')->get();
        $salidasActivass = Salida::where('estado', 'activo')->get();
        $salidasActivas = Salida::all();
        // Pasar las salidas activas a la vista
        return view('salidas.index', compact('salidasActivass', 'salidasInactivass'));
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
    
        // Registrar la nueva salida en la tabla 'salida' y almacenar la salida creada
        $salida = Salida::create([
            'fecha_salida' => $fecha_salida,
            'idproducto' => $request->input('idproducto'),
            'identrada' => $request->input('identrada'), // Aquí estás guardando el identrada
            'idusuario' => $request->input('idusuario'),
            'unidad_medida' => $request->input('unidad_medida'),
            'cantidad' => $request->input('cantidad'),
            'estado' => 'activo', // Estado inicial de la salida como 'activo'
        ]);
    
        // Actualizar los campos 'cantidad' y 'salida' en la tabla 'entrada'
        $entrada->cantidad -= $request->cantidad; // Reducir la cantidad de la entrada
        $entrada->salida += $request->cantidad;   // Sumar la cantidad de salida al campo 'salida'
    
        // Verificar si la cantidad llega a 0, y cambiar el estado de la entrada a "inactivo"
        if ($entrada->cantidad == 0) {
            $entrada->estado = 'inactivo';  // Cambiar el estado de la entrada a inactivo
            $salida->estado = 'inactivo';   // Cambiar el estado de la salida a inactivo
            $salida->save();                // Guardar el estado actualizado de la salida
        }
    
        // Guardar la entrada actualizada (siempre se guarda, independientemente de la cantidad)
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
            // Obtener la entrada relacionada a esta salida
            $entrada = Entrada::findOrFail($salida->identrada);
    
            // Calcular la diferencia entre la nueva cantidad y la cantidad original de la salida
            $diferencia = $request->cantidad - $salida->cantidad;
    
            // Verificar si la diferencia es válida (que no exceda la cantidad disponible en la entrada)
            if ($diferencia > $entrada->cantidad) {
                return redirect()->back()->withErrors('La nueva cantidad de salida excede la cantidad disponible en la entrada.');
            }
    
            // Actualizar los campos en la entrada
            $entrada->cantidad -= $diferencia; // Reducir la cantidad disponible según la diferencia
            $entrada->salida += $diferencia;   // Ajustar el total del campo 'salida'
    
            // Verificar si la cantidad llega a 0, y cambiar el estado de la entrada a "inactivo"
            if ($entrada->cantidad == 0) {
                $entrada->estado = 'inactivo'; // Marcar la entrada como inactiva
                $salida->estado = 'inactivo';  // Marcar también la salida como inactiva
            }
    
            // Guardar los cambios en la entrada
            $entrada->save();
    
            // Actualizar los datos de la salida
            $salida->update([
                'fecha_salida' => $request->input('fecha_salida'),
                'cantidad' => $request->input('cantidad'),
            ]);
    
            return redirect()->route('salidas.index')->with('success', 'Salida actualizada exitosamente. La entrada ha sido actualizada.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la salida: ' . $e->getMessage());
        }
    }
    

  
    public function destroy(Salida $salida) 
{
    // Buscar la entrada asociada a la salida que se va a eliminar
    $entrada = Entrada::find($salida->identrada);

    if ($entrada) {
        // Restar la cantidad de la salida de los campos correspondientes en la entrada
        $entrada->salida -= $salida->cantidad;
        $entrada->cantidad += $salida->cantidad; // Se suma la cantidad de la salida eliminada de vuelta al stock existente
        // Verificar si la entrada debe estar activa nuevamente
        if ($entrada->cantidad > 0) {
            $entrada->estado = 'activo'; // Cambiar el estado a activo si la cantidad es mayor a 0
        }
       
        // Guardar los cambios en la entrada
        $entrada->save();
    }

    // Eliminar la salida
    $salida->delete();

    return redirect()->route('salidas.index')->with('success', 'Salida eliminada exitosamente.');
}

    public function getProductosByCategoria($category_id)
    {
     $productos = Producto::where('category_id', $category_id)->get();
     return response()->json($productos);
    }
}

