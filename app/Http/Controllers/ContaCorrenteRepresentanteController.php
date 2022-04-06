<?php

namespace App\Http\Controllers;

use App\Models\ContaCorrenteRepresentante;
use App\Models\Representante;
use App\Http\Requests\ContaCorrenteRepresentanteRequest;
use App\Models\ContaCorrenteRepresentanteAnexos as ModelsContaCorrenteRepresentanteAnexos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ContaCorrenteRepresentanteController extends Controller
{
    public function create(Request $request)
    {
        $representante = Representante::with('pessoa')->find($request->representante_id);
        $balanco = ['Reposição', 'Venda', 'Devolução'];

        return view('conta_corrente_representante.create', compact('representante', 'balanco'));
    }

    public function store(ContaCorrenteRepresentanteRequest $request)
    {
        if ($request->balanco == 'Venda' || $request->balanco == 'Devolução') {
            $peso_agregado = $request->peso;
            $fator_agregado = $request->fator;
        } else {
            $peso_agregado = -$request->peso;
            $fator_agregado = -$request->fator;
        }

        $request->request->add(['peso_agregado' => $peso_agregado]);
        $request->request->add(['fator_agregado' => $fator_agregado]);

        $contaCorrente = ContaCorrenteRepresentante::create($request->all());
        
        if ($request->hasFile('anexo')) {
            foreach ($request->file('anexo') as $file) {
                ModelsContaCorrenteRepresentanteAnexos::create([
                    'nome' => $file->getClientOriginalName(),
                    'conta_corrente_id' => $contaCorrente->id,
                    'path' => $file->store('conta_corrente_representante/' . $contaCorrente->id, 'public'),
                ]);
            }
        }
        
        $request
            ->session()
            ->flash(
                'message',
                'Registro criado com sucesso!'
            );

        return redirect()->route("conta_corrente_representante.show", $contaCorrente->representante_id);
    }

    public function show($id)
    {
        $contaCorrente = DB::select("SELECT cc.*,
            sum(cc.peso_agregado) OVER (ORDER BY cc.data, cc.id) as saldo_peso,
            sum(cc.fator_agregado) OVER (ORDER BY cc.data, cc.id) as saldo_fator
            FROM conta_corrente_representante cc
            WHERE cc.representante_id = ? AND cc.deleted_at IS NULL
            ORDER BY cc.data, cc.id ",
            [$id]
        );

        $representante = Representante::with('pessoa')->findOrFail($id);
        
        return view('conta_corrente_representante.show', compact('contaCorrente', 'representante'));
    }

    public function edit($id)
    {
        $contaCorrente = ContaCorrenteRepresentante::with('representante')->findOrFail($id);
        $balanco = ['Reposição', 'Venda', 'Devolução'];

        return view('conta_corrente_representante.edit', compact('contaCorrente', 'balanco'));
    }

    public function update(ContaCorrenteRepresentanteRequest $request, $id)
    {  
        if ($request->balanco == 'Reposição') {
            $peso_agregado = -$request->peso;
            $fator_agregado = -$request->fator;
        } else {
            $peso_agregado = $request->peso;
            $fator_agregado = $request->fator;
        }

        $request->request->add(['peso_agregado' => $peso_agregado]);
        $request->request->add(['fator_agregado' => $fator_agregado]);

        $contaCorrente = ContaCorrenteRepresentante::findOrFail($id);
        $contaCorrente
            ->fill($request->all())
            ->save();

        $request
            ->session() 
            ->flash(
                'message',
                'Registro atualizado com sucesso!'
            );

        return redirect()->route("conta_corrente_representante.show", $request->representante_id);
    }

    public function destroy(Request $request, $id)
    {
        $contaCorrente = ContaCorrenteRepresentante::findOrFail($id);
        $contaCorrente->delete();

        $request
            ->session()
            ->flash(
                'message',
                'Registro excluído com sucesso!'
            );

        return redirect()->route("conta_corrente_representante.show", $contaCorrente->representante_id);
    }

    public function impresso($id)
    {
        $contaCorrente = DB::select("SELECT cc.*,
            sum(cc.peso_agregado) OVER (ORDER BY cc.data, cc.id) as saldo_peso,
            sum(cc.fator_agregado) OVER (ORDER BY cc.data, cc.id) as saldo_fator
            FROM conta_corrente_representante cc
            WHERE cc.representante_id = ? AND cc.deleted_at IS NULL
            ORDER BY data, cc.id",
            [$id]
        );

        $representante = Representante::with('pessoa')->findOrFail($contaCorrente[0]->representante_id);
    
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('conta_corrente_representante.pdf.impresso', compact('contaCorrente', 'representante') );
            
        return $pdf->stream();
    }

    public function impresso2($id)
    {
        $contaCorrente = DB::select("SELECT cc.*,
            sum(cc.peso_agregado) OVER (ORDER BY cc.data, cc.id) as saldo_peso
            FROM conta_corrente_representante cc
            WHERE cc.representante_id = ? AND cc.deleted_at IS NULL
            ORDER BY data asc, id asc",
            [$id]
        );

        $representante = Representante::with('pessoa')->findOrFail($contaCorrente[0]->representante_id);
        
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('conta_corrente_representante.pdf.impresso_terceiros', compact('contaCorrente', 'representante') );
            
        return $pdf->stream();
    }
}
