<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório de Vendas </title>
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    td, th {
        border: 1px solid black;
        text-align: center;
    }
    th {
        background-color:black;
        color:white;
    }
    tr:nth-child(even) {
        background-color: #a9acb0;
    }
    h1, h3 {
        text-align: center;
    }
    .nome {
        font-size:10px;
    }
</style>
<body>
    <h3>
        Relatório Vendas - {{ $representante->pessoa->nome }}
    </h3>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Cliente</th>
                <th>Peso</th>
                <th>Peso pago</th>
                <th>Fator</th>
                <th>Fator Pago</th>
                <th>Total</th>
                <th>Total Pago</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($vendas as $venda)
                <tr>
                    <td>@data($venda->data_venda)</td>
                    <td class='nome'>{{substr($venda->cliente->pessoa->nome,0,25)}}</td>
                    <td>@peso($venda->peso)</td>
                    <td>@moeda($venda->cotacao_peso)</td>
                    <td>@fator($venda->fator)</td>
                    <td>@moeda($venda->cotacao_fator)</td>
                    <td>@moeda(($venda->peso * $venda->cotacao_peso) + ($venda->fator * $venda->cotacao_fator))</td>
                    <td>@moeda($venda->valor_total)</td>
                </tr>
            @empty
                <tr>
                    <td colspan=8>Nenhum registro</td>
                </tr>
            @endforelse
            <tfoot>
                <tr>
                    <td colspan=2><b>Total</b></td>
                    <td colspan=2><b>@peso($vendas->sum('peso'))</b></td>
                    <td colspan=2><b>@fator($vendas->sum('fator'))</b></td>
                    <td colspan=2><b>@moeda($vendas->sum('valor_total'))</b></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
    <br>

    <table>
        <thead>

            <tr>
                <th>Porcentagem</th>
                <th>Total de vendas (g)</th>
                <th>Total de comissão (g)</th>
                <th>Média de preço</th>
                <th>Valor comissão</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Peso ({{ $comissaoRepresentante["porcentagem_peso"] }} %)</td>
                <td>@peso($vendas->sum('peso'))</td>
                <td>@peso($vendas->sum('peso') * ($comissaoRepresentante["porcentagem_peso"] / 100))</td>
                <td>@moeda($totalVendaPesoAVista / $vendas->where('metodo_pagamento', 'À vista')->sum('peso'))</td>
                <td>
                    @moeda(($totalVendaPesoAVista / $vendas->where('metodo_pagamento', 'À vista')->sum('peso')) * $vendas->sum('peso') * ($comissaoRepresentante["porcentagem_peso"] / 100))
                </td>
            </tr>
            <tr>
                <td>Fator ({{ $comissaoRepresentante["porcentagem_fator"] }} %)</td>
                <td>@fator($vendas->sum('fator'))</td>
                <td>@peso($vendas->sum('fator') * ($comissaoRepresentante["porcentagem_fator"] / 100))</td>
                <td>@moeda($totalVendaFatorAVista / $vendas->where('metodo_pagamento', 'À vista')->sum('fator'))</td>
                <td>
                    @moeda(($totalVendaFatorAVista / $vendas->where('metodo_pagamento', 'À vista')->sum('fator')) * $vendas->sum('fator') * ($comissaoRepresentante["porcentagem_fator"] / 100))
                </td>
            </tr>
            <tr>
                <td colspan=4>Total</td>
                <td>@moeda(
                    ($totalVendaPesoAVista / $vendas->where('metodo_pagamento', 'À vista')->sum('peso')) * $vendas->sum('peso') * ($comissaoRepresentante["porcentagem_peso"] / 100)
                    +
                    ($totalVendaFatorAVista / $vendas->where('metodo_pagamento', 'À vista')->sum('fator')) * $vendas->sum('fator') * ($comissaoRepresentante["porcentagem_fator"] / 100)
                )</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th>Forma Pagamento</th>
                <th>Status</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pagamentosPorForma as $pagamento)
                <tr>
                    <td>{{$pagamento->first()->forma_pagamento}}</td>
                    <td>{{$pagamento->first()->status}}</td>
                    <td>@moeda($pagamento->sum('valor_parcela'))</td>
                </tr>
            @empty
                <tr>
                    <td colspan=5>Nenhum registro</td>
                </tr>
            @endforelse
            <tfoot>
                <tr>
                    <td colspan=2><b>Total</b></td>
                    <td><b>@moeda($pagamentosTotal)</b></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
</body>
</html>

