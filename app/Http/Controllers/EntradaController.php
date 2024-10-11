<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Entrada;
use App\Models\Producto;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\CierreInventario;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;




class EntradaController extends Controller
{
    public function index()
    {

        Carbon::setLocale('es');
        $ultimoCierree = CierreInventario::latest('fecha_cierre')->first();
        $fechaUltimoCierree = $ultimoCierree ? Carbon::parse($ultimoCierree->fecha_cierre)->translatedFormat('l d F Y') : 'No hay cierres anteriores';

        $entradas = Entrada::with(['producto', 'proveedor', 'usuario'])->get();


        // Obtener el último cierre de inventario
    $ultimoCierre = CierreInventario::latest('fecha_cierre')->first();

    // Si existe un cierre anterior, obtener la fecha
    $fechaUltimoCierre = $ultimoCierre ? $ultimoCierre->fecha_cierre : Carbon::now()->startOfYear();

    // Obtener las entradas activas (cantidad > 0) desde el último cierre
    $entradasDesdeUltimoCierre = Entrada::where('estado', 'activo')
        ->where('cantidad', '>', 0)
        ->whereDate('fecha_ingreso', '>', $fechaUltimoCierre)
        ->get();

    // Obtener las entradas activas (cantidad > 0) anteriores al último cierre
    $entradasAntesUltimoCierre = Entrada::where('estado', 'activo')
        ->where('cantidad', '>', 0)
        ->whereDate('fecha_ingreso', '<=', $fechaUltimoCierre)
        ->get();

        return view('entradas.index', compact('entradas', 'entradasDesdeUltimoCierre', 'entradasAntesUltimoCierre', 'fechaUltimoCierree' ));
    }

    public function create()

    {
        $productos = Producto::all();
        $categorias = Category::all();
        $proveedores = Supplier::all();
        $user = auth()->user();
        return view('entradas.create', compact('productos', 'proveedores', 'user', 'categorias' ));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'fecha_ingreso' => 'required|date',
                'idproducto' => 'required|exists:productos,id',
                'idproveedor' => 'required|exists:suppliers,id',
                'idusuario' => 'required|exists:users,id',
                'unidad_medida' => 'required|string|max:255',
                'cantidad' => 'required|integer|min:1',
                'cantidad_entrante' => 'required|integer|min:1',
                'precio_unidad' => 'required|numeric|min:0',
                
            ]);
    
            // Convertir la fecha a formato Carbon
        $fecha_ingreso = Carbon::parse($request->input('fecha_ingreso'));
        // Calcular saldo_compra
        $saldo_compra = $request->input('cantidad') * $request->input('precio_unidad');
    
        Entrada::create([
            'fecha_ingreso' => $fecha_ingreso,
            'idproducto' => $request->input('idproducto'),
            'idproveedor' => $request->input('idproveedor'),
            'idusuario' => $request->input('idusuario'),
            'unidad_medida' => $request->input('unidad_medida'), // Corregido aquí
            'cantidad' => $request->input('cantidad'),
            'cantidad_entrante' => $request->input('cantidad_entrante'),
            'precio_unidad' => $request->input('precio_unidad'),
            'saldo_compra' => $saldo_compra, // Guardar el saldo calculado
        ]);
    
            return redirect()->route('entradas.index')->with('success', 'Compra guardada exitosamente.');
        }catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('entradas.index')->with('error', 'No se puede agregar la entrada');
        }
     
    }

    public function show(Entrada $entrada)
    {
        // Cargar la relación de salidas para esta entrada
        // Cargar la entrada con sus salidas asociadas
       $entrada = Entrada::with('salidas')->findOrFail($entrada->id);

     // Sumar la cantidad de las salidas asociadas a esta entrada
       $sumSalida = $entrada->salidas->sum('cantidad');


        return view('entradas.show', compact('entrada', 'sumSalida' ));
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
            'cantidad' => 'required|integer|min:1',
            'precio_unidad' => 'required|numeric|min:0',
          
        ]);

        // Calcular saldo_compra
        $saldo_compra = $request->input('cantidad') * $request->input('precio_unidad');


        try {
            
            $entrada->update([
                'fecha_ingreso' => $request->input('fecha_ingreso'),
                'idproducto' => $request->input('idproducto'),
                'idproveedor' => $request->input('idproveedor'),
                'cantidad' => $request->input('cantidad'),
                'precio_unidad' => $request->input('precio_unidad'),
                'saldo_compra' => $saldo_compra, // Guardar el nuevo saldo calculado
            ]);

            return redirect()->route('entradas.index')->with('success', 'Entrada actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la entrada: ' . $e->getMessage());
        }

    }



    public function generarPdf($id)
    {
    $entrada = Entrada::with(['producto', 'proveedor', 'usuario'])->findOrFail($id);
    $pdf = PDF::loadView('entradas.show_pdf', compact('entrada'));
    
    return $pdf->download('entrada_' . $id . '.pdf');
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

    public function getProductosByCategoria($category_id)
   {
    $productos = Producto::where('category_id', $category_id)->get();
    return response()->json($productos);
   }

   public function getEntradaByProduct($idproducto)
   {
   // Filtrar entradas por producto que estén activas (por ejemplo, estado = 'activo' y cantidad > 0)
   $entradas = Entrada::where('idproducto', $idproducto)
   ->where('estado', 'activo')  // Solo entradas con estado 'activo'
   ->where('cantidad', '>', 0)  // Solo entradas con cantidad mayor a 0
   ->get();

return response()->json($entradas);
   }
}
