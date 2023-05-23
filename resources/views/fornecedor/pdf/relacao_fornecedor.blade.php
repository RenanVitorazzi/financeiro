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
    .debito {
        color: red;
        font-weight: 300;
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
                <th>Débito</th>
                <th>Crédito</th>
                <th>Observação</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($registrosContaCorrente as $conta)
                @if ($conta->data > $data_inicio)


                    @if ($conta->balanco == 'Débito')
                        <tr>
                            <td>@data($conta->data)</td>
                            <td>@peso($conta->peso)</td>
                            <td></td>
                            <td>{{ $conta->observacao }}</td>
                            <td>@peso($conta->saldo)</td>
                        </tr>
                    @else
                        <tr>
                            <td>@data($conta->data)</td>
                            <td></td>
                            <td>@peso($conta->peso)</td>
                            <td>{{ $conta->observacao }}</td>
                            <td>@peso($conta->saldo)</td>
                        </tr>
                    @endif
                @endif
            @empty
                <tr>
                    <td colspan=5>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan=4>Saldo atual</td>
                <td class='debito'>@peso($registrosContaCorrente[count($registrosContaCorrente) - 1]->saldo)</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
