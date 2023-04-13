<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Despesas {{$mes}}</title>
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
        text-align: center;
    }
    .credito {
        background-color:palegreen;
        font-size: 20px;
    }
    .debito {
        background-color:crimson;
        font-size: 20px;
    }
</style>
<body>
    <h3>Despesas - Mês {{$mes}}</h3>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Nome</th>
                <th>Local</th>
                <th>Valor</th>
                
            </tr>
        </thead>
        <tbody>
            @forelse ($despesas as $despesa)
                <tr>
                    <td>@data($despesa->data_vencimento)</td>
                    <td class='nome'>{{$despesa->nome}}</td>
                    <td>{{ $despesa->local->nome }}</td>
                    <td>@moeda($despesa->valor)</td>
                </tr>
            @empty
                <tr>
                    <td colspan=4>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan=3><b>TOTAL</b></td>
                <td colspan=1><b>@moeda($despesas->sum('valor'))</b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

