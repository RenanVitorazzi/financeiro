<?php

namespace App\Http\Controllers;

use App\Models\ContaCorrenteRepresentante;
use App\Representante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContaCorrenteRepresentanteController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        $representantes = Representante::all();
        return view('conta_corrente_representante.create', compact('representantes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fator' => 'required|numeric|min:0',
            'peso' => 'required|numeric|min:0',
            'data' => 'required',
            'balanco' => 'required',
            'representante_id' => 'required',
        ]);

        ContaCorrenteRepresentante::create(
            $request->all()
        );

        $request
        ->session()
        ->flash(
            'message',
            'Conta corrente criada com sucesso!'
        );

        return redirect("/conta_corrente_representante/{$request->representante_id}");
    }

    public function show($id)
    {
        $contaCorrente = ContaCorrenteRepresentante::select('id', 'peso', 'fator', 'balanco', 'data', 'representante_id', 'observacao')
        ->where('representante_id', $id)
        ->orderBy('data')
        ->paginate(10);

        $somaNegativa = ContaCorrenteRepresentante::select(DB::raw('sum( peso ) as peso, sum( fator ) as fator'))
            ->where('representante_id', $id)
            ->where('balanco', '=', 'Reposição')
            ->get();

        $somaPositiva = ContaCorrenteRepresentante::select(DB::raw('sum( peso ) as peso, sum( fator ) as fator'))
            ->where('representante_id', $id)
            ->where('balanco', '<>', 'Reposição')
            ->get();

        $balancoPeso = $somaPositiva[0]->peso - $somaNegativa[0]->peso;
        $balancoFator = $somaPositiva[0]->fator - $somaNegativa[0]->fator;
        
        $representante = Representante::findOrFail($id);

        return view('representante.show', compact('contaCorrente', 'representante', 'balancoPeso', 'balancoFator'));
    }

    public function edit($id)
    {
        $contaCorrente = ContaCorrenteRepresentante::findOrFail($id);
        $representantes = Representante::all();

        return view('conta_corrente_representante.edit', compact('contaCorrente', 'representantes'));
    }

    public function update(Request $request, $id)
    {  
        $request->validate([
            'fator' => 'required|numeric|min:0',
            'peso' => 'required|numeric|min:0',
            'data' => 'required',
            'balanco' => 'required',
            'representante_id' => 'required',
        ]);

        $contaCorrente = ContaCorrenteRepresentante::findOrFail($id);
        $contaCorrente
            ->fill($request->all())
            ->save();

        $request
            ->session() 
            ->flash(
                'message',
                'Conta corrente atualizada com sucesso!'
            );

        return redirect("/conta_corrente_representante/{$request->representante_id}");

    }

    public function destroy(Request $request, $id)
    {
        $contaCorrente = ContaCorrenteRepresentante::findOrFail($id);
        $representante_id = $contaCorrente->representante_id;
        
        $contaCorrente->delete();

        $request
            ->session()
            ->flash(
                'message',
                'Conta corrente excluído com sucesso!'
            );

        return redirect("/conta_corrente_representante/{$representante_id}");
    }
}
