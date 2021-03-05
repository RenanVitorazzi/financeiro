<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Http\Requests\RequestFormPessoa;
use App\Models\Venda;
use App\Pessoa;
use App\Representante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $clientes = Cliente::with(['pessoa', 'representante'])->get();
        $message = $request->session()->get('message');
        // dd($clientes->first()->venda->last()->metodo_pagamento);
        return view('cliente.index', compact('clientes', 'message'));
    }

    public function create()
    {
        $representantes = Representante::all();
        
        return view('cliente.create', compact('representantes'));
    }

    public function store(RequestFormPessoa $request)
    {
        $pessoa = Pessoa::create($request->all());
        Cliente::create([
            'pessoa_id' => $pessoa->id,
            'representante_id' => $request->representante
        ]);

        $request
            ->session()
            ->flash(
                'message',
                'Cliente cadastrado com sucesso!'
            );

        return redirect()->route('clientes.index');
    }

    public function show(Cliente $cliente) {

        $vendas = Venda::with(['parcela'])
            ->where('cliente_id', $cliente->id)
            // ->paginate(10);
            ->get();

        // $totalAberto = DB::table('vendas')
        //     ->selectRaw('sum(peso) as peso, sum(fator) as fator, balanco')
        //     ->where('cliente_id', $cliente->id)
        //     ->groupBy('balanco')
        //     ->orderBy('balanco')
        //     ->get();
        //     dd($totalAberto);
        return view('cliente.show', compact('cliente', 'vendas'));
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        $representantes = Representante::all();

        return view('cliente.edit', compact('cliente', 'representantes'));
    }

    public function update(RequestFormPessoa $request, $id) 
    {
        $cliente = Cliente::findOrFail($id);
        $pessoa = Pessoa::findOrFail($cliente->pessoa_id);
        
        $pessoa->fill($request->all())
            ->save();
            
        $cliente->representante_id = $request->representante_id;
        $cliente->save();
            
        $request
            ->session()
            ->flash(
                'message',
                'Cliente atualizado com sucesso!'
            );
        return redirect()->route('clientes.index');
    }

    public function destroy(Request $request, $id) 
    {
        Cliente::destroy($id);

        $request
            ->session()
            ->flash(
                'message',
                'Cliente excluído com sucesso!'
            );
        return redirect()->route('clientes.index');
    }
    
}
