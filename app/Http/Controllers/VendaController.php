<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\SalvarVendaRequest;
use App\Models\ContaCorrenteRepresentante;
use App\Models\Parcela;
use App\Models\Venda;
use App\Models\Representante;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function create(Request $request)
    {
        $idRepresentante = $request->id;
        $clientes = Cliente::with('pessoa')->get();
        $metodo_pagamento = ['À vista', 'Parcelado'];
        $forma_pagamento = ['Dinheiro', 'Cheque', 'Transferência Bancária', 'Depósito'];

        return view('venda.create', compact('idRepresentante', 'clientes', 'metodo_pagamento', 'forma_pagamento'));
    }

    public function store(SalvarVendaRequest $request)
    {
        $venda = Venda::create([
            'data_venda' => $request->data_venda,
            'cliente_id' => $request->cliente_id,
            'representante_id' => $request->representante_id,
            'peso' => $request->peso,
            'fator' => $request->fator,
            'cotacao_fator' => $request->cotacao_fator,
            'cotacao_peso' => $request->cotacao_peso,
            'valor_total' => $request->valor_total,
            'metodo_pagamento' => $request->metodo_pagamento,
        ]);

        foreach ($request->data_parcela as $key => $value) {
            Parcela::create([
                'venda_id' => $venda->id,
                'forma_pagamento' => $request->forma_pagamento[$key],
                'nome_cheque' => $request->nome_cheque[$key],
                'numero_cheque' => $request->numero_cheque[$key],
                'data_parcela' => $value,
                'valor_parcela' => $request->valor_parcela[$key],
                'observacao' => $request->observacao[$key],
            ]);
        }
        
        return redirect("/venda/{$request->representante_id}");
    }

    public function show(Request $request, $id)
    {
        $vendas = Venda::with('parcela')
            ->where('representante_id', $id)
            ->where('enviado_conta_corrente', null)
            ->latest()
            ->get();

        $representante = Representante::findOrFail($id);

        return view('venda.show', compact('vendas', 'representante'));
    }

    public function edit($id)
    {
        $venda = Venda::findOrFail($id);
        $representantes = Representante::with('pessoa')->get();
        $clientes = Cliente::with('pessoa')->get();
        
        return view('venda.edit', compact('representantes', 'venda', 'clientes'));
    }

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

    public function destroy($id)
    {
        Venda::destroy($id);

        return json_encode([
            'icon' => 'success',
            'title' => 'Sucesso!',
            'text' => 'Fornecedor excluído com sucesso!'
        ]);
    }

    public function enviarContaCorrente (Request $request) {
        $vendas = Venda::findOrFail($request->vendas_id);

        foreach ($vendas as $key => $venda) {
            $venda->update([
                'enviado_conta_corrente' => 1
            ]);
        }

        ContaCorrenteRepresentante::create([
            'fator' => $vendas->sum('fator'),
            'peso' => $vendas->sum('peso'),
            'fator_agregado' => $vendas->sum('fator'),
            'peso_agregado' => $vendas->sum('peso'),
            'data' => date('Y-m-d'),
            'balanco' => 'Venda',
            'representante_id' => $vendas->first()->representante_id
        ]);
        
        return json_encode([
           'representante_id' => $vendas->first()->representante_id,
        ]);
    }
}
