<?php

namespace App\Http\Controllers;

use App\Models\ContaCorrenteRepresentante;
use App\Models\Representante;
use App\Models\Estoque;
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
        $representante = Representante::findOrFail($request->representante_id);
        if ($request->balanco == 'Venda' || $request->balanco == 'Devolução') {
            $peso_agregado = $request->peso;
            $fator_agregado = $request->fator;
        } else {
            $peso_agregado = -$request->peso;
            $fator_agregado = -$request->fator;
        }

        $lancado_estoque = ($request->balanco !== 'Venda' && !$representante->atacado) ? 1 : NULL;
    
        $request->request->add(['peso_agregado' => $peso_agregado]);
        $request->request->add(['fator_agregado' => $fator_agregado]);
        $request->request->add(['lancado_estoque' => $lancado_estoque]);

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

        
        if ($request->balanco !== 'Venda' && !$representante->atacado) {
                
            $balanco = $request->balanco == 'Devolução' ? 'Crédito' : 'Débito';

            Estoque::create([
                'data' => $request->data,
                'balanco' => $balanco,
                'peso' => $request->peso,
                'fator' => $request->fator,
                'representante_id' => $request->representante_id,
                'peso_agregado' => $request->peso_agregado,
                'fator_agregado' => $request->fator_agregado,
                'user_id' => auth()->user()->id,
                'cc_representante_id' => $contaCorrente->id,
            ]);
            
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
            (SELECT SUM(peso_agregado) 
                    FROM conta_corrente_representante 
                    WHERE representante_id = ? 
                    AND deleted_at IS NULL 
                    AND (data < cc.data OR (data = cc.data AND id <= cc.id))) as saldo_peso,
                    (SELECT SUM(fator_agregado) 
                    FROM conta_corrente_representante 
                    WHERE representante_id = ? 
                    AND deleted_at IS NULL 
                    AND (data < cc.data OR (data = cc.data AND id <= cc.id))) as saldo_fator
            FROM conta_corrente_representante cc 
            WHERE representante_id = ?
            AND deleted_at IS NULL 
            ORDER BY data, id",
            [$id, $id, $id]
        );

        $representante = Representante::with('pessoa')->findOrFail($id);
        $impresso = 'impresso_ccr';

        if ($representante->atacado) {
            $impresso = 'impresso_ccr2';
        }
        return view('conta_corrente_representante.show', compact('contaCorrente', 'representante', 'impresso'));
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
        $representante = Representante::findOrFail($request->representante_id);

        if (!$representante->atacado) {
            $balanco = $request->balanco == 'Devolução' ? 'Crédito' : 'Débito';

            if ($request->balanco == 'Venda') {
                Estoque::where('cc_representante_id', $contaCorrente->id)->delete();
            } else {
                $estoque = Estoque::updateOrCreate (
                ['cc_representante_id' => $contaCorrente->id],    
                [
                    'data' => $request->data,
                    'balanco' => $balanco,
                    'peso' => $request->peso,
                    'fator' => $request->fator,
                    'representante_id' => $request->representante_id,
                    'peso_agregado' => $request->peso_agregado,
                    'fator_agregado' => $request->fator_agregado,
                    'user_id' => auth()->user()->id,
                    'cc_representante_id' => $contaCorrente->id,
                    'deleted_at' => NULL
                ]);
            }
                      
        } 

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
        
        $representante = Representante::findOrFail($contaCorrente->representante_id);
        
        Estoque::where('cc_representante_id', $contaCorrente->id)->delete();

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
                (SELECT SUM(peso_agregado) 
                    FROM conta_corrente_representante 
                    WHERE representante_id = ? 
                    AND deleted_at IS NULL 
                    AND (data < cc.data OR (data = cc.data AND id <= cc.id))) as saldo_peso,
                (SELECT SUM(fator_agregado) 
                    FROM conta_corrente_representante 
                    WHERE representante_id = ? 
                    AND deleted_at IS NULL 
                    AND (data < cc.data OR (data = cc.data AND id <= cc.id))) as saldo_fator
            FROM conta_corrente_representante cc 
            WHERE representante_id = ?
            AND deleted_at IS NULL 
            ORDER BY data, id",
            [$id, $id, $id]
        );

        $representante = Representante::with('pessoa')->findOrFail($contaCorrente[0]->representante_id);
    
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('conta_corrente_representante.pdf.impresso', compact('contaCorrente', 'representante') );
            
        return $pdf->stream();
    }

    public function impresso2($id)
    {
        $contaCorrente = DB::select("SELECT cc.*, 
            (SELECT SUM(peso_agregado) 
                    FROM conta_corrente_representante 
                    WHERE representante_id = ? 
                    AND deleted_at IS NULL 
                    AND (data < cc.data OR (data = cc.data AND id <= cc.id))) as saldo_peso,
                    (SELECT SUM(fator_agregado) 
                    FROM conta_corrente_representante 
                    WHERE representante_id = ? 
                    AND deleted_at IS NULL 
                    AND (data < cc.data OR (data = cc.data AND id <= cc.id))) as saldo_fator
            FROM conta_corrente_representante cc 
            WHERE representante_id = ?
            AND deleted_at IS NULL 
            ORDER BY data, id",
            [$id, $id, $id]
        );

        $representante = Representante::with('pessoa')->findOrFail($contaCorrente[0]->representante_id);
        
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('conta_corrente_representante.pdf.impresso_terceiros', compact('contaCorrente', 'representante') );
            
        return $pdf->stream();
    }
}
