<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing.index');
})->name('home');

Route::get('/login', [UserController::class, 'formularioLogin'])->name('usuario.login');
Route::post('/login', [UserController::class, 'login'])->name('usuario.validar');
Route::post('/logout', [UserController::class, 'logout'])->name('usuario.logout');

//sin backoffice

Route::get('/users/register', [UserController::class, 'formularioNuevo'])->name('usuario.registrar');
Route::post('/users/register', [UserController::class, 'registrar'])->name('usuario.registrar');

Route::get('/backoffice', function () {
    $user = Auth::user();
    if ($user == null){
        return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
    }
    return view('backoffice.dashboard', ['user => $user']);
})->name('backoffice.dashboard');

// Route::get('backoofice/productos', [ProductosController::class, 'index'])->name('productos.index');
// Route::post('backoofice/productos/new', [ProductosController::class, 'create'])->name('productos.create');

// con backoffice

Route::get('backoffice/users', [UserController::class, 'index'])->name('usuarios.index');
Route::get('backoffice/productos', function() {return view('backoffice.mantenedor.producto');});
Route::get('backoffice/users/get/{_id}', [UserController::class, 'getById']);
Route::post('backoffice/users/new', [UserController::class, 'create'])->name('usuarios.create');
Route::post('backoffice/users/down/{_id}', [UserController::class, 'disable'])->name('usuarios.disable');
Route::post('backoffice/users/up/{_id}', [UserController::class, 'enable'])->name('usuarios.enable');
Route::post('backoffice/users/update/{_id}', [UserController::class, 'update'])->name('usuarios.update');
Route::post('backoffice/users/delete/{_id}', [UserController::class, 'delete'])->name('usuarios.delete');
