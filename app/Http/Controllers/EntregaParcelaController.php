<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parceiro;
use App\Models\Parcela;
use App\Models\Representante;
use App\Models\EntregaParcela;
use App\Models\PagamentosRepresentantes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class EntregaParcelaController extends Controller
{
    public function index()
    {
        $parceiros = Parceiro::with('pessoa')->get();
        $representantes = Representante::with('pessoa')->get();

        return view('entrega_parcela.index', compact('parceiros', 'representantes'));
    }

    public function entrega_representante($representante_id)
    {
        $representante = Representante::findOrFail($representante_id);

        $cheques = DB::select('SELECT
                p.data_parcela, nome_cheque, numero_cheque, valor_parcela, mc.motivo, mc.status, p.id
            FROM
                parcelas p
                    INNER JOIN
                entrega_parcela ep ON ep.parcela_id = p.id
                    LEFT JOIN
                movimentacoes_cheques mc ON mc.parcela_id = p.id
            WHERE
                ep.entregue_parceiro is not null
                AND ep.entregue_representante is null
                    AND p.forma_pagamento LIKE ?
                    AND p.representante_id = ?

            GROUP BY p.id
            ORDER BY data_parcela, valor_parcela',
            ['Devolvido' , 'Resgatado', 'Cheque', $representante_id]
        );

        // $cheques = DB::select('SELECT
        //         p.data_parcela, nome_cheque, numero_cheque, valor_parcela, mc.motivo, mc.status, p.id
        //     FROM
        //         parcelas p
        //             INNER JOIN
        //         movimentacoes_cheques mc ON mc.parcela_id = p.id
        //     WHERE
        //         mc.status IN (?, ?)
        //             AND p.forma_pagamento LIKE ?
        //             AND p.representante_id = ?
        //             AND p.id NOT IN
        //                 (SELECT parcela_id FROM entrega_parcela WHERE entregue_representante IS NOT NULL)

        //     GROUP BY p.id
        //     ORDER BY data_parcela, valor_parcela',
        //     ['Devolvido' , 'Resgatado', 'Cheque', $representante_id]
        // );

        $hoje = date('Y-m-d');
        $tipo = 'entregue_representante';

        return view('entrega_parcela.receber_parceiro', compact('tipo', 'representante', 'cheques', 'hoje'));
    }

    public function receber_parceiro($parceiro_id)
    {
        $parceiro = Parceiro::findOrFail($parceiro_id);

        $cheques = DB::select('SELECT
                p.data_parcela, nome_cheque, numero_cheque, valor_parcela, mc.motivo, mc.status, p.id
            FROM
                parcelas p
                    INNER JOIN
                movimentacoes_cheques mc ON mc.parcela_id = p.id
            WHERE
                mc.status IN (?, ?)
                    AND p.forma_pagamento LIKE ?
                    AND p.parceiro_id = ?
                    AND p.id NOT IN
                        (SELECT parcela_id FROM entrega_parcela where entregue_parceiro IS NOT NULL)
            GROUP BY p.id
            ORDER BY data_parcela, valor_parcela',
            ['Devolvido' , 'Resgatado', 'Cheque', $parceiro_id]
        );
        $tipo = 'entregue_parceiro';
        return view('entrega_parcela.receber_parceiro', compact('tipo', 'parceiro', 'cheques'));
    }

    public function store(Request $request)
    {
        foreach ($request->cheque_id as $index => $parcela_id) {
            $entrega = EntregaParcela::updateOrCreate(
                ['parcela_id' => $parcela_id],
                [$request->tipo => DB::raw('NOW()')]
            );
        }

        $request
            ->session()
            ->flash(
                'message',
                'Baixa efetuada!'
            );

        return redirect()->back();
    }

    public function pdf_cheques_entregues($representante_id, $data_entrega)
    {
        $representante = Representante::findOrFail($representante_id);

        $cheques = DB::select('SELECT
                p.id,
                p.nome_cheque,
                p.data_parcela,
                p.valor_parcela,
                p.numero_cheque,
                ep.entregue_representante,
                IF (
					(SELECT id from movimentacoes_cheques WHERE parcela_id = p.id AND status like ?) > 0, ?, p.status
                ) as status
            FROM parcelas p
            INNER JOIN entrega_parcela ep ON p.id = ep.parcela_id
            WHERE p.representante_id = ?
                AND entregue_representante = ?
            ORDER BY p.data_parcela,p.valor_parcela',
            ['Pago representante', 'Pago', $representante_id, $data_entrega]
        );

        $chequeId = [];
        $totalCheque = 0;

        foreach($cheques as $cheque) {
            array_push($chequeId, $cheque->id);

            $totalCheque += $cheque->valor_parcela;
        }

        $pagamentos = PagamentosRepresentantes::with('conta')
            ->whereIn('parcela_id', $chequeId)->get();

        $pdf = App::make('dompdf.wrapper');
        // $pdf->setPaper('A4', 'landscape');
        $pdf->loadView('entrega_parcela.pdf.pdf_cheques_entregues', compact('totalCheque', 'pagamentos','cheques', 'representante') );

        return $pdf->stream();
    }
}
