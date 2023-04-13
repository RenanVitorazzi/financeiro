<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clientes {{$representante->pessoa->nome}}</title>
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
                <th colspan = 7>Clientes - {{$representante->pessoa->nome}}</th>
            </tr>
            <tr>
                <th></th>
                <th>Nome</th>
                <th>Estado</th>
                <th>Município</th>
                <th>CEP</th>
                <th>Endereço</th>
                <th>Telefones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clientes as $cliente)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->estado }}</td>
                    <td>{{ $cliente->municipio }}</td>
                    <td>{{ $cliente->cep }}</td>
                    
                    @if ($cliente->cep)
                        <td>{{ $cliente->bairro }}, {{ $cliente->logradouro }}, {{ $cliente->numero }} - {{ $cliente->complemento }}</td>
                    @else
                        <td></td>
                    @endif
                    
                    <td>{{ $cliente->celular }} {{ $cliente->telefone }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan=7>Nenhum registro</td>
                </tr>
            @endforelse
        </tbody>
    </table>


</body>
</html>

