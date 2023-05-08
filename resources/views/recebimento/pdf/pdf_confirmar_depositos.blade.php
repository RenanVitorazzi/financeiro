<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Depósitos a confirmar</title>
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
    th {
        background-color: #b0b8c2;
    }
    h3 {
        text-align: center;
    }

    tfoot {
        background-color: #d9dde2;
    }
</style>
<body>
    <h3>Confirmar depósitos</h3>
    <table>
        <thead>
            <tr>
                <th>Conta</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Forma Pagamento</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($depositos as $deposito)
                <tr>
                    <td>{{ $deposito->conta->nome}}</td>
                    <td>@data($deposito->data)</td>
                    <td>@moeda($deposito->valor)</td>
                    <td>{{ $deposito->forma_pagamento }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan = 4>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

