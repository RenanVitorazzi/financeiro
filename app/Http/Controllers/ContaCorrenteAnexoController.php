<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnexoContaCorrenteRequest;
use App\Models\ContaCorrente;
use App\Models\ContaCorrenteAnexos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContaCorrenteAnexoController extends Controller
{

    public function index(Request $request)
    {
        $files = ContaCorrenteAnexos::where('conta_corrente_id', $request->id)->get();
        $contaCorrente = ContaCorrente::find($request->id);

        return view('conta_corrente_anexo.index', compact('files', 'contaCorrente'));
    }

    public function create(Request $request)
    {
        $contaCorrente = ContaCorrente::findOrFail($request->id);
        
        return view('conta_corrente_anexo.create', compact('contaCorrente'));
    }

    public function store(AnexoContaCorrenteRequest $request)
    {
        foreach ($request->file('anexo') as $file) {
            ContaCorrenteAnexos::create([
                'nome' => $file->getClientOriginalName(),
                'conta_corrente_id' => $request->conta_corrente_id,
                'path' => $file->store('conta_corrente/' . $request->conta_corrente_id, 'public'),
            ]);
        }

        return redirect()->route('conta_corrente_anexo.index', ['id' => $request->conta_corrente_id]);
    }

    public function destroy($id)
    {
        $contaCorrenteAnexos = ContaCorrenteAnexos::findOrFail($id);

        $delete = Storage::disk('public')->delete($contaCorrenteAnexos->path);
        
        $delete2 = ContaCorrenteAnexos::findOrFail($id)->delete();

        return json_encode([
            'icon' => 'success',
            'title' => 'Sucesso!',
            'text' => 'Anexo excluído com sucesso!',
            'delete' => $delete,
            'delete2' => $delete2,
        ]);
    }
}
