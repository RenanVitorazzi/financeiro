<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SeederGeral extends Seeder
{
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(FornecedorSeeder::class);
        $this->call(RepresentanteSeeder::class);
        $this->call(ParceiroSeeder::class);
    }
}
