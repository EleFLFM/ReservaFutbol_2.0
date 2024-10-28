<?php

use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Ruta raíz: Redirige a login si no está autenticado, sino muestra la vista welcome o home.
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
Auth::routes();

// Ruta después de autenticación (HomeController)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas de horarios (CRUD)
Route::resource('horarios', HorarioController::class);

// Rutas para gestionar reservas
Route::post('/reservas', [ReservaController::class, 'store']);
Route::get('/admin/reservas', [ReservaController::class, 'index']);
Route::post('/admin/reservas/{id}/aprobar', [ReservaController::class, 'aprobar']);
Route::post('/admin/reservas/{id}/rechazar', [ReservaController::class, 'rechazar']);
