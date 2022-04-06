<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdiamentoFormRequest;
use App\Models\Adiamento;
use App\Models\Feriados;
use App\Models\Parceiro;
use App\Models\Parcela;
use App\Models\Representante;
use App\Models\TrocaAdiamento as ModelsTrocaAdiamento;
use App\Models\TrocaParcela;
use DateTime;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use TrocaAdiamento;

class AdiamentosController extends Controller
{
    public function index()
    {
        $cheques = Parcela::with('representante')
            ->where([
                ['forma_pagamento', 'Cheque']
            ])
            ->where('status', 'Adiado')
            ->orderBy('data_parcela')
            ->paginate(30);

        return view('adiamento.index', compact('cheques'));
    }

    public function store(AdiamentoFormRequest $request)
    {
        $nova_data = new DateTime($request->nova_data);
        $feriados = Feriados::all();

        while (in_array($nova_data->format('w'), [0, 6]) || !$feriados->where('data_feriado', $nova_data->format('Y-m-d'))->isEmpty()) {
            $nova_data->modify('+1 weekday');
        }

        $porcentagem = $request->taxa_juros / 100;
        $cheque = Parcela::findOrFail($request->parcela_id);

        $parcela_data = new DateTime($request->parcela_data);
       
        $dias = $parcela_data->diff($nova_data)->days;

        $jurosTotais = ( ( ($cheque->valor_parcela * $porcentagem) / 30 ) * $dias);
        
        $cheque->update([
            'status' => 'Adiado'
        ]);

        //* Deleta o registro antigo e gera um novo
        if(Adiamento::where('parcela_id', $cheque->id)->exists()){
            Adiamento::where('parcela_id', $cheque->id)->delete();
        }

        //!GERA UMA 'VIA' PARA A PESSOA QUE ESTÁ COM O CHEQUE, DESSE JEITO SABEMOS O QUANTO PAGAREMOS
        if ($cheque->parceiro_id) {
            $parceiro = Parceiro::findOrFail($cheque->parceiro_id);
            $troca = TrocaParcela::where('parcela_id', $cheque->id)->firstOrFail();

            $porcentagemParceiro = number_format($parceiro->porcentagem_padrao / 100, 3);
            $jurosTotaisParceiro = ( ( ($cheque->valor_parcela * $porcentagemParceiro) / 30 ) * $dias);
            
            if(ModelsTrocaAdiamento::where('parcela_id', $cheque->id)->exists()){
                ModelsTrocaAdiamento::where('parcela_id', $cheque->id)->delete();
            }

            ModelsTrocaAdiamento::create([
                'data' => $nova_data->format('Y-m-d'),
                'dias_totais' => $dias,
                'juros_totais' => $jurosTotaisParceiro,
                'adicional_juros' => $jurosTotaisParceiro,
                'taxa' => $parceiro->porcentagem_padrao,
                'parcela_id' => $cheque->id,
                'troca_parcela_id' => $troca->id
            ]);
        }
        
        $adiamento = Adiamento::create([
            'nova_data' => $nova_data->format('Y-m-d'),
            'taxa_juros' => $request->taxa_juros,
            'juros_totais' => $jurosTotais,
            'dias_totais' => $dias,
            'observacao' => $request->observacao,
            'parcela_id' => $cheque->id
        ]);

        return json_encode([
            'title' => 'Sucesso',
            'icon' => 'success',
            'text' => 'Cheque prorrogado para dia '.$nova_data->format('d/m/Y'),
            'adiamento' => $adiamento,
        ]);        
    }

    public function adiamento_impresso ($representante_id) {

        $representante = Representante::with('pessoa')->findOrFail($representante_id);

        $adiamentos = Parcela::whereHas('adiamentos')
            ->where('representante_id', $representante_id)
            ->with('adiamentos')
            ->get();

        $total = 0;

        foreach ($adiamentos as $adiamentos->adiamentos => $cheque) {
            $total += $cheque->adiamentos->juros_totais;
        }
        
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('adiamento.pdf.adiamentos_representante', compact('adiamentos', 'representante', 'total') );
        
        return $pdf->stream();
    }
}
