<?php

namespace Database\Seeders;

use App\Models\Fornecedor;
use App\Models\Pessoa;
use Illuminate\Database\Seeder;

class FornecedorSeeder extends Seeder
{
    public function run()
    {
        $array_pessoa = [
            [
                'nome' => 'Itart',
                'tipoCadastro' => 'Pessoa Jurídica',
            ],
            [
                'nome' => 'Marcelo Fuzati',
                'tipoCadastro' => 'Pessoa Jurídica',
            ],
            [
                'nome' => 'Neom',
                'tipoCadastro' => 'Pessoa Jurídica',
            ],
            [
                'nome' => 'Duarts',
                'tipoCadastro' => 'Pessoa Jurídica',
            ],
            [
                'nome' => 'Ibraim',
                'tipoCadastro' => 'Pessoa Jurídica',
            ],
            [
                'nome' => 'Leandro Finetto',
                'tipoCadastro' => 'Pessoa Jurídica',
            ],
            [
                'nome' => 'Irmãos Finetto',
                'tipoCadastro' => 'Pessoa Jurídica',
            ],
            [
                'nome' => 'Jocel',
                'tipoCadastro' => 'Pessoa Jurídica',
            ],
            [
                'nome' => 'Cláudio',
                'tipoCadastro' => 'Pessoa Jurídica',
            ],
            [
                'nome' => 'Bia',
                'tipoCadastro' => 'Pessoa Jurídica',
            ],
            [
                'nome' => 'Raro',
                'tipoCadastro' => 'Pessoa Jurídica',
            ],
        ];

        foreach ($array_pessoa as $key => $pessoa) {
            $novo_registro = Pessoa::create($pessoa);

            Fornecedor::create([
                'pessoa_id' => $novo_registro->id
            ]);
        }
    }
}
