<?php

namespace App\Http\Controllers;

use App\Models\ContaCorrenteRepresentante;
use App\Representante;
use Illuminate\Http\Request;

class ContaCorrenteRepresentanteController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $contaCorrente = ContaCorrenteRepresentante::select('id', 'peso', 'fator', 'balanco', 'data', 'representante_id')
        ->where('representante_id', $id)
        ->get();
        
        return view('representante.show', compact('contaCorrente'));
    }

    public function edit($id)
    {
        $contaCorrente = ContaCorrenteRepresentante::findOrFail($id);
        $representantes = Representante::all();
        // dd($contaCorrente);
        return view('conta_corrente_representante.edit', compact('contaCorrente', 'representantes'));
    }


    public function update(Request $request, $id)
    {
        $contaCorrente = ContaCorrenteRepresentante::findOrFail($id);
        $contaCorrente->update([
            $request->all()
        ]);
        $contaCorrente->save();

        
    }

    public function destroy(ContaCorrenteRepresentanteController $contaCorrenteRepresentanteController)
    {
        //
    }
}
