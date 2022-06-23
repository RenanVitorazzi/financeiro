<?php

namespace App\Http\Controllers;

use App\Models\Adiamento;
use App\Models\DespesaFixa;
use App\Models\Local;
use App\Models\Parcela;
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

        $ordensPagamentoParaSemana = Parcela::with('representante')
            ->where([
                ['forma_pagamento', 'Depósito'],
                ['status', 'Aguardando'],
                ['data_parcela', '<=', DB::raw('DATE_ADD(curdate(), INTERVAL '.$qtdDiasParaSexta.' day)')],
            ])
            ->orderBy('data_parcela')
            ->orderBy('valor_parcela')
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
            
        return view('home', compact('depositos', 'adiamentos', 'ordensPagamentoParaSemana'));
    }
}
