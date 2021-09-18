<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conta Corrente - {{ $representante->pessoa->nome }}</title>
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
        Conta Corrente - {{ $representante->pessoa->nome }}
    </h1>

    <table>
        <thead>
            <tr>
                <th colspan="2">Saldo</th>
            </tr>
            <tr>
                <th>Peso</th>
                <th>Fator</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>@peso($contaCorrente[0]->saldo_peso)</td>
                <td>@fator($contaCorrente[0]->saldo_fator)</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Relação</th>
                <th>Balanço</th>
                <th>Observação</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($contaCorrente as $registro)
                <tr>
                    <td>@data($registro->data)</td>
                    <td>
                        <div>Peso: @peso($registro->peso)</div>
                        <div>Fator: @fator($registro->fator)</div>
                    </td>
                    <td>{{ $registro->balanco }}</td>
                    <td>{{ $registro->observacao }}</td>
                    <td>
                        <div>Peso: @peso($registro->saldo_peso)</div>
                        <div>Fator: @fator($registro->saldo_fator)</div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhum registro criado</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>