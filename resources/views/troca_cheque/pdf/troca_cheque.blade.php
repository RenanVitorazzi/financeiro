<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $troca->titulo }}</title>
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

    h3 {
        text-align:center;
    }
</style>
<body>
<h3>
    {{ $troca->parceiro->pessoa->nome ?? $troca->titulo }} - @data($troca->data_troca)<br> 
    Taxa: {{ $troca->taxa_juros }}%
</h3>

<x-table>
    <x-table-header>
        <tr>
            <th>Nome</th>
            <th>Data</th>
            <th>Dias</th>
            <th>Valor Bruto</th>
            <th>Juros</th>
            <th>Valor líquido</th>
        </tr>
    </x-table-header>
    <tbody>
        @foreach ($cheques as $cheque)
            <tr>
                <td>{{ substr($cheque->nome_cheque, 0, 25) }}</td>
                <td>@data($cheque->data)</td>
                <td>{{ $cheque->dias }}</td>
                <td>@moeda($cheque->valor_parcela)</td>
                <td>@moeda($cheque->valor_juros)</td>
                <td>@moeda($cheque->valor_liquido)</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan=3><b>Total</b></td>
            <td><b>@moeda($troca->valor_bruto)</b></td>
            <td><b>@moeda($troca->valor_juros)</b></td>
            <td><b>@moeda($troca->valor_liquido)</b></td>
        </tr>
    </tfoot>
</x-table>
</body>
</html>