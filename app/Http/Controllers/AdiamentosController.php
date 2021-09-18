<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdiamentoFormRequest;
use App\Models\Adiamento;
use App\Models\Parceiro;
use App\Models\Parcela;
use App\Models\TrocaAdiamento as ModelsTrocaAdiamento;
use App\Models\TrocaParcela;
use TrocaAdiamento;

class AdiamentosController extends Controller
{
    public function index()
    {
        $cheques = Parcela::with('representante')
            ->where([
                ['forma_pagamento', 'Cheque']
            ])
            ->whereIn('status', array('Aguardando', 'Adiado'))
            ->orderBy('data_parcela')
            ->paginate(30);
            
        return view('adiamento.index', compact('cheques'));
    }

    public function store(AdiamentoFormRequest $request)
    {
        $porcentagem = $request->taxa_juros / 100;
        $cheque = Parcela::findOrFail($request->parcela_id);

        $nova_data = date_create($request->nova_data);
        $parcela_data = date_create($request->parcela_data);
        $interval = date_diff($nova_data, $parcela_data);
       
        $dias = $interval->format('%a');

        $jurosTotais = ( ( ($cheque->valor_parcela * $porcentagem) / 30 ) * $dias);
        
        $cheque->update([
            'status' => 'Adiado'
        ]);
        
        //!GERA UMA 'VIA' PARA A PESSOA QUE ESTÁ COM O CHEQUE, DESSE JEITO SABEMOS O QUANTO TEREMOS QUE PAGÁ-LO
        if ($cheque->parceiro_id) {
            $parceiro = Parceiro::findOrFail($cheque->parceiro_id);
            $troca = TrocaParcela::where('parcela_id', $cheque->id)->firstOrFail();

            $porcentagemParceiro = number_format($parceiro->porcentagem_padrao / 100, 3);
            $jurosTotaisParceiro = ( ( ($cheque->valor_parcela * $porcentagemParceiro) / 30 ) * $dias);
         
            ModelsTrocaAdiamento::create([
                'data' => $request->nova_data,
                'dias_totais' => $dias,
                'juros_totais' => $jurosTotaisParceiro,
                'adicional_juros' => $jurosTotaisParceiro,
                'taxa' => $parceiro->porcentagem_padrao,
                'parcela_id' => $cheque->id,
                'troca_parcela_id' => $troca->id
            ]);
        }
        
        $adiamento = Adiamento::create([
            'nova_data' => $request->nova_data,
            'taxa_juros' => $request->taxa_juros,
            'juros_totais' => $jurosTotais,
            'dias_totais' => $dias,
            'observacao' => $request->observacao,
            'parcela_id' => $cheque->id
        ]);

        return json_encode([
            'title' => 'Sucesso',
            'icon' => 'success',
            'text' => 'Salvo com sucesso',
            'adiamento' => $adiamento
        ]);        
    }
}
