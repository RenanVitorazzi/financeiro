<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdemDePagamentoRequest;
use App\Models\Parcela;
use App\Models\Representante;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordensPagamento = DB::select("SELECT 
        p.data_parcela, 
        p.valor_parcela, 
        UPPER(pa.nome) AS nome_cliente, 
        p.nome_cheque,
        p.observacao,
        p.id, 
        (SELECT UPPER(p1.nome) FROM representantes r1 INNER JOIN pessoas p1 ON p1.id= r1.pessoa_id where r1.id = v.representante_id) as nome_representante
        FROM parcelas p
        LEFT JOIN vendas v ON v.id = p.venda_id
        LEFT JOIN clientes c ON c.id = v.cliente_id
        LEFT JOIN pessoas pa ON pa.id = c.pessoa_id
        where status like 'Aguardando Pagamento'
        ORDER BY p.data_parcela, p.valor_parcela");
    
        $qtdDiasParaSexta = 5 - Carbon::now()->dayOfWeek;
        
        return view('op.index', compact('ordensPagamento', 'qtdDiasParaSexta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $representantes = Representante::with('pessoa')->get();

        return view('op.create', compact('representantes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrdemDePagamentoRequest $request)
    {
        // dd($request->validated());
        $i = 0;
        foreach ($request->valor_parcela as $valor => $valor2) {

            $op = Parcela::create([
                'nome_cheque' => $request->nome_cheque,
                'representante_id' => $request->representante_id,
                'valor_parcela' => $valor2,
                'data_parcela' => $request->data_parcela[$i],
                'observacao' => $request->observacao[$i],
                'status' => 'Aguardando',
                'forma_pagamento' => 'Depósito',
            ]);
            
            $i++;
            
        }
        return redirect()->route('ops.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
