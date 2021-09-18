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
        <div>
            {{ $fornecedor->pessoa->nome }} 
            (@peso($registrosContaCorrente[count($registrosContaCorrente)-1]->saldo))
        </div>
    </h1>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Balanço</th>
                <th>Peso</th>
                <th>Observação</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($registrosContaCorrente as $conta)
                @if ($loop->last)
                    <tr>
                        <td><b>@data($conta->data)</b></td>
                        <td><b>{{ $conta->balanco }}</b></td>
                        <td><b>@peso($conta->peso)</b></td>
                        <td><b>{{ $conta->observacao }}</b></td>
                        <td><b>@peso($conta->saldo)</b></td>
                    </tr>
                @else
                    <tr>
                        <td>@data($conta->data)</td>
                        <td>{{ $conta->balanco }}</td>
                        <td>@peso($conta->peso)</td>
                        <td>{{ $conta->observacao }}</td>
                        <td>@peso($conta->saldo)</td>
                    </tr>
                @endif 
            @empty
                <tr>
                    <td colspan=5>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>