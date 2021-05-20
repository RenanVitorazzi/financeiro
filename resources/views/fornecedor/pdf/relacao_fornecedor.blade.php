<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fornecedores</title>
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
</style>
<body>
    <h1>
        <div>Fornecedor: {{ $fornecedor->pessoa->nome }} </div>
        <div>Saldo: {{ $registrosContaCorrente[count($registrosContaCorrente)-1]->saldo }}</div>
    </h1>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Balanço</th>
                <th>Peso (gramas)</th>
                <th>Observação</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($registrosContaCorrente as $conta)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($conta->data)) }}</td>
                    <td>{{ $conta->balanco }}</td>
                    <td>{{ number_format($conta->peso, 3) }}</td>
                    <td>{{ $conta->observacao }}</td>
                    <td>{{ number_format($conta->saldo, 3) }}</td>
                </tr> 
            @empty
                <tr>
                    <td colspan=5>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>