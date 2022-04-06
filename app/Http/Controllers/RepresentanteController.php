<?php

namespace App\Http\Controllers;

use App\Http\Requests\baixarDebitosRepresentantesRequest;
use App\Http\Requests\RequestFormPessoa;
use App\Models\Adiamento;
use App\Models\ContaCorrenteRepresentante;
use App\Models\Parcela;
use App\Models\Pessoa;
use App\Models\Representante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class RepresentanteController extends Controller {
    
    public function index(Request $request)
    {
        $representantes = Representante::with('pessoa', 'conta_corrente', 'venda')->get();
        $message = $request->session()->get('message');
        $devolvidos = Parcela::where('status', 'Devolvido')->get();
        
        return view('representante.index', compact('representantes', 'message', 'devolvidos'));
    }
    
    public function create()
    {
        return view('representante.create');
    }

    public function store(RequestFormPessoa $request)
    {
        DB::transaction(function () use ($request) {
            $pessoa = Pessoa::create($request->validated());
    
            Representante::create([
                'pessoa_id' => $pessoa->id
            ]);
        });

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

    public function show($id)
    {
        $representante = Representante::with('pessoa')
            ->withSum('conta_corrente', 'peso_agregado')
            ->withSum('conta_corrente', 'fator_agregado')
            ->adiamentos()
            ->findOrFail($id);
        
        $devolvidos = Parcela::with('parceiro')
            ->where('status', 'Devolvido')
            ->where('representante_id', $id)
            ->orderBy('data_parcela')
            ->get();

        return view('representante.show', compact('representante', 'devolvidos'));
    }

    public function update (RequestFormPessoa $request, $id)
    {
        $representante = Representante::findOrFail($id);
        $pessoa = Pessoa::findOrFail($representante->pessoa_id);
        
        $pessoa->fill($request->validated())
            ->save();
            
        $request
            ->session()
            ->flash(
                'message',
                'Representante atualizado com sucesso!'
            );

        return redirect()->route('representantes.index');
    }

    public function destroy (Request $request, $id)
    {
        Representante::destroy($id);
        
        $request
            ->session() 
            ->flash(
                'message',
                'Registro deletado com sucesso!'
            );

        return redirect()->route('representantes.index');
    }

    public function impresso()
    {
        $representantes = Representante::with('pessoa', 'conta_corrente')->get();
        $contaCorrenteGeral = ContaCorrenteRepresentante::get();
        $devolvidos = Parcela::where('status', 'Devolvido')->get();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('representante.pdf.impresso', compact('representantes', 'contaCorrenteGeral', 'devolvidos') );
            
        return $pdf->stream();
    }

    public function baixarDebitosRepresentantes(baixarDebitosRepresentantesRequest $request, $representante_id)
    {
        //TODO criar botão desfazer
        if ($request->devolvidos) {
            Parcela::whereIn('id', $request->devolvidos)->update(['status' => 'Pago']);
        }
        
        if ($request->adiamentos) {
            Adiamento::whereIn('id', $request->adiamentos)->update(['pago' => 1]);
        }
        
        return redirect()->route('representantes.show', $representante_id);

    }
} 

?>