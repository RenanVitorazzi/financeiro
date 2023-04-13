@extends('layout')

@section('title')
{{$cliente->pessoa->nome}} 
@endsection

@section('body')
<div class='mb-4'>
    <h3 class='d-inline' style="color:#212529">Histórico - {{$cliente->pessoa->nome}} </h3> 
</div>
    @if(Session::has('message'))
        <p class="alert alert-success">{{ Session::get('message') }}</p>
    @endif
    {{-- <div class='alert alert-success'>
        Valor total de cheques para o mês: <b>{{ number_format($chequesMes, 2) }}</b>
    </div>  --}}
    {{-- <div>
        <h3 class="{{ $balancoFator > 0 ? 'text-success' : 'text-danger' }} font-weight-bold float-right">
            Fator: {{ number_format($balancoFator, 2) }}g
        </h3> 
    </div> --}}
  
    <x-table>
        {{-- <x-table-header>
            <th colspan=7>Vendas </th>
        </x-table-header> --}}
        <x-table-header>
            <th>Data</th>
            <th>Pagamento</th>
            <th>Compra</th>
            <th>Cotação</th>
            <th>Valor da Venda</th>
            <th>Pagamento</th>
            <th>Ações</th>
        </x-table-header>
        <tbody>
            @forelse ($vendas as $venda)
            <tr>
                <td>{{ date('d/m/Y', strtotime($venda->data_venda)) }}</td>
                <td>{{$venda->metodo_pagamento}}</td>   
                <td>
                    Peso: @peso($venda->peso)
                    <br>
                    Fator: @fator($venda->fator)
                </td>
                <td>
                    Peso: @moeda($venda->cotacao_peso)
                    <br>
                    Fator: @moeda($venda->cotacao_fator)
                </td>   
                <td>@moeda($venda->valor_total)</td>
                <td>
                    @foreach ($venda->parcela as $parcela)
                        <div>
                            {{$parcela->forma_pagamento}} -
                            @data($parcela->data_parcela) - 
                            @moeda($parcela->valor_parcela) 
                        </div>
                    @endforeach
                </td>
                <td>
                    <x-botao-editar href='{{ route("venda.edit", $venda->id) }}'></x-botao-editar>
                    <x-botao-excluir action='{{ route("venda.destroy", $venda->id) }}'></x-botao-excluir>
                </td>
            </tr>

            @empty
            <tr><td colspan="7" class="table-danger">Nenhum registro criado</td></tr>
            @endforelse
        </tbody>
    </x-table>

@endsection
@push('script')
<script>
    $(document).ready( function () {
        $('table').DataTable();
    } );
</script>
@endpush