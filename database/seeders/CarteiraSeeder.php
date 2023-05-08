<?php

namespace Database\Seeders;

use App\Models\Parcela;
use App\Models\Representante;
use Illuminate\Database\Seeder;
use Storage;

class CarteiraSeeder extends Seeder
{
    public function __construct()
    {
        $this->parcelas = Parcela::all();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('public')->get('json/.json');
        $json = json_decode($json, true);

        foreach ($json['Carteira'] as $cheque => $info) {
            /*
            $parcela_filtrada = $this->parcelas->where('valor_parcela', $info['valor_parcela'])
                ->where('representante_id', $info['id_representante'])
                ->where('data_parcela', $info['data_parcela']);

            if (!$parcela_filtrada->isEmpty() && $info['observacao']) {

                Parcela::find($parcela_filtrada->first()->id)->update([
                    'observacao' => $info['observacao']
                ]);

            } else {

                Parcela::create([
                    'nome_cheque' => $info['nome_cheque'],
                    'numero_banco' => $info['numero_banco'] ?? NULL,
                    'numero_cheque' => $info['numero_cheque'] ?? NULL,
                    'valor_parcela' => $info['valor_parcela'],
                    'data_parcela' => $info['data_parcela'],
                    'representante_id' => $info['id_representante'] ?? NULL,
                    'observacao' => $info['observacao'] ?? NULL,
                    'forma_pagamento' => 'Cheque'
                ]);

            }
            */

            Parcela::create([
                'nome_cheque' => $info['nome_cheque'],
                'numero_banco' => $info['numero_banco'] ?? NULL,
                'numero_cheque' => $info['numero_cheque'] ?? NULL,
                'valor_parcela' => $info['valor_parcela'],
                'data_parcela' => $info['data_parcela'],
                'representante_id' => $info['id_representante'] ?? NULL,
                'observacao' => $info['observacao'] ?? NULL,
                'forma_pagamento' => 'Cheque'
            ]);
        }
    }
}
