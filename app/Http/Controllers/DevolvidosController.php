<?php

namespace App\Http\Controllers;

use App\Models\Devolvidos;
use App\Models\Parcela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevolvidosController extends Controller
{
    protected array $arrayMotivos;

    public function __construct ()
    {
        $this->arrayMotivos = [
            [
                "motivo_id" => 11,
                "descricao" => "Cheque sem fundos - 1ª apresentação"
            ],
            [
                "motivo_id" => 12,
                "descricao" => "Cheque sem fundos - 2ª apresentação"
            ],
            [
                "motivo_id" => 13,
                "descricao" => "Conta encerrada"
            ],
            [
                "motivo_id" => 14,
                "descricao" => "Prática espúria"
            ],
            [
                "motivo_id" => 20,
                "descricao" => "Cheque sustado ou revogado em virtude de roubo"
            ],
            [
                "motivo_id" => 21,
                "descricao" => "Cheque sustado ou revogado"
            ],
            [
                "motivo_id" => 22,
                "descricao" => "Divergência ou insuficiência de assinatura"
            ],
            [
                "motivo_id"=> 23, 
                "descricao" => "Cheques emitidos por entidades e órgãos da administração pública federal direta e indireta"
            ],
            [
                "motivo_id"=> 24, 
                "descricao" => "Bloqueio judicial ou determinação do Bacen"
            ],
            [
                "motivo_id"=> 25, 
                "descricao" => "Cancelamento de talonário pelo participante destinatário"
            ],
            [
                "motivo_id"=> 27, 
                "descricao" => "Feriado municipal não previsto"
            ],
            [
                "motivo_id"=> 28, 
                "descricao" => "Cheque sustado ou revogado em virtude de roubo, furto ou extravio"
            ],
            [
                "motivo_id"=> 30, 
                "descricao" => "Furto ou roubo de cheque"
            ],
            [
                "motivo_id"=> 70, 
                "descricao" => "Sustação ou revogação provisória"
            ],
            [
                "motivo_id"=> 31, 
                "descricao" => "Erro formal"
            ],
            [
                "motivo_id"=> 33, 
                "descricao" => "Divergência de endosso"
            ],
            [
                "motivo_id"=> 34, 
                "descricao" => "Cheque apresentado por participante que não o indicado no cruzamento em preto, sem o endosso-mandato"
            ],
            [
                "motivo_id"=> 35, 
                "descricao" => "Cheque fraudado"
            ],
            [
                "motivo_id"=> 37, 
                "descricao" => "Registro inconsistente"
            ],
            [
                "motivo_id"=> 38, 
                "descricao" => "Assinatura digital ausente ou inválida"
            ],
            [
                "motivo_id"=> 39, 
                "descricao" => "Imagem fora do padrão"
            ],
            [
                "motivo_id"=> 40, 
                "descricao" => "Moeda Inválida"
            ],
            [
                "motivo_id"=> 41, 
                "descricao" => "Cheque apresentado a participante que não o destinatário"
            ],
            [
                "motivo_id"=> 43, 
                "descricao" => "Não passível de reapresentação em virtude de persistir o motivo da devolução"
            ],
            [
                "motivo_id"=> 44, 
                "descricao" => "Cheque prescrito"
            ],
            [
                "motivo_id"=> 45, 
                "descricao" => "Cheque emitido por entidade obrigada a realizar movimentação e utilização de recursos financeiros do Tesouro Nacional mediante Ordem Bancária"
            ],
            [
                "motivo_id"=> 48, 
                "descricao" => "Cheque de valor superior a R$100,00 (cem reais)"
            ],
            [
                "motivo_id"=> 49, 
                "descricao" => "Remessa nula"
            ],
            [
                "motivo_id"=> 59, 
                "descricao" => "Informação essencial faltante"
            ],
            [
                "motivo_id"=> 60, 
                "descricao" => "Instrumento inadequado para a finalidade"
            ],
            [
                "motivo_id"=> 61, 
                "descricao" => "Papel não compensável"
            ],
            [
                "motivo_id"=> 71, 
                "descricao" => "Inadimplemento contratual da cooperativa de crédito no acordo de compensação"
            ],
            [
                "motivo_id"=> 72, 
                "descricao" => "Contrato de Compensação encerrado"]
        ];
    }

    public function index()
    {
        $motivos = json_encode($this->arrayMotivos); 
        $cheques = Parcela::whereIn('status', ['Depositado', 'Aguardando', 'Devolvido'])
            ->where('data_parcela', '<=', DB::raw('CURDATE()'))
            ->get();

        return view('devolvidos.index', compact('cheques', 'motivos'));
    }
} 
