<?php

namespace App\Http\Controllers;

use App\Http\Requests\baixarDebitosRepresentantesRequest;
use App\Http\Requests\RequestFormPessoa;
use App\Models\Adiamento;
use App\Models\ContaCorrenteRepresentante;
use App\Models\EntregaParcela;
use App\Models\Parcela;
use App\Models\Pessoa;
use App\Models\Representante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class RepresentanteController extends Controller {

    public function index(Request $request)
    {
        $representantes = Representante::with('pessoa:id,nome')
            ->withSum('conta_corrente', 'peso_agregado')
            ->withSum('conta_corrente', 'fator_agregado')
            ->orderBy('atacado')
            ->get();

        $message = $request->session()->get('message');

        return view('representante.index', compact('representantes', 'message'));
    }

    public function create()
    {
        return view('representante.create');
    }

    public function store(RequestFormPessoa $request)
    {
        DB::transaction(function () use ($request) {
            $pessoa = Pessoa::create($request->validated());

            Representante::create([
                'pessoa_id' => $pessoa->id
            ]);
        });

        $request
            ->session()
            ->flash(
                'message',
                'Representante cadastrado com sucesso!'
            );
        return redirect()->route('representantes.index');
    }

    public function edit($id)
    {
        $representante = Representante::findOrFail($id);

        return view('representante.edit', compact('representante'));
    }

    public function show($id)
    {
        $representante = Representante::with('pessoa')
            ->withSum('conta_corrente', 'peso_agregado')
            ->withSum('conta_corrente', 'fator_agregado')
            ->adiamentos()
            ->findOrFail($id);

        $devolvidos = Parcela::with('parceiro')
            ->where('status', 'Devolvido')
            ->where('representante_id', $id)
            ->orderBy('data_parcela')
            ->get();

        return view('representante.show', compact('representante', 'devolvidos'));
    }

    public function update (RequestFormPessoa $request, $id)
    {
        $representante = Representante::findOrFail($id);
        $pessoa = Pessoa::findOrFail($representante->pessoa_id);

        $pessoa->fill($request->validated())
            ->save();

        $request
            ->session()
            ->flash(
                'message',
                'Representante atualizado com sucesso!'
            );

        return redirect()->route('representantes.index');
    }

    public function destroy (Request $request, $id)
    {
        Representante::destroy($id);

        $request
            ->session()
            ->flash(
                'message',
                'Registro deletado com sucesso!'
            );

        return redirect()->route('representantes.index');
    }

    public function impresso()
    {
        $representantes = Representante::with('pessoa', 'conta_corrente')->get();
        $contaCorrenteGeral = ContaCorrenteRepresentante::get();
        $devolvidos = Parcela::where('status', 'Devolvido')->get();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('representante.pdf.impresso', compact('representantes', 'contaCorrenteGeral', 'devolvidos') );

        return $pdf->stream();
    }

    public function baixarDebitosRepresentantes(baixarDebitosRepresentantesRequest $request, $representante_id)
    {
        //TODO criar botão desfazer
        if ($request->devolvidos) {
            Parcela::whereIn('id', $request->devolvidos)->update(['status' => 'Pago']);
        }

        if ($request->adiamentos) {
            Adiamento::whereIn('id', $request->adiamentos)->update(['pago' => 1]);
        }

        return redirect()->route('representantes.show', $representante_id);

    }

    // public function pdf_cc_representante ($representante_id)
    // {
    //     $representante = Representante::findOrFail($representante_id);

    //     $saldos = DB::select('SELECT * FROM (
    //             SELECT
    //                 pr.data as data,
    //                 pr.valor as valor,
    //                 CONCAT(?, p.forma_pagamento, ?, p.status, ?, p.nome_cheque, ?,DATE_FORMAT(p.data_parcela, ?), ?, pr.forma_pagamento, ?, c.nome) AS nome,
    //                 ? as status
    //             FROM
    //                 pagamentos_representantes pr
    //                     LEFT JOIN parcelas p ON p.id = pr.parcela_id
    //                     LEFT JOIN contas c ON c.id = pr.conta_id
    //             WHERE
    //                 pr.representante_id = ?
    //                 AND pr.baixado IS NULL
    //                 AND pr.deleted_at IS NULL
    //                 AND p.forma_pagamento like ?
    //             UNION ALL

    //             SELECT
    //                 date(pr.created_at) as data,
    //                 p.valor_parcela as valor,
    //                 CONCAT(p.nome_cheque, ?, DATE_FORMAT(p.data_parcela, ?), ?, p.status, ?, ?, p.numero_cheque, ?) as nome,
    //                 pr.representante_status as status
    //             FROM
    //                 parcelas_representantes pr
    //                     INNER JOIN
    //                 parcelas p ON p.id = pr.parcela_id
    //             WHERE
    //                 p.representante_id = ?
    //         ) a
    //         ORDER BY data, valor',
    //         [
    //             'Crédito Ref. ', ' ', ' - ', ' (', '%d/%m/%Y',') - ', ' ',
    //             'Crédito',
    //             $representante_id,
    //             'Cheque',
    //             ' - ', '%d/%m/%Y',' - ', ' - ', ' (nº ', ')',
    //             $representante_id
    //         ]
    //     );
    //     // dd($saldos);
    //     $saldo_total = 0;

    //     $pdf = App::make('dompdf.wrapper');
    //     $hoje = date('Y-m-d');
    //     $pdf->loadView('representante.pdf.pdf_cc_representante', compact('saldos', 'representante', 'saldo_total', 'hoje') );

    //     return $pdf->stream();
    // }

    public function pdf_cc_representante($representante_id)
    {

        $representante = Representante::findOrFail($representante_id);
        $infoRepresentante = [
            1 => [
                'Saldo' => -24269,
                'Data' => '2023-04-13'
            ],
            5 => [
                'Saldo' => -33974,
                'Data' => '2023-04-13'
            ],
            20 => [
                'Saldo' => -51400,
                'Data' => '2023-04-13'
            ],
            23 => [
                'Saldo' => -26486,
                'Data' => '2023-04-13'
            ],
            24 => [
                'Saldo' => 0,
                'Data' => '2023-04-13'
            ],
        ];
        // dd($infoRepresentante[$representante_id]['Data'] );

        $saldos = DB::select('SELECT
                (sum(p.valor_parcela) - (SELECT COALESCE(SUM(pr.valor), 0) FROM pagamentos_representantes pr WHERE pr.deleted_at is null  and representante_id = ? AND pr.parcela_id in (SELECT ep1.parcela_id FROM entrega_parcela ep1 where ep1.entregue_representante = ep.entregue_representante) ) ) as valor_total_debito,
                ep.entregue_representante as data_entrega,
                ? as balanco,
                ? as descricao
            FROM movimentacoes_cheques m
            INNER JOIN parcelas p ON p.id = m.parcela_id AND p.representante_id = ? AND m.status IN (?, ?)
            INNER JOIN entrega_parcela ep ON p.id = ep.parcela_id AND entregue_representante IS NOT NULL
            WHERE ep.entregue_representante >= ?
            group by ep.entregue_representante
        UNION
            SELECT  pr.valor, pr.data as data_entrega, ? as balanco, pr.observacao as descricao
            FROM pagamentos_representantes pr
            WHERE pr.representante_id = ?
            AND pr.baixado IS NULL
            AND pr.parcela_id IS NULL
            AND pr.deleted_at IS NULL
        ORDER BY data_entrega',
            [
                $representante_id,
                'Débito',
                'Cheque entregue em mãos',
                $representante_id,
                'Devolvido',
                'Resgatado',
                $infoRepresentante[$representante_id]['Data'],
                'Crédito',
                $representante_id
            ]
        );

        $ValorTotalChequesNaoEntregues = Parcela::where('representante_id', $representante_id)
            ->whereHas('entrega', function ($query) {
                $query->whereNull('entregue_representante')
                    ->whereNotNull('entregue_parceiro');
            })->sum('valor_parcela');

        $ValorTotalChequesComParceiros = Parcela::where('representante_id', $representante_id)
            ->whereHas('movimentacoes', function ($query) {
                $query->whereIn('status', ['Devolvido', 'Resgatado']);
            })
            ->where('data_parcela', '>=', '2023-03-17')
            ->doesntHave('entrega')
            ->sum('valor_parcela');

        $saldo_total = $infoRepresentante[$representante_id]['Saldo'];

        $pdf = App::make('dompdf.wrapper');
        $hoje = date('Y-m-d');
        $pdf->loadView('representante.pdf.pdf_cc_representante_novo', compact('ValorTotalChequesComParceiros', 'saldos', 'representante', 'saldo_total', 'hoje', 'infoRepresentante', 'ValorTotalChequesNaoEntregues') );

        return $pdf->stream();
    }

    public function pdf_cheques_devolvidos_escritorio ($representante_id)
    {
        $representante = Representante::findOrFail($representante_id);

        $cheques = Parcela::with('pagamentos_representantes')
            ->whereHas('entrega', function ($query) {
                $query->whereNull('entregue_representante');
            })
            ->where('status', '<>', 'Pago')
            ->where('representante_id', $representante->id)
            ->orderBy('nome_cheque')
            ->orderBy('data_parcela')
            ->get();

        // dd($cheques);

        // $cheques = DB::select('SELECT
        //     p.id,
        //     p.numero_cheque,
        //     p.numero_banco,
        //     p.nome_cheque,
        //     p.data_parcela,
        //     p.valor_parcela,
        //     SUM(pr.valor) AS valor_pago
        // FROM
        //     parcelas p
        //         INNER JOIN
        //     movimentacoes_cheques mc ON p.id = mc.parcela_id
        //         INNER JOIN
        //     entrega_parcela e ON e.parcela_id = p.id
        //         LEFT JOIN
        //     pagamentos_representantes pr ON pr.parcela_id = p.id
        // WHERE
        //     mc.status LIKE ?
        //         AND p.representante_id = ?
        //         AND p.status NOT LIKE ?
        //         AND pr.deleted_at IS NULL
        //         AND p.deleted_at IS NULL
        //         AND entregue_parceiro IS NOT NULL
        //         AND entregue_representante IS NULL
        // GROUP BY p.id , mc.status , e.parcela_id
        // ORDER BY p.nome_cheque , data_parcela , valor_parcela',
        // ['Devolvido', $representante->id, 'Pago']);

        $totalPago = $cheques->sum(function ($cheques) {
            return $cheques->pagamentos_representantes->sum('valor');
        });
        // dd($totalPago);
        $pdf = App::make('dompdf.wrapper');
        $hoje = date('Y-m-d');
        $pdf->loadView('representante.pdf.pdf_cheques_devolvidos_escritorio',
            compact('cheques', 'representante', 'totalPago', 'hoje')
        )->setPaper('a4', 'landscape');

        return $pdf->stream();
    }
}

?>
