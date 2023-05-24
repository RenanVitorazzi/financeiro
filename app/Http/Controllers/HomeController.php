<?php

namespace App\Http\Controllers;

use App\Models\Adiamento;
use App\Models\DespesaFixa;
use App\Models\Local;
use App\Models\Parcela;
use App\Models\Despesa as ModelsDespesa;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $depositos = Parcela::where([
                ['data_parcela','<=', DB::raw('CURDATE()')],
                ['parceiro_id', NULL],
                ['status', 'Aguardando'],
                ['forma_pagamento', 'Cheque'],
            ])
            ->orderBy('data_parcela')
            ->orderBy('valor_parcela')
            ->orderBy('nome_cheque')
            ->get();

        $qtdDiasParaSexta = 5 - Carbon::now()->dayOfWeek;

        $idFixasPagas = ModelsDespesa::with('local')
            ->where(DB::raw('MONTH(data_vencimento)'), DB::raw('MONTH(CURDATE())'))
            ->whereNotNull('fixas_id')
            ->orderBy('local_id')
            ->pluck('fixas_id');

        $fixasNaoPagas = DespesaFixa::with('local')
            ->whereNotIn('id', $idFixasPagas)
            ->where('dia_vencimento', '<=', DB::raw('DAY(CURDATE()+7)'))
            ->get();

        $adiamentos = DB::select('SELECT
                data_parcela,
                nome_cheque,
                valor_parcela,
                a.nova_data,
                numero_cheque,
                (SELECT nome from pessoas where pessoas.id = r.pessoa_id) as representante,
                (SELECT nome from pessoas where pessoas.id = pa.pessoa_id) as parceiro
            FROM
                parcelas p
            INNER JOIN adiamentos a ON a.parcela_id = p.id
            LEFT JOIN representantes r ON r.id = p.representante_id
            LEFT JOIN parceiros pa ON pa.id = p.parceiro_id
            WHERE CONVERT(a.created_at, DATE) = CURDATE()
            ORDER BY pa.id'
        );

        $ops = Parcela::ops()
            ->with('representante.pessoa', 'venda.cliente.pessoa', 'pagamentos_representantes')
            ->where('data_parcela', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('representante_id', '<>', 3)
            ->orderBy('representante_id')
            ->get();

        return view('home', compact('depositos', 'adiamentos', 'fixasNaoPagas', 'ops'));
    }
}
