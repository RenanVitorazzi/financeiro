<?php

namespace Database\Seeders;

use App\Models\Parceiro;
use App\Models\Pessoa;
use Illuminate\Database\Seeder;

class ParceiroSeeder extends Seeder
{
    public function run()
    {
        $info = [
            [
                'nome' => 'Jadir',
                'tipoCadastro' => 'Pessoa Jurídica',
                'porcentagem_padrao' => 1.8
            ],
            [
                'nome' => 'Wesley',
                'tipoCadastro' => 'Pessoa Jurídica',
                'porcentagem_padrao' => 2.2
            ],
            [
                'nome' => 'Cláudio',
                'tipoCadastro' => 'Pessoa Jurídica',
                'porcentagem_padrao' => 2.0
            ]
        ];

        foreach ($info as $key => $pessoa) {
            $novo_registro = Pessoa::create([
                'nome' => $pessoa['nome'],
                'tipoCadastro' => $pessoa['tipoCadastro'],
            ]);

            Parceiro::create([
                'pessoa_id' => $novo_registro->id,
                'porcentagem_padrao' => $pessoa['porcentagem_padrao']
            ]);
        }
    }
}
