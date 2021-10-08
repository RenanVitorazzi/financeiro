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
                <th>%</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($fornecedores as $fornecedor)
                @if ($fornecedor->conta_corrente_sum_peso_agregado != 0)
                    <tr>
                        <td>{{ $fornecedor->pessoa->nome }}</td>
                        <td>@peso($fornecedor->conta_corrente_sum_peso_agregado)</td>
                        <td> {{ number_format($fornecedor->conta_corrente_sum_peso_agregado / $fornecedores->sum('conta_corrente_sum_peso_agregado') * 100, 2) }} % </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan=3>Nenhum registro</td>
                </tr>
            @endforelse
            <tfoot>
                <tr>
                    <td><b>Total</b></td>
                    <td><b>@peso($fornecedores->sum('conta_corrente_sum_peso_agregado'))</b></td>
                    <td></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
    {{-- <img src="{{$chart}}" alt=""> --}}
</body>
</html>

