<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório Mensal {{$mes}}/{{$ano}}</title>
</head>
<style>
    table {
        width:49%;
        border-collapse: collapse;
        font-size: 14px;
        page-break-inside: avoid;
    }
    td, th {
        border: 1px solid black;
        text-align: center;
    }
    th {
        background-color: #b0b8c2;
    }
    h1 {
        text-align: center;
    }
    .table-representantes {
        float: right;
    }
    tfoot {
        background-color: #d9dde2;
    }
</style>
<body>
    <table class='table-representantes'>
        <thead>
            <tr>
                <th colspan = 5>Representantes</th>
            </tr>
            <tr>
                <th rowspan=2>Nome</th>
                <th colspan=2>Reposição</th>
                <th colspan=2>Venda</th>
            </tr>
            <tr>
                <th>Peso</th>
                <th>Fator</th>
                <th>Peso</th>
                <th>Fator</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cc_representantes->groupBy('representante_id') as $key => $cc)
                <tr>
                    <td>{{ $representantes->where('id', $key)->first()->pessoa->nome }}</td>
                    <td>@peso($cc->where('balanco', 'LIKE', 'Reposição')->sum('peso'))</td>
                    <td>@fator($cc->where('balanco', 'LIKE', 'Reposição')->sum('fator'))</td>
                    <td>@peso($cc->where('balanco', 'LIKE', 'Venda')->sum('peso'))</td>
                    <td>@fator($cc->where('balanco', 'LIKE', 'Venda')->sum('fator'))</td>
                </tr>
            @empty
                <tr>
                    <td colspan = 5>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td>@peso($cc_representantes->where('balanco', 'LIKE', 'Reposição')->sum('peso'))</td>
                <td>@fator($cc_representantes->where('balanco', 'LIKE', 'Reposição')->sum('fator'))</td>
                <td>@peso($cc_representantes->where('balanco', 'LIKE', 'Venda')->sum('peso'))</td>
                <td>@fator($cc_representantes->where('balanco', 'LIKE', 'Venda')->sum('fator'))</td>
            </tr>
            <tr>
                <td rowspan=2>Saldo total</td>
                <td colspan=2>Peso</td>
                <td colspan=2>Fator</td>
            </tr>
            <tr>
                <td colspan=2>@peso($cc_representantes->where('balanco', 'LIKE', 'Venda')->sum('peso') - $cc_representantes->where('balanco', 'LIKE', 'Reposição')->sum('peso')) </td>
                <td colspan=2>@fator($cc_representantes->where('balanco', 'LIKE', 'Venda')->sum('fator') - $cc_representantes->where('balanco', 'LIKE', 'Reposição')->sum('fator')) </td>
            </tr>
        </tfoot>
    </table>

    <table>
        <thead>
            <tr>
                <th colspan = 3>Fornecedores</th>
            </tr>
            <tr>
                <th>Nome</th>
                <th>Compra</th>
                <th>Fechamento</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cc_fornecedores->groupBy('fornecedor_id') as $key => $cc)
                <tr>
                    <td>{{ $fornecedores->where('id', $key)->first()->pessoa->nome }}</td>
                    <td>@peso($cc->where('balanco', 'LIKE', 'Débito')->sum('peso'))</td>
                    <td>@peso($cc->where('balanco', 'LIKE', 'Crédito')->sum('peso'))</td>
                </tr>
            @empty
                <tr>
                    <td colspan = 3>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td>@peso($cc_fornecedores->where('balanco', 'LIKE', 'Débito')->sum('peso'))</td>
                <td>@peso($cc_fornecedores->where('balanco', 'LIKE', 'Crédito')->sum('peso'))</td>
            </tr>
            <tr>
                <td>Saldo total</td>
                <td colspan=2> @peso($cc_fornecedores->where('balanco', 'LIKE', 'Crédito')->sum('peso') - $cc_fornecedores->where('balanco', 'LIKE', 'Débito')->sum('peso')) </td>
            </tr>
        </tfoot>
    </table>

    <br>

    <table class='table-representantes'>
        <thead>
            <tr>
                <th colspan = 2>Adiamentos</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total de cheques adiado</td>
                <td>{{ $adiamentos->total }}</td>
            </tr>
            <tr>
                <td>Total de Juros</td>
                <td>@moeda($adiamentos->juros)</td>
            </tr>
        </tbody>

    </table>

    <table>
        <thead>
            <tr>
                <th colspan = 2>Depósitos e OPs</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Depósitos de cheques em conta</td>
                <td>@moeda($depositosConta)</td>
            </tr>
            <tr>
                <td>OPs</td>
                <td>@moeda($ops)</td>
            </tr>
        </tbody>

    </table>

    <br>
    <table>
        <thead>
            <tr>
                <th colspan = 2>Despesa</th>
            </tr>
            <tr>
                <th>Local</th>
                <th>Valor</th>

            </tr>
        </thead>
        <tbody>
            @forelse ($despesa_mensal->groupBy('local_id') as $key => $despesa)
                <tr>
                    <td>{{ $locais->where('id', $key)->first()->nome }}</td>
                    <td>@moeda($despesa->sum('valor'))</td>
                </tr>
            @empty
                <tr>
                    <td colspan = 2>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td>@moeda($despesa_mensal->sum('valor'))</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

