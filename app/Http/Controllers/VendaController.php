<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\SalvarVendaRequest;
use App\Models\Consignado;
use App\Models\ContaCorrenteRepresentante;
use App\Models\Parcela;
use App\Models\Venda;
use App\Models\Representante;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    public function create(Request $request)
    {
        $representante_id = $request->id;

        $clientes = DB::select('SELECT 
                                    UPPER(p.nome) AS nome, c.id
                                FROM
                                    clientes c
                                        INNER JOIN
                                    pessoas p ON p.id = c.pessoa_id
                                WHERE
                                    c.representante_id = ?
                                        AND c.deleted_at IS NULL
                                ORDER BY p.nome',
                                [$representante_id]
        );

        $metodo_pagamento = ['À vista', 'Parcelado'];
        $forma_pagamento = ['Dinheiro', 'Cheque', 'Transferência Bancária', 'Pix'];

        return view('venda.create', compact('representante_id', 'clientes', 'metodo_pagamento', 'forma_pagamento'));
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
                'numero_banco' => $request->numero_banco[$key],
                'nome_cheque' => $request->nome_cheque[$key],
                'numero_cheque' => $request->numero_cheque[$key],
                'data_parcela' => $value,
                'status' => $request->status[$key],
                'valor_parcela' => $request->valor_parcela[$key],
                'observacao' => $request->observacao[$key],
                'representante_id' => $venda->representante_id,
            ]);
        }
        
        if ($request->baixar) {
            Consignado::where('id', $request->baixar)->update([
                'baixado' => Carbon::now(),
                'venda_id' => $venda->id
            ]);
        }

        return redirect()->route('venda.show', $venda->representante_id);
    }

    public function show(Request $request, $id)
    {
        if (auth()->user()->is_representante && auth()->user()->is_representante != $id) {
            abort(403);
        }
        
        $vendas = Venda::with('parcela')
            ->where('representante_id', $id)
            ->where('enviado_conta_corrente', null)
            // ->latest()
            ->orderBy('data_venda')
            ->get();
        // dd($vendas);
        $representante = Representante::findOrFail($id);

        return view('venda.show', compact('vendas', 'representante'));
    }

    public function edit($id)
    {
        $venda = Venda::findOrFail($id);
        //TODO criar filtro para que o representante só consiga colocar a própria venda
        $representantes = Representante::with('pessoa')->get();
        $clientes = Cliente::with('pessoa')->get();
        $metodo_pagamento = ['À vista', 'Parcelado'];
        $forma_pagamento = ['Dinheiro', 'Cheque', 'Transferência Bancária', 'Depósito'];

        return view('venda.edit', compact('representantes', 'venda', 'clientes', 'forma_pagamento', 'metodo_pagamento'));
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

    public function destroy(Request $request, $id)
    {
        $venda = Venda::findOrFail($id);
        $venda->delete();

        $request
            ->session() 
            ->flash(
                'message',
                'Venda excluída com sucesso!'
            );

        return redirect()->route('venda.show', $venda->representante_id);
    }

    public function enviarContaCorrente (Request $request) {
        $vendas = Venda::find($request->vendas_id);

        $contaCorrente = ContaCorrenteRepresentante::create([
            'fator' => $vendas->sum('fator'),
            'peso' => $vendas->sum('peso'),
            'fator_agregado' => $vendas->sum('fator'),
            'peso_agregado' => $vendas->sum('peso'),
            'data' => date('Y-m-d'),
            'balanco' => 'Venda',
            'representante_id' => $vendas->first()->representante_id
        ]);

        Venda::whereIn('id', $request->vendas_id)->update([
            'enviado_conta_corrente' => $contaCorrente->id
        ]);
        
        // return redirect()->route('venda.show', $vendas->first()->representante_id);
        return json_encode([
           'contaCorrente' => $contaCorrente->id,
           'route' => route('conta_corrente_representante.show', $contaCorrente->representante_id)
        ]);
    } 

    public function pdf_relatorio_vendas($relatorio_venda_id)
    {
        
        $vendas = DB::select( "SELECT v.data_venda, v.peso, v.fator, v.valor_total, p.nome as nome_cliente
            FROM clientes c
            inner join vendas v ON v.cliente_id = c.id and enviado_conta_corrente = ?
            inner join pessoas p ON p.id = c.pessoa_id
            ORDER BY v.data_venda", 
            [$relatorio_venda_id]
        );
        

        $totalVendas =  DB::select( "SELECT sum(v.peso) as peso, sum(v.fator) as fator, sum(v.valor_total) as valor_total 
            FROM clientes c
            inner join vendas v ON v.cliente_id = c.id and enviado_conta_corrente = ?", 
            [$relatorio_venda_id]
        );
        // dd($totalVendas);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('venda.pdf.relatorio_venda', compact('vendas', 'totalVendas') );
        
        return $pdf->stream();
    }

    public function pdf_conferencia_relatorio_vendas($representante_id)
    {
        
        $vendas = DB::select( "SELECT v.data_venda, peso,fator, valor_total, UPPER(SUBSTRING(p.nome, 1, 30)) as nome_cliente from vendas  v
            INNER JOIN clientes c ON c.id = v.cliente_id 
            INNER JOIN pessoas p ON p.id = c.pessoa_id 
            WHERE 
            enviado_conta_corrente is null 
            AND v.representante_id = ?
            AND v.deleted_at is NULL
            ORDER BY data_venda, v.created_at", 
            [$representante_id]
        );

        $pagamentos = DB::select( "SELECT 
                SUM(valor_parcela) valor, forma_pagamento, status
            FROM
                parcelas
            WHERE
                venda_id IN (SELECT  id FROM vendas WHERE enviado_conta_corrente IS NULL  AND representante_id = ? AND deleted_at is NULL ) 
            GROUP BY forma_pagamento , status", 
            [$representante_id]
        );

        $pagamentos_total = DB::select( "SELECT 
                SUM(valor_parcela) AS valor
            FROM
                parcelas
            WHERE
                venda_id IN (SELECT  id FROM vendas WHERE enviado_conta_corrente IS NULL  AND representante_id = ? AND deleted_at is NULL ) ", 
            [$representante_id]
        );

        $totalVendas = DB::select( "SELECT SUM(peso) AS peso, SUM(fator) AS fator, SUM(valor_total) AS valor_total
            from vendas  v
            WHERE enviado_conta_corrente is null
            AND v.deleted_at is NULL 
            AND v.representante_id = ?", 
            [$representante_id]
        );

        $representante = Representante::findOrFail($representante_id);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('venda.pdf.pdf_conferencia_relatorio_vendas', compact('vendas', 'representante', 'totalVendas', 'pagamentos', 'pagamentos_total') );
        
        return $pdf->stream();
    }

    public function pdf_acerto_documento($representante_id)
    {
        $acertos = DB::select( "SELECT DISTINCT 
                c.id as cliente_id,
                (SELECT UPPER(nome) from pessoas WHERE id = c.pessoa_id) as cliente
            FROM
                vendas v
                    INNER JOIN
                parcelas p ON p.venda_id = v.id
                    LEFT JOIN clientes c ON c.id = v.cliente_id
                    LEFT JOIN representantes r ON r.id = v.representante_id
            WHERE
                p.deleted_at IS NULL
                AND v.deleted_at IS NULL 
                AND r.id = ?
                AND (
                p.forma_pagamento like 'Cheque' AND p.status like 'Aguardando Envio'
                OR 
                p.forma_pagamento != 'Cheque' AND p.status != 'Pago'
                )
            ORDER BY 2, data_parcela , valor_parcela", 
            [$representante_id]
        );

        $representante = Representante::findOrFail($representante_id);
        $hoje = date('Y-m-d');
        $total_divida_valor = 0;
        $total_divida_valor_pago = 0;

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'venda.pdf.pdf_acerto_documento', 
            compact('representante_id', 
            'acertos', 
            'representante', 
            'total_divida_valor', 
            'total_divida_valor_pago',
            'hoje') 
        );
        
        return $pdf->stream();
    }
}
