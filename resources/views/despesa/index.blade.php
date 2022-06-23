@extends('layout')
@section('title')
Despesas
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Despesas</li>
    </ol>
</nav>
<div class='mb-2 d-flex justify-content-between'>
    <h3> Despesas </h3>
    <div>
        <x-botao-novo href="{{ route('despesas.create') }}"></x-botao-novo>
    </div>
</div>
@if (count($fixasNaoPagas)>0)
    
    <x-table>
        <x-table-header>
            <th colspan = 4>DESPESAS FIXAS NÃO PAGAS!</th>
        </x-table-header>
        <x-table-header>
            <th>Nome</th>
            <th>Valor</th>
            <th>Vencimento</th>
            <th>Local</th>
        </x-table-header>
        <tbody>
        @foreach ($fixasNaoPagas as $fixaNaoPaga)
            <tbody>
                <td>{{ $fixaNaoPaga->nome }}</td>
                <td>@moeda($fixaNaoPaga->valor)</td>
                <td>{{ $fixaNaoPaga->dia_vencimento }}</td>
                <td>{{ $fixaNaoPaga->local->nome }}</td>
            </tbody>
        @endforeach
    </x-table>
  
@endif
<x-table>
    <x-table-header>
        <th>Nome</th>
        <th>Valor</th>
        <th>Vencimento</th>
        <th>Local</th>
        <th></th>
    </x-table-header>
    <tbody>
        @forelse ($despesas as $despesa)
            <tr>
                <td>{{ $despesa->nome }}</td>
                <td>@moeda($despesa->valor)</td>
                <td>@data($despesa->data_vencimento)</td>
                <td>{{ $despesa->local->nome }}</td>
                <td>
                    <x-botao-editar class="mr-2" href="{{ route('despesas.edit', $despesa->id) }}"></x-botao-editar>
                    <x-botao-excluir action="{{ route('despesas.destroy', $despesa->id) }}"></x-botao-excluir>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan=5>Nenhum registro!</td>
                </tr>
            @endforelse
        <tfoot>
            <tr>
                <th>Total</th>
                <th colspan=4>@moeda($despesas->sum('valor'))</th>
            </tr>
        </tfoot>
    </tbody>
</x-table>


@endsection
@section('script')
<script>
    @if(Session::has('message'))
        toastr["success"]("{{ Session::get('message') }}")
    @endif
</script>
@endsection