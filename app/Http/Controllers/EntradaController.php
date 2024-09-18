<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Producto;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EntradaController extends Controller
{
    public function index()
    {
        $entradas = Entrada::with(['producto', 'proveedor', 'usuario'])->get();
        return view('entradas.index', compact('entradas'));
    }

    public function create()
    {
        $productos = Producto::all();
        $proveedores = Supplier::all();
        $usuarios = User::all();
        return view('entradas.create', compact('productos', 'proveedores', 'usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_ingreso' => 'required|date',
            'idproducto' => 'required|exists:productos,id',
            'idproveedor' => 'required|exists:suppliers,id',
            'idusuario' => 'required|exists:users,id',
            'unidad_medida' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'precio_unidad' => 'required|numeric|min:0',
            'saldo_compra' => 'required|numeric|min:0',
        ]);

        // Convertir la fecha a formato Carbon
    $fecha_ingreso = Carbon::parse($request->input('fecha_ingreso'));

    Entrada::create([
        'fecha_ingreso' => $fecha_ingreso,
        'idproducto' => $request->input('idproducto'),
        'idproveedor' => $request->input('idproveedor'),
        'idusuario' => $request->input('idusuario'),
        'unidad_medida' => $request->input('unidad_medida'),
        'cantidad' => $request->input('cantidad'),
        'precio_unidad' => $request->input('precio_unidad'),
        'saldo_compra' => $request->input('saldo_compra'),
    ]);

        return redirect()->route('entradas.index')->with('success', 'Compra guardada exitosamente.');
    }

    public function show(Entrada $entrada)
    {
        return view('entradas.show', compact('entrada'));
    }

    public function edit(Entrada $entrada)
    {
        $productos = Producto::all();
        $proveedores = Supplier::all();
        $usuarios = User::all();
        return view('entradas.edit', compact('entrada', 'productos', 'proveedores', 'usuarios'));
    }

    public function update(Request $request, Entrada $entrada)
    {
        $request->validate([
            'fecha_ingreso' => 'required|date',
            'idproducto' => 'required|exists:productos,id',
            'idproveedor' => 'required|exists:suppliers,id',
            'idusuario' => 'required|exists:users,id',
            'unidad_medida' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'precio_unidad' => 'required|numeric|min:0',
            'saldo_compra' => 'required|numeric|min:0',
        ]);

        $entrada->update($request->all());

        return redirect()->route('entradas.index')->with('success', 'Entrada actualizada exitosamente.');
    }

    public function destroy(Entrada $entrada)
    {
        try {
            $entrada->delete();
            return redirect()->route('entradas.index')->with('success', 'Entrada eliminada exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('entradas.index')->with('error', 'No se puede eliminar esta entrada.');
        }
    }
}