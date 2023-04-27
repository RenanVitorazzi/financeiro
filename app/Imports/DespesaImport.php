<?php

namespace App\Imports;

use App\Models\Conta;
use App\Models\Despesa;
use App\Models\PagamentosRepresentantes;
use DateTime;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DespesaImport implements ToCollection
{
    public array $arrayDados = [];
    public $dataInicio;
    public $dataFim;
    public $conta;

    public function collection(Collection $rows)
    {
        $agencia_banco = $rows[3][1];
        $conta_banco = '%'. $rows[4][1]. '%';
        $conta = Conta::where([
            ['agencia', $agencia_banco],
            ['conta', 'LIKE', $conta_banco]
        ])->first();

        $periodo = $rows[7][1];
        $regexDatas = "/[0-9]{1,2}\\/[0-9]{1,2}\\/[0-9]{4}/";
        preg_match_all($regexDatas, $periodo, $datas);
        $data1 = DateTime::createFromFormat('d/m/Y', $datas[0][0])->format('Y-m-d');
        $data2 = DateTime::createFromFormat('d/m/Y', $datas[0][1])->format('Y-m-d');

        $this->dataInicio = $data1;
        $this->dataFim = $data2;
        $this->conta = $conta;

        foreach ($rows as $index => $row) {
            if ($index < 10 || $row[3] == NULL) continue;

            $valor = number_format(abs($row[3]), 2, ".", "");

            // $dataTratada = DateTime::createFromFormat('d/m/Y', $row[0])->format('Y-m-d');

            if ($row[3] < 0) {
                // retira os cheques devolvidos na conta
                if ( (
                    str_contains($row[1], 'DEV CH') ||
                    str_contains($row[1], 'TAR ADAPT') ||
                    str_contains($row[1], 'TAR PLANO')
                ) === true) continue;

                $despesaFiltrada = Despesa::whereBetween('data_vencimento', [$data1, $data2])
                    ->where([
                        ['valor', '=', $valor],
                        ['local_id', '=', $conta->id]
                    ])
                    ->get();

                if ($despesaFiltrada->isNotEmpty()) continue;

                array_push($this->arrayDados, $row);
            } else {
                //confere se foi depósito, reapresentação ou rendimento
                if ( (
                    str_contains($row[1], 'DEP CHQ') ||
                    str_contains($row[1], 'REAPR AUT') ||
                    str_contains($row[1], 'REND PAGO')
                ) === true) continue;

                $pagamentosFiltrados = PagamentosRepresentantes::whereBetween('data', [$data1, $data2])
                    ->where([
                        ['valor', '=', $valor],
                        ['conta_id', '=', $conta->id]
                    ])
                    ->get();

                if ($pagamentosFiltrados->isNotEmpty()) continue;

                array_push($this->arrayDados, $row);
            }

        }

    }
}
