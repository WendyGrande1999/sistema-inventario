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
Route::get('productos/categoria/{category_id}', [EntradaController::class, 'getProductosByCategoria'])->name('productos.categoria');

Route::get('/api/productos/{id}', [ProductoController::class, 'getProducto']);




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





