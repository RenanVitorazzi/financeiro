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
            </tr>
        </thead>
        <tbody>
            @forelse ($representantes as $representante)
                <tr>
                    <td>{{ $representante->pessoa->nome }}</td>
                    <td>{{ number_format($representante->conta_corrente->sum('peso_agregado'), 3, ',', '.') }}</td>
                    <td>{{ number_format($representante->conta_corrente->sum('fator_agregado'), 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Nenhum registro criado</td>
                </tr>
            @endforelse
                <tr>
                    <td><b>Total</b></td>
                    <td><b>{{ number_format($contaCorrenteGeral->sum('peso_agregado'), 3, ',', '.') }}</b></td>
                    <td><b>{{ number_format($contaCorrenteGeral->sum('fator_agregado'), 2, ',', '.') }}</b></td>
                </tr>
        </tbody>
    </table>
</body>
</html>