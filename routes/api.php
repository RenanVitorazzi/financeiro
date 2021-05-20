<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\TrocaChequeController;
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

Route::post('enviarContaCorrente', [VendaController::class, 'enviarContaCorrente'])->name('enviarContaCorrente');
Route::post('adiar_cheque', [TrocaChequeController::class, 'adiar_cheque'])->name('adiarCheque');
Route::post('resgatar_cheque', [TrocaChequeController::class, 'resgatar_cheque'])->name('resgatarCheque');

Route::post('troca_cheques', [TrocaChequeController::class, 'trocar'])->name('trocar');
Route::get('clientes/procurar', [ClienteController::class, 'procurarCliente'])->name('procurarCliente');
// Route::get('/enviarContaCorrente', [ClienteController::class, 'todosClientes'])->name('todosClientes');
