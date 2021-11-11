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

    h1 {
        text-align: center;
    }

    .cheques td {
        font-size: 10px;
    }
</style>
<body>
    <h1>{{ $troca->titulo }}</h1>
<x-table>
    <x-table-header>
        <tr>
            <th>Total Bruto</th>
            <th>Total Juros</th>
            <th>Total Líquido</th>
        </tr>
    </x-table-header>
    <tbody>
        <tr>
            <td>@moeda($troca->valor_bruto)</td>
            <td>@moeda($troca->valor_juros)</td>
            <td>@moeda($troca->valor_liquido)</td>
        </tr>
    </tbody>
</x-table>
<p></p>
<x-table class="cheques">
    <x-table-header>
        <tr>
            <th>Nome</th>
            <th>Data</th>
            <th>Nº ch</th>
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
                <td>{{ $cheque->numero_cheque }}</td>
                <td>{{ $cheque->dias }}</td>
                <td>@moeda($cheque->valor_parcela)</td>
                <td>@moeda($cheque->valor_juros)</td>
                <td>@moeda($cheque->valor_liquido)</td>
            </tr>
        @endforeach
    </tbody>
</x-table>
</body>
</html>