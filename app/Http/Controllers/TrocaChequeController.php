<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdiamentoFormRequest;
use App\Http\Requests\EditTrocaChequeRequest;
use App\Http\Requests\TrocaChequesRequest;
use App\Models\Parcela;
use App\Models\Troca;
use App\Models\TrocaAdiamento;
use App\Models\TrocaParcela;
use App\Models\Parceiro;
use App\Models\Representante;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class TrocaChequeController extends Controller
{
    public function index() 
    {
        $trocas = Troca::latest()
            ->paginate(15);

        return view('troca_cheque.index', compact('trocas') );
    }

    public function create() 
    {
        $cheques = Parcela::where('forma_pagamento', 'Cheque')
            ->whereNull('parceiro_id')
            ->orderBy('data_parcela')
            ->get();

        $parceiros = Parceiro::with('pessoa')
            ->get();

        return view('troca_cheque.create', compact('cheques', 'parceiros') );
    }
    
    public function store(TrocaChequesRequest $request) 
    {
        $porcetagem_padrao = $request->taxa_juros;
        $taxa = $porcetagem_padrao / 100;
       
        $cheques = Parcela::find($request->cheque_id);
        $dataInicio = new DateTime($request->data_troca);
        
        $troca = Troca::create([
            'data_troca' => $request->data_troca,
            'parceiro_id' => $request->parceiro_id,
            'titulo' => $request->titulo,
            'observacao' => $request->observacao,
            'taxa_juros' => $request->taxa_juros,
        ]);

        $totalJuros = 0;
        $totalLiquido = 0;
        
        foreach ($cheques as $cheque) {
            $adicionar_dia = 0;
            $dataFim = new DateTime($cheque->data_parcela);
            $diferencaDias = $dataInicio->diff($dataFim);

            if ($request->parceiro_id == 3) {
                switch ($dataFim->format('w')) {
                    case 0:
                        $adicionar_dia = 1;
                        break;
                    case 6:
                        $adicionar_dia = 2;
                        break;
                    default:
                        $adicionar_dia = 0;
                        break;
                }
            }

            $dias = ($diferencaDias->days + $adicionar_dia);
            $juros = ( ($cheque->valor_parcela * $taxa) / 30 ) * $dias;
            $valorLiquido = $cheque->valor_parcela - $juros;

            $totalJuros += $juros;
            $totalLiquido += $valorLiquido;

            TrocaParcela::create([
                'parcela_id' => $cheque->id,
                'troca_id' => $troca->id,
                'dias' => $dias,
                'valor_liquido' => $valorLiquido,
                'valor_juros' => $juros
            ]);

            $cheque->update([
                'parceiro_id' => $request->parceiro_id
            ]);
        }

        $totalBruto = $totalLiquido + $totalJuros;
         
        $troca->update([
            'valor_liquido' => $totalLiquido,
            'valor_bruto' => $totalBruto,
            'valor_juros' => $totalJuros,
        ]);

        return redirect()->route('troca_cheques.index');
    }

    public function edit($id)
    {
        $troca = Troca::findOrFail($id);
        $parceiros = Parceiro::with('pessoa')->get();

        return view('troca_cheque.edit', compact('troca', 'parceiros'));
    }

    public function update(EditTrocaChequeRequest $request, $id)
    {
        $troca = Troca::findOrFail($id);

        //!CONFERIR SE A DATA DA TROCA OU A TAXA AINDA SÃO AS MESMAS
        if  (($troca->data_troca !== $request->data_troca) || $troca->taxa_juros != $request->taxa_juros) {
            $cheques = TrocaParcela::with('parcelas')->where('troca_id', $troca->id)->orderBy('dias')->get();
            // dd($cheques->parcelas);

            $totalJuros = 0;
            $totalLiquido = 0;
            $dataInicio = new DateTime($request->data_troca);
            $taxa = $request->taxa_juros / 100;

            foreach ($cheques as $cheque) {
                
                $dataFim = new DateTime($cheque->parcelas->data_parcela);
                $diferencaDias = $dataInicio->diff($dataFim);
                
                $adicionar_dia = 0;
                if ($request->parceiro_id == 3) {
                    switch ($dataFim->format('w')) {
                        case 0:
                            $adicionar_dia = 1;
                            break;
                        case 6:
                            $adicionar_dia = 2;
                            break;
                        default:
                            $adicionar_dia = 0;
                            break;
                    }
                }
                
                $dias = ($diferencaDias->days + $adicionar_dia);
                $juros = ( ($cheque->parcelas->valor_parcela * $taxa) / 30 ) * $dias;
                $valorLiquido = $cheque->parcelas->valor_parcela - $juros;
    
                $totalJuros += $juros;
                $totalLiquido += $valorLiquido;
    
                $cheque->update([
                    'dias' => $dias,
                    'valor_liquido' => $valorLiquido,
                    'valor_juros' => $juros
                ]);
    
                $cheque->parcelas->update([
                    'parceiro_id' => $request->parceiro_id
                ]);
            }
    
            $totalBruto = $totalLiquido + $totalJuros;

            $troca->update([
                'valor_liquido' => $totalLiquido,
                'valor_bruto' => $totalBruto,
                'valor_juros' => $totalJuros,
            ]);

        }
        
        $troca->update($request->all());
        return redirect()->route('troca_cheques.index');
    }
    
    public function pdf_troca($id)
    {
        $troca = Troca::with('parceiro')->findOrFail($id);
        
        $cheques = DB::select('SELECT 
                *
            FROM
                parcelas
                    INNER JOIN
                trocas_parcelas t ON t.parcela_id = parcelas.id
            WHERE
                troca_id = ?
            ORDER BY data_parcela, valor_parcela', 
            [$id]
        );

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('troca_cheque.pdf.troca_cheque', compact('troca', 'cheques') );
        
        return $pdf->stream();
    }

    public function show($id) 
    {
        $troca = Troca::with(['cheques' => function ($query) {
                $query->orderBy('dias');
            }, 'parceiro'])
        ->findOrFail($id);
            
        return view('troca_cheque.show', compact('troca') );
    }

    public function adiar_cheque(AdiamentoFormRequest $request)
    { 
        $porcentagem = $request->taxa / 100;
        $cheque = Parcela::findOrFail($request->cheque_id);

        $datetime1 = date_create($request->data);
        $datetime2 = date_create($cheque->data_parcela);
        $interval = date_diff($datetime1, $datetime2);

        $dias = $interval->format('%a');

        $trocaParcela = TrocaParcela::findOrFail($request->troca_parcela_id);
        
        $adicionalJuros = ( ( ($cheque->valor_parcela * $porcentagem) / 30 ) * $dias);
        $jurosTotais = $adicionalJuros + $trocaParcela->valor_juros;

        $cheque->update([
            'status' => 'Adiado'
        ]);

        $adiamento = TrocaAdiamento::create([
            'data' => $request->data,
            'dias_totais' => $dias,
            'adicional_juros' => $adicionalJuros,
            'juros_totais' => $jurosTotais,
            'taxa' => $request->taxa,
            'observacao' => $request->observacao,
            'data' => $request->data,
            'troca_parcela_id' => $request->troca_parcela_id,
            'parcela_id' => $request->cheque_id,
        ]);

        return json_encode([
            'title' => 'Sucesso',
            'icon' => 'success',
            'text' => 'Salvo com sucesso',
            'adiamento' => $adiamento,
        ]);        
    }

    public function resgatar_cheque(Request $request, $id)
    {        
        $cheque = Parcela::findOrFail($id);
        $cheque->update([
            'status' => 'Resgatado'
        ]);
        
        return redirect()->route('troca_cheques.show', $request->troca_id);
    }
}
