<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Models\Conta;
use App\Models\Parcela;
use App\Models\Parceiro;
use App\Models\Representante;
use App\Models\PagamentosParceiros;
use App\Models\MovimentacaoCheque;
use App\Models\ParcelaRepresentante;
use App\Models\PagamentosRepresentantes;
use App\Http\Requests\RecebimentosUpdateRequest;
use App\Http\Requests\RecebimentosRequestStore;

class RecebimentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pgtoRepresentante = PagamentosRepresentantes::with('parcela')
            ->orderBy('id', 'desc')
            ->take(15)
            ->get();
        // dd($pgtoRepresentante);

        // $pgtoParceiro = PagamentosParceiros::with('parcela')
        //     ->where('confirmado', 0)
        //     ->get();

        return view('recebimento.index', compact('pgtoRepresentante'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contas = Conta::all();
        $parceiros = Parceiro::all();
        $representantes = Representante::all();
        $data = NULL;
        $descricao = NULL;
        $valor = NULL;
        $contaImportacao = NULL;

        return view('recebimento.create', compact('contas', 'parceiros', 'representantes', 'data', 'descricao', 'valor', 'contaImportacao'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecebimentosRequestStore $request)
    {
        if ($request->parcela_id) {
            $parcela = Parcela::find($request->parcela_id);
        }

        if ($request->tipo_pagamento == 1) {
            $pagamentoParceiro = PagamentosParceiros::create($request->validated());
            if ($parcela) {
                Parcela::where('id', $parcela->id)->update(['status' => 'Pago']);
            }
        } else if ($request->tipo_pagamento == 2) {

            $pagamentoRepresentante = PagamentosRepresentantes::create(
                array_merge(
                    $request->validated(),
                    ['representante_id' => $request->representante_id]
                )
            );

            if ($request->parcela_id) {
                $valorTotalPago = PagamentosRepresentantes::where('parcela_id', $parcela->id)
                    ->sum('valor');

                if ($valorTotalPago >= $parcela->valor_parcela) {

                    Parcela::where('id', $parcela->id)->update(['status' => 'Pago']);
                    MovimentacaoCheque::create([
                        'parcela_id' => $parcela->id,
                        'status' => 'Pago representante',
                    ]);

                }
            }

        } else if ($request->tipo_pagamento == 3 && $request->tipo_pagamento == 4) {

            $pagamentoRepresentante = PagamentosRepresentantes::create($request->validated());

            $pagamentoParceiro = PagamentosParceiros::create($request->validated());

            if ($parcela->id) {
                $valorTotalPagoRepresentante = PagamentosRepresentantes::where('parcela_id', $parcela->id)
                    ->sum('valor');


                $valorTotalPagoParceiro = PagamentosParceiros::where('parcela_id', $parcela->id)
                    ->sum('valor');

                if ($valorTotalPagoRepresentante >= $parcela->valor_parcela) {
                    MovimentacaoCheque::create([
                        'parcela_id' => $parcela->id,
                        'status' => 'Pago representante',
                    ]);
                }

                if ($valorTotalPagoParceiro >= $parcela->valor_parcela) {
                    MovimentacaoCheque::create([
                        'parcela_id' => $parcela->id,
                        'status' => 'Pago parceiro',
                    ]);

                }
            }

        }

        $request
        ->session()
        ->flash(
            'message',
            'Recebimento cadastrado com sucesso!'
        );

        return redirect()->route('recebimentos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($request)
    {
        $contas = Conta::all();
        $parceiros = Parceiro::all();
        $representantes = Representante::all();
        $pagamentosRepresentantes = PagamentosRepresentantes::findOrFail($request);
        $formasPagamento = ['Pix', 'TED', 'Depósito', 'DOC', 'Dinheiro'];
        $outrosPagamentos =  PagamentosRepresentantes::where('parcela_id', $pagamentosRepresentantes->parcela_id)
            ->where('id', '<>', $pagamentosRepresentantes->id)
            ->get();
        // dd(!$outrosPagamentos->isEmpty());

        return view('recebimento.edit', compact('pagamentosRepresentantes', 'contas', 'parceiros', 'representantes', 'formasPagamento', 'outrosPagamentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RecebimentosUpdateRequest $request, $recebimento_id)
    {
        PagamentosRepresentantes::where('id', $recebimento_id)
            ->update($request->validated());

            $request
        ->session()
        ->flash(
            'message',
            'Recebimento alterado com sucesso!'
        );

        return redirect()->route('recebimentos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        PagamentosRepresentantes::destroy($id);

        $request
        ->session()
        ->flash(
            'message',
            'Excluído com sucesso!'
        );

        return redirect()->route('recebimentos.index');
    }

    public function criarRecebimentoImportacao($data, $descricao, $valor, $contaImportacao)
    {
        $contas = Conta::all();
        $parceiros = Parceiro::all();
        $representantes = Representante::all();

        return view('recebimento.create', compact('contas', 'parceiros', 'representantes', 'data', 'descricao', 'valor', 'contaImportacao'));
    }
}
