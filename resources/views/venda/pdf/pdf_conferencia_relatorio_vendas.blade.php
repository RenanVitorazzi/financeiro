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
                @php
                    $totalVendaPeso += ($venda->peso * $venda->cotacao_peso);
                    $totalVendaFator += ($venda->fator * $venda->cotacao_fator);
                @endphp
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
                <th>Média Preço Peso</th>
                <th>Média Preço Fator</th>
                <th>Total Vendas (Prazo)</th>
                <th>Total Vendas (À Vista)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>@moeda($totalVendaPeso / $vendas->sum('peso') )</td>
                <td>@moeda($totalVendaFator / $vendas->sum('fator'))</td>
                <td>{{ $vendas->where('metodo_pagamento', '=', 'Parcelado')->count() }}</td>
                <td>{{ $vendas->where('metodo_pagamento', '=', 'À vista')->count() }}</td>
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
                    <td><b>@moeda($pagamentos_total)</b></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
</body>
</html>

