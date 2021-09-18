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
    h1 {
        text-align: center;
    }
</style>
<body>
    <h1>Fornecedores</h1>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Balanço</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($fornecedores as $fornecedor)
                <tr>
                    <td>{{ $fornecedor->pessoa->nome }}</td>
                    <td>@peso($fornecedor->conta_corrente_sum_peso_agregado)</td>
                </tr>
            @empty
                <tr>
                    <td colspan=2>Nenhum registro</td>
                </tr>
            @endforelse
            <tfoot>
                <tr>
                    <td><b>Total</b></td>
                    <td><b>@peso($fornecedores->sum('conta_corrente_sum_peso_agregado'))</b></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
</body>
</html>

