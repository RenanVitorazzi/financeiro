<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestFormPessoa;
use App\Fornecedor;
use App\Pessoa;
use App\ContaCorrente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fornecedores = Fornecedor::all();
        $message = $request->session()->get('message');
        
        return view('fornecedor.index', compact('fornecedores', 'message'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fornecedor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestFormPessoa $request)
    {
        $pessoa = Pessoa::create($request->all());

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fornecedor = Fornecedor::with(['contaCorrente'])->findOrFail($id);
        $balanco = ContaCorrente::balanco($id);
        
        return view('fornecedor.show',  compact('fornecedor', 'balanco'));    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);

        return view('fornecedor.edit', compact('fornecedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Fornecedor::destroy($id);

        $request
            ->session()
            ->flash(
                'message',
                'Fornecedor excluído com sucesso!'
            );

        return redirect()->route('fornecedores.index');
    }

    // function contaCorrente(Request $request, $id)
    // {
    //     $fornecedor = Fornecedor::findOrFail($id);
    //     return view('fornecedor.contaCorrente',  compact('fornecedor'));
    // }
}
