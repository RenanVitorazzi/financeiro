@extends('layout')
@section('title')
Conta Corrente - {{ $fornecedor->pessoa->nome }}
@endsection
@section('body')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h3>{{ $fornecedor->pessoa->nome }}</h3>
            <x-botao-novo href="{{ route('conta_corrente.create', ['fornecedor_id' => $fornecedor->id]) }}">
            </x-botao-novo>
        </div>
        <h3 class="{{ $balanco > 0 ? 'text-success' : 'text-danger' }} font-weight-bold">
            {{ number_format($balanco, 2) }}g
        </h3> 
        <x-table id="tabelaBalanco">
            <x-table-header>
                <tr>
                    <th>Data</th>
                    <th>Quantidade (Gramas)</th>
                    <th>Balanço</th>
                    <th>Observação</th>
                    <th>Ações</th>
                </tr>
            </x-table-header>
            <tbody>
                @forelse ($fornecedor->contaCorrente as $contaCorrente)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($contaCorrente->data)) }}</td>
                        <td>{{ number_format($contaCorrente->peso, 2)}}</td>
                        <td class="{{ $contaCorrente->balanco == 'Crédito' ? 'text-success' : 'text-danger' }}">
                            <b>{{ $contaCorrente->balanco }}</b>
                            <i class="fas {{ $contaCorrente->balanco == 'Crédito' ? 'fa-angle-up' : 'fa-angle-down' }}"></i>
                        </td>
                        <td>{{ $contaCorrente->observacao }}</td>
                        <td>
                            <a class="btn btn-dark" title="Editar" href="{{ route("conta_corrente.edit", $contaCorrente->id) }}">
                                <span class="fas fa-pencil-alt"></span>
                            </a>
                            <form method="POST" action="{{ route("conta_corrente.destroy", $contaCorrente->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" title="Excluir">
                                    <span class="fas fa-trash-alt"></span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan=4>Nenhum registro</td>
                </tr>
                @endforelse
            </tbody>
        </x-table>
    </div>
@endsection
@section('script')
<script>
    $("#tabelaBalanco").dataTable();
</script>
@endsection