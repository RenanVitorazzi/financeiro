<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Despesas {{$mes}}</title>
</head>
<style>
    * {
        margin:5 10 10 5;
    }
    table {
        width:100%;
        border-collapse: collapse;
        font-size: 12px;
        page-break-inside: avoid;
    }
    td, th {
        border: 1px solid black;
        text-align: center;
    }
    th {
        background-color:#e0e1e2;
        /* color:white; */
    }

    h5, h3 {
        text-align: center;
    }
    .data, .valor {
        width: 25%;
    }
</style>
<body>
    <h5>Despesas - Mês {{$mes}}</h5>

    @foreach ($despesas->groupBy('local_id') as $key => $despesa_local)
        <table>
            <thead>
                <tr>
                    <th colspan=3>
                        {{ $local->where('id', $key)->first()->nome }}
                        {{-- (@moeda( $despesas->where('local_id', $key)->sum('valor'))) --}}
                    </th>
                </tr>
                {{-- <tr>
                    <th>Data</th>
                    <th>Nome</th>
                    <th>Valor</th>
                </tr> --}}
            </thead>
            <tbody>
                @forelse ($despesas->where('local_id', $key) as $despesa)
                    <tr>
                        <td class='data'>@data($despesa->data_vencimento)</td>
                        <td class='nome'>{{$despesa->nome}}</td>
                        <td class='valor'>@moeda($despesa->valor)</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan=3>Nenhuma despesa</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan=2>Total</th>
                    <th>@moeda( $despesas->where('local_id', $key)->sum('valor') )</th>
                </tr>
            </tfoot>
        </table>
    @endforeach
    <h3>Total Geral: @moeda($despesas->sum('valor'))</h3>
    {{-- <table>
        <thead>
            <tr>
                <th>Total geral</th>
                <th>@moeda($despesas->sum('valor'))</th>
            </tr>
        </thead>
    </table> --}}
</body>
</html>

