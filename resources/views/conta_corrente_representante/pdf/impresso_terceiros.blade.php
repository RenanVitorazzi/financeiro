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
                @if ($loop->last)
                    <tr>
                        <td><b>@data($registro->data)</b></td>
                        <td><b>Peso: @peso($registro->peso)</b></td>
                        <td><b>{{ $registro->balanco == 'Reposição' ? 'Compra' : 'Fechamento' }}</b></td>
                        <td><b>{{ $registro->observacao }}</b></td>
                        <td><b>@peso($registro->saldo_peso)</b></td>
                    </tr>
                @else
                    <tr>
                        <td>@data($registro->data)</td>
                        <td>
                            Peso: @peso($registro->peso)
                        </td>
                        <td>
                            {{ $registro->balanco == 'Reposição' ? 'Compra' : 'Fechamento' }}
                        </td>
                        <td>{{ $registro->observacao }}</td>
                        <td>
                            @peso($registro->saldo_peso)
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="5">Nenhum registro criado</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>