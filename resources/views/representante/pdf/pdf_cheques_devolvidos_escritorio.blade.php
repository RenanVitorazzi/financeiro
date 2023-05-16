<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relação de cheques empresa {{$representante->pessoa->nome}}</title>
</head>
<style>
    table {
        width:100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    td, th {
        border: 1px solid black;
        text-align: center;
    }
    th {
        background-color: #d6d8db;
    }
    h3 {
        text-align: center;
        margin: 0px;
    }
    .titular {
        font-size: 10px;
        text-align: left;
        padding-left: 5px
    }
    p {
        margin: 0;
    }
</style>
<body>
    <h3>Relação de cheques no escritório - {{$representante->pessoa->nome}} @data($hoje)</h3>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Titular</th>
                <th>Número</th>
                <th>Valor cheque</th>
                <th>Pagamentos</th>
                <th>Total pago</th>
                <th>Total devedor</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cheques as $cheque)
                <tr>
                    <td>@data($cheque->data_parcela)</td>
                    <td class='titular'>{{$cheque->nome_cheque}}</td>
                    <td>{{ $cheque->numero_cheque }}</td>
                    <td>@moeda($cheque->valor_parcela)</td>
                    <td>
                        @forelse ($cheque->pagamentos_representantes as $pagamentos)
                            <p>@data($pagamentos->data) - @moeda($pagamentos->valor) {{ $pagamentos->confirmado == 1 ? '' : '(Não confirmado)'}}</p>
                        @empty
                        @endforelse
                    </td>
                    <td>@moeda($cheque->pagamentos_representantes->sum('valor'))</td>
                    <td>@moeda($cheque->valor_parcela - $cheque->pagamentos_representantes->sum('valor'))</td>
                </tr>
            @empty
                <tr>
                    <td colspan=7>Nenhum registro</td>
                </tr>
            @endforelse
            <tfoot>
                <tr>
                    <td colspan=3><b>Total</b></td>
                    <td><b>@moeda($cheques->sum('valor_parcela'))</b></td>
                    <td colspan=2><b>@moeda($totalPago)</b></td>
                    <td><b>@moeda($cheques->sum('valor_parcela') - $totalPago)</b></td>
                </tr>
            </tfoot>
        </tbody>

    </table>
</body>
</html>

