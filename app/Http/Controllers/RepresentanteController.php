<?php

namespace App\Http\Controllers;

use App\Http\Requests\baixarDebitosRepresentantesRequest;
use App\Http\Requests\RequestFormPessoa;
use App\Models\Adiamento;
use App\Models\ContaCorrenteRepresentante;
use App\Models\Parcela;
use App\Models\Pessoa;
use App\Models\Representante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class RepresentanteController extends Controller {
    
    public function index(Request $request)
    {
        $representantes = Representante::with('pessoa', 'conta_corrente', 'venda')->get();
        $message = $request->session()->get('message');
        $devolvidos = Parcela::where('status', 'Devolvido')->get();
        
        return view('representante.index', compact('representantes', 'message', 'devolvidos'));
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

    public function pdf_cc_representante ($representante_id) 
    {
        $representante = Representante::findOrFail($representante_id);
        
        $saldos = DB::select('SELECT * FROM (
                SELECT 
                    pr.data as data, 
                    pr.valor as valor, 
                    CONCAT(?, p.forma_pagamento, ?, p.status, ?, p.nome_cheque, ?,DATE_FORMAT(p.data_parcela, ?), ?, pr.forma_pagamento, ?, c.nome) AS nome,
                    ? as status 
                FROM 
                    pagamentos_representantes pr 
                        LEFT JOIN parcelas p ON p.id = pr.parcela_id
                        LEFT JOIN contas c ON c.id = pr.conta_id
                WHERE 
                    pr.representante_id = ? 
                    AND pr.baixado IS NULL 
                    AND pr.deleted_at IS NULL
                    AND p.forma_pagamento like ?
                UNION ALL 
                
                SELECT 
                    date(pr.created_at) as data, 
                    p.valor_parcela as valor, 
                    CONCAT(p.nome_cheque, ?, DATE_FORMAT(p.data_parcela, ?), ?, p.status, ?, ?, p.numero_cheque, ?) as nome,
                    pr.representante_status as status
                FROM
                    parcelas_representantes pr
                        INNER JOIN
                    parcelas p ON p.id = pr.parcela_id
                WHERE
                    p.representante_id = ?
            ) a
            ORDER BY data, valor', 
            [
                'Crédito Ref. ', ' ', ' - ', ' (', '%d/%m/%Y',') - ', ' ', 
                'Crédito', 
                $representante_id, 
                'Cheque', 
                ' - ', '%d/%m/%Y',' - ', ' - ', ' (nº ', ')', 
                $representante_id
            ]
        );
        // dd($saldos);
        $saldo_total = 0;
        
        $pdf = App::make('dompdf.wrapper');
        $hoje = date('Y-m-d');
        $pdf->loadView('representante.pdf.pdf_cc_representante', compact('saldos', 'representante', 'saldo_total', 'hoje') );
        
        return $pdf->stream();
    }

    public function pdf_cheques_devolvidos_escritorio ($representante_id) 
    {
        $representante = Representante::findOrFail($representante_id);
        
        $cheques = DB::select('SELECT 
            p.id,
            p.numero_cheque,
            p.numero_banco,
            p.nome_cheque,
            p.data_parcela,
            p.valor_parcela,
            SUM(pr.valor) AS valor_pago
        FROM
            parcelas p
                INNER JOIN
            movimentacoes_cheques mc ON p.id = mc.parcela_id
                AND mc.status LIKE ?
                LEFT JOIN
            entrega_parcela e ON e.parcela_id = p.id
                AND entregue_parceiro IS NOT NULL
                AND entregue_representante IS NULL
                LEFT JOIN
            pagamentos_representantes pr ON pr.parcela_id = p.id
                AND pr.deleted_at IS NULL
                AND p.deleted_at IS NULL
        WHERE
            p.representante_id = ?
                AND p.status NOT LIKE ?
        GROUP BY p.id , mc.status , e.parcela_id
        ORDER BY p.nome_cheque , data_parcela , valor_parcela',
        ['Devolvido', $representante->id, 'Pago']);

        $saldo_total = 0;

        $pdf = App::make('dompdf.wrapper');
        $hoje = date('Y-m-d');
        $pdf->loadView('representante.pdf.pdf_cheques_devolvidos_escritorio', compact('cheques', 'representante', 'saldo_total', 'hoje') );
        
        return $pdf->stream();
    }
} 

?>