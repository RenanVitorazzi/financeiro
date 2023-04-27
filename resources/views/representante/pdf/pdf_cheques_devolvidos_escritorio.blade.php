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
</style>
<body>
    <h3>Relação de cheques empresa - {{$representante->pessoa->nome}} @data($hoje)</h3>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Titular</th>
                <!-- <th>Número</th> -->
                <th>Valor cheque</th>
                <th>Total pago</th>
                <th>Total devedor</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cheques as $cheque)
                <tr>
                    <td>@data($cheque->data_parcela)</td>
                    <td class='titular'>{{$cheque->nome_cheque}}</td>    
                    <!-- <td>{{ $cheque->numero_banco }} {{ $cheque->numero_cheque }}</td>   -->
                    <td>@moeda($cheque->valor_parcela)</td>      
                    <td>@moeda($cheque->valor_pago)</td>
                    <td>@moeda($cheque->valor_parcela - $cheque->valor_pago)</td>
                </tr>
                @php
                    $saldo_total += $cheque->valor_parcela - $cheque->valor_pago;
                @endphp
            @empty
                <tr>
                    <td colspan=5>Nenhum registro</td>
                </tr>
            @endforelse
            <tfoot>
                <tr>
                    <td colspan=4>Total</td>
                    <td>@moeda($saldo_total)</td>
                </tr>
            </tfoot>
        </tbody>
      
    </table>
</body>
</html>

