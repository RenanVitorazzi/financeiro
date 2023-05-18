<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CLIENTES {{$representante->pessoa->nome}}</title>
</head>
<style>
    table {
        width:100%;
        border-collapse: collapse;
        font-size:12px;
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
    .nome {
        font-size:10px;
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
                    <td class='nome'>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->estado }}</td>
                    <td>{{ substr($cliente->municipio,0,15) }}</td>
                    <td>{{ $cliente->cep }}</td>

                    @if ($cliente->cep)
                        <td>{{ $cliente->bairro }}, {{ $cliente->logradouro }}, {{ $cliente->numero }}</td>
                    @else
                        <td></td>
                    @endif

                    <td>{{ $cliente->celular }}
                        @if ($cliente->telefone)
                        <br>
                        {{ $cliente->telefone }}
                        @endif
                    </td>
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

