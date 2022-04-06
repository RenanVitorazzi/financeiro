<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestFormPessoa;
use App\Models\Adiamento;
use App\Models\Fornecedor;
use App\Models\Pessoa;
use App\Models\ContaCorrente;
use App\Models\Parceiro;
use App\Models\Parcela;
use App\Models\Representante;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class FornecedorController extends Controller
{
    public function index(Request $request)
    {
        $fornecedores = Fornecedor::with(['pessoa'])
        ->withSum('contaCorrente', 'peso_agregado')
        ->get()
        ->sortBy('conta_corrente_sum_peso_agregado');

        $labels = json_encode($fornecedores->pluck('pessoa.nome'));

        $data = json_encode($fornecedores->pluck('conta_corrente_sum_peso_agregado'));

        $message = $request->session()->get('message');
        
        return view('fornecedor.index', compact('fornecedores', 'message', 'labels', 'data'));
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

        $registrosContaCorrente = DB::select("SELECT id, 
                data, 
                balanco, 
                peso, 
                observacao, 
                sum(peso_agregado) OVER (ORDER BY data, id) AS saldo 
            FROM 
                conta_corrente 
            WHERE 
                fornecedor_id = ? 
                AND deleted_at IS NULL
            ORDER BY data, id", 
            [$id]
        );
        
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

    public function destroy(Request $request, $id)
    {
        Fornecedor::destroy($id);
        ContaCorrente::where('fornecedor_id', $id)->delete();
        
        $request
        ->session()
        ->flash(
            'message',
            'Fornecedor excluído com sucesso!'
        );

        return redirect()->route('fornecedores.index');
    }

    public function pdf_fornecedores()
    {
        $fornecedores = Fornecedor::with(['pessoa'])
        ->withSum('contaCorrente', 'peso_agregado')
        ->get()
        ->sortBy('conta_corrente_sum_peso_agregado');

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('fornecedor.pdf.fornecedores', compact('fornecedores') );
        
        return $pdf->stream();
    }

    public function pdf_fornecedor($id)
    {
        $fornecedor = Fornecedor::with('pessoa')->findOrFail($id);

        $registrosContaCorrente = DB::select("SELECT id, data, balanco, peso, observacao, sum(peso_agregado) OVER (ORDER BY data) AS saldo 
        FROM conta_corrente 
        WHERE fornecedor_id = ? 
        AND deleted_at IS NULL", [$id]);
        
        // dd($contas);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('fornecedor.pdf.relacao_fornecedor', compact('fornecedor', 'registrosContaCorrente') );
        
        return $pdf->stream();
    }

    public function pdf_diario()
    {
        $fornecedores = Fornecedor::with(['pessoa'])
            ->withSum('contaCorrente', 'peso_agregado')
            ->get()
            ->sortBy('conta_corrente_sum_peso_agregado');

        $carteira = Parcela::select(DB::raw('sum(valor_parcela) as `valor`, YEAR(data_parcela) year, LPAD (MONTH(data_parcela),2,0) month'))
            ->carteira()
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        
        $devolvidos = Parcela::where('status', 'Devolvido')->get();

        $representantes = Representante::with('pessoa')
            ->withSum('conta_corrente', 'peso_agregado')
            ->withSum('conta_corrente', 'fator_agregado')
            ->get();
        
        $adiamentos = Parcela::withSum('adiamentos', 'juros_totais')
            ->whereHas('adiamentos')
            ->get();
        
        
        $parceiros = DB::select('SELECT 
                SUM(juros_totais) AS totalJuros, pe.nome AS nomeParceiro
            FROM
                troca_adiamentos t
                    INNER JOIN
                parcelas p ON p.id = t.parcela_id
                    INNER JOIN
                parceiros pa ON pa.id = p.parceiro_id
                    INNER JOIN
                pessoas pe ON pe.id = pa.pessoa_id
            WHERE
                t.pago IS NULL
                AND t.deleted_at IS NULL
                AND pa.deleted_at IS NULL
            GROUP BY pa.id
        ');
        
        $pagamentoMed = DB::select('SELECT 
            (SELECT IFNULL(sum(peso), 0) FROM conta_corrente WHERE balanco like ? and fornecedor_id = f.id AND deleted_at is null) 
            -
            ((SELECT IFNULL(sum(peso)/2, 0) FROM conta_corrente WHERE balanco like ? and fornecedor_id = f.id AND (datediff(curdate(), data) between 30 and 59) AND deleted_at is null ) + 
            (SELECT IFNULL(sum(peso), 0) FROM conta_corrente WHERE balanco like ? and fornecedor_id = f.id AND (datediff(curdate(), data) >= 60) AND deleted_at is null ) ) AS total,
            (SELECT nome from pessoas WHERE f.pessoa_id = id) as fornecedor,
            f.id as fornecedor_id
            FROM fornecedores f',
            [
                'Crédito', 'Débito', 'Débito'
            ]
        );
        $hoje = date('d/m/Y');

        // dd($adiamentos);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('fornecedor.pdf.diario', compact('fornecedores', 'carteira', 'representantes', 'devolvidos', 'pagamentoMed', 'adiamentos', 'hoje', 'parceiros') );
        
        return $pdf->stream();
    }
    
}
