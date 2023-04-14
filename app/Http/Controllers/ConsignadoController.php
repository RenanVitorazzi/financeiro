<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsignadoStoreRequest;
use App\Models\Cliente;
use App\Models\Consignado;
use App\Models\Representante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ConsignadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $consignados = Consignado::with(['cliente', 'representante'])
            ->where('baixado', NULL)
            ->get();
        
        $message = $request->session()
            ->get('message');
        
        return view('consignado.index', compact('consignados', 'message'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $representantes = Representante::with('pessoa')
            ->where('atacado', NULL)
            ->get();
        
        return view('consignado.create', compact('representantes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConsignadoStoreRequest $request)
    {
        Consignado::create(
            $request->validated()
        );

        $request
            ->session()
            ->flash(
                'message',
                'Consignado cadastrado com sucesso!'
            );


        return redirect()->route('consignado.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consignado  $consignado
     * @return \Illuminate\Http\Response
     */
    // public function show(Consignado $consignado)
    // {
    //     dd($consignado);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consignado  $consignado
     * @return \Illuminate\Http\Response
     */
    public function edit(Consignado $consignado)
    {
        $clientes = Cliente::where('representante_id', $consignado->representante_id)
            ->get();
        
        $representantes = Representante::empresa()->get();

        return view('consignado.edit', compact('clientes', 'representantes', 'consignado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consignado  $consignado
     * @return \Illuminate\Http\Response
     */
    public function update(ConsignadoStoreRequest $request, Consignado $consignado)
    {
        $consignado->update($request->validated());
        
        $request
        ->session()
        ->flash(
            'message',
            'Consignado atualizado com sucesso!'
        );

        return redirect()->route('consignado.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consignado  $consignado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Consignado $consignado)
    {
        $consignado->delete();

        $request
        ->session()
        ->flash(
            'message',
            'Consignado excluído com sucesso!'
        );

        return redirect()->route('consignado.index');
    }

    public function pdf_consignados() {
        $consignados = Consignado::with('cliente')
            ->where('baixado', NULL)
            ->orderBy('representante_id')
            ->orderBy('data')
            ->get();
        
        $representantesEmpresa = Representante::with('pessoa')->empresa()->get();
        // $consignados->where('representante_id', 5)->sum('peso');
        // dd($consignados);
        
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('consignado.pdf.pdf_consignados', 
            compact('consignados', 'representantesEmpresa') 
        );
        
        return $pdf->stream();
    }

    public function pdf_consignados_geral() {
        $consignados = Consignado::with('cliente')
            ->where('baixado', NULL)
            ->orderBy('representante_id')
            ->orderBy('data')
            ->get();
        
        $representantesEmpresa = Representante::with('pessoa')->empresa()->get();
        
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('consignado.pdf.pdf_consignados_geral', 
            compact('consignados', 'representantesEmpresa') 
        );
        
        return $pdf->stream();
    }
}
