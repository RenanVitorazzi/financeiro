<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Parcela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChequeController extends Controller
{
    public function index() {
        
        $cheques = DB::select(
            "SELECT par.numero_cheque, 
                par.id as id,
                par.valor_parcela, 
                par.status, 
                par.data_parcela,
                par.observacao, 
                p.nome as cliente,
                (SELECT p.nome FROM pessoas p WHERE p.id = r.pessoa_id) as representante
            FROM 
                parcelas AS par
                INNER JOIN vendas as v ON v.id = par.venda_id
                INNER JOIN clientes as c ON c.id = v.cliente_id
                INNER JOIN pessoas as p ON p.id = c.pessoa_id
                INNER JOIN representantes as r ON r.id = v.representante_id
        ");

        return view('cheque.index', compact('cheques') );
    }
}
