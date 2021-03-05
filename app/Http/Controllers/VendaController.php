<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Http\Requests\SalvarVendaRequest;
use App\Models\ContaCorrenteRepresentante;
use App\Models\Parcela;
use App\Models\Venda;
use App\Representante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $idRepresentante = $request->id;
        $representantes = Representante::all();
        $clientes = Cliente::all();
        return view('venda.create', compact('representantes', 'idRepresentante', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalvarVendaRequest $request)
    {   
        if (!$request->parcelas) {
            $request->request->add(['parcelas' => 1]);
        }
        
        $venda = Venda::create($request->all());

        if ($request->metodo_pagamento === 'Cheque') {
            foreach ($request->data_parcela as $key => $value) {
                Parcela::create([
                    'venda_id' => $venda->id,
                    'valor_parcela' => $request->valor_parcela[$key],
                    'data_parcela' => $value,
                ]);
            }
        }
        
        return redirect("/venda/{$request->representante_id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $chequesMes = DB::table('parcelas')
        //     ->whereMonth('data_parcela', date('m'))
        //     ->whereNull('deleted_at')
        //     ->sum('valor_parcela');

        $vendas = Venda::with('parcela')
            ->where('representante_id', $id)
            ->where('balanco', 'Venda')
            ->where('enviado_conta_corrente', null)
            ->orderByDesc('id')
            ->get();
            // ->paginate(5, ['*'], 'vendas');

        // $abertos = Venda::with('parcela')
        //     ->where('representante_id', $id)
        //     ->where('balanco', 'Aberto')
        //     ->orWhere('balanco', 'Devolução')
        //     ->orderByDesc('id')
        //     ->paginate(5, ['*'], 'abertos');

        $representante = Representante::findOrFail($id);
        return view('venda.show', compact('vendas', 'representante'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $venda = Venda::findOrFail($id);
        $representantes = Representante::all();
        $clientes = Cliente::all();
        
        return view('venda.edit', compact('representantes', 'venda', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function update(SalvarVendaRequest $request, $id)
    {  
        $venda = Venda::findOrFail($id);
        $parcelas = Parcela::where('venda_id', $id)->get();
        
        if ($request->metodo_pagamento === 'Cheque') {

            $quantidadeBanco = count($parcelas);
            $quantidadeRequest = count($request->data_parcela);
            
            foreach ($parcelas as $key => $value) {
                if ($key < $quantidadeRequest) {
                    $value->update([
                        'data_parcela' => $request->data_parcela[$key], 
                        'valor_parcela' => $request->valor_parcela[$key],
                    ]);
                }
            }

            //! Conferir quantidade de parcelas no banco e no request
            if ($quantidadeBanco > $quantidadeRequest) {
                //? Se o número de parcelas for Maior, atualizar e deletar antigos registro 
                foreach ($parcelas->skip($quantidadeRequest) as $key => $parcelasAntigas) {
                    $parcelasAntigas->delete();
                }
            } else if ($quantidadeBanco < $quantidadeRequest) {
                //* Se o número de parcelas for Menor, atualizar e inserir novos registro 
                for ($i = $quantidadeBanco; $i < $quantidadeRequest; $i++) {
                    $parcela_nova = Parcela::create([
                        'venda_id' => $id,
                        'data_parcela' => $request->data_parcela[$i], 
                        'valor_parcela' => $request->valor_parcela[$i],
                    ]);
                }
            }
            
        } else {
            foreach ($parcelas as $parcela) {
                $parcela->delete();
            }
            $request->request->add(['parcelas' => 1]);
        }

        $venda
            ->fill($request->all())
            ->save();

        $request
            ->session() 
            ->flash(
                'message',
                'Venda atualizada com sucesso!'
            );
        return redirect("/venda/{$request->representante_id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $venda = Venda::findOrFail($id);
        $representante_id = $venda->representante_id;
        $venda->delete();
        $request
            ->session() 
            ->flash(
                'message',
                'Venda deletada com sucesso!'
            );
        return redirect("/venda/{$representante_id}");
    }

    public function enviarContaCorrente (Request $request) {
        $vendas = Venda::find($request->vendas_id);
        
        $valor_total_vendas = $vendas->sum('valor_total');
        $valor_total_peso = $vendas->sum('peso');
        $valor_total_fator = $vendas->sum('fator');
        
        foreach ($vendas as $key => $venda) {
            $venda->update([
                'enviado_conta_corrente' => 1
            ]);
        }

        $hoje = date('Y-m-d');

        ContaCorrenteRepresentante::create([
            'valor_total' => $valor_total_vendas,
            'fator' => $valor_total_fator,
            'peso' => $valor_total_peso,
            'data' => $hoje,
            'balanco' => 'Venda',
            'representante_id' => $vendas->first()->representante_id
        ]);
        
        return json_encode([
           'representante_id' => $vendas->first()->representante_id,
        ]);
    }
}
