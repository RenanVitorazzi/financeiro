@extends('layout')
@section('title')
Fornecedores
@endsection
@section('body')
    <div class="container">

        <div class="mb-4">
            <h3 class='d-inline'>{{ $fornecedor->pessoa->nome }}</h3>
            <a href="{{ route('conta_corrente.create') }}" class="btn btn-success float-right">
                Novo <i class='fas fa-plus'></i>
            </a>
            
        </div>

        <h3 class="{{ $totalGeral > 0 ? 'text-success' : 'text-danger' }} font-weight-bold d-inline float-right">{{ number_format($totalGeral, 2) }}g</h3> 

        <table class="table text-center table-light" id="tabelaBalanço">
            <thead class="thead-dark">
                <tr>
                    <th>Data</th>
                    <th>Quantidade (Gramas)</th>
                    <th>Balanço</th>
                    <th>Observação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contasCorrentes as $contaCorrente)
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
        </table>

        {{ $contasCorrentes->links() }}

    </div>
@endsection