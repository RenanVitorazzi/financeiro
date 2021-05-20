<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdiamentoFormRequest;
use App\Http\Requests\TrocaChequesRequest;
use App\Models\Parcela;
use App\Models\Troca;
use App\Models\TrocaAdiamento;
use App\Models\TrocaParcela;
use App\Models\Parceiro;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class TrocaChequeController extends Controller
{
    public function index() 
    {
        $trocas = Troca::with('parceiro')
            ->latest()
            ->paginate(15);
        
        return view('troca_cheque.index', compact('trocas') );
    }

    public function create() 
    {
        $cheques = DB::select(
            "SELECT par.numero_cheque, 
                par.id as id,
                par.valor_parcela, 
                par.status, 
                par.data_parcela,
                par.observacao, 
                p.nome as cliente,
                (SELECT p.nome FROM pessoas p WHERE p.id = r.pessoa_id) as representante,
                par.motivo_devolucao
            FROM 
                parcelas AS par
                INNER JOIN vendas as v ON v.id = par.venda_id
                INNER JOIN clientes as c ON c.id = v.cliente_id
                INNER JOIN pessoas as p ON p.id = c.pessoa_id
                INNER JOIN representantes as r ON r.id = v.representante_id
                WHERE par.status LIKE 'Aguardando' AND par.parceiro_id is null"
        );
        $parceiros = Parceiro::with('pessoa')
            ->get();

        return view('troca_cheque.create', compact('cheques', 'parceiros') );
    }
    
    public function trocar(TrocaChequesRequest $request) 
    {
        $porcetagem_padrao = Parceiro::findOrFail($request->parceiro_id)->porcentagem_padrao;
        $taxa = round($porcetagem_padrao / 100, 2);
       
        $cheques = Parcela::find($request->cheque_id);
        $dataInicio = new DateTime($request->data_troca);
        // $troca = Troca::all();
        
        $troca = Troca::create([
            'data_troca' => $request->data_troca,
            'parceiro_id' => $request->parceiro_id,
        ]);

        $totalJuros = 0;
        $totalLiquido = 0;

        foreach ($cheques as $cheque) {
            $dataFim = new DateTime($cheque->data_parcela);
            $diferencaDias = $dataInicio->diff($dataFim);

            $juros = ( ($cheque->valor_parcela * $taxa) / 30 ) * $diferencaDias->days;
            $valorLiquido = round($cheque->valor_parcela - $juros, 2);

            $totalJuros += $juros;
            $totalLiquido += $valorLiquido;

            TrocaParcela::create([
                'parcela_id' => $cheque->id,
                'troca_id' => $troca->id,
                'dias' => $diferencaDias->days,
                'valor_liquido' => $valorLiquido,
                'valor_juros' => $juros
            ]);

            $cheque->update([
                'parceiro_id' => $request->parceiro_id
            ]);
        }

        $totalBruto = $totalLiquido - $totalJuros;
         
        $troca->update([
            'valor_liquido' => round($totalLiquido, 2),
            'valor_bruto' => round($totalBruto, 2),
            'valor_juros' => round($totalJuros, 2)
        ]);

        return json_encode([
            'troca' => $troca
        ]);
    }

    public function pdf_troca($id)
    {
        $troca = Troca::with(['cheques', 'parceiro'])->find($id);
        
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('troca_cheque.pdf.troca_cheque', compact('troca') );
        
        return $pdf->stream();
    }

    public function show($id) 
    {
        $troca = Troca::with('cheques', 'parceiro')->findOrFail($id);
        
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
        $jurosAdicionais = $adicionalJuros - $trocaParcela->valor_juros;

        $cheque->update([
            'status' => 'Adiado'
        ]);

        $adiamento = TrocaAdiamento::create([
            'data' => $request->data,
            'dias_totais' => $dias,
            'adicional_juros' => $adicionalJuros,
            'juros_totais' => $jurosAdicionais,
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

    public function resgatar_cheque(Request $request)
    {
        //TODO recalcular total de Resgatado 
        
        $cheque = Parcela::findOrFail($request->parcela_id);
        $cheque->update([
            'status' => 'Resgatado'
        ]);
        
        return json_encode([
            'parcela_id' => $request->parcela_id
        ]);
    }
}
