<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fechamento {{$representante->pessoa->nome}}</title>
</head>
<style>
    table {
        width:100%;
        border-collapse: collapse;
    }

    td, th {
        border: 1px solid black;
        text-align: center;
        font-size: 12px;
    }
    
    tr:nth-child(even) {
        background-color: #e4e8ec;
    }

    h3 {
        text-align: center;
    }
    
</style>
<body>  
    <h3>Fechamento {{$representante->pessoa->nome}} (@data($hoje))</h3>
    <table>
        <thead>
            <tr>
               <th colspan=6>Devolvidos</th>
            </tr>
            <tr>
                <th>Cliente</th>
                <th>Valor</th>
                <th>Data</th>
                <th>Dias</th>
                <th>Motivo</th>
                <th>Juros totais</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cheques_devolvidos as $cheque_devolvido)
                <tr>
                    <td>{{ $cheque_devolvido->nome_cheque, 0, 35 }}</td>
                    <td>@moeda($cheque_devolvido->valor_parcela)</td>
                    <td>@data($cheque_devolvido->data_parcela)</td>
                    <td>{{ $cheque_devolvido->dias }}</td>
                    <td>{{ $cheque_devolvido->motivo }}</td>
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
                <td colspan=5><b>Total</b></td>
                <td colspan=1><b>@moeda($juros_totais[0]->juros_totais)</b></td>
            </tr>
        </tfoot>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th colspan = 6>Prorrogações - @data($data_inicio) até @data($hoje)</th>
            </tr>
            <tr>
                <th>Cliente</th>
                {{-- <th>Data adiamento</th> --}}
                <th>Valor</th>
                <th>De</th>
                <th>Para</th>
                <th>Dias</th>
                <th>Juros totais</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($adiamentos as $adiamento)
                <tr>
                    <td>{{ $adiamento->nome_cheque }}</td>
                    {{-- <td>@data($adiamento->created_at)</td> --}}
                    <td>@moeda($adiamento->valor_parcela)</td>
                    <td>@data($adiamento->data_parcela)</td>
                    <td>@data($adiamento->nova_data)</td>
                    <td>{{ $adiamento->dias_totais }}</td>
                    <td>@moeda($adiamento->juros_totais)</td>
                </tr>
            @empty
                <tr>
                    <td colspan=6>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan=5><b>Total</b></td>
                <td colspan=1><b>@moeda($adiamentos_total[0]->total_juros)</b></td>
            </tr>
        </tfoot>
    </table>
    <br>
    <table>
        <tbody>
            <tr>
                <td>Valor cheques devolvidos</td>
                <td>@moeda($totalValorCheques[0]->valor_total)</td>
            </tr>
            <tr>
                <td>Juros devolvidos</td>
                <td>@moeda($juros_totais[0]->juros_totais)</td>
            </tr>
            <tr>
                <td>Juros das prorrogações</td>
                <td>@moeda($adiamentos_total[0]->total_juros)</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td><b>Total</b></td>
                <td><b>@moeda($adiamentos_total[0]->total_juros + $juros_totais[0]->juros_totais + $totalValorCheques[0]->valor_total)</b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

