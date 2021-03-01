<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestFormPessoa;
use App\Parceiro;
use App\Pessoa;
use Illuminate\Http\Request;

class ParceiroController extends Controller
{
    public function index(Request $request) 
    {
        $parceiros = Parceiro::all();
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
            'porcentagem_padrao' => 'required|numeric',
        ]);

        $pessoa = Pessoa::create($request->all());

        Parceiro::create([
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
}

?>