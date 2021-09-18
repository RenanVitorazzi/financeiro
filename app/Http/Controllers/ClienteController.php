<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pessoa;
use App\Models\Representante;
use App\Http\Requests\RequestFormPessoa;
use App\Models\Venda;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $clientes = Cliente::with(['pessoa', 'representante'])->get();
        $message = $request->session()->get('message');
        
        return view('cliente.index', compact('clientes', 'message'));
    }

    public function create()
    {
        $representantes = Representante::with('pessoa')->get();
        
        return view('cliente.create', compact('representantes'));
    }

    public function store(RequestFormPessoa $request)
    {
        $pessoa = Pessoa::create($request->validated());

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
            ->get();

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
        
        $pessoa->fill($request->validated())
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

    public function procurarCliente(Request $request)
    {
        $clientes = Cliente::query()
            ->with('pessoa')
            ->whereHas('pessoa', function (Builder $query) use ($request) {
                $query->where('nome', 'like', '%'.$request->dado.'%');
                $query->orWhere('cpf', 'like', $request->dado);
            })
            ->where('representante_id', $request->representante_id)
            ->get();

        return json_encode([
            'clientes' => $clientes
        ]);
    }
    
}
