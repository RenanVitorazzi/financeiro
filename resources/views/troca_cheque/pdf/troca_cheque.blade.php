<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Troca {{$troca->parceiro->pessoa->nome}} - {{date("d/m/Y", strtotime($troca->data_troca))}}</title>
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
      <h1>
            {{$troca->parceiro->pessoa->nome}} - {{date("d/m/Y", strtotime($troca->data_troca))}}
      </h1>
      <x-table>
            <x-table-header>
                  <tr>
                        <th>Total Bruto</th>
                        <th>Total Juros</th>
                        <th>Total Líquido</th>
                  </tr>
            </x-table-header>
            <tbody>
                  <tr>
                        <td><b>R$ {{number_format($troca->valor_bruto, 2, ',', '.')}}</b></td>
                        <td><b>R$ {{number_format($troca->valor_juros, 2, ',', '.')}}</b></td>
                        <td><b>R$ {{number_format($troca->valor_liquido, 2, ',', '.')}}</b></td>
                  </tr>
            </tbody>
      </x-table>
      <p></p>
      <x-table>
            <x-table-header>
                  <tr>
                        <th>Nome</th>
                        <th>Data</th>
                        <th>Dias</th>
                        <th>Valor</th>
                        <th>Juros</th>
                        <th>Valor líquido</th>
                  </tr>
            </x-table-header>
            <tbody>
                  @foreach ($troca->cheques as $cheque)
                  <tr>
                      <td>{{$cheque->parcelas->first()->venda->cliente->pessoa->nome}}</td>
                      <td>{{date("d/m/Y", strtotime($cheque->parcelas->first()->data_parcela))}}</td>
                      <td>{{$cheque->dias}}</td>
                      <td>R$ {{number_format($cheque->parcelas->first()->valor_parcela, 2)}}</td>
                      <td>R$ {{number_format($cheque->valor_juros, 2)}}</td>
                      <td>R$ {{number_format($cheque->valor_liquido, 2)}}</td>
                  </tr>
                  @endforeach
            </tbody>
      </x-table>
</body>
</html>