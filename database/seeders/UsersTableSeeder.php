<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'renan',
            'email' => 'renan.vitorazzi1@gmail.com',
            'password' => bcrypt('renan'),
            'is_admin' => 1,
        ]);

        User::create([
            'name' => 'fernanda',
            'email' => 'fernanda.vitorazzi1@bol.com',
            'password' => bcrypt('luciano'),
            'is_admin' => 1,
        ]);
    }
}
