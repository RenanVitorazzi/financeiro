<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conta Corrente Representantes</title>
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
</style>
<body>
    <h1>
        Conta Corrente Representantes
    </h1>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Saldo Peso</th>
                <th>Saldo Fator</th>
                <th>Total Devolvidos</th>
                <th>Saldo Geral</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($representantes as $representante)
                @if ($representante->conta_corrente->sum('peso_agregado') != 0 || $representante->conta_corrente->sum('fator_agregado') != 0)
                    <tr>
                        <td>{{ $representante->pessoa->nome }}</td>
                        <td>@peso($representante->conta_corrente->sum('peso_agregado')) </td>
                        <td>@fator($representante->conta_corrente->sum('fator_agregado')) </td>
                        <td>@moeda($devolvidos->where('representante_id', $representante->id)->sum('valor_parcela'))</td>
                        <td>@peso(($representante->conta_corrente->sum('fator_agregado') / 32)  + $representante->conta_corrente->sum('peso_agregado') ) </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="4">Nenhum registro criado</td>
                </tr>
            @endforelse
                <tr>
                    <td><b>Total</b></td>
                    <td><b>@peso($contaCorrenteGeral->sum('peso_agregado')) </b></td>
                    <td><b>@fator($contaCorrenteGeral->sum('fator_agregado')) </b></td>
                    <td><b>@moeda($devolvidos->sum('valor_parcela')) </b></td>
                    <td><b>@peso(($contaCorrenteGeral->sum('fator_agregado') / 32) + $contaCorrenteGeral->sum('peso_agregado')) </b></td>
                </tr>
        </tbody>
    </table>
</body>
</html>