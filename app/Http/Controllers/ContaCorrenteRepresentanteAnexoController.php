<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnexoContaCorrenteRequest;
use App\Models\ContaCorrenteRepresentante;
use App\Models\ContaCorrenteRepresentanteAnexos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContaCorrenteRepresentanteAnexoController extends Controller
{

    public function index(Request $request)
    {
        $files = ContaCorrenteRepresentanteAnexos::where('conta_corrente_id', $request->id)->get();
        $contaCorrente = ContaCorrenteRepresentante::with('representante')->find($request->id);
        
        return view('conta_corrente_representante_anexo.index', compact('files', 'contaCorrente'));
    }

    public function create(Request $request)
    {
        $contaCorrente = ContaCorrenteRepresentante::findOrFail($request->id);
        
        return view('conta_corrente_representante_anexo.create', compact('contaCorrente'));
    }

    public function store(AnexoContaCorrenteRequest $request)
    {
        foreach ($request->file('anexo') as $file) {
            ContaCorrenteRepresentanteAnexos::create([
                'nome' => $file->getClientOriginalName(),
                'conta_corrente_id' => $request->conta_corrente_id,
                'path' => $file->store('conta_corrente/' . $request->conta_corrente_id, 'public'),
            ]);
        }

        return redirect()->route('ccr_anexo.index', ['id' => $request->conta_corrente_id]);
    }

    public function destroy($id)
    {
        $contaCorrenteAnexos = ContaCorrenteRepresentanteAnexos::findOrFail($id);
        $delete = Storage::disk('public')->delete($contaCorrenteAnexos->path);
        
        $delete2 = ContaCorrenteRepresentanteAnexos::findOrFail($id)->delete();

        return json_encode([
            'icon' => 'success',
            'title' => 'Sucesso!',
            'text' => 'Anexo excluído com sucesso!',
            'delete' => $delete,
            'delete2' => $delete2,
        ]);
    }
}
