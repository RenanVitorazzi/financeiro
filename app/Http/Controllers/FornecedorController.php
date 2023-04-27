<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestFormPessoa;
use App\Models\Adiamento;
use App\Models\Fornecedor;
use App\Models\Pessoa;
use App\Models\ContaCorrente;
use App\Models\Parceiro;
use App\Models\Parcela;
use App\Models\Representante;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class FornecedorController extends Controller
{
    public function index(Request $request)
    {
        $fornecedores = Fornecedor::with(['pessoa'])
        ->withSum('contaCorrente', 'peso_agregado')
        ->get()
        ->sortBy('conta_corrente_sum_peso_agregado');

        $labels = json_encode($fornecedores->pluck('pessoa.nome'));

        $data = json_encode($fornecedores->pluck('conta_corrente_sum_peso_agregado'));

        $message = $request->session()->get('message');
        
        return view('fornecedor.index', compact('fornecedores', 'message', 'labels', 'data'));
    }

    public function create()
    {
        return view('fornecedor.create');
    }

    public function store(RequestFormPessoa $request)
    {
        $pessoa = Pessoa::create($request->validated());

        Fornecedor::create([
            'pessoa_id' => $pessoa->id,
        ]);
        
        $request
            ->session()
            ->flash(
                'message',
                'Fornecedor cadastrado com sucesso!'
            );

        return redirect()->route('fornecedores.index');
    }

    public function show($id)
    {
        $fornecedor = Fornecedor::with('pessoa')->findOrFail($id);

        $registrosContaCorrente = DB::select("SELECT id, 
                data, 
                balanco, 
                peso, 
                observacao, 
                (SELECT SUM(peso_agregado) 
                    FROM conta_corrente 
                    WHERE fornecedor_id = ? 
                    AND deleted_at IS NULL 
                    AND (data < cc.data OR (data = cc.data AND id <= cc.id))) as saldo
            FROM 
                conta_corrente cc
            WHERE 
                fornecedor_id = ? 
                AND deleted_at IS NULL
            ORDER BY data, id", 
            [$id, $id]
        );
        
        return view('fornecedor.show',  compact('fornecedor', 'registrosContaCorrente'));    
    }

    public function edit($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);

        return view('fornecedor.edit', compact('fornecedor'));
    }

    public function update(RequestFormPessoa $request, $id)
    {
        $fornecedor = Fornecedor::findOrFail($id);

        $pessoa = Pessoa::findOrFail($fornecedor->pessoa_id);
        
        $pessoa->fill($request->all())
            ->save();

        $request
            ->session()
            ->flash(
                'message',
                'Fornecedor atualizado com sucesso!'
            );

        return redirect()->route('fornecedores.index');
    }

    public function destroy(Request $request, $id)
    {
        Fornecedor::destroy($id);
        ContaCorrente::where('fornecedor_id', $id)->delete();
        
        $request
        ->session()
        ->flash(
            'message',
            'Fornecedor excluído com sucesso!'
        );

        return redirect()->route('fornecedores.index');
    }

    public function pdf_fornecedores()
    {
        $fornecedores = Fornecedor::with(['pessoa'])
        ->withSum('contaCorrente', 'peso_agregado')
        ->get()
        ->sortBy('conta_corrente_sum_peso_agregado');

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('fornecedor.pdf.fornecedores', compact('fornecedores') );
        
        return $pdf->stream();
    }

    public function pdf_fornecedor($id)
    {
        $fornecedor = Fornecedor::with('pessoa')->findOrFail($id);

        $registrosContaCorrente = DB::select("SELECT id, data, balanco, peso, observacao, (SELECT SUM(peso_agregado) 
            FROM conta_corrente 
            WHERE fornecedor_id = ? 
            AND deleted_at IS NULL 
            AND (data < cc.data OR (data = cc.data AND id <= cc.id))) as saldo 
        FROM conta_corrente cc
        WHERE fornecedor_id = ? 
        AND deleted_at IS NULL
        ORDER BY data, id", [$id, $id]);
        
        // dd($contas);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('fornecedor.pdf.relacao_fornecedor', compact('fornecedor', 'registrosContaCorrente') );
        
        return $pdf->stream();
    }

    public function pdf_diario()
    {
        $fornecedores = Fornecedor::with(['pessoa'])
            ->withSum('contaCorrente', 'peso_agregado')
            ->get()
            ->sortBy('conta_corrente_sum_peso_agregado');

        $carteira = DB::select('SELECT 
                sum(valor_parcela) as total_mes,
                MONTH(IF(par.status = ?,
                    (SELECT nova_data FROM adiamentos WHERE parcela_id = par.id ORDER BY id desc LIMIT 1), 
                    par.data_parcela
                )) as month,
                YEAR(IF(par.status = ?,
                    (SELECT nova_data FROM adiamentos WHERE parcela_id = par.id ORDER BY id desc LIMIT 1), 
                    par.data_parcela
                )) as year
            FROM
                parcelas par
            WHERE
                par.status in (?,?)
                    AND par.deleted_at IS NULL
                    AND parceiro_id IS NULL
                    AND forma_pagamento LIKE ?
                    GROUP BY YEAR( IF(par.status = ?,
                    (SELECT nova_data FROM adiamentos WHERE parcela_id = par.id ORDER BY id desc LIMIT 1), 
                    par.data_parcela
                ) ), MONTH( IF(par.status = ?,
                    (SELECT nova_data FROM adiamentos WHERE parcela_id = par.id ORDER BY id desc LIMIT 1), 
                    par.data_parcela
                ) )
            ORDER BY 3,2',
            ['Adiado', 'Adiado', 'Adiado', 'Aguardando', 'Cheque', 'Adiado', 'Adiado']
        );
        
        $totalCarteira =  DB::select('SELECT 
                sum(valor_parcela) as totalCarteira
            FROM
                parcelas par
            WHERE
                par.status in (?,?)
                    AND par.deleted_at IS NULL
                    AND parceiro_id IS NULL
                    AND forma_pagamento LIKE ?',
            ['Adiado', 'Aguardando', 'Cheque']
        );
        
        $devolvidos = Parcela::where('status', 'Devolvido')->get();

        $representantes = Representante::with('pessoa')
            ->withSum('conta_corrente', 'peso_agregado')
            ->withSum('conta_corrente', 'fator_agregado')
            ->get();
        
        $adiamentos = Parcela::withSum('adiamentos', 'juros_totais')
            ->whereHas('adiamentos')
            ->get();
        
        
        $parceiros = DB::select('SELECT 
                SUM(juros_totais) AS totalJuros, pe.nome AS nomeParceiro
            FROM
                troca_adiamentos t
                    INNER JOIN
                parcelas p ON p.id = t.parcela_id
                    INNER JOIN
                parceiros pa ON pa.id = p.parceiro_id
                    INNER JOIN
                pessoas pe ON pe.id = pa.pessoa_id
            WHERE
                t.pago IS NULL
                AND t.deleted_at IS NULL
                AND pa.deleted_at IS NULL
            GROUP BY pa.id
        ');
        
        $mes = date('m');
        $Op = DB::select('SELECT 
                MONTH(p.data_parcela) AS mes, 
                SUM(p.valor_parcela) AS total_devedor, 
                SUM((SELECT SUM(valor) FROM pagamentos_representantes pr WHERE pr.parcela_id = p.id  AND pr.deleted_at is null)) AS total_pago
            FROM
                parcelas p
                    LEFT JOIN
                vendas v ON v.id = p.venda_id
                    INNER JOIN
                clientes c ON c.id = v.cliente_id
                    INNER JOIN
                pessoas pe ON pe.id = c.pessoa_id
            WHERE
                p.forma_pagamento IN (?, ?, ?)
                    AND p.status LIKE ?
                    AND year(p.data_parcela) = year(CURDATE())
                    AND v.deleted_at is null
                AND p.deleted_at is null
                    GROUP BY MONTH(p.data_parcela)
                    ORDER BY 1',
            ['Cheque' , 'Pix', 'Transferência Bancária', 'Aguardando Pagamento']
        );

        $chequesAguardandoEnvio = DB::select('SELECT 
            SUM(VALOR_PARCELA) AS valor, MONTH(data_parcela) AS mes
            FROM parcelas where forma_pagamento like ? 
            AND status like ?
            AND deleted_at is null
            GROUP BY MONTH(data_parcela)
            ORDER BY MONTH(data_parcela)',
            ['Cheque', 'Aguardando Envio']
        );
        $chequesAguardandoEnvioTotal = 0;
        $totalDevedorGeral = 0;
        $totalPagoGeral = 0;
        $opsVencidasDevedoras = 0;
        $opsPagas = 0;
        
        // $pagamentoMed = DB::select('SELECT 
        //     (SELECT IFNULL(sum(peso), 0) FROM conta_corrente WHERE balanco like ? and fornecedor_id = f.id AND deleted_at is null) 
        //     -
        //     ((SELECT IFNULL(sum(peso)/2, 0) FROM conta_corrente WHERE balanco like ? and fornecedor_id = f.id AND (datediff(curdate(), data) between 30 and 59) AND deleted_at is null ) + 
        //     (SELECT IFNULL(sum(peso), 0) FROM conta_corrente WHERE balanco like ? and fornecedor_id = f.id AND (datediff(curdate(), data) >= 60) AND deleted_at is null ) ) AS total,
        //     (SELECT nome from pessoas WHERE f.pessoa_id = id) as fornecedor,
        //     f.id as fornecedor_id
        //     FROM fornecedores f',
        //     [
        //         'Crédito', 'Débito', 'Débito'
        //     ]
        // );
        $hoje = date('d/m/Y');

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'fornecedor.pdf.diario', 
            compact(
                'fornecedores', 
                'carteira', 
                'representantes', 
                'devolvidos', 
                'adiamentos', 
                'hoje', 
                'parceiros', 
                'totalCarteira',
                'Op', 
                'mes',
                'opsVencidasDevedoras',
                'opsPagas',
                'totalDevedorGeral',
                'totalPagoGeral',
                'chequesAguardandoEnvio',
                'chequesAguardandoEnvioTotal'
            ) 
        );
        
        return $pdf->stream();
    }

    public function pdf_mov_diario()
    {
        $adiamentos = DB::select("SELECT 
                p.data_parcela, 
                p.valor_parcela, 
                p.nome_cheque AS nome_cheque,
                a.nova_data,
                a.juros_totais,
                (SELECT nome FROM pessoas p WHERE p.id = pp.pessoa_id) as nome_parceiro,
                (SELECT nome FROM pessoas p WHERE p.id = r.pessoa_id) as nome_representante
            FROM parcelas p 
            INNER JOIN adiamentos a ON a.parcela_id = p.id 
            LEFT JOIN parceiros pp ON p.parceiro_id = pp.id
            LEFT JOIN representantes r ON r.id = p.representante_id 
            WHERE 
                DATE_FORMAT(a.created_at, '%Y-%m-%d') = CURDATE()
                AND p.deleted_at is null
            ORDER BY r.id, p.data_parcela, p.valor_parcela");

        $cc_fornecedor = DB::select("SELECT 
                cc.peso, 
                p.nome, 
                cc.cotacao, 
                cc.valor,
                cc.balanco,
                cc.observacao
            FROM conta_corrente cc 
            INNER JOIN fornecedores f ON f.id = cc.fornecedor_id
            INNER JOIN pessoas p ON p.id = f.pessoa_id 
            WHERE 
                DATE_FORMAT(cc.created_at, '%Y-%m-%d') = CURDATE() 
                AND cc.deleted_at is null");
    
        $cc_representante = DB::select("SELECT 
                cc.peso,
                cc.fator,
                cc.balanco, 
                p.nome, 
                cc.observacao 
            FROM conta_corrente_representante cc 
            INNER JOIN representantes r ON r.id = cc.representante_id 
            INNER JOIN pessoas p ON p.id = r.pessoa_id 
            WHERE 
                DATE_FORMAT(cc.created_at, '%Y-%m-%d') = CURDATE() 
                AND cc.deleted_at is null");

            $devolvidos = DB::select('SELECT 
                p.nome_cheque ,
                p.valor_parcela,
                p.data_parcela,
                mc.status,
                mc.motivo,
                (SELECT nome FROM pessoas WHERE pessoas.id = r.pessoa_id) AS nome_representante,
                (SELECT nome FROM pessoas WHERE pessoas.id = pa.pessoa_id) AS nome_parceiro
                FROM
                movimentacoes_cheques mc
                    INNER JOIN
                parcelas p ON p.id = mc.parcela_id
                    LEFT JOIN
                representantes r ON r.id = p.representante_id
                    LEFT JOIN
                parceiros pa ON pa.id = p.parceiro_id
                WHERE
                p.status IN (?,?)
                AND CONVERT( mc.data , DATE) = CURDATE()', 
                ['Resgatado', 'Devolvido']
            );

            $depositados = DB::select('SELECT 
                p.nome_cheque ,
                p.valor_parcela,
                p.data_parcela,
                p.status,
                p.motivo,
                (SELECT nome FROM pessoas WHERE pessoas.id = r.pessoa_id) AS nome_representante                FROM
                movimentacoes_cheques mc
                    INNER JOIN
                parcelas p ON p.id = mc.parcela_id
                    LEFT JOIN
                representantes r ON r.id = p.representante_id
                    LEFT JOIN
                parceiros pa ON pa.id = p.parceiro_id
                WHERE
                p.status IN (?)
                AND CONVERT( mc.data , DATE) = CURDATE()', 
                ['Depositado']
            );
    
        $hoje = date('Y-m-d');
        $juros_totais = 0;
        $total_devolvido = 0;
        $total_depositado = 0;

            

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'fornecedor.pdf.mov_diario', 
            compact(
                'total_depositado',
                'depositados',
                'total_devolvido',
                'devolvidos',
                'juros_totais',
                'hoje',
                'cc_representante', 
                'adiamentos', 
                'cc_fornecedor'
            ) 
        );
        
        return $pdf->stream();
    }
    
}
