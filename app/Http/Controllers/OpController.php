<?php

namespace App\Http\Controllers;

use App\Models\Parcela;
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
        $ordensPagamento = Parcela::with('representante')
        ->where([
            ['forma_pagamento', 'Depósito'],
            ['status', 'Aguardando'],
        ])
        ->orderBy('data_parcela')
        ->orderBy('valor_parcela')
        ->get();
        
        $qtdDiasParaSexta = 5 - Carbon::now()->dayOfWeek;
        
        $ordensPagamentoParaSemana = Parcela::with('representante')
        ->where([
            ['forma_pagamento', 'Depósito'],
            ['status', 'Aguardando'],
            ['data_parcela', '<=', DB::raw('DATE_ADD(curdate(), INTERVAL '.$qtdDiasParaSexta.' day)')],
        ])
        ->orderBy('data_parcela')
        ->orderBy('valor_parcela')
        ->get();

        return view('op.index', compact('ordensPagamento', 'ordensPagamentoParaSemana'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
