@extends('layout')
@section('title')
Carteira de cheques
@endsection
@section('body')

<div class='mb-2 d-flex justify-content-between'>
    <h3> Carteira de Cheques </h3>
    <div>
        <x-botao-imprimir class="mr-2" href="{{ route('carteira_cheque_total') }}"></x-botao-imprimir>
        <x-botao-novo href="{{ route('cheques.create') }}"></x-botao-novo>
    </div>
</div>
       
<x-table id="tabelaBalanco">
    <x-table-header>
        <tr>
            {{-- <th>Cliente</th> --}}
            <th>Data</th>
            <th>Titular</th>
            @if (!auth()->user()->is_representante)
                <th>Representante</th>
            @endif
            <th>Valor</th>
            {{-- <th>Status</th> --}}
            <th>Detalhes</th>
            <th>Ações</th>
        </tr>
    </x-table-header>
    <tbody>
        @forelse ($cheques as $cheque)
            <tr class="{{ ($cheque->data_parcela < Carbon\Carbon::now()) ? 'table-danger' : '' }}">
                {{-- <td>{{ $cheque->venda_id ? $cheque->cliente : 'Não informado' }}
                </td> --}}
                <td>@data($cheque->data_parcela)</td>
                <td>{{ $cheque->nome_cheque }}</td>
                @if (!auth()->user()->is_representante)
                    <td>{{ $cheque->venda_id ? $cheque->nome_representante : $cheque->nome_representante}}</td>
                @endif
                <td>@moeda($cheque->valor_parcela)</td>
                {{-- <td>
                    <span class="{{ $arrayCores[$cheque->status] }}">
                        {{ $cheque->status }}
                        @if ($cheque->status == 'Devolvido')
                            {{"(Motivo: $cheque->motivo_devolucao)" }}
                        @endif
                    </span>
                </td> --}}
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
    $(document).ready( function () {
        $('#tabelaBalanco').dataTable( {
            "ordering": false
        } );
    } );
</script>
@endsection