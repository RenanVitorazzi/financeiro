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
    .pagamentos, .titular {
        font-size:10px;
        width:30%;
    }

    .tabelaloca {
        font-size: 14px;
    } 

    .assinatura {
        float:right;
        width:40%;
        border-top: 1px solid black;
        text-align: center;
    }
    .local {
        width:50%;
        border-top: 1px solid black;
        text-align: center;
    }
</style>
<body>
    <h3>Cheques entregues  - {{ $representante->pessoa->nome }} </h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Data</th>
                <th>Titular</th>
                <th>Número</th>
                <th>Valor</th>
                
                <th>Pagamento</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cheques as $cheque)
                <tr>
                    <td>{{ $loop->index + 1}}</td>
                    <td>@data($cheque->data_parcela)</td>
                    <td class='titular'>{{ $cheque->nome_cheque }}</td>
                    <td>{{ $cheque->numero_cheque }}</td>
                    <td>@moeda($cheque->valor_parcela)</td>
                    <td class='pagamentos'>
                        @foreach ($pagamentos->where('parcela_id', $cheque->id) as $pagamento)
                            
                            @data($pagamento->data) - {{$pagamento->forma_pagamento }} {{ $pagamento->conta->nome}} - @moeda($pagamento->valor){{ $pagamento->confirmado ? '' : ' - Não confirmado'}} <br>
                            
                        @endforeach
                    </td>
                    <td>{{ $cheque->status }}</td>
                    
                </tr>
            @empty
            <tr>
                <td colspan=4>Nenhum registro</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <p></p>
    <table class='tabelaloca'>
        <thead>
            <tr>
                <th>Total devolvido</th>
                <th>Total pago</th>
                <th>Total em aberto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>@moeda($totalCheque)</td>
                <td>@moeda($pagamentos->sum('valor'))</td>
                <td>@moeda($totalCheque - $pagamentos->sum('valor'))</td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <div>
        <p class='assinatura'>Visto do representante</p>
        <p class='local'>Data e Local</p>

        
    <div>
</body>
</html>

