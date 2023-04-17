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
use App\Http\Controllers\ConsignadoController;
use App\Http\Controllers\ContaCorrenteAnexoController;
use App\Http\Controllers\ContaCorrenteRepresentanteAnexoController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\DevolvidosController;
use App\Http\Controllers\TrocaChequeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\RecebimentosController;
use App\Http\Controllers\EntregaParcelaController;

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
        Route::get('procurarConsignado', [ConsignadoController::class, 'procurarConsignado'])->name('procurarConsignado');

        //? Cadastros auxiliares
        Route::resource('fornecedores', FornecedorController::class);
        Route::resource('representantes', RepresentanteController::class);
        Route::resource('parceiros', ParceiroController::class);
        Route::resource('consignado', ConsignadoController::class);
        
        //? Financeiro
        Route::resource('conta_corrente', ContaCorrenteController::class);
        Route::resource('troca_cheques', TrocaChequeController::class);
        Route::resource('adiamentos', AdiamentosController::class);
        Route::resource('devolvidos', DevolvidosController::class);
        Route::post('devolvidos/pagar_cheque_devolvido/{parcela_id}', [DevolvidosController::class, 'pagar_cheque_devolvido'])->name('pagarChequeDevolvido');
        Route::resource('despesas', DespesaController::class);
        Route::resource('ops', OpController::class);
        Route::get('estoque/lancar_cc_estoque/{cc_id}/{tabela}', [EstoqueController::class, 'lancar_cc_estoque'])->name('lancar_cc_estoque');
        Route::resource('estoque', EstoqueController::class);
        Route::resource('recebimentos', RecebimentosController::class);
        Route::resource('entrega_parcela', EntregaParcelaController::class);
        Route::get('entrega_parcela/receber_parceiro/{parceiro_id}', [EntregaParcelaController::class, 'receber_parceiro'])->name('receber_parceiro');
        Route::get('entrega_parcela/entrega_representante/{representante_id}', [EntregaParcelaController::class, 'entrega_representante'])->name('entrega_representante');

        //? PDF
        Route::get('pdf_troca/{id}', [TrocaChequeController::class, 'pdf_troca'])->name('pdf_troca');
        Route::get('pdf_cc_parceiro/{parceiro_id}', [ParceiroController::class, 'pdf_cc_parceiro'])->name('pdf_cc_parceiro');
        Route::get('pdf_cc_representante/{representante_id}', [RepresentanteController::class, 'pdf_cc_representante'])->name('pdf_cc_representante');
        Route::get('pdf_fornecedores', [FornecedorController::class, 'pdf_fornecedores'])->name('pdf_fornecedores');
        Route::get('pdf_fornecedor/{id}', [FornecedorController::class, 'pdf_fornecedor'])->name('pdf_fornecedor');
        Route::get('carteira_cheque_total', [ChequeController::class, 'carteira_cheque_total'])->name('carteira_cheque_total');
        Route::get('pdf_diario', [FornecedorController::class, 'pdf_diario'])->name('pdf_diario');
        Route::get('pdf_mov_diario', [FornecedorController::class, 'pdf_mov_diario'])->name('pdf_mov_diario');
        Route::get('pdf_clientes/{representante_id}', [ClienteController::class, 'pdf_clientes'])->name('pdf_clientes');
        Route::get('adiamento_impresso/{representante_id}', [AdiamentosController::class, 'adiamento_impresso'])->name('adiamento_impresso');
        Route::get('cheques_devolvidos/{representante_id}', [DevolvidosController::class, 'cheques_devolvidos'])->name('cheques_devolvidos');
        Route::get('fechamento_representante/{representante_id}', [DevolvidosController::class, 'fechamento_representante'])->name('fechamento_representante');
        Route::get('pdf_cheques/{representante_id}', [ChequeController::class, 'pdf_cheques'])->name('pdf_cheques');
        Route::get('pdf_relatorio_vendas/{enviado_conta_corrente_id}', [VendaController::class, 'pdf_relatorio_vendas'])->name('pdf_relatorio_vendas');
        Route::get('pdf_conferencia_relatorio_vendas/{representante_id}', [VendaController::class, 'pdf_conferencia_relatorio_vendas'])->name('pdf_conferencia_relatorio_vendas');
        Route::get('pdf_acerto_documento/{representante_id}', [VendaController::class, 'pdf_acerto_documento'])->name('pdf_acerto_documento');
        Route::get('pdf_despesa_mensal/{mes}', [DespesaController::class, 'pdf_despesa_mensal'])->name('pdf_despesa_mensal');
        Route::get('pdf_cheques_entregues/{representante_id}', [EntregaParcelaController::class, 'pdf_cheques_entregues'])->name('pdf_cheques_entregues');
        Route::get('pdf_estoque', [EstoqueController::class, 'pdf_estoque'])->name('pdf_estoque');
        Route::get('pdf_consignados', [ConsignadoController::class, 'pdf_consignados'])->name('pdf_consignados');
        Route::get('pdf_consignados_geral', [ConsignadoController::class, 'pdf_consignados_geral'])->name('pdf_consignados_geral');

        //? Anexos 
        Route::resource('conta_corrente_anexo', ContaCorrenteAnexoController::class)->only([
            'index', 'create', 'store', 'destroy'
        ]);
        Route::get('consulta_cheque', [ChequeController::class, 'consulta_cheque'])->name('consulta_cheque');
        Route::get('consulta_parcela_pagamento', [ChequeController::class, 'consulta_parcela_pagamento'])->name('consulta_parcela_pagamento');
        Route::get('procurar_pagamento', [ChequeController::class, 'procurar_pagamento'])->name('procurar_pagamento');
        Route::get('procurarCliente', [ClienteController::class, 'procurarCliente'])->name('procurarCliente');
        Route::get('titularDoUltimoCheque', [ChequeController::class, 'titularDoUltimoCheque'])->name('titularDoUltimoCheque');
        // Route::post('adiar_cheque', [AdiamentosController::class, 'adiar_cheque'])->name('adiarCheque');
    });
});