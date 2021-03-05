<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VendaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/enviarContaCorrente', [VendaController::class, 'enviarContaCorrente'])->name('enviarContaCorrente');
// Route::get('/enviarContaCorrente', [ClienteController::class, 'todosClientes'])->name('todosClientes');
