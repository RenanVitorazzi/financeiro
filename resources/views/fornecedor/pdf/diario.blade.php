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
        font-size: 14px;
        page-break-inside: avoid;
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
                <th colspan = 2>Carteira {{$hoje}}</th>
            </tr>
            <tr>
                <th>Mês</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($carteira as $carteira_mensal)
                <tr>
                    <td>{{ $carteira_mensal->month }}/{{ $carteira_mensal->year }}</td>
                    <td>@moeda($carteira_mensal->total_mes)</td>
                </tr>
            @empty
                <tr>
                    <td colspan=2>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td><b>Total</b></td>
                <td><b>@moeda($totalCarteira[0]->totalCarteira)</b></td>
            </tr>
        </tfoot>
    </table>
<br>
    <table class="a">
        <thead>
            <tr>
                <th colspan=2>Fornecedores</th>
            </tr>
            <tr>
                <th>Nome</th>
                <th>Saldo</th>
                <!-- <th>%</th> -->
                {{-- <th>30/60</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse ($fornecedores as $fornecedor)
                @if ($fornecedor->conta_corrente_sum_peso_agregado != 0)
                    <tr>
                        <td>{{ $fornecedor->pessoa->nome }}</td>
                        <td>@peso($fornecedor->conta_corrente_sum_peso_agregado)</td>
                        <!-- <td> {{ number_format($fornecedor->conta_corrente_sum_peso_agregado / $fornecedores->sum('conta_corrente_sum_peso_agregado') * 100, 2) }} % </td> -->
                        {{-- <td>  
                            @foreach ($pagamentoMed as $pagamento_fornecedor)
                                @if ($pagamento_fornecedor->fornecedor_id === $fornecedor->id)
                                    {{ $pagamento_fornecedor->total }}
                                @endif
                            @endforeach
                        </td> --}}
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan=2>Nenhum registro</td>
                </tr>
            @endforelse
            <tfoot>
                <tr>
                    <td><b>Total</b></td>
                    <td><b>@peso($fornecedores->sum('conta_corrente_sum_peso_agregado'))</b></td>
                    {{-- <td></td> --}}
                    <!-- <td></td> -->
                </tr>
            </tfoot>
        </tbody>
    </table>
<br>
    <table>
        <thead>
            <tr>
                <th colspan=4>Representantes</th>
            </tr>
            <tr>
                <th>Nome</th>
                <th>Peso</th>
                <th>Fator</th>
                <th>Total</th>
                <!-- <th>Devolvidos</th>
                <th>Prorrogações</th> -->
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
                        <!-- <td>@moeda($devolvidos->where('representante_id', $representante->id)->sum('valor_parcela'))</td>
                        <td>
                            @moeda($adiamentos->where('representante_id', $representante->id)->sum('adiamentos_sum_juros_totais'))
                        </td> -->
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
                    <td><b>@peso($representantes->sum('conta_corrente_sum_peso_agregado'))</b></td>
                    <td><b>@fator($representantes->sum('conta_corrente_sum_fator_agregado'))</b></td>
                    <td><b>@peso($representantes->sum('conta_corrente_sum_peso_agregado') + $representantes->sum('conta_corrente_sum_fator_agregado') / 32 )</b></td>
                    <!--<td><b>@moeda($devolvidos->sum('valor_parcela')) </b></td> -->
                    <!-- <td><b> </b></td> -->
                </tr>
            </tfoot>
        </tbody>
    </table>
<!-- <br>
    <table>
        <thead>
            <tr>
                <th colspan=2>Juros adiamentos</th>
            </tr>
            <tr>
                <th>Parceiro</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($parceiros as $parceiro)
                <tr>
                    <td>{{ $parceiro->nomeParceiro }}</td>
                    <td>@moeda($parceiro->totalJuros)</td>
                </tr>
            @empty
                <tr>
                    <td colspan=2>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
    </table> -->
    <br>
    <table>
        <thead>
            <tr>
                <th colspan=4>Ordens de pagamento</th>
            </tr>
            <tr>
                <th>Mês</th>
                <th>Valor em aberto</th>
                <th>Valor pago</th>
                <th>Valor líquido</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($Op as $OpMensal)
            
                @if($mes > $OpMensal->mes)
                    @php
                        $opsVencidasDevedoras += $OpMensal->total_devedor;
                        $opsPagas += $OpMensal->total_pago;
                    @endphp
                @elseif($mes == $OpMensal->mes)
                    <tr>
                        <td>{{ $OpMensal->mes }}</td>
                        <td>@moeda($opsVencidasDevedoras)</td>
                        <td>@moeda($opsPagas)</td>
                        <td>@moeda($opsVencidasDevedoras - $opsPagas)</td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $OpMensal->mes }}</td>
                        <td>@moeda($OpMensal->total_devedor)</td>
                        <td>@moeda($OpMensal->total_pago)</td>
                        <td>@moeda($OpMensal->total_devedor - $OpMensal->total_pago)</td>
                    </tr>
                @endif
            @php
                $totalDevedorGeral += $OpMensal->total_devedor;
                $totalPagoGeral += $OpMensal->total_pago;
            @endphp
               
            @empty
                <tr>
                    <td colspan=4>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th>@moeda($totalDevedorGeral)</th>
                <th>@moeda($totalPagoGeral)</th>
                <th>@moeda($totalDevedorGeral - $totalPagoGeral)</th>
            </tr>
        </tfoot>
    </table> 
    <br>
    <table>
        <thead>
            <tr>
                <th colspan=2>Aguardando envio de cheques</th>
            </tr>
            <tr>
                <th>Mês</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($chequesAguardandoEnvio as $chequeEnvio)
                <tr>
                    <td>{{ $chequeEnvio->mes }}</td>
                    <td>@moeda($chequeEnvio->valor)</td>
                </tr>
                @php
                    $chequesAguardandoEnvioTotal += $chequeEnvio->valor;
                @endphp
            @empty
                <tr>
                    <td colspan=2>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th>@moeda($chequesAguardandoEnvioTotal)</th>
            </tr>
        </tfoot>
    </table> 
</body>
</html>

