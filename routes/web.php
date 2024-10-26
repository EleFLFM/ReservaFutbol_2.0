<?php

use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('horarios', HorarioController::class);
Route::post('/reservas', [ReservaController::class, 'store']);
Route::get('/admin/reservas', [ReservaController::class, 'index']);
Route::post('/admin/reservas/{id}/aprobar', [ReservaController::class, 'aprobar']);
Route::post('/admin/reservas/{id}/rechazar', [ReservaController::class, 'rechazar']);
