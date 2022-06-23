<?php

use App\Http\Controllers\AdiamentosController;
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
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\DevolvidosController;
use App\Http\Controllers\TrocaChequeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {

    Route::resource('clientes', ClienteController::class);
    Route::resource('conta_corrente_representante', ContaCorrenteRepresentanteController::class);
    Route::resource('venda', VendaController::class);
    Route::resource('cheques', ChequeController::class);
    Route::post('enviar_conta_corrente', [VendaController::class, 'enviarContaCorrente'])->name('enviar_conta_corrente');
    Route::get('impresso_ccr/{id}', [ContaCorrenteRepresentanteController::class, 'impresso'])->name('impresso_ccr');
    Route::get('impresso_ccr2/{id}', [ContaCorrenteRepresentanteController::class, 'impresso2'])->name('impresso_ccr2');
    Route::get('relacao_ccr/', [RepresentanteController::class, 'impresso'])->name('relacao_ccr');
    Route::resource('ccr_anexo', ContaCorrenteRepresentanteAnexoController::class)->only([
        'index', 'create', 'store', 'destroy'
    ]);

    Route::group(['middleware' => ['is_admin']], function() {

        Route::post('resgatar_cheque/{id}', [TrocaChequeController::class, 'resgatar_cheque'])->name('resgatar_cheque');
        Route::post('baixarDebitosRepresentantes/{representante_id}', [RepresentanteController::class, 'baixarDebitosRepresentantes'])->name('baixarDebitosRepresentantes');
        Route::post('depositar_diario', [ChequeController::class, 'depositar_diario'])->name('depositar_diario');
        Route::view('procura_cheque', 'cheque.procura_cheque')->name('procura_cheque');

        //? Cadastros auxiliares
        Route::resource('fornecedores', FornecedorController::class);
        Route::resource('representantes', RepresentanteController::class);
        Route::resource('parceiros', ParceiroController::class);
        
        //? Financeiro
        Route::resource('conta_corrente', ContaCorrenteController::class);
        Route::resource('troca_cheques', TrocaChequeController::class);
        Route::resource('adiamentos', AdiamentosController::class);
        Route::resource('devolvidos', DevolvidosController::class);
        Route::post('devolvidos/pagar_cheque_devolvido/{parcela_id}', [DevolvidosController::class, 'pagar_cheque_devolvido'])->name('pagarChequeDevolvido');
        Route::resource('despesas', DespesaController::class);
        Route::resource('ops', OpController::class);
        
        //? PDF
        Route::get('pdf_troca/{id}', [TrocaChequeController::class, 'pdf_troca'])->name('pdf_troca');
        Route::get('pdf_fornecedores', [FornecedorController::class, 'pdf_fornecedores'])->name('pdf_fornecedores');
        Route::get('pdf_fornecedor/{id}', [FornecedorController::class, 'pdf_fornecedor'])->name('pdf_fornecedor');
        Route::get('carteira_cheque_total', [ChequeController::class, 'carteira_cheque_total'])->name('carteira_cheque_total');
        Route::get('pdf_diario', [FornecedorController::class, 'pdf_diario'])->name('pdf_diario');
        Route::get('adiamento_impresso/{representante_id}', [AdiamentosController::class, 'adiamento_impresso'])->name('adiamento_impresso');
        Route::get('cheques_devolvidos/{representante_id}', [DevolvidosController::class, 'cheques_devolvidos'])->name('cheques_devolvidos');
        Route::get('fechamento_representante/{representante_id}', [DevolvidosController::class, 'fechamento_representante'])->name('fechamento_representante');
        
        //? Anexos 
        Route::resource('conta_corrente_anexo', ContaCorrenteAnexoController::class)->only([
            'index', 'create', 'store', 'destroy'
        ]);
        Route::get('consulta_cheque', [ChequeController::class, 'consulta_cheque'])->name('consulta_cheque');
        // Route::post('adiar_cheque', [AdiamentosController::class, 'adiar_cheque'])->name('adiarCheque');
    });
});