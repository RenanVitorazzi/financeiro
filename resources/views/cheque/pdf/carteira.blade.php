<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carteira de cheques</title>
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
    tr:nth-child(even) {
        background-color: #a9acb0;
    }
    h1 {
        text-align: center;
    }
</style>
<body>
    <h1>Carteira de cheques</h1>
    <table>
        <thead>
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
</body>
</html>

