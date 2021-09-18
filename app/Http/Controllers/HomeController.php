<?php

namespace App\Http\Controllers;

use App\Models\Parcela;
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
        $json = file_get_contents('https://api.calendario.com.br/?ano=2023&estado=SP&cidade=SAO_JOSE_DO_RIO_PRETO&token=cmVuYW4udml0b3JhenppMUBnbWFpbC5jb20maGFzaD0xNTU4MDg5ODg&json=true');
        $obj = json_decode($json);
        // dd($obj);
        $FERIADOS_MUNICIPAIS = []; 

        foreach ($obj as $obj2 => $valor) {
            array_push($FERIADOS_MUNICIPAIS, $valor->date);
        }
        // dd($FERIADOS_MUNICIPAIS);

        $depositos = Parcela::where([
            ['data_parcela','<=', DB::raw('CURDATE()')],
            ['parceiro_id', NULL],
            ['status', 'Aguardando']
        ])
        ->orderBy('data_parcela')
        ->orderBy('valor_parcela')
        ->get();

        return view('home', compact('depositos'));
    }
}
