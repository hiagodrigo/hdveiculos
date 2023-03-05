<?php

use App\Http\Controllers\VeiculoController;
use Illuminate\Support\Facades\Route;

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

Route::resource('veiculos', VeiculoController::class);

Route::get('/', [VeiculoController::class, 'index']);

Route::get('/veiculos/{id}', [VeiculoController::class, 'show']);

Route::get('/dashboard', [VeiculoController::class, 'dashboard'])->name('dashboard')->middleware('auth');

Route::post('/veiculos/join/{id}', [VeiculoController::class, 'veiculoInteresse'])->middleware('auth');
Route::delete('/veiculos/leave/{id}', [VeiculoController::class, 'retirarInteresse'])->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
]);
