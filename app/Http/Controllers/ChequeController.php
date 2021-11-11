<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChequeRepresentanteRequest;
use App\Http\Requests\ChequeRequest;
use App\Models\Parcela;
use App\Models\Representante;
use App\Models\Troca;
use App\Models\TrocaParcela;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ChequeController extends Controller
{
    public function index() 
    {
        $cheques = DB::select('SELECT 
                                    par.id,
                                    par.nome_cheque,
                                    par.numero_cheque,
                                    par.valor_parcela,
                                    par.observacao,
                                    par.status,
                                    par.venda_id,
                                    (SELECT UPPER(p.nome) FROM pessoas p WHERE p.id = r.pessoa_id) AS nome_representante,
                                    IF(par.status = ?,
                                        (SELECT nova_data FROM adiamentos WHERE parcela_id = par.id ORDER BY id desc LIMIT 1), 
                                        par.data_parcela
                                    ) as data_parcela
                                FROM
                                    parcelas par
                                        LEFT JOIN
                                    representantes r ON r.id = par.representante_id
                                WHERE
                                    par.status != ?
                                        AND par.status != ?
                                        AND par.status != ?
                                        AND par.deleted_at IS NULL
                                        AND r.deleted_at IS NULL
                                        AND parceiro_id IS NULL
                                ORDER BY data_parcela ASC, valor_parcela ASC', ['Adiado', 'Pago', 'Depositado', 'Resgatado']);
        
        $arrayCores = [
            'Devolvido' => 'text-danger', 
            'Adiado' => 'text-warning', 
            'Sustado' => 'text-danger', 
            'Pago' => 'text-success', 
            'Aguardando' => 'text-muted',
            'Resgatado' => 'text-warning',
            'Depositado' => 'text-muted'    ,
        ];

        return view('cheque.index', compact('cheques', 'arrayCores') );
    }

    public function edit($id)
    {
        $cheque = Parcela::findOrFail($id);
        $situacoesCheque = ['Pago', 'Sustado', 'Adiado', 'Aguardando', 'Devolvido', 'Resgatado', 'Depositado'];

        return view('cheque.edit', compact('cheque', 'situacoesCheque'));
    }

    public function update(ChequeRequest $request, $id) 
    {
        $cheque = Parcela::findOrFail($id);
        $cheque->update($request->validated());

        return redirect()->route('cheques.index');
    }

    public function create()
    {
        $representantes = Representante::with('pessoa')->get();
    
        return view('cheque.create', compact('representantes'));
    }

    public function store(ChequeRepresentanteRequest $request)
    {
        if ($request->nova_troca == 'Sim') {
            $hoje = date('Y-m-d');
            
            $representante = Representante::with('pessoa')->find($request->representante_id);

            $novaTroca = Troca::create([
                'titulo' => $representante->pessoa->nome . ' - ' . date('d/m/Y'),
                'data_troca' => $hoje,
                'taxa_juros' => $request->taxa_juros,
                'observacao' => 'Gerado automaticamente',
            ]);
            // dd($novaTroca); 
            $dataInicio = new DateTime($novaTroca->data_troca);
        }
        
        for ($i = 0; $i < $request->quantidade_cheques; $i++) { 
            $cheque = Parcela::create([
                'representante_id' => $request->representante_id,
                'nome_cheque' => $request->nome_cheque[$i],
                'numero_cheque' => $request->numero_cheque[$i],
                'valor_parcela' => $request->valor_parcela[$i],
                'data_parcela' => $request->data_parcela[$i],
                'forma_pagamento' => 'Cheque',
                'status' => 'Aguardando',
            ]);    
    
            if ($request->nova_troca == 'Sim') {
                $taxa_troca = $novaTroca->taxa_juros/100;
                $dataFim = new DateTime($cheque->data_parcela);
                $diferencaDias = $dataInicio->diff($dataFim);
    
                $juros = ( ($cheque->valor_parcela * $taxa_troca) / 30 ) * $diferencaDias->days;
                $valorLiquido = $cheque->valor_parcela - $juros;
                
                TrocaParcela::create([
                    'parcela_id' => $cheque->id,
                    'troca_id' => $novaTroca->id,
                    'valor_liquido' => $valorLiquido,
                    'valor_juros' => $juros,
                    'dias' => $diferencaDias->days,
                ]);
            }
        }

        if ($request->nova_troca == 'Sim') {
            $cheques = TrocaParcela::withSum('parcelas', 'valor_parcela')
            ->where('troca_id', $novaTroca->id)
            ->get();
            // dd($cheques->sum('parcelas_sum_valor_parcela'));

            $novaTroca->update([
                'valor_bruto' => $cheques->sum('parcelas_sum_valor_parcela'),
                'valor_liquido' => $cheques->sum('valor_liquido'),
                'valor_juros' => $cheques->sum('valor_juros'),
            ]);
        }
        return redirect()->route('cheques.index');
    }

    public function carteira_cheque_total () 
    {

        $carteira = Parcela::select(DB::raw('sum(valor_parcela) as `valor`, YEAR(data_parcela) year, LPAD (MONTH(data_parcela),2,0) month'))
            ->where([
                ['forma_pagamento', 'Cheque'],
                ['status', '!=', 'Pago'],
                ['status', '!=', 'Depositado'],
                ['status', '!=', 'Adiado'],
                ['parceiro_id', NULL],
            ])
            //['data_parcela', '>=', DB::raw('curdate()')],
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('cheque.pdf.carteira', compact('carteira') );
        
        return $pdf->stream();
    }

    public function consulta_cheque(Request $request)
    {
        $cheques = DB::select(' SELECT 
                                    par.id,
                                    UPPER(par.nome_cheque) as nome_cheque,
                                    par.data_parcela,
                                    par.numero_cheque,
                                    Concat(?,Format(valor_parcela, 2, ?) ) AS valor_parcela_tratado,
                                    par.valor_parcela,
                                    UPPER(par.status) AS status,
                                    (SELECT UPPER(p.nome) FROM pessoas p WHERE p.id = r.pessoa_id) AS nome_representante,
                                    (SELECT UPPER(p.nome) FROM pessoas p WHERE p.id = pa.pessoa_id) AS nome_parceiro,
                                    par.numero_banco,
                                    par.parceiro_id,
                                    a.nova_data
                                FROM
                                    parcelas par
                                LEFT JOIN
                                    representantes r ON r.id = par.representante_id
                                LEFT JOIN
                                    parceiros pa ON pa.id = par.parceiro_id
                                LEFT JOIN
                                    adiamentos a ON a.parcela_id = par.id
                                WHERE 
                                    NOT EXISTS( SELECT id FROM adiamentos AS M2 WHERE M2.parcela_id = a.parcela_id AND M2.id > a.id) 
                                    AND par.deleted_at IS NULL
                                    AND par.'.$request->tipo_select.' = ?
                                    ORDER BY par.data_parcela', 
                                [
                                    'R$ ',
                                    'de_DE',
                                    $request->texto_pesquisa,
                                ]
        );

        return json_encode($cheques);
    }

    public function depositar_diario()
    {
        Parcela::where([
            ['data_parcela','<=', DB::raw('CURDATE()')],
            ['parceiro_id', NULL],
            ['status', 'Aguardando']
        ])->update(['status' => 'Depositado']);
        
        return redirect()->route('home');
    }
}