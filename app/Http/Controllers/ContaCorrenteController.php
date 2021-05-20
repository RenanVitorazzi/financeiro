<?php

namespace App\Http\Controllers;

use App\Models\ContaCorrente;
use App\Models\Fornecedor;
use App\Http\Requests\ContaCorrenteRequest;
use App\Models\ContaCorrenteAnexos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContaCorrenteController extends Controller
{
    public function create(Request $request)
    {
        $fornecedor = Fornecedor::findOrFail($request->fornecedor_id);
        
        return view('contaCorrente.create', compact('fornecedor'));
    }

    public function store(ContaCorrenteRequest $request)
    {
        if ($request->balanco == 'Débito') {
            $peso_agregado = -$request->peso;
        } else {
            $peso_agregado = $request->peso;
        }
        
        $request->request->add(['peso_agregado' => $peso_agregado]);
        
        $contaCorrente = ContaCorrente::create(
            $request->all()
        );

        if ($request->hasFile('anexo')) {
            foreach ($request->file('anexo') as $file) {
                ContaCorrenteAnexos::create([
                    'nome' => $file->getClientOriginalName(),
                    'conta_corrente_id' => $contaCorrente->id,
                    'path' => $file->store('conta_corrente/' . $contaCorrente->id, 'public'),
                ]);
            }
        }

        $request
            ->session()
            ->flash(
                'message',
                'Conta corrente criada com sucesso!'
            );

        return redirect("/fornecedores/{$request->fornecedor_id}");
    }

    public function edit($id)
    {
        $contaCorrente = contaCorrente::findOrFail($id);
        $fornecedores = Fornecedor::with('pessoa')->get();
        
        return view("contaCorrente.edit", compact("contaCorrente", "fornecedores"));
    }

    public function update(ContaCorrenteRequest $request, $id)
    {
        $contaCorrente = contaCorrente::findOrFail($id);
        
        if ($request->balanco == 'Débito') {
            $peso_agregado = -$request->peso;
        } else {
            $peso_agregado = $request->peso;
        }

        $request->request->add(['peso_agregado' => $peso_agregado]);
        
        $contaCorrente
            ->fill($request->all())
            ->save();
        
        $request
            ->session()
            ->flash(
                'message',
                'Conta corrente atualizada com sucesso!'
            );

        return redirect("/fornecedores/{$request->fornecedor_id}");
    }

    public function destroy($id)
    {
        $contaCorrente = ContaCorrente::findOrFail($id);
        
        if (ContaCorrenteAnexos::where('conta_corrente_id', $id)->exists()) {
            ContaCorrenteAnexos::where('conta_corrente_id', $id)->delete();
            Storage::disk('public')->deleteDirectory('conta_corrente/' . $id);
        }

        $contaCorrente->delete();
        
        return json_encode([
            'icon' => 'success',
            'title' => 'Sucesso!',
            'text' => 'Fornecedor excluído com sucesso!',
        ]);
        
    }
}
