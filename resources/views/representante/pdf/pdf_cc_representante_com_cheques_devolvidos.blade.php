<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conta Correntes {{$representante->pessoa->nome}}</title>
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
        background-color: #a9acb0;
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
    <h3>{{ $representante->pessoa->nome }}</h3>
    <table>
        <thead>
            <tr>
                <th colspan=5>
                    Conta corrente  - Cheques devolvidos
                </th>
                </tr>
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
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>TOTAL</td>
                <td colspan=3></td>
            </tr>
        </tfoot>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th colspan=8>Conta corrente  - Pasta</th>
            </tr>
            <tr>
                <th rowspan=2>Data</th>
                <th rowspan=2>Descrição</th>
                <th colspan=3>Peso</th>
                <th colspan=3>Fator</th>
            </tr>
            <tr>

                <th>Débito</th>
                <th>Crédito</th>
                <th>Saldo</th>

                <th>Débito</th>
                <th>Crédito</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>@data(now())</td>
                <td>Saldo atual</td>
                <td></td>
                <td></td>
                <td>@peso($contaCorrenteRepresentante->sum('peso_agregado'))</td>
                <td></td>
                <td></td>
                <td>@fator($contaCorrenteRepresentante->sum('fator_agregado'))</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan=2>TOTAL</td>
                <td colspan=3></td>
                <td colspan=3></td>
            </tr>
        </tbody>
    </table>
</body>
</html>

