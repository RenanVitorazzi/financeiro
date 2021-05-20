<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestFormPessoa;
use App\Models\Fornecedor;
use App\Models\Pessoa;
use App\Models\ContaCorrente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class FornecedorController extends Controller
{
    public function index(Request $request)
    {
        $fornecedores = Fornecedor::with(['pessoa'])
        ->withSum('contaCorrente', 'peso_agregado')
        ->get();
        
        $message = $request->session()->get('message');
        
        return view('fornecedor.index', compact('fornecedores', 'message'));
    }

    public function create()
    {
        return view('fornecedor.create');
    }

    public function store(RequestFormPessoa $request)
    {
        $pessoa = Pessoa::create($request->validated());

        Fornecedor::create([
            'pessoa_id' => $pessoa->id,
        ]);
        
        $request
            ->session()
            ->flash(
                'message',
                'Fornecedor cadastrado com sucesso!'
            );

        return redirect()->route('fornecedores.index');
    }

    public function show($id)
    {
        $fornecedor = Fornecedor::with('pessoa')->findOrFail($id);

        $registrosContaCorrente = DB::select("SELECT id, data, balanco, peso, observacao, sum(peso_agregado) OVER (ORDER BY id) AS saldo 
        FROM conta_corrente 
        WHERE fornecedor_id = ? 
        AND deleted_at IS NULL", [$id]);
        
        return view('fornecedor.show',  compact('fornecedor', 'registrosContaCorrente'));    
    }

    public function edit($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);

        return view('fornecedor.edit', compact('fornecedor'));
    }

    public function update(RequestFormPessoa $request, $id)
    {
        $fornecedor = Fornecedor::findOrFail($id);

        $pessoa = Pessoa::findOrFail($fornecedor->pessoa_id);
        
        $pessoa->fill($request->all())
            ->save();

        $request
            ->session()
            ->flash(
                'message',
                'Fornecedor atualizado com sucesso!'
            );

        return redirect()->route('fornecedores.index');
    }

    public function destroy($id)
    {
        Fornecedor::destroy($id);
        
        return json_encode([
            'icon' => 'success',
            'title' => 'Sucesso!',
            'text' => 'Fornecedor excluído com sucesso!'
        ]);
    }

    public function pdf_fornecedores()
    {
        $fornecedores = Fornecedor::with(['pessoa'])
        ->withSum('contaCorrente', 'peso_agregado')
        ->get();
    
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('fornecedor.pdf.fornecedores', compact('fornecedores') );
        
        return $pdf->stream();
    }

    public function pdf_fornecedor($id)
    {
        $fornecedor = Fornecedor::with('pessoa')->findOrFail($id);

        $registrosContaCorrente = DB::select("SELECT id, data, balanco, peso, observacao, sum(peso_agregado) OVER (ORDER BY id) AS saldo 
        FROM conta_corrente 
        WHERE fornecedor_id = ? 
        AND deleted_at IS NULL", [$id]);
        
        // dd($contas);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('fornecedor.pdf.relacao_fornecedor', compact('fornecedor', 'registrosContaCorrente') );
        
        return $pdf->stream();
    }
}
