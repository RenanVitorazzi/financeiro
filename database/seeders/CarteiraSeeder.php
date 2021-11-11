<?php

namespace Database\Seeders;

use App\Models\Parcela;
use App\Models\Representante;
use Illuminate\Database\Seeder;
use Storage;

class CarteiraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // dd();
        $json = Storage::disk('public')->get('json/.json');
        $json = json_decode($json, true);
        
        foreach ($json['Carteira'] as $cheque => $info) {

            Parcela::create([
                'nome_cheque' => $info['nome_cheque'],
                'numero_banco' => $info['numero_banco'] ?? NULL,
                'numero_cheque' => $info['numero_cheque'] ?? NULL,
                'valor_parcela' => $info['valor_parcela'],
                'data_parcela' => $info['data_parcela'],
                'representante_id' => $info['id_representante'],
                'observacao' => $info['observacao'] ?? NULL,
                'forma_pagamento' => 'Cheque'
            ]);
        }
    }
}
