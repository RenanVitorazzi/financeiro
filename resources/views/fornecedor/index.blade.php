@extends('layout')
@section('title')
Fornecedores
@endsection
@section('body')

<div class='mb-2 d-flex justify-content-between'>
    <h3> Fornecedores </h3>
    <div>
        <x-botao-imprimir class="mr-2" href="{{ route('pdf_fornecedores') }}"></x-botao-imprimir>
        <x-botao-novo href="{{ route('fornecedores.create') }}"></x-botao-novo>
    </div>
</div>
<div class='bg-white rounded'>
    <ul class="d-flex list-group list-group">
        @forelse ($fornecedores as $fornecedor)
        
            <li class='list-group-item d-flex justify-content-between'>
                <div class='mt-2'>
                    <span>{{ $fornecedor->pessoa->nome }}</span>
                    <span class="font-weight-bold ml-2 badge {{ $fornecedor->conta_corrente_sum_peso_agregado > 0 ? 'badge-success' : 'badge-danger' }}">{{ number_format($fornecedor->conta_corrente_sum_peso_agregado, 3) }}</span>
                </div>
                <div class='d-flex'>
                    <a class="btn btn-primary mr-2" title="Conta corrente" href="{{ route('fornecedores.show', $fornecedor->id) }}">
                        <i class="fas fa-chart-area"></i>
                    </a>
                    <x-botao-editar class="mr-2" href="{{ route('fornecedores.edit', $fornecedor->id) }}"></x-botao-editar>
                    <x-botao-excluir action="{{ route('fornecedores.destroy', $fornecedor->id) }}">
                    </x-botao-excluir>
                </div>
            </li>
        @empty
            <li class='list-group-item list-group-item-danger'>Nenhum registro criado!</li>
        @endforelse
    </ul>
</div>
@endsection
@section('script')
<script>
    @if(Session::has('message'))
        toastr["success"]("{{ Session::get('message') }}")
    @endif
</script>
@endsection