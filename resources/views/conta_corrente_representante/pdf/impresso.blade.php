<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conta Corrente - {{ $representante->pessoa->nome }}</title>
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
    th {
        background-color:black;
        color:white;
    }
    .saldo {
        background-color:#d1d1d3;
    }
    h1 {
        text-align: center;
    }
</style>
<body>
    <h1>Conta Corrente - {{ $representante->pessoa->nome }}</h1>
    <table>
        <thead>
            <tr>
                <th rowspan=2>Data</th>
                <th rowspan=2>Observação</th>
                <th colspan=3>Peso</th>
                <th colspan=3>Fator</th>
            </tr>
            <tr>
                <th>Crédito</th>
                <th>Débito</th>
                <th>Saldo</th>
                <th>Crédito</th>
                <th>Débito</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($contaCorrente as $registro)
                <tr>
                    @if ($registro->balanco == 'Venda')
                        <td>@data($registro->data)</td>
                        <td>{{ $registro->balanco }}{{ $registro->observacao }} </td>
                        <td></td>
                        <td>@peso($registro->peso) </td>
                        <td class="saldo">@peso($registro->saldo_peso)</td>
                        <td></td>
                        <td>@fator($registro->fator) </td>
                        <td class="saldo">@fator($registro->saldo_fator)</td>
                    @else
                        <td>@data($registro->data)</td>
                        <td>
                            {{ $registro->balanco }}
                            {{ $registro->observacao ? '('.$registro->observacao.')' : '' }} 
                        </td>
                        <td>@peso($registro->peso)</td>
                        <td></td>
                        <td class="saldo">@peso($registro->saldo_peso)</td>
                        <td>@fator($registro->fator)</td>
                        <td></td>
                        <td class="saldo">@fator($registro->saldo_fator)</td>
                    @endif
                    
                </tr>
            @empty
                <tr>
                    <td colspan="8">Nenhum registro criado</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td class="saldo" colspan=2>Total</td>
                <td class="saldo" colspan=3 class="peso">@peso($contaCorrente[count($contaCorrente) - 1]->saldo_peso)</td>
                <td class="saldo" colspan=3>@fator($contaCorrente[count($contaCorrente) - 1]->saldo_fator)</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>