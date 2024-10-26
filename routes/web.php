<?php

use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return view('auth.login');
});
Route::get('/horarios', [HorarioController::class, 'index']);
Route::post('/reservas', [ReservaController::class, 'store']);
Route::get('/admin/reservas', [ReservaController::class, 'index']);
Route::post('/admin/reservas/{id}/aprobar', [ReservaController::class, 'aprobar']);
Route::post('/admin/reservas/{id}/rechazar', [ReservaController::class, 'rechazar']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
