<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relação de consignados por representante</title>
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
    .nomeRepresentante {
        background-color:#a9acb0;
    }
    /* tr:nth-child(even) {
        background-color: #a9acb0;
    } */
    h3 {
        text-align: center;
        margin-bottom: 6px;
        margin-top: 0px;
    }
</style>
<body>
    <h3>Relação de consignados</h3>
    <table>
        <thead>
            <tr>
                <th>Representante</th>
                <th>Peso</th>
                <th>Fator</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($representantesEmpresa as $representante)
                <tr>
                    <td>{{ $representante->pessoa->nome }}</td>
                    <td>@peso($consignados->where('representante_id', $representante->id)->sum('peso'))</td>
                    <td>@fator($consignados->where('representante_id', $representante->id)->sum('fator'))</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>TOTAL</th>
                <th>@peso($consignados->sum('peso'))</th>
                <th>@fator($consignados->sum('fator'))</th>
            </tr>
        </tfoot>       
    </table>
</body>
</html>

