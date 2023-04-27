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
        $regexChequeDevolvido = "";
        preg_match_all($regexDatas, $periodo, $datas);

        $data1 = DateTime::createFromFormat('d/m/Y', $datas[0][0])->format('Y-m-d');
        $data2 = DateTime::createFromFormat('d/m/Y', $datas[0][1])->format('Y-m-d');

        // $despesas = Despesa::whereBetween('data_vencimento', [$data1, $data2]);
        // dd($despesas);
        // $pagamentos = PagamentosRepresentantes::whereBetween('data', [$data1, $data2]);

        $arrayLancamentosPendentes = [];

        foreach ($rows as $index => $row) {
            if ($index < 23 || $row[3] == NULL) continue;

            $valor = number_format(abs($row[3]), 2, ".", "");

            // $dataTratada = DateTime::createFromFormat('d/m/Y', $row[0])->format('Y-m-d');

            if ($row[3] < 0) {
                // retira os cheques devolvidos na conta
                if (str_contains($row[1], 'DEV CH') === true) continue;

                $despesaFiltrada = Despesa::whereBetween('data_vencimento', [$data1, $data2])
                    ->where([
                        ['valor', '=', $valor],
                        ['local_id', '=', $conta->id]
                    ])
                    ->get();

                if ($despesaFiltrada->isNotEmpty()) continue;

                array_push($arrayLancamentosPendentes, $row);
            } else {
                $pagamentosFiltrados = PagamentosRepresentantes::whereBetween('data', [$data1, $data2])
                    ->where([
                        ['valor', '=', $valor],
                        ['conta_id', '=', $conta->id]
                    ])
                    ->get();

                if ($pagamentosFiltrados->isNotEmpty()) continue;

                array_push($arrayLancamentosPendentes, $row);
            }

        }
        dd($arrayLancamentosPendentes);
    }
}
