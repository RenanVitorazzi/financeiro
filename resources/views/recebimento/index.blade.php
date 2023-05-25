@extends('layout')
@section('title')
Recebimentos
@endsection
@section('body')
<div class='mb-2 d-flex justify-content-between'>
    <h3>Recebimentos</h3>
    <div>
        <x-botao-imprimir class='mr-2' href="{{ route('pdf_confirmar_depositos') }}"></x-botao-imprimir>
        <x-botao-novo href="{{ route('recebimentos.create') }}"></x-botao-novo>
    </div>
</div>
<x-table id="tableRecebimentos">
    <x-table-header>
        <tr>
            <th colspan=8>Últimos lançamentos</th>
        </tr>
        <tr>
            <th>Data do pagamento</th>
            <th>Cliente</th>
            <th>Valor</th>
            <th>Conta</th>
            <th>Confirmado?</th>
            <th>Representante</th>
            {{-- <th>Dados da dívida</th> --}}
            <th><i class='fas fa-edit'></i></th>
        </tr>
    </x-table-header>
    <tbody>
            @foreach ($pgtoRepresentante as $pgto)
            <tr class="{{ !$pgto->confirmado ? 'table-danger' : ''}}">
                <td>@data($pgto->data)</td>
                <td>
                    @if (!$pgto->parcela()->exists())
                        CRÉDITO CONTA-CORRENTE
                    @else
                        {{ $pgto->parcela->venda_id !== NULL ? $pgto->parcela->venda->cliente->pessoa->nome : $pgto->parcela->nome_cheque }}
                    @endif
                </td>
                {{-- <td>{{ $pgto->parcela->venda_id !== NULL ? $pgto->parcela->venda->cliente->pessoa->nome : $pgto->parcela->nome_cheque }}</td> --}}

                <td>@moeda($pgto->valor)</td>
                <td>{{ $pgto->conta->nome ?? ''}}</td>
                <td>{{ $pgto->confirmado ? 'Sim' : 'Não' }}</td>
                <td>{{ $pgto->representante->pessoa->nome }}</td>
                <td>
                    <div class='d-flex'>
                        <a class='btn btn-dark mr-2' href={{ route('recebimentos.edit', $pgto->id) }}>
                            <i class='fas fa-edit'></i>
                        </a>
                        <x-botao-excluir action="{{ route('recebimentos.destroy', $pgto->id) }}">
                        </x-botao-excluir>
                    </div>
                </td>
            </tr>
            @endforeach
    </tbody>
</x-table>

@endsection
@section('script')
<script>
    @if(Session::has('message'))
        toastr["success"]("{{ Session::get('message') }}")
    @endif

    $(document).ready( function () {
        $('#tableRecebimentos').DataTable({
            order: []
        });
    } );
</script>
@endsection
