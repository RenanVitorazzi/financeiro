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

        @foreach ($representantesEmpresa as $representante)
            <table>
                <thead>
                    <tr>
                        <th class="nomeRepresentante" colspan=4>{{ $representante->pessoa->nome }}</th>
                    </tr>
                    <tr>
                        <th>Data</th>
                        <th>Nome do cliente</th>
                        <th>Peso</th>
                        <th>Fator</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @forelse ($consignados->where('representante_id', $representante->id) as $consignado)
                        <tr>
                            <td>@data($consignado->data)</td>
                            <td>{{$consignado->cliente->pessoa->nome}}</td>
                            <td>@peso($consignado->peso)</td>
                            <td>@fator($consignado->fator)</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan=4> Nenhum registro </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan=2><b>TOTAL</b></td>
                        <td><b>@peso($consignados->where('representante_id', $representante->id)->sum('peso'))</b></td>
                        <td><b>@fator($consignados->where('representante_id', $representante->id)->sum('fator'))</b></td>
                    </tr>
                </tfoot>       
            </table>
            <br>
        @endforeach

</body>
</html>

