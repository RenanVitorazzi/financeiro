<?php

namespace Database\Seeders;

use App\Models\Parcela;
use App\Models\Troca;
use App\Models\TrocaParcela;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ImportarTrocaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('public')->get('json/claudio.json');
        $json = json_decode($json, true);

        foreach ($json as $data_importacao => $troca) {
            $dataInicio = new DateTime($data_importacao);
           
            $novaTroca = Troca::create([
                'data_troca' => $data_importacao,
                'parceiro_id' => 3,
                'titulo' => 'Troca Cláudio ' . $data_importacao,
                'taxa_juros' => 2,
                'observacao' => 'Seeder Cláudio'
            ]);

            $totalJuros = 0;
            $totalLiquido = 0;

            foreach ($troca as $parcelas => $cheque) {

                $representante = Parcela::where('nome_cheque', $cheque['nome_cheque'])->first();
                $representante_id = $representante ? $representante->representante_id : null;
                $cheque_status = Carbon::createFromFormat('Y-m-d', $cheque['data_parcela'])->isPast() ? 'Pago' : 'Aguardando';
                
                //! CRIAR PARCELA 
                $parcela = Parcela::create([
                    'nome_cheque' => strtoupper($cheque['nome_cheque']),
                    'data_parcela' => $cheque['data_parcela'],
                    'valor_parcela' => $cheque['valor_parcela'],
                    'forma_pagamento' => 'Cheque',
                    'status' => $cheque_status,
                    'representante_id' => $representante_id,
                    'parceiro_id' => 3,
                    'observacao' => 'Seeder Cláudio'
                ]);

                $dataFim = new DateTime($parcela->data_parcela);
                //! LINKAR PARCELA NA PARCELAS_TROCAS 
                $adicionar_dia = 0;
                
                switch ($dataFim->format('w')) {
                    case 0:
                        $adicionar_dia = 1;
                        break;
                    case 6:
                        $adicionar_dia = 2;
                        break;
                    default:
                        $adicionar_dia = 0;
                        break;
                }
                
                
                $diferencaDias = $dataInicio->diff($dataFim);
                $dias = ($diferencaDias->days + $adicionar_dia);

                $juros = ( ($parcela->valor_parcela * 0.02) / 30 ) * $dias;
                $valorLiquido = $parcela->valor_parcela - $juros;
                
                $totalJuros += $juros;
                $totalLiquido += $valorLiquido;

                TrocaParcela::create([
                    'parcela_id' => $parcela->id,
                    'troca_id' => $novaTroca->id,
                    'dias' => $diferencaDias->days,
                    'valor_juros' => $juros,
                    'valor_liquido' => $valorLiquido,
                ]);

            }
            
            $totalBruto = $totalLiquido + $totalJuros;
             
            $novaTroca->update([
                'valor_liquido' => $totalLiquido,
                'valor_bruto' => $totalBruto,
                'valor_juros' => $totalJuros,
            ]);
            
        }
        
    }
}
