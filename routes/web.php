<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepresentanteController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ParceiroController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ContaCorrenteController;
use App\Http\Controllers\ContaCorrenteRepresentanteController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\ChequeController;

Route::get('/cheque', [ChequeController::class, 'index']);

//* Cadastros auxiliares
Route::resource('clientes', ClienteController::class);
Route::resource('representantes', RepresentanteController::class);
Route::resource('parceiros', ParceiroController::class);
Route::resource('fornecedores', FornecedorController::class);

//* Conta corrente
Route::resource('conta_corrente', ContaCorrenteController::class);
Route::resource('conta_corrente_representante', ContaCorrenteRepresentanteController::class);

Route::resource('venda', VendaController::class);

// Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
