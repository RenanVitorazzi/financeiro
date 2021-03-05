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
            <th>Balanço</th>
            <th>Valor</th>
            <th>Pagamento</th>
            <th>Ações</th>
        </x-table-header>
        <tbody>
            @forelse ($vendas as $venda)
            <tr>
                <td>{{ date('d/m/Y', strtotime($venda->data_venda)) }}</td>
                <td class="{{ $venda->balanco !== 'Venda' ? 'text-danger' : 'text-success' }}">
                    <b>{{ $venda->balanco }}</b>
                    <i class="fas {{ $venda->balanco !== 'Venda' ? 'fa-angle-down' : 'fa-angle-up' }}"></i>
                </td>   
                @if ($venda->metodo_pagamento)
                    <td>{{ number_format($venda->valor_total, 2) }}</td>
                    <td>
                        <div><b>{{$venda->metodo_pagamento}}</b></div>
                        @foreach ($venda->parcela as $parcela)
                        <div>
                            {{ date('d/m/Y', strtotime($parcela->data_parcela)) }} - {{ number_format($parcela->valor_parcela, 2) }} 
                        </div>
                        @endforeach
                    </td>
                @else
                    <td>- - - - -</td>
                    <td>
                        Peso: {{ number_format($venda->peso, 2) ?? '0.00' }}<br>
                        Fator: {{ number_format($venda->fator, 2) ?? '0.00'}}
                    </td>
                @endif
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