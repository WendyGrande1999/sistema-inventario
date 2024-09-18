<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:suppliers',
        ]);

        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Proveedor creado con éxito.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:suppliers,email,' . $supplier->id,
        ]);

        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Proveedor actualizado con éxito.');
    }

   



    public function destroy(Supplier $supplier)
    {

        try {
            $supplier->delete();
           return redirect()->route('suppliers.index')->with('success', 'Proveedor eliminado con éxito.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('suppliers.index')->with('error', 'No se puede eliminar este proveedor porque está asociado a una o más compras.');
        }
        
    }
}
