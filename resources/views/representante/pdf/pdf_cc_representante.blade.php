<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Extrato {{$representante->pessoa->nome}}</title>
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
    /* tr:nth-child(even) {
        background-color: #a9acb0;
    } */
    h3 {
        text-align: center;
    }
    .titular {
        font-size: 10px;
        text-align: left;
    }
    .credito {
        background-color: rgb(173, 255, 173);
    }
</style>
<body>
    <h3>Extrato {{$representante->pessoa->nome}} - @data($hoje)</h3>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Titular</th>
                <th>Débito</th>
                <th>Crédito</th>
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
                    <tr class='credito'>
                        <td>@data($saldo->data)</td>
                        <td class='titular' colspan=2>{{$saldo->nome}}</td>    
                        <td>@moeda($saldo->valor)</td>      
                        <td>@moeda($saldo_total)</td>
                    </tr>
                @else if
                    <tr>
                        <td>@data($saldo->data)</td>
                        <td class='titular'>{{$saldo->nome}}</td>
                        <td>@moeda($saldo->valor)</td>    
                        <td></td>       
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
                <td colspan=3><b>TOTAL</b></td>
                <td colspan=2><b>@moeda($saldo_total)</b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

