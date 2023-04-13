@extends('layout')
@section('title')
Ordens de Pagamento 
@endsection
@section('body')

<div class='mb-2 d-flex justify-content-between'>
    <h3> Ordens de Pagamento </h3>
    <div>
        <x-botao-novo href="{{ route('ops.create') }}"></x-botao-novo>
    </div>
</div>
       
<x-table id="tabelaBalanco">
    <x-table-header>
        <tr>
            <th>Data</th>
            <th>Titular</th>
            <th>Representante</th>
            <th>Valor</th>
            <th>Detalhes</th>
            <th>Ações</th>
        </tr>
    </x-table-header>
    <tbody>
        @forelse ($ordensPagamento as $op)
            <tr class="{{ ($op->data_parcela < Carbon\Carbon::now()) ? 'table-danger' : '' }}">
                <td>@data($op->data_parcela)</td>
                <td>{{ $op->nome_cliente ?? $op->nome_cheque}}</td>
                <td>{{ $op->nome_representante}}</td>
                <td>@moeda($op->valor_parcela)</td>
                <td>{{ $op->observacao}}</td>
                <td>
                    <x-botao-editar href="{{ route('cheques.edit', $op->id) }}"></x-botao-editar>
                </td>
            </tr>
        @empty
        <tr>
            <td colspan=7>Nenhum registro</td>
        </tr>
        @endforelse
    </tbody>
</x-table>

@endsection
@section('script')
<script>
    $(document).ready( function () {
        $('#tabelaBalanco').dataTable( {
            "ordering": false
        } );
    } );
</script>
@endsection