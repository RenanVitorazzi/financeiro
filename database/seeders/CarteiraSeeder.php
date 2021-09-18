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
        
        $json = Storage::disk('public')->get('json/jailson.json');
        $json = json_decode($json, true);
        
        foreach ($json['Carteira'] as $cheque => $info) {

            // $array_representante = [
            //     'Jairo' => 1,
            //     'Jailson' => 2,
            //     'Lucio' => 3,
            //     'Dudo' => 4,
            //     'Dennis' => 5,
            //     'Marciel' => 6,
            //     'Marlon' => 7,
            //     'Glauco' => 8,
            //     'Mineiro' => 9,
            //     'Fabio' => 10,
            //     'Israel' => 11,
            //     'Rogério' => 12,
            //     'Pelicano' => 13,
            //     'Rhanulfo' => 14,
            // ];

            Parcela::create([
                'nome_cheque' => $info['nome_cheque'],
                'numero_banco' => $info['numero_banco'],
                'numero_cheque' => $info['numero_cheque'],
                'valor_parcela' => $info['valor_parcela'],
                'data_parcela' => $info['data_parcela'],
                'representante_id' => 2,
                'forma_pagamento' => 'Cheque'
            ]);
        }
    }
}
