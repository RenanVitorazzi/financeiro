@extends('layout')
@section('title')
Carteira de cheques
@endsection
@section('body')
<div class='mb-2 d-flex justify-content-between'>
    <h3> Cheques </h3>
    <x-botao-novo href="{{ route('cheques.create') }}"></x-botao-novo>
</div>
       
<x-table id="tabelaBalanco">
    <x-table-header>
        <tr>
            <th>Cliente</th>
            <th>Titular do cheque</th>
            <th>Representante</th>
            <th>Data</th>
            <th>Valor</th>
            <th>Status</th>
            <th>Detalhes</th>
            <th>Ações</th>
        </tr>
    </x-table-header>
    <tbody>
        @forelse ($cheques as $cheque)
            <tr class="{{ ($cheque->data_parcela < date('d-m-Y')) ? 'table-danger' : '' }}">
                <td>{{ $cheque->venda_id ? $cheque->cliente : 'Não informado' }}
                </td>
                <td>{{  $cheque->nome_cheque  }}</td>
                <td>{{ $cheque->venda_id ? $cheque->representante : $cheque->representante->pessoa->nome}}</td>
                <td>{{ date('d/m/Y', strtotime($cheque->data_parcela)) }}</td>
                <td>R$ {{ number_format($cheque->valor_parcela,2, ',', '.') }}</td>
                <td>
                    <span class="{{ $arrayCores[$cheque->status] }}">
                        {{ $cheque->status }}
                        @if ($cheque->status == 'Devolvido')
                            {{"(Motivo: $cheque->motivo_devolucao)" }}
                        @endif
                    </span>
                </td>
                <td>{{ $cheque->numero_cheque }} {{ $cheque->observacao}}</td>
                <td>
                    <x-botao-editar href="{{ route('cheques.edit', $cheque->id) }}"></x-botao-editar>
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
    $("#tabelaBalanco").dataTable();
</script>
@endsection