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
        width:100%;
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
</style>
<body>
    <h1>
        Relatório Vendas - {{ $representante->pessoa->nome }} 
    </h1>
    <h3>
        @data($vendas[0]->data_venda) - @data($vendas[count($vendas)-1]->data_venda)
    </h3>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Cliente</th>
                <th>Peso</th>
                <th>Fator</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($vendas as $venda)
                <tr>
                    <td>@data($venda->data_venda)</td>
                    <td>{{$venda->nome_cliente}}</td>
                    <td>@peso($venda->peso)</td>
                    <td>@fator($venda->fator)</td>
                    <td>@moeda($venda->valor_total)</td>
                </tr>
            @empty
                <tr>
                    <td colspan=5>Nenhum registro</td>
                </tr>
            @endforelse
            <tfoot>
                <tr>
                    <td colspan=2><b>Total</b></td>
                    <td><b>@peso($totalVendas[0]->peso)</b></td>
                    <td><b>@fator($totalVendas[0]->fator)</b></td>
                    <td><b>@moeda($totalVendas[0]->valor_total)</b></td>
                </tr>
            </tfoot>
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
            @forelse ($pagamentos as $pagamento)
                <tr>
                    <td>{{$pagamento->forma_pagamento}}</td>
                    <td>{{$pagamento->status}}</td>
                    <td>@moeda($pagamento->valor)</td>
                </tr>
            @empty
                <tr>
                    <td colspan=5>Nenhum registro</td>
                </tr>
            @endforelse
            <tfoot>
                <tr>
                    <td colspan=2><b>Total</b></td>
                    <td><b>@moeda($pagamentos_total[0]->valor)</b></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
</body>
</html>

