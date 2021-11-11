<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prorrogações - {{$representante->pessoa->nome}} @data($data_inicio) até @data($hoje)</title>
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
    /* tfoot > tr > td > b {
        color:red;
    } */
    tr:nth-child(even) {
        background-color: #e4e8ec;
    }
    h3 {
        text-align: center;
    }
    * {
        margin-top: 5px;
        margin-bottom: 5px;
    }
    .nome_pequeno {
        font-size: 10px;
    }
</style>
<body>
    <h3>Prorrogações - {{$representante->pessoa->nome}} @data($data_inicio) até @data($hoje)</h3>
    <table>
        <thead>
           
            <tr>
                <th>Cliente</th>
                {{-- <th>Data adiamento</th> --}}
                <th>De</th>
                <th>Para</th>
                <th>Dias</th>
                <th>Juros totais</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($adiamentos as $adiamento)
                <tr>
                    <td class="nome_pequeno">{{ substr($adiamento->nome_cheque, 0, 40) }}</td>
                    {{-- <td>@data($adiamento->created_at)</td> --}}
                    <td>@data($adiamento->data_parcela)</td>
                    <td>@data($adiamento->nova_data)</td>
                    <td>{{ $adiamento->dias_totais }}</td>
                    <td>@moeda($adiamento->juros_totais)</td>
                </tr>
            @empty
                <tr>
                    <td colspan=5>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan=4><b>Total</b></td>
                <td colspan=1><b>@moeda($adiamentos_total[0]->total_juros)</b></td>
            </tr>
        </tfoot>
    </table>
    <p></p>
</body>
</html>

