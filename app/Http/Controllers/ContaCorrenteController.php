<?php

namespace App\Http\Controllers;

use App\ContaCorrente;
use App\Fornecedor;
use App\Http\Requests\ContaCorrenteRequest;
use GuzzleHttp\RedirectMiddleware;
use Illuminate\Http\Request;

class ContaCorrenteController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $fornecedor = Fornecedor::findOrFail($request->fornecedor_id);
        
        return view('contaCorrente.create', compact('fornecedor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContaCorrenteRequest $request)
    {
        ContaCorrente::create(
            $request->all()
        );

        $request
            ->session()
            ->flash(
                'message',
                'Conta corrente criada com sucesso!'
            );

        return redirect("/fornecedores/{$request->fornecedor_id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contaCorrente = contaCorrente::findOrFail($id);
        $fornecedores = Fornecedor::all();
        
        return view("contaCorrente.edit", compact("contaCorrente", "fornecedores"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContaCorrenteRequest $request, $id)
    {

        $contaCorrente = contaCorrente::findOrFail($id);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $contaCorrente = ContaCorrente::findOrFail($id);
        $fornecedor_id = $contaCorrente->fornecedor_id;
        
        $contaCorrente->delete();

        $request
            ->session()
            ->flash(
                'message',
                'Conta corrente excluído com sucesso!'
            );

        return redirect("/fornecedores/{$fornecedor_id}");
    }
}
