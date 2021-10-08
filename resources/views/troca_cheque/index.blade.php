@extends('layout')
@section('title')
Trocas de cheques
@endsection
@section('body')
<div class="mb-2 d-flex justify-content-between">
    <h3>Trocas de cheques</h3>
    <x-botao-novo href="{{ route('troca_cheques.create') }}"></x-botao-novo>
</div>
<x-table id="tabelaCheques">
    <x-table-header>
        <tr>
            <th>Parceiro</th>
            <th>Data da troca</th>
            <th>Valor bruto</th>
            <th>Juros</th>
            <th>Taxa</th>
            <th>Valor líquido</th>
            <th>Ações</th>
        </tr>
    </x-table-header>
    <tbody>
        @forelse ($trocas as $troca)
        <tr>
            <td> {{ $troca->parceiro()->exists() ? $troca->parceiro->pessoa->nome : 'Não informado' }} </td>
            <td> @data($troca->data_troca) </td>
            <td> @moeda($troca->valor_bruto) </td>
            <td> @moeda($troca->valor_juros) </td>
            <td> {{ number_format($troca->taxa_juros,2) }}% </td>
            <td> @moeda($troca->valor_liquido) </td>
            <td>
                <a class="btn btn-dark" href="{{ route('troca_cheques.show', $troca->id) }}">
                    <i class="fas fa-eye"></i>
                </a>
                <a class="btn btn-dark" target="_blank" href="{{ route('pdf_troca', $troca->id) }}">
                    <i class="fas fa-print"></i>
                </a>
                <a class="btn btn-dark" href="{{ route('troca_cheques.edit', $troca->id) }}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan=6>Nenhum registro</td>
        </tr>
        @endforelse
    </tbody>
</x-table>
{{ $trocas->links() }}
@endsection
@section('script')
<script>

</script>
@endsection