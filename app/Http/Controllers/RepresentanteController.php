<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestFormPessoa;
use App\Pessoa;
use App\Representante;
use Illuminate\Http\Request;

class RepresentanteController extends Controller {
    
    public function index(Request $request) 
    {
        $representantes = Representante::all();
        $message = $request->session()->get('message');
        
        return view('representante.index', compact('representantes', 'message'));
    }
    
    public function create() 
    {
        return view('representante.create');
    }

    public function store(RequestFormPessoa $request) 
    {
        $pessoa = Pessoa::create($request->all());
        Representante::create([
            'pessoa_id' => $pessoa->id
        ]);
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

    public function update (RequestFormPessoa $request, $id) 
    {
        $representante = Representante::findOrFail($id);
        $pessoa = Pessoa::findOrFail($representante->pessoa_id);
        
        $pessoa->fill($request->all())
            ->save();
            
        $request
            ->session()
            ->flash(
                'message',
                'Representante atualizado com sucesso!'
            );
        return redirect()->route('representantes.index');
    }

    public function destroy (Request $request, $id) {

        Representante::destroy($id);

        $request
            ->session()
            ->flash(
                'message',
                'Representante excluído com sucesso!'
            );
        return redirect()->route('representantes.index');
    }
} 

?>