@extends('layout')

@section('title')
Representantes
@endsection

@section('body')
<div class='mb-2 d-flex justify-content-between'>
    <h3>Representantes</h3>  
    <div class="d-flex">
        <x-botao-imprimir class="mr-2" href="{{ route('relacao_ccr') }}"></x-botao-imprimir>
        <x-botao-novo href="{{ route('representantes.create') }}"></x-botao-novo>
    </div>
</div>

<x-table class="table-striped">
    <x-table-header>
        <tr>
            <th>Nome</th>
            <th>Peso</th>
            <th>Fator</th>
            <!-- <th>Devolvidos</th> -->
            <th></th>
        </tr>
    </x-table-header>
    <tbody>
        @forelse ($representantes as $representante)
        <tr>
            <td>{{ $representante->pessoa->nome }}</td>
            <td>@peso($representante->conta_corrente->sum('peso_agregado'))g</td>
            <td>@fator($representante->conta_corrente->sum('fator_agregado'))ft</td>
            <!-- <td>@moeda($devolvidos->where('representante_id', $representante->id)->sum('valor_parcela'))</td> -->
            <td>
                <a class="btn btn-dark" 
                    title="Acerto de documentos" 
                    target='_blank' 
                    href="{{ route('pdf_acerto_documento', $representante->id) }}">
                    Acertos
                </a>
                <a class="btn btn-dark" 
                    title="Cheques Devolvidos " 
                    target='_blank' 
                    href="{{ route('pdf_cc_representante', $representante->id) }}">
                    Chs Devolvidos 
                </a>
                <a class="btn btn-dark" 
                    title="Conta Corrente" 
                    target='_blank' 
                    href="{{ route('conta_corrente_representante.show', $representante->id) }}">
                    Conta Corrente
                </a>
                
                <a class="btn btn-dark" 
                    title="Vendas" 
                    target='_blank' 
                    href="{{ route('venda.show', $representante->id) }}">
                    Vendas
                </a>
                {{-- 
                <a class="btn btn-dark" title="Detalhes" href="{{ route('representantes.show', $representante->id) }}">
                    <i class="fas fa-eye"></i>
                </a>
                <a class="btn btn-dark" title="Imprimir devolvidos" target="_blank" href="{{ route('cheques_devolvidos', $representante->id) }}">
                    <i class="fas fa-print"></i>
                </a> 
                
                <x-botao-editar href="{{ route('representantes.edit', $representante->id) }}"></x-botao-editar>
                --}}
            </td>
        </tr>
        @empty
            <tr>
                <td colspan=4>Nenhum registro criado!</td>
        @endforelse
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