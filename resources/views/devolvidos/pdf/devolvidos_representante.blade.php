<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Devolvidos - {{$representante->pessoa->nome}}</title>
</head>
<style>
    table {
        width:100%;
        border-collapse: collapse;
    }
    td, th {
        border: 1px solid black;
        text-align: center;
        font-size: 11px;
    }
    tr:nth-child(even) {
        background-color: #e4e8ec;
    }
    h3 {
        text-align: center;
    }
</style>
<body>
    <h3>Devolvidos - {{$representante->pessoa->nome}} @data($hoje)</h3>
    <table>
        <thead>
           
            <tr>
                <th>Cliente</th>
                <th>Data</th>
                <th>Dias</th>
                <th>Motivo</th>
                <th>Valor</th>
                <th>Juros totais</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cheques_devolvidos as $cheque_devolvido)
                <tr>
                    <td>{{ substr($cheque_devolvido->nome_cheque, 0, 50) }}</td>
                    <td>@data($cheque_devolvido->data_parcela)</td>
                    <td>{{ $cheque_devolvido->dias }}</td>
                    <td>{{ $cheque_devolvido->motivo }}</td>
                    <td>@moeda($cheque_devolvido->valor_parcela)</td>
                    <td>@moeda($cheque_devolvido->juros)</td>
                </tr>
            @empty
                <tr>
                    <td colspan=6>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan=4><b>Total</b></td>
                <td colspan=1><b>@moeda($juros_totais[0]->total_cheque)</b></td>
                <td colspan=1><b>@moeda($juros_totais[0]->juros_totais)</b></td>
            </tr>
            <tr>
                <td colspan=4><b>Total Geral</b></td>
                <td colspan=2><b>@moeda($juros_totais[0]->total_cheque + $juros_totais[0]->juros_totais)</b></td>
            </tr>
        </tfoot>
    </table>
    <p></p>
</body>
</html>

