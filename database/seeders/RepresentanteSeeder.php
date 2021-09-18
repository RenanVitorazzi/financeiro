<?php

namespace Database\Seeders;

use App\Models\Pessoa;
use App\Models\Representante;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RepresentanteSeeder extends Seeder
{
    public function run()
    {
        $array_pessoa =  [
            [
                'nome' => 'Jairo',
                'tipoCadastro' => 'Pessoa Física',            
            ],
            [
                'nome' => 'Jailson',
                'tipoCadastro' => 'Pessoa Física',
            ],
            [
                'nome' => 'Lucio',
                'tipoCadastro' => 'Pessoa Física',
            ],
            [
                'nome' => 'Dudo',
                'tipoCadastro' => 'Pessoa Física',
            ],
            [
                'nome' => 'Dennis',
                'tipoCadastro' => 'Pessoa Física',
            ],
            [
                'nome' => 'Marciel',
                'tipoCadastro' => 'Pessoa Física',
            ],
            [
                'nome' => 'Marlon',
                'tipoCadastro' => 'Pessoa Física',
            ],
            [
                'nome' => 'Glauco',
                'tipoCadastro' => 'Pessoa Física',
            ],
            [
                'nome' => 'Mineiro',
                'tipoCadastro' => 'Pessoa Física',
            ],
            [
                'nome' => 'Fabio',
                'tipoCadastro' => 'Pessoa Física',
            ],
            [
                'nome' => 'Israel',
                'tipoCadastro' => 'Pessoa Física',
            ],
            [
                'nome' => 'Rogério',
                'tipoCadastro' => 'Pessoa Física',
            ]
        ];

        foreach ($array_pessoa as $key => $pessoa) {
            $novo_registro = Pessoa::create($pessoa);

            Representante::create([
                'pessoa_id' => $novo_registro->id
            ]);
        }
    }
}
