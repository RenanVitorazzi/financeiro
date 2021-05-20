<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChequeRepresentanteRequest;
use App\Http\Requests\ChequeRequest;
use App\Models\Parcela;
use App\Models\Representante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChequeController extends Controller
{
    public function index() {
        
        // $cheques = DB::select(
        //     "SELECT par.numero_cheque, 
        //         par.id as id,
        //         par.valor_parcela, 
        //         par.status, 
        //         par.data_parcela,
        //         par.observacao, 
        //         p.nome as cliente,
        //         (SELECT p.nome FROM pessoas p WHERE p.id = r.pessoa_id) as representante
        //     FROM 
        //         parcelas AS par
        //         LEFT JOIN vendas as v ON v.id = par.venda_id
        //         INNER JOIN clientes as c ON c.id = v.cliente_id
        //         INNER JOIN pessoas as p ON p.id = c.pessoa_id
        //         INNER JOIN representantes as r ON r.id = v.representante_id"
        // );

        $cheques = Parcela::where('forma_pagamento', 'Cheque')
            ->orderBy('data_parcela')
            ->get();
        
        $arrayCores = [
            'Devolvido' => 'text-danger', 
            'Adiado' => 'text-warning', 
            'Sustado' => 'text-danger', 
            'Pago' => 'text-success', 
            'Aguardando' => 'text-muted'
        ];

        return view('cheque.index', compact('cheques', 'arrayCores') );
    }

    public function edit($id)
    {
        $cheque = Parcela::findOrFail($id);
        $situacoesCheque = ['Pago', 'Sustado', 'Adiado', 'Aguardando', 'Devolvido'];

        return view('cheque.edit', compact('cheque', 'situacoesCheque'));
    }

    public function update (ChequeRequest $request, $id) {
        $cheque = Parcela::findOrFail($id);
        $cheque->update($request->validated());

        return redirect()->route('cheques.index');
    }

    public function create()
    {
        $representantes = Representante::with('pessoa')->get();
        return view('cheque.create', compact('representantes'));
    }

    public function store(ChequeRepresentanteRequest $request)
    {
        for ($i=0; $i < $request->quantidade_cheques; $i++) { 
            Parcela::create([
                'representante_id' => $request->representante_id,
                'nome_cheque' => $request->nome_cheque[$i],
                'numero_cheque' => $request->numero_cheque[$i],
                'valor_parcela' => $request->valor_parcela[$i],
                'data_parcela' => $request->data_parcela[$i],
                'forma_pagamento' => 'Cheque',
                'status' => 'Aguardando',
            ]);    
        }

        return redirect()->route('cheques.index');
    }
}