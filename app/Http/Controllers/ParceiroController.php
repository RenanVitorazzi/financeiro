<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestFormPessoa;
use App\Models\Parceiro;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ParceiroController extends Controller
{
    public function index(Request $request)
    {
        $parceiros = Parceiro::with('pessoa')->get();
        $message = $request->session()->get('message');

        return view('parceiro.index', compact('parceiros', 'message'));
    }

    public function create()
    {
        return view('parceiro.create');
    }

    public function store(RequestFormPessoa $request)
    {

        $request->validate([
            'porcentagem_padrao' => 'required|numeric|min:0|max:100',
        ]);

        $pessoa = Pessoa::create($request->all());

        $parceiro = Parceiro::create([
            'pessoa_id' => $pessoa->id,
            'porcentagem_padrao' => $request->porcentagem_padrao
        ]);

        $request
            ->session()
            ->flash(
                'message',
                'Parceiro cadastrado com sucesso!'
            );

        return redirect()->route('parceiros.index');
    }

    public function edit($id)
    {
        $parceiro = Parceiro::findOrFail($id);

        return view('parceiro.edit', compact('parceiro'));
    }

    public function update (RequestFormPessoa $request, $id)
    {
        $parceiro = Parceiro::findOrFail($id);

        $pessoa = Pessoa::findOrFail($parceiro->pessoa_id);

        $pessoa->fill($request->all())
            ->save();

        $parceiro->porcentagem_padrao = $request->porcentagem_padrao;
        $parceiro->save();

        $request
            ->session()
            ->flash(
                'message',
                'Parceiro atualizado com sucesso!'
            );

        return redirect()->route('parceiros.index');
    }

    public function destroy (Request $request, $id)
    {
        Parceiro::destroy($id);

        $request
        ->session()
        ->flash(
            'message',
            'Parceiro excluído com sucesso!'
        );

        return redirect()->route('parceiros.index');
    }

    public function pdf_cc_parceiro ($parceiro_id)
    {
        $parceiro = Parceiro::findOrFail($parceiro_id);

        $saldos = DB::select('SELECT * FROM
                (SELECT
                        mc.data as rank2,
                        p.nome_cheque AS nome_cheque,
                        p.valor_parcela as valor,
                        mc.status
                    FROM
                        movimentacoes_cheques mc
                            INNER JOIN
                        parcelas p ON p.id = mc.parcela_id
                    WHERE
                        p.parceiro_id = ? AND mc.status IN (?,?)
                        AND mc.parcela_id NOT IN  (SELECT parcela_id
                            FROM movimentacoes_cheques
                            WHERE status like ?
                            and deleted_at is null
                            AND parcela_id = mc.parcela_id
                )
            UNION ALL
                SELECT
                    ta2.created_at as rank2,
                    p2.nome_cheque AS nome_cheque,
                    ta2.juros_totais as valor,
                    ?
                FROM parcelas p2
                INNER JOIN troca_adiamentos ta2
                    ON ta2.parcela_id = p2.id AND ta2.pago is null AND p2.parceiro_id = ?
            UNION ALL
                SELECT
                    pp.data as rank2,
                        UPPER(pp.observacao),
                        pp.valor,
                        ?
                    FROM pagamentos_parceiros pp WHERE parceiro_id = ?
                    AND deleted_at is null
                    and baixado is null
                ) a order by rank2',
            [$parceiro_id, 'Devolvido', 'Resgatado', 'Pago parceiro', 'Prorrogação', $parceiro_id, 'Crédito', $parceiro_id]
        );

        $saldo_total = 0;

        $pdf = App::make('dompdf.wrapper');
        $hoje = date('Y-m-d');
        $pdf->loadView('parceiro.pdf.pdf_cc_parceiro', compact('saldos', 'parceiro', 'saldo_total', 'hoje') );

        return $pdf->stream();
    }
}

?>
