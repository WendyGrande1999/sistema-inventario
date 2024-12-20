<?php

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\PageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    return view('auth.login'); // Redirige al formulario de inicio de sesión
});


Auth::routes();



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::resource('categories', CategoryController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('productos', ProductoController::class);
Route::resource('entradas', EntradaController::class);
Route::resource('salidas', SalidaController::class);

Route::get('productos/categoria/{category_id}', [EntradaController::class, 'getProductosByCategoria'])->name('productos.categoria');
Route::get('/prod/producto/{id}/existencia', [ProductoController::class, 'obtenerExistenciaa'])->name('prod-productos.existencia');

Route::get('/salida/entrada/{productoId}', [EntradaController::class, 'getEntradaByProduct']);

Route::get('/api/productos/{id}', [ProductoController::class, 'getProducto']);

Route::get('/inventario/stock', [ProductoController::class, 'stockReport']);
// Ruta para mostrar el botón de generar cierre manual
Route::get('/inventario/cierre-manual', [InventarioController::class, 'mostrarCierreManual'])->name('inventario.cierre-manual');

// Ruta para procesar el cierre manual
Route::post('/inventario/generar-cierre', [InventarioController::class, 'generarCierreManual'])->name('inventario.generar-cierre');

// Mostrar el formulario para seleccionar una fecha de cierre
Route::get('/inventario/cierres', [InventarioController::class, 'mostrarCierres'])->name('inventario.cierres');

// Obtener los productos del cierre seleccionado
Route::get('/inventario/cierre-detalle', [InventarioController::class, 'mostrarEntradasPorCierre'])->name('inventario.cierre-detalle');
// Ruta para mostrar el gráfico de cierres de inventario


Route::get('/productos/{id}/existencia', [ProductoController::class, 'getExistencia'])->name('productos.existencia');




Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');
Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create'); // Nueva ruta
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/admin/users', [UserController::class, 'store'])->name('users.store'); // Esta es la ruta correcta
    Route::post('/admin/users/{user}/roles', [UserController::class, 'assignRoles'])->name('admin.users.roles.assign');
});

Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');

// Ruta para cerrar sesión
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Redirige a la página de inicio o donde desees después de cerrar sesión
})->name('logout');






// Ruta para mostrar el formulario de solicitud de restablecimiento de contraseña
Route::get('password/confirm', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.confirm'); // Cambia el nombre de la ruta si lo deseas

// Ruta para enviar el enlace de restablecimiento de contraseña
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

// Ruta para mostrar el formulario de restablecimiento de contraseña
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

// Ruta para manejar la solicitud de restablecimiento de contraseña
Route::post('password/reset', [ResetPasswordController::class, 'reset'])
    ->name('password.update');


Route::get('/entradas/{id}/pdf', [EntradaController::class, 'generarPdf'])->name('entradas.pdf');

Route::get('/entrad/entradas/{fecha}/{producto}', [EntradaController::class, 'entradasPorDiaYProducto'])->name('entradas.dia');
Route::get('/end/entradas/detalle/{codigo}', [EntradaController::class, 'detallePorProductoYFechas'])->name('entradas.detallee');


// Ruta para mostrar el formulario y los detalles del producto seleccionado


// Ruta para mostrar el formulario de selección de producto
Route::get('/reportes/seleccionar', [ProductoController::class, 'seleccionarProducto'])->name('reportes.seleccionar');

// Ruta para mostrar los detalles del producto seleccionado
Route::get('/reportes/detalle', [ProductoController::class, 'mostrarDetalleProducto'])->name('reportes.detalle');

Route::get('/reportes/producto/pdf/{codigo}', [App\Http\Controllers\ReporteController::class, 'generarPDF2'])->name('reportes_pdf.pdf');

Route::get('/reporte-diario/mostrar', [ReporteController::class, 'mostrarReporteDiario'])->name('reporte-diario.mostrar');
Route::get('/reporte-diario/generar', [ReporteController::class, 'generarReporteDiario'])->name('reporte-diario.generar');
Route::get('/reporte-diario/generar/{fechaTexto}/', [ReporteController::class, 'generarPdfDia2'])->name('reportes_diario');

Route::get('/report/reporte-diario/pdf', [ReporteController::class, 'generarPDF4'])->name('report-diarioo.pdf');
Route::get('/repo/reporte-por-fechas/pdf', [ReporteController::class, 'generarPDF6'])->name('report-porr-fechas.pdf');


Route::get('/grafico', [ChartController::class, 'index'])->name('grafico.index');

Route::get('/cierre/{fecha_cierre}/entradas/{producto}', [EntradaController::class, 'mostrarEntradasPorProductoCierre'])
    ->name('entradas.productoCierre');

// Ruta para mostrar el formulario de selección de fechas
Route::get('/reportes/mes/seleccionar-fechas', [ReporteController::class, 'seleccionarFechas'])->name('reportes.seleccionarFechas');

// Ruta para generar el reporte de inventario por fechas
Route::get('/reportes/mes/reporte-por-fechas', [ReporteController::class, 'generarReportePorFechas'])->name('reportes.reportePorFechas');
Route::get('/reportes/mes/reporte-por-fechas/ {{ $fechaInicioTexto } al { $fechaCierreTexto }}', [ReporteController::class, 'generarPdfPorFechas'])->name('reportes.generarPdfPorFechas');

Route::get('/ayuda', [PageController::class, 'ayuda'])->name('ayuda');
Route::get('/terminos-y-condiciones', [PageController::class, 'terminos'])->name('terminos');
Route::get('/privacidad', [PageController::class, 'privacidad'])->name('privacidad');
