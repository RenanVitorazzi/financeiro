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
                <th>Descrição</th>
                <th>Débito</th>
                <th>Crédito</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>@data($infoRepresentante[$representante->id]['Data'])</td>
                <td colspan=3>Saldo anterior</td>
                <td>@moeda($saldo_total)</td>
            </tr>
            @forelse ($saldos as $saldo)
                @if ($saldo->balanco == 'Débito')
                    <tr>
                        <td>@data($saldo->data_entrega)</td>
                        <td>
                            <a target='_blank' href='{{ route('pdf_cheques_entregues', ['representante_id' => $representante->id, 'data_entrega' => $saldo->data_entrega]) }}'>
                                {{ $saldo->descricao }} - @data($saldo->data_entrega)
                            </a>
                        </td>
                        <td>@moeda(-$saldo->valor_total_debito)</td>
                        <td></td>
                        @php
                            $saldo_total -= $saldo->valor_total_debito;
                        @endphp
                        <td>@moeda($saldo_total)</td>
                    </tr>
                @else
                    <tr>
                        <td>@data($saldo->data_entrega)</td>
                        <td>{{ $saldo->descricao }}</td>
                        <td></td>
                        <td>@moeda($saldo->valor_total_debito)</td>
                        @php
                            $saldo_total += $saldo->valor_total_debito;
                        @endphp
                        <td>@moeda($saldo_total)</td>
                    </tr>
                @endif

            @empty
                <tr>
                    <td colspan=5>Nenhum registro</td>
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
    <br>
    <table>
        <tr>
            <td>Total de cheques na empresa</td>
            <td>@moeda($ValorTotalChequesNaoEntregues)</td>
        </tr>
        <tr>
            <td>Total de cheques com parceiros</td>
            <td>@moeda($ValorTotalChequesComParceiros)</td>
        </tr>
    </table>
</body>
</html>

