<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Acerto de documentos - {{$representante->pessoa->nome}}</title>
</head>
<style>
    * {
        margin: 10;
        padding:0;
    }
    body {
        margin-top: 1px;
    }
    table {
        margin: 0 4 0 4;
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
        background-color: #d6d8db;
    }
    h3 {
        text-align: center;
    }
    .pagamentos, .status {
        font-size:10px;
    }
    .pagamentos {
        width:30%;
    }
    .tabelaloca {
        font-size: 14px;
    }
    /* .vencido {
        background-color:rgb(209, 92, 92);
    } */
    .vencimento {
        width:10%;
    }
    .linha-pagamento {
        margin: 0px;
    }
</style>
<body>
    <h3>Acerto de documentos - {{$representante->pessoa->nome}}</h3>

    @foreach ($acertos as $acerto)
        <table>
            <thead>
                <tr>
                    <th colspan=6>{{$acerto->cliente}}</th>
                </tr>
                <tr>
                    <th class="vencimento">Vencimento</th>
                    <th>Status</th>
                    <th>Forma</th>
                    <th>Valor</th>
                    <th>Pagamentos</th>
                    <th>Total Aberto</th>
                </tr>
            </thead>
            <tbody>
            @php
                $sql = DB::select( "SELECT
                        p.data_parcela as vencimento,
                        p.valor_parcela AS valor,
                        p.status,
                        p.forma_pagamento,
                        (SELECT nome from pessoas WHERE id = r.pessoa_id) as representante,
                        SUM(pr.valor) AS valor_pago,
                        p.id as parcela_id
                    FROM
                        vendas v
                            INNER JOIN
                        parcelas p ON p.venda_id = v.id
                            LEFT JOIN clientes c ON c.id = v.cliente_id
                            LEFT JOIN representantes r ON r.id = v.representante_id
                            LEFT JOIN pagamentos_representantes pr ON pr.parcela_id = p.id
                    WHERE
                        p.deleted_at IS NULL
                        AND v.deleted_at IS NULL
                        AND r.id = ?
                        AND (
                        p.forma_pagamento like 'Cheque' AND p.status like 'Aguardando Envio'
                        OR
                        p.forma_pagamento != 'Cheque' AND p.status != 'Pago'
                        )
                        AND pr.deleted_at IS NULL
                        AND pr.baixado IS NULL
                        AND c.id = ?
                    GROUP BY p.id
                    ORDER BY c.pessoa_id, data_parcela , valor_parcela",
                    [$representante_id, $acerto->cliente_id]
                );

                $cliente_valor = 0;
                $cliente_valor_pago = 0;
            @endphp

                @foreach ($sql as $divida)
                    @php
                        $pgtos = DB::select( "SELECT c.nome as conta_nome, pr.*
                            FROM pagamentos_representantes pr
                            INNER JOIN contas c ON c.id=pr.conta_id
                            WHERE pr.parcela_id = ?
                                AND pr.baixado IS NULL
                                AND pr.deleted_at IS NULL",
                            [$divida->parcela_id]
                        );
                        $cliente_valor += $divida->valor;
                        $cliente_valor_pago += $divida->valor_pago;

                        $total_divida_valor += $divida->valor;
                        $total_divida_valor_pago += $divida->valor_pago;
                    @endphp
                    <tr class="{{ $divida->vencimento < $hoje ? 'vencido' : ''}}">
                        <td>@data($divida->vencimento)</td>
                        <td class='status'>{{$divida->status}}</td>
                        <td>{{$divida->forma_pagamento == 'Transferência Bancária' ? 'Op' : $divida->forma_pagamento}}</td>
                        <td>@moeda($divida->valor)</td>
                        <td class='pagamentos'>
                            @foreach ($pgtos as $pgto)
                                <div class="linha-pagamento">
                                    @data($pgto->data) - @moeda($pgto->valor) ({{$pgto->conta_nome}})
                                    <b>{{$pgto->confirmado ? '' : 'PAGAMENTO NÃO CONFIRMADO'}}</b>
                                </div>
                            @endforeach
                        </td>
                        <td>@moeda($divida->valor - $divida->valor_pago)</td>
                    </tr>
                    @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan=3><b>TOTAL</b></td>
                    <td>@moeda($cliente_valor)</td>
                    <td>@moeda($cliente_valor_pago)</td>
                    <td><b>@moeda($cliente_valor - $cliente_valor_pago)</b></td>
                </tr>
            </tfoot>
        </table>
        <br>
    @endforeach
    <table class="tabelaloca">
        <thead>
            <tr><th colspan=3>RESUMO</th></tr>
            <tr>
                <th>VALOR</th>
                <th>VALOR RECEBIDO</th>
                <th>VALOR EM ABERTO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>@moeda($total_divida_valor)</td>
                <td>@moeda($total_divida_valor_pago)</td>
                <td><b>@moeda($total_divida_valor - $total_divida_valor_pago)</b></td>
            </tr>
        </tbody>
    </table>
</body>
</html>

