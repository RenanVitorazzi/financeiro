<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Models\Estoque;
use App\Models\ContaCorrente;
use App\Models\ContaCorrenteRepresentante;
use App\Http\Requests\AdicionarEstoqueRequest;

class EstoqueController extends Controller
{
    public function index()
    {
        $lancamentos =  DB::select('SELECT
                e.*,
                e.balanco AS balanco_estoque,
                (SELECT p.nome FROM  representantes r INNER JOIN pessoas p ON p.id =r.pessoa_id WHERE  ccr.representante_id = r.id ) AS nome_representante,
                (SELECT p.nome FROM  fornecedores f INNER JOIN pessoas p ON p.id =f.pessoa_id WHERE  ccf.fornecedor_id = f.id ) AS nome_fornecedor,
                ccf.balanco AS balanco_fornecedor,
                ccr.balanco AS balanco_representante,
                ccr.representante_id,
                ccf.fornecedor_id,
                ccf.observacao AS observacao_fornecedor,
                ccr.observacao AS observacao_representante,
                (SELECT SUM(peso_agregado)
                    FROM estoque
                    WHERE deleted_at IS NULL
                    AND (data < e.data OR (data = e.data AND id <= e.id))) as saldo_peso,
                (SELECT SUM(fator_agregado)
                    FROM estoque
                    WHERE deleted_at IS NULL
                    AND (data < e.data OR (data = e.data AND id <= e.id))) as saldo_fator,
                r.atacado AS representante_atacado
            FROM estoque e
            LEFT JOIN conta_corrente ccf ON ccf.id = e.cc_fornecedor_id AND ccf.deleted_at IS NULL
            LEFT JOIN conta_corrente_representante ccr ON ccr.id = e.cc_representante_id AND ccr.deleted_at IS NULL
            LEFT JOIN representantes r ON r.id = ccr.representante_id
            WHERE e.deleted_at is null
            ORDER BY e.data'
        );

        $lancamentos_pendentes = DB::select('SELECT * FROM (
            SELECT
                ccf.peso, ccf.balanco, p.nome, DATE_FORMAT(ccf.data, ?) AS data_tratada , ? AS tabela, ccf.data, ccf.id
                FROM conta_corrente ccf
                INNER JOIN fornecedores f ON f.id = ccf.fornecedor_id
                INNER JOIN pessoas p ON p.id = f.pessoa_id
                WHERE lancado_estoque IS NULL
                    AND balanco like ?
                    AND ccf.deleted_at IS NULL
                    AND f.deleted_at IS NULL
            UNION

            SELECT ccr.peso, ccr.balanco, p.nome, DATE_FORMAT(ccr.data, ?) AS data_tratada, ? AS tabela, ccr.data, ccr.id
                FROM conta_corrente_representante ccr
                INNER JOIN representantes r ON r.id = ccr.representante_id AND r.atacado = 1
                INNER JOIN pessoas p ON p.id = r.pessoa_id
                WHERE lancado_estoque IS NULL
                AND ccr.deleted_at IS NULL
                AND balanco in (?,?)
            ) a
            ORDER BY data',
            ['%d/%m/%Y', 'conta_corrente', 'Débito', '%d/%m/%Y', 'conta_corrente_representante','Reposição','Devolução']
        );

        return view('estoque.index', compact('lancamentos', 'lancamentos_pendentes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $conta_corrente = '';
        $balancoReal = '';
        $tabela = '';
        return view('estoque.create', compact('conta_corrente', 'balancoReal', 'tabela'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdicionarEstoqueRequest $request)
    {
        $representante_id = NULL;
        $fornecedor_id = NULL;
        $cc_representante_id = NULL;
        $cc_fornecedor_id = NULL;
        $peso_agregado = $request->peso;
        $fator_agregado = $request->fator;

        if ($request->conta_corrente_id) {

            if ($request->tabela == 'conta_corrente') {

                ContaCorrente::where('id', $request->conta_corrente_id)->update(['lancado_estoque' => 1]);

                $contaCorrente = ContaCorrente::where('id', $request->conta_corrente_id)->first();
                $fornecedor_id = $contaCorrente->fornecedor_id;
                $cc_fornecedor_id = $contaCorrente->id;

            } else if ($request->tabela == 'conta_corrente_representante') {

                if ($request->balanco == 'Reposição') {
                    $peso_agregado = -$request->peso;
                    $fator_agregado = -$request->fator;
                }

                contaCorrenteRepresentante::where('id', $request->conta_corrente_id)
                    ->update([
                        'lancado_estoque' => 1
                    ]);

                $contaCorrenteRepresentante = contaCorrenteRepresentante::where('id', $request->conta_corrente_id)->first();
                $representante_id = $contaCorrenteRepresentante->representante_id;
                $cc_representante_id = $contaCorrenteRepresentante->id;
            }
        } else {
            if ($request->balanco == 'Débito') {
                $peso_agregado = -$peso_agregado;
                $fator_agregado = -$fator_agregado;
            }
        }

        Estoque::create([
            'data' => $request->data,
            'balanco' => $request->balanco,
            'peso' => $request->peso,
            'fator' => $request->fator,
            'representante_id' => $representante_id,
            'fornecedor_id' => $fornecedor_id,
            'peso_agregado' => $peso_agregado,
            'fator_agregado' => $fator_agregado,
            'user_id' => auth()->user()->id,
            'cc_representante_id' => $cc_representante_id,
            'cc_fornecedor_id' => $cc_fornecedor_id,
            'observacao' => $request->observacao
        ]);

        return redirect("/estoque");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estoque = Estoque::findOrFail($id);

        return view('estoque.edit', compact('estoque'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdicionarEstoqueRequest $request, $id)
    {

        Estoque::findOrFail($id)->update($request->validated());

        return redirect("/estoque");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function lancar_cc_estoque($conta_corrente_id, $tabela) {

        if ($tabela == 'conta_corrente_representante') {
            $conta_corrente = DB::select('SELECT p.nome, ccr.*
                FROM conta_corrente_representante ccr
                INNER JOIN representantes r ON r.id = ccr.representante_id
                INNER JOIN pessoas p ON p.id = r.pessoa_id
                WHERE ccr.id = ?',
                [$conta_corrente_id]
            );

            $balancoReal = $conta_corrente[0]->balanco;

        } else {
            $conta_corrente = DB::select('SELECT p.nome, ccf.*
                FROM conta_corrente ccf
                INNER JOIN fornecedores f ON f.id = ccf.fornecedor_id
                INNER JOIN pessoas p ON p.id = f.pessoa_id
                WHERE ccf.id = ?',
                [$conta_corrente_id]
            );

            if ($conta_corrente[0]->balanco == 'Débito') {
                $balancoReal = 'Compra';
            } else {
                $balancoReal = 'Devolução';
            }
        }

        $conta_corrente = $conta_corrente[0];
        return view('estoque.create', compact('conta_corrente', 'balancoReal', 'tabela'));

    }

    public function pdf_estoque()
    {
        $lancamentos =  DB::select('SELECT
                e.*,
                e.balanco AS balanco_estoque,
                (SELECT p.nome FROM  representantes r INNER JOIN pessoas p ON p.id =r.pessoa_id WHERE  ccr.representante_id = r.id ) AS nome_representante,
                (SELECT p.nome FROM  fornecedores f INNER JOIN pessoas p ON p.id =f.pessoa_id WHERE  ccf.fornecedor_id = f.id ) AS nome_fornecedor,
                ccf.balanco AS balanco_fornecedor,
                ccr.balanco AS balanco_representante,
                ccr.representante_id,
                ccf.fornecedor_id,
                ccf.observacao AS observacao_fornecedor,
                ccr.observacao AS observacao_representante,
                (SELECT SUM(peso_agregado)
                    FROM estoque
                    WHERE deleted_at IS NULL
                    AND (data < e.data OR (data = e.data AND id <= e.id))) as saldo_peso,
                (SELECT SUM(fator_agregado)
                    FROM estoque
                    WHERE deleted_at IS NULL
                    AND (data < e.data OR (data = e.data AND id <= e.id))) as saldo_fator,
                r.atacado AS representante_atacado
            FROM estoque e
            LEFT JOIN conta_corrente ccf ON ccf.id = e.cc_fornecedor_id AND ccf.deleted_at IS NULL
            LEFT JOIN conta_corrente_representante ccr ON ccr.id = e.cc_representante_id AND ccr.deleted_at IS NULL
            LEFT JOIN representantes r ON r.id = ccr.representante_id
            WHERE e.deleted_at is null
            ORDER BY e.data'
        );

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('estoque.pdf.pdf_estoque', compact('lancamentos') );

        return $pdf->stream();
    }
}
