<?php

namespace Database\Seeders;

use App\Models\Feriados as ModelsFeriados;
use DateTime;
use Feriados;
use Illuminate\Database\Seeder;

class FeriadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        dd('oi');
        $json = file_get_contents('https://api.calendario.com.br/?ano=2024&estado=SP&cidade=SAO_JOSE_DO_RIO_PRETO&token=cmVuYW4udml0b3JhenppMUBnbWFpbC5jb20maGFzaD0xNTU4MDg5ODg&json=true');
        $obj = json_decode($json);

        $typecode_feriados = [1, 2, 3];

        foreach ($obj as $obj2 => $valor) {
            //* Checa se o feriado é nacional, estadual ou municipal
            if (in_array($valor->type_code, $typecode_feriados)) {

                $data = DateTime::createFromFormat('d/m/Y', $valor->date );
                $feriado = ModelsFeriados::where('data_feriado', $data->format('Y-m-d'))->get();

                if ($feriado->isEmpty()) {
                    ModelsFeriados::create([
                        'data_feriado' => $data->format('Y-m-d'),
                        'descricao' => $valor->description
                    ]);
                } 
            }
        }
    }
}
