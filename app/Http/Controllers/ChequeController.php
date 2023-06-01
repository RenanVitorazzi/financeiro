<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChequeRepresentanteRequest;
use App\Http\Requests\ChequeRequest;
use App\Models\Parcela;
use App\Models\Representante;
use App\Models\Troca;
use App\Models\TrocaParcela;
use App\Models\MovimentacaoCheque;
use App\Models\ParcelaRepresentante;
use App\Models\Feriados;
use App\Models\PagamentosRepresentantes;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ChequeController extends Controller
{
    public $feriados;

    public function __construct()
    {
        $this->feriados = Feriados::all();
    }

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
                                    par.status in (?,?)
                                        AND par.deleted_at IS NULL
                                        AND r.deleted_at IS NULL
                                        AND parceiro_id IS NULL
                                        AND forma_pagamento LIKE ?
                                ORDER BY data_parcela ASC, valor_parcela ASC', ['Adiado','Adiado','Aguardando', 'Cheque']);

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
        $status_antigo = $cheque->status;

        $cheque->update($request->validated());
        $arrayStatus = ['Devolvido', 'Resgatado'];

        if ( in_array($cheque->status,$arrayStatus) ) {
            if ( $cheque->parceiro_id != NULL ) {
                $troca_parcela = TrocaParcela::where('parcela_id', $cheque->id)->first();
                $troca_parcela->update(['pago' => NULL]);
            }

            ParcelaRepresentante::firstOrCreate(
                ['parcela_id' => $cheque->id],
                ['representante_status' => $cheque->status]
            );

        }

        if ( $status_antigo != $cheque->status ) {
            MovimentacaoCheque::create([
                'parcela_id' => $cheque->id,
                'status' => $cheque->status,
                'motivo' => $cheque->motivo
            ]);
        }

        return redirect()->route('cheques.index');
    }

    public function create()
    {
        $representantes = Representante::with('pessoa')->get();

        return view('cheque.create', compact('representantes'));
    }

    public function store(ChequeRepresentanteRequest $request)
    {
        $hoje = date('d-m-Y');
        if ($request->nova_troca == 'Sim') {

            $representante = Representante::with('pessoa')->find($request->representante_id);

            $novaTroca = Troca::create([
                'titulo' => $representante->pessoa->nome . ' - ' . $hoje,
                'data_troca' => $request->data_troca,
                'taxa_juros' => $request->taxa_juros,
                'observacao' => 'Gerado automaticamente',
            ]);

            $dataInicio = new DateTime($novaTroca->data_troca);
        }

        for ($i = 0; $i < $request->quantidade_cheques; $i++) {
            $cheque = Parcela::create([
                'representante_id' => $request->representante_id,
                'nome_cheque' => $request->nome_cheque[$i],
                'numero_banco' => $request->numero_banco[$i],
                'numero_cheque' => $request->numero_cheque[$i],
                'valor_parcela' => $request->valor_parcela[$i],
                'data_parcela' => $request->data_parcela[$i],
                'forma_pagamento' => 'Cheque',
                'status' => 'Aguardando',
            ]);

            if ($request->nova_troca == 'Sim') {
                $taxa_troca = $novaTroca->taxa_juros/100;

                $dataFim = new DateTime($cheque->data_parcela);

                //* Confere se é sábado ou domingo ou se o próximo dia útil não é feriado
                while (in_array($dataFim->format('w'), [0, 6])
                    || !$this->feriados->where('data_feriado', $dataFim->format('Y-m-d'))->isEmpty()) {
                    $dataFim->modify('+1 weekday');
                }

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
                ['status', '=', 'Aguardando'],
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

        // $cheques = Parcela::with(['venda.cliente.pessoa.nome', 'representante', 'parceiro', 'adiamentos'])
        //     ->whereIn('status', ['Devolvido', 'Resgatado', 'Aguardando pagamento', 'Aguardando envio'])
        //     ->where($request->tipo_select, '=', $request->texto_pesquisa)

        //     ->orWhere('nome_cheque', 'like', '%'. $request->texto_pesquisa . '%')

        //     ->where('forma_pagamento', 'Cheque')
        //     ->get()
        //     ->toArray();
        $nome_cliente = '%'.$request->texto_pesquisa.'%';

        $cheques = DB::select('SELECT
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
                a.nova_data,
                v.cliente_id,
                a.id as adiamento_id
            FROM
                parcelas par
            LEFT JOIN
                representantes r ON r.id = par.representante_id
            LEFT JOIN
                parceiros pa ON pa.id = par.parceiro_id
            LEFT JOIN
                adiamentos a ON a.parcela_id = par.id
            LEFT JOIN
                vendas v ON par.venda_id = v.id
            WHERE
                NOT EXISTS( SELECT id FROM adiamentos AS M2 WHERE M2.parcela_id = a.parcela_id AND M2.id > a.id)
                AND par.deleted_at IS NULL
                AND par.forma_pagamento like ?
                AND  ('.$request->tipo_select.' = ?
                OR
                    nome_cheque like ?)
                ORDER BY par.data_parcela
                LIMIT 150',
            ['R$ ' ,'de_DE', 'Cheque', $request->texto_pesquisa, $nome_cliente]
        );
        $blackList = DB::select('SELECT DISTINCT
                pa.nome_cheque,
                GROUP_CONCAT(pa.nome_cheque) as nome_cheque,
                GROUP_CONCAT(v.cliente_id) as cliente_id
            FROM
                movimentacoes_cheques p
                    INNER JOIN
                parcelas pa ON pa.id = p.parcela_id
                    LEFT JOIN
                vendas v ON v.id = pa.venda_id
            WHERE
                p.status LIKE ?
                AND p.parcela_id IN (SELECT parcela_id FROM movimentacoes_cheques WHERE status LIKE ? AND p.parcela_id = parcela_id)',
            ['Devolvido', 'Adiado']
        );

        return json_encode(['Cheques' => $cheques, 'blackList' => $blackList]);
    }

    public function depositar_diario()
    {
        $parcelas = Parcela::where([
            ['data_parcela','<=', DB::raw('CURDATE()')],
            ['parceiro_id', NULL],
            ['forma_pagamento', 'Cheque'],
            ['status', 'Aguardando']
        ])->pluck('id');

        Parcela::where([
            ['data_parcela','<=', DB::raw('CURDATE()')],
            ['parceiro_id', NULL],
            ['forma_pagamento', 'Cheque'],
            ['status', 'Aguardando']
        ])->update(['status' => 'Depositado']);

        $hoje = date('Y-m-d');

        foreach($parcelas as $parcela) {
            $movCheque = MovimentacaoCheque::create([
                'parcela_id' => $parcela,
                'status' => 'Depositado'
            ]);

        }

        return redirect()->route('home');
    }

    public function pdf_cheques ($representante_id)
    {
        $representante = Representante::findOrFail($representante_id);

        $parcelas = Parcela::where([
            ['data_parcela','>=', DB::raw('CURDATE()')],
            ['representante_id', $representante_id],
            ['forma_pagamento', 'Cheque'],
            ['status', 'Aguardando'],
        ])
        // ->orderBy('nome_cheque')
        ->orderBy('data_parcela')
        ->orderBy('valor_parcela')

        ->orderBy('numero_cheque')
        ->get();
        // dd($parcelas);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('cheque.pdf.pdf_cheques', compact('parcelas', 'representante') );

        return $pdf->stream();
    }

    public function consulta_parcela_pagamento(Request $request)
    {
        // $cheques = DB::select(' SELECT
        //                             par.id,
        //                             UPPER(par.nome_cheque) as nome_cheque,
        //                             par.data_parcela,
        //                             par.numero_cheque,
        //                             Concat(?,Format(valor_parcela, 2, ?) ) AS valor_parcela_tratado,
        //                             par.valor_parcela,
        //                             UPPER(par.status) AS status,
        //                             par.representante_id,
        //                             (SELECT UPPER(p.nome) FROM pessoas p WHERE p.id = r.pessoa_id) AS nome_representante,
        //                             (SELECT UPPER(p.nome) FROM pessoas p WHERE p.id = pa.pessoa_id) AS nome_parceiro,
        //                             par.numero_banco,
        //                             par.parceiro_id,
        //                             a.nova_data,
        //                             (SELECT UPPER(p.nome) FROM pessoas p WHERE p.id = c.pessoa_id) AS nome_cliente,
        //                             par.forma_pagamento
        //                         FROM
        //                             parcelas par
        //                         LEFT JOIN
        //                             representantes r ON r.id = par.representante_id
        //                         LEFT JOIN
        //                             parceiros pa ON pa.id = par.parceiro_id
        //                         LEFT JOIN
        //                             adiamentos a ON a.parcela_id = par.id
        //                         LEFT JOIN
        //                             vendas v ON v.id = par.venda_id
		// 						LEFT JOIN
		// 							clientes c ON c.id = v.cliente_id
        //                         LEFT JOIN
        //                             pessoas p ON p.id = c.pessoa_id
        //                         WHERE
        //                             NOT EXISTS( SELECT id FROM adiamentos AS M2 WHERE M2.parcela_id = a.parcela_id AND M2.id > a.id)
        //                             AND par.deleted_at IS NULL
        //                             AND par.status NOT LIKE ?
        //                             AND (par.'.$request->tipo_select.' = ? OR p.nome LIKE ?)
        //                             ORDER BY par.data_parcela',
        //                         [
        //                             'R$ ',
        //                             'de_DE',
        //                             'Aguardando',
        //                             $request->texto_pesquisa,
        //                             $request->texto_pesquisa
        //                         ]
        // );

        return Parcela::with(['venda', 'representante', 'parceiro', 'adiamentos'])
            ->whereIn('status', ['Devolvido', 'Resgatado', 'Aguardando pagamento', 'Aguardando envio'])
            ->where($request->tipo_select, $request->texto_pesquisa)

            ->orWhere('nome_cheque', 'like', '%'. $request->texto_pesquisa . '%')
            ->get()
            ->toJson();
    }

    public function titularDoUltimoCheque(Request $request)
    {
        $titular = DB::select('SELECT DISTINCT
                p.nome_cheque, p.numero_banco
            FROM
                vendas v
            INNER JOIN
                parcelas p ON p.venda_id = v.id
            WHERE
                v.cliente_id = ?
                AND p.forma_pagamento LIKE ?
            ORDER BY p.id DESC',
            [$request->cliente_id, 'Cheque']
        );

        return json_encode($titular);
    }

    public function procurar_pagamento(Request $request)
    {
        return PagamentosRepresentantes::where('parcela_id', $request->parcela_id)->get();
    }
}
