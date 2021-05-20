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
use App\Http\Controllers\ContaCorrenteAnexoController;
use App\Http\Controllers\ContaCorrenteRepresentanteAnexoController;
use App\Http\Controllers\TrocaChequeController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    
    //? Cadastros auxiliares
    Route::resource('fornecedores', FornecedorController::class);
    Route::resource('representantes', RepresentanteController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('parceiros', ParceiroController::class);
    
    //? Financeiro
    Route::resource('conta_corrente', ContaCorrenteController::class);
    Route::resource('conta_corrente_representante', ContaCorrenteRepresentanteController::class);
    Route::resource('venda', VendaController::class);
    Route::resource('cheques', ChequeController::class);
    Route::resource('troca_cheques', TrocaChequeController::class);
    
    //? PDF
    Route::get('pdf_troca/{id}', [TrocaChequeController::class, 'pdf_troca'])->name('pdf_troca');
    Route::get('pdf_fornecedores', [FornecedorController::class, 'pdf_fornecedores'])->name('pdf_fornecedores');
    Route::get('pdf_fornecedor/{id}', [FornecedorController::class, 'pdf_fornecedor'])->name('pdf_fornecedor');
    Route::get('impresso_ccr/{id}', [ContaCorrenteRepresentanteController::class, 'impresso'])->name('impresso_ccr');
    Route::get('relacao_ccr/', [RepresentanteController::class, 'impresso'])->name('relacao_ccr');
    
    //? Anexos 
    Route::resource('conta_corrente_anexo', ContaCorrenteAnexoController::class)->only([
        'index', 'create', 'store', 'destroy'
    ]);
    Route::resource('ccr_anexo', ContaCorrenteRepresentanteAnexoController::class)->only([
        'index', 'create', 'store', 'destroy'
    ]);
});