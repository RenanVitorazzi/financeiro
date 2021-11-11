<?php

namespace App\Http\Controllers;

use App\Models\Devolvidos;
use App\Models\Parcela;
use App\Models\Representante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class DevolvidosController extends Controller
{
    protected array $arrayMotivos;

    // public function __construct ()
    // {
    //     $this->arrayMotivos = [
    //         [
    //             "motivo_id" => 11,
    //             "descricao" => "Cheque sem fundos - 1ª apresentação"
    //         ],
    //         [
    //             "motivo_id" => 12,
    //             "descricao" => "Cheque sem fundos - 2ª apresentação"
    //         ],
    //         [
    //             "motivo_id" => 13,
    //             "descricao" => "Conta encerrada"
    //         ],
    //         [
    //             "motivo_id" => 14,
    //             "descricao" => "Prática espúria"
    //         ],
    //         [
    //             "motivo_id" => 20,
    //             "descricao" => "Cheque sustado ou revogado em virtude de roubo"
    //         ],
    //         [
    //             "motivo_id" => 21,
    //             "descricao" => "Cheque sustado ou revogado"
    //         ],
    //         [
    //             "motivo_id" => 22,
    //             "descricao" => "Divergência ou insuficiência de assinatura"
    //         ],
    //         [
    //             "motivo_id"=> 23, 
    //             "descricao" => "Cheques emitidos por entidades e órgãos da administração pública federal direta e indireta"
    //         ],
    //         [
    //             "motivo_id"=> 24, 
    //             "descricao" => "Bloqueio judicial ou determinação do Bacen"
    //         ],
    //         [
    //             "motivo_id"=> 25, 
    //             "descricao" => "Cancelamento de talonário pelo participante destinatário"
    //         ],
    //         [
    //             "motivo_id"=> 27, 
    //             "descricao" => "Feriado municipal não previsto"
    //         ],
    //         [
    //             "motivo_id"=> 28, 
    //             "descricao" => "Cheque sustado ou revogado em virtude de roubo, furto ou extravio"
    //         ],
    //         [
    //             "motivo_id"=> 30, 
    //             "descricao" => "Furto ou roubo de cheque"
    //         ],
    //         [
    //             "motivo_id"=> 70, 
    //             "descricao" => "Sustação ou revogação provisória"
    //         ],
    //         [
    //             "motivo_id"=> 31, 
    //             "descricao" => "Erro formal"
    //         ],
    //         [
    //             "motivo_id"=> 33, 
    //             "descricao" => "Divergência de endosso"
    //         ],
    //         [
    //             "motivo_id"=> 34, 
    //             "descricao" => "Cheque apresentado por participante que não o indicado no cruzamento em preto, sem o endosso-mandato"
    //         ],
    //         [
    //             "motivo_id"=> 35, 
    //             "descricao" => "Cheque fraudado"
    //         ],
    //         [
    //             "motivo_id"=> 37, 
    //             "descricao" => "Registro inconsistente"
    //         ],
    //         [
    //             "motivo_id"=> 38, 
    //             "descricao" => "Assinatura digital ausente ou inválida"
    //         ],
    //         [
    //             "motivo_id"=> 39, 
    //             "descricao" => "Imagem fora do padrão"
    //         ],
    //         [
    //             "motivo_id"=> 40, 
    //             "descricao" => "Moeda Inválida"
    //         ],
    //         [
    //             "motivo_id"=> 41, 
    //             "descricao" => "Cheque apresentado a participante que não o destinatário"
    //         ],
    //         [
    //             "motivo_id"=> 43, 
    //             "descricao" => "Não passível de reapresentação em virtude de persistir o motivo da devolução"
    //         ],
    //         [
    //             "motivo_id"=> 44, 
    //             "descricao" => "Cheque prescrito"
    //         ],
    //         [
    //             "motivo_id"=> 45, 
    //             "descricao" => "Cheque emitido por entidade obrigada a realizar movimentação e utilização de recursos financeiros do Tesouro Nacional mediante Ordem Bancária"
    //         ],
    //         [
    //             "motivo_id"=> 48, 
    //             "descricao" => "Cheque de valor superior a R$100,00 (cem reais)"
    //         ],
    //         [
    //             "motivo_id"=> 49, 
    //             "descricao" => "Remessa nula"
    //         ],
    //         [
    //             "motivo_id"=> 59, 
    //             "descricao" => "Informação essencial faltante"
    //         ],
    //         [
    //             "motivo_id"=> 60, 
    //             "descricao" => "Instrumento inadequado para a finalidade"
    //         ],
    //         [
    //             "motivo_id"=> 61, 
    //             "descricao" => "Papel não compensável"
    //         ],
    //         [
    //             "motivo_id"=> 71, 
    //             "descricao" => "Inadimplemento contratual da cooperativa de crédito no acordo de compensação"
    //         ],
    //         [
    //             "motivo_id"=> 72, 
    //             "descricao" => "Contrato de Compensação encerrado"]
    //     ];
    // }

    public function index()
    {
        // $motivos = json_encode($this->arrayMotivos); 
        $cheques = Parcela::where('status', 'Devolvido')
        ->orderBy('data_parcela')
        ->orderBy('valor_parcela')
        ->get();

        return view('devolvidos.index', compact('cheques'));
    }

    public function pagarChequeDevolvido($id)
    {
        return $id;
    }
    public function cheques_devolvidos ($representante_id) {
        
        $representante = Representante::with('pessoa')->findorFail($representante_id);

        $cheques_devolvidos = DB::select('SELECT 
                nome_cheque,
                data_parcela,
                valor_parcela,
                DATEDIFF(CURDATE(), data_parcela) AS dias,
                (valor_parcela * 0.03 / 30) * DATEDIFF(CURDATE(), data_parcela) as juros,
                p.motivo
            FROM
                parcelas p
            WHERE
                status LIKE ?
                    AND p.representante_id = ?
                    AND p.deleted_at IS NULL
            ORDER BY data_parcela, valor_parcela, nome_cheque', 
            ['Devolvido', $representante->id]
        );

        $juros_totais = DB::select('SELECT 
                SUM((valor_parcela * 0.03 / 30) * DATEDIFF(CURDATE(), data_parcela)) as juros_totais,
                SUM(valor_parcela) as total_cheque
            FROM
                parcelas p
            WHERE
                status LIKE ?
                    AND p.representante_id = ?
                    AND p.deleted_at IS NULL', 
            ['Devolvido', $representante->id]
        );
        $hoje = date('Y-m-d');

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('devolvidos.pdf.devolvidos_representante', compact('cheques_devolvidos', 'juros_totais', 'representante', 'hoje'));
        
        return $pdf->stream();
    }

    public function fechamento_representante ($representante_id, $data_inicio) {
        
        $representante = Representante::with('pessoa')->findorFail($representante_id);

        $cheques_devolvidos = DB::select('SELECT 
                nome_cheque,
                data_parcela,
                valor_parcela,
                DATEDIFF(CURDATE(), data_parcela) AS dias,
                (valor_parcela * 0.03 / 30) * DATEDIFF(CURDATE(), data_parcela) as juros,
                p.motivo
            FROM
                parcelas p
            WHERE
                status LIKE ?
                    AND p.representante_id = ?
                    AND p.deleted_at IS NULL
            ORDER BY data_parcela, valor_parcela, nome_cheque', 
            ['Devolvido', $representante->id]
        );

        $juros_totais = DB::select('SELECT 
                SUM((valor_parcela * 0.03 / 30) * DATEDIFF(CURDATE(), data_parcela)) as juros_totais
            FROM
                parcelas p
            WHERE
                status LIKE ?
                    AND p.representante_id = ?
                    AND p.deleted_at IS NULL', 
            ['Devolvido', $representante->id]
        );

        $adiamentos = DB::select('SELECT 
                p.nome_cheque, 
                p.numero_cheque, 
                a.created_at, 
                p.data_parcela, 
                a.nova_data, 
                p.valor_parcela, 
                a.juros_totais, 
                a.dias_totais 
            FROM 
                parcelas p 
            INNER JOIN 
                adiamentos a ON a.parcela_id = p.id AND a.pago IS NULL
            WHERE p.representante_id = ?
                AND p.deleted_at IS NULL
                AND a.created_at >= ?', 
            [$representante_id, $data_inicio]
        );
            
        $adiamentos_total = DB::select('SELECT 
                SUM(a.juros_totais) AS total_juros
            FROM 
                parcelas p 
            INNER JOIN 
                adiamentos a ON a.parcela_id = p.id AND a.pago IS NULL
            WHERE p.representante_id = ?
                AND p.deleted_at IS NULL
                AND a.created_at >= ? ', 
            [$representante_id, $data_inicio]
        );

        $totalValorCheques = DB::select('SELECT 
                SUM(valor_parcela) as valor_total
            FROM
                parcelas p
            WHERE
                status LIKE ?
                    AND p.representante_id = ?
                    AND p.deleted_at IS NULL', 
            ['Devolvido', $representante->id]
        );

        $hoje = date('Y-m-d');

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'devolvidos.pdf.fechamento', 
            compact('cheques_devolvidos', 'juros_totais', 'representante', 'hoje', 'adiamentos', 'adiamentos_total', 'data_inicio', 'totalValorCheques')
        );
        
        return $pdf->stream();
    }
} 
