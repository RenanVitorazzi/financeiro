<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório Geral</title>
</head>
<style>
    table {
        width:100%;
        border-collapse: collapse;
    }
    td, th {
        border: 1px solid black;
        text-align: center;
    }
    tr:nth-child(even) {
        background-color: #d9dde2;
    }
    h1 {
        text-align: center;
    }
    
</style>
<body>
    <table>
        <thead>
            <tr>
                <th colspan = 4>Carteira</th>
            </tr>
            <tr>
                <th>Mês</th>
                <th>Valor</th>
                <th>Valor (Adiados)</th>
                <th>Valor (Total)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($carteira as $carteira_mensal)

                <tr>
                    <td>{{ $carteira_mensal->month }}/{{ $carteira_mensal->year }}</td>
                    <td>@moeda($carteira_mensal->valor)</td>
                    @php
                        $adiadoMes = DB::select('SELECT 
                                SUM(p1.valor_parcela) as total_adiado,
                                YEAR(nova_data) year, 
                                MONTH(nova_data) month 
                            FROM adiamentos a 
                            INNER JOIN parcelas p1 ON a.parcela_id = p1.id  
                            WHERE NOT EXISTS (SELECT id FROM adiamentos AS M2 WHERE M2.parcela_id = a.parcela_id AND M2.id > a.id) 
                            AND p1.parceiro_id is null
                            AND MONTH(nova_data) = ?
                            GROUP BY month, year', 
                            [$carteira_mensal->month]
                        );
                        // dd($totalAdiado);
                    @endphp
                    @if (count($adiadoMes) > 0)
                        <td>@moeda($adiadoMes[0]->total_adiado)</td>
                        <td>@moeda($carteira_mensal->valor + $adiadoMes[0]->total_adiado)</td>
                    @else
                        <td>@moeda(0)</td>
                        <td>@moeda($carteira_mensal->valor)</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan=4>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td><b>Total</b></td>
                <td><b>@moeda($carteira->sum('valor'))</b></td>
                @php
                    $totalAdiado = DB::select('SELECT 
                            SUM(p1.valor_parcela) as total_adiado,
                            YEAR(nova_data) year, 
                            MONTH(nova_data) month 
                        FROM adiamentos a 
                        INNER JOIN parcelas p1 ON a.parcela_id = p1.id 
                        WHERE NOT EXISTS (SELECT id FROM adiamentos AS M2 WHERE M2.parcela_id = a.parcela_id AND M2.id > a.id) 
                        AND p1.parceiro_id is null
                        GROUP BY month, year'
                    );
                    // dd($totalAdiado->sum('total_adiado'));
                    $valorTotalAdiado = 0;

                    foreach ($totalAdiado as $valor => $value) {
                        $valorTotalAdiado += $value->total_adiado;
                    }
                @endphp
                <td><b>@moeda($valorTotalAdiado)</b></td>
                <td><b>@moeda($carteira->sum('valor') + $valorTotalAdiado)</b></td>
            </tr>
        </tfoot>
    </table>
<br>
    <table class="a">
        <thead>
            <tr>
                <th colspan=4>Fornecedores</th>
            </tr>
            <tr>
                <th>Nome</th>
                <th>Balanço</th>
                <th>%</th>
                <th>30/60</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($fornecedores as $fornecedor)
                @if ($fornecedor->conta_corrente_sum_peso_agregado != 0)
                    <tr>
                        <td>{{ $fornecedor->pessoa->nome }}</td>
                        <td>@peso($fornecedor->conta_corrente_sum_peso_agregado)</td>
                        <td> {{ number_format($fornecedor->conta_corrente_sum_peso_agregado / $fornecedores->sum('conta_corrente_sum_peso_agregado') * 100, 2) }} % </td>
                        <td>  
                            @foreach ($pagamentoMed as $pagamento_fornecedor)
                                @if ($pagamento_fornecedor->fornecedor_id === $fornecedor->id)
                                    {{ $pagamento_fornecedor->total }}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan=4>Nenhum registro</td>
                </tr>
            @endforelse
            <tfoot>
                <tr>
                    <td><b>Total</b></td>
                    <td><b>@peso($fornecedores->sum('conta_corrente_sum_peso_agregado'))</b></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
<br>
    <table>
        <thead>
            <tr>
                <th colspan=6>Representantes</th>
            </tr>
            <tr>
                <th>Nome</th>
                <th>Peso</th>
                <th>Fator</th>
                <th>Total</th>
                <th>Devolvidos</th>
                <th>Juros adiados</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($representantes as $representante)
                @if ($representante->conta_corrente_sum_peso_agregado != 0 || $representante->conta_corrente_sum_fator_agregado != 0)
                    <tr>
                        <td>{{ $representante->pessoa->nome }}</td>
                        <td>@peso($representante->conta_corrente_sum_peso_agregado)</td>
                        <td>@fator($representante->conta_corrente_sum_fator_agregado)</td>
                        <td>@peso($representante->conta_corrente_sum_peso_agregado + ($representante->conta_corrente_sum_fator_agregado / 32) )</td>
                        <td>@moeda($devolvidos->where('representante_id', $representante->id)->sum('valor_parcela'))</td>
                        <td>
                            @moeda($adiamentos->where('representante_id', $representante->id)->sum('adiamentos_sum_juros_totais'))
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan=6>Nenhum registro</td>
                </tr>
            @endforelse
            <tfoot>
                <tr>
                    <td><b>Total</b></td>
                    <td><b>@peso($representantes->sum('conta_corrente_sum_peso_agregado'))</b></td>
                    <td><b>@fator($representantes->sum('conta_corrente_sum_fator_agregado'))</b></td>
                    <td><b>@peso($representantes->sum('conta_corrente_sum_peso_agregado') + $representantes->sum('conta_corrente_sum_fator_agregado') / 32 )</b></td>
                    <td><b>@moeda($devolvidos->sum('valor_parcela')) </b></td>
                    <td><b> </b></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
    
</body>
</html>

