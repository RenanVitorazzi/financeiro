<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContaCorrenteRepresentanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('conta_corrente_representante_controllers')->insert([
            'representante_id' => 3,
            'peso' => 3000,
            'fator' => 50000,
            'observacao' => 'seeder',
            'data' => '2021-03-01',
            'balanco' => 'Reposição'
        ]);

    }
}
