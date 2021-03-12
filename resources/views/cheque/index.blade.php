@extends('layout')
@section('title')
Relação de cheques
@endsection
@section('body')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h3>Relação de cheques</h3>
            {{-- <x-botao-novo href="{{ route('conta_corrente.create', ['fornecedor_id' => $fornecedor->id]) }}">
            </x-botao-novo> --}}
        </div>
        {{-- <h3 class="{{ $balanco > 0 ? 'text-success' : 'text-danger' }} font-weight-bold">
            {{ number_format($balanco, 2) }}g
        </h3>  --}}
        <x-table id="tabelaBalanco">
            <x-table-header>
                <tr>
                    <th>Cliente</th>
                    <th>Representante</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Detalhes</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </x-table-header>
            <tbody>
                @forelse ($cheques as $cheque)
                    <tr>
                        <td>{{ $cheque->cliente }}</td>
                        <td>{{ $cheque->representante }}</td>
                        <td>{{ date('d/m/Y', strtotime($cheque->data_parcela)) }}</td>
                        <td>R$ {{ number_format($cheque->valor_parcela,2, ',', '.') }}</td>
                        <td>{{ $cheque->numero_cheque }} {{ $cheque->observacao}}</td>
                        <td>{{ $cheque->status }}</td>
                        <td>
                            <a class="btn btn-dark" title="Editar" href="{{ route("conta_corrente.edit", $cheque->id) }}">
                                <span class="fas fa-pencil-alt"></span>
                            </a>
                            <form method="POST" action="{{ route("conta_corrente.destroy", $cheque->id) }}" class="d-inline">
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