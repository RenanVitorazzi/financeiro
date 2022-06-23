<?php

namespace Database\Seeders;

use App\Models\Parcela;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

class OpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('public')->get('json/op_2022_06_22.json');
        $json = json_decode($json, true);
        
        foreach ($json['OPS'] as $cheque => $info) {
         
            Parcela::create([
                'nome_cheque' => $info['nome_cheque'],
                'valor_parcela' => $info['valor_parcela'],
                'data_parcela' => $info['vencimento_parcela'],
                'representante_id' => $info['id_representante'] ?? NULL,
                'observacao' => $info['observacao'] ?? NULL,
                'forma_pagamento' => 'Depósito'
            ]);
        }
    }
}
