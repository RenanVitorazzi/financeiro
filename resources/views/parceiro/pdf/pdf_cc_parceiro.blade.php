<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Extrato {{$parceiro->pessoa->nome}}</title>
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
        background-color:black;
        color:white;
    }
    tr:nth-child(even) {
        background-color: #a9acb0;
    }
    h3 {
        text-align: center;
    }
    .credito {
        background-color:palegreen;
        font-size: 20px;
    }
    .debito {
        background-color:crimson;
        font-size: 20px;
    }
    .nome {
        font-size: 10px;
        text-align: left;
    }
</style>
<body>
    <h3>Extrato {{$parceiro->pessoa->nome}} - @data($hoje)</h3>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Titular</th>
                <th>Status</th>
                <th>Crédito</th>
                <th>Débito</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($saldos as $saldo)
                @php
                    if($saldo->status == 'Crédito') {
                        $tr = 'credito';
                        $saldo_total = $saldo_total + $saldo->valor;
                    } else {
                        $tr = '';
                        $saldo_total -= $saldo->valor;
                    }
                    
                @endphp 
                @if ($saldo->status == 'Crédito')
                    <tr>
                        <td>@data($saldo->rank2)</td>
                        <td class='nome'>{{$saldo->nome_cheque}}</td>
                        <td>{{$saldo->status}}</td>
                        <td>@moeda($saldo->valor)</td>     
                        <td></td>      
                        <td>@moeda($saldo_total)</td>
                    </tr>
                @else if
                    <tr>
                        <td>@data($saldo->rank2)</td>
                        <td class='nome'>{{$saldo->nome_cheque}}</td>
                        <td>{{$saldo->status}}</td>
                        <td></td>    
                        <td>@moeda($saldo->valor)</td>       
                        <td>@moeda($saldo_total)</td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan=6>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            @php
            if ($saldo_total < 0) {
                $tfoot = 'debito';
            } else {
                $tfoot = 'credito';
            }
            @endphp
            <tr>
                <td colspan=4><b>TOTAL</b></td>
                <td colspan=2 class={{$tfoot}}><b>@moeda($saldo_total)</b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

