@extends('layout')

@section('title')
Representantes
@endsection

@section('body')
<div class='mb-2 d-flex justify-content-between'>
    <h3>Representantes</h3>  
    <div>
        <x-botao-imprimir class="mr-2" href="{{ route('relacao_ccr') }}"></x-botao-imprimir>
        <x-botao-novo href="{{ route('representantes.create') }}"></x-botao-novo>
    </div>
</div>
    @forelse ($representantes as $representante)
        @if ($loop->first)
        <div class='row'>  
        @endif
            <div class="col-4 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class='mt-2'>{{ $representante->pessoa->nome }}</div>
                        <div class="d-flex">
                            <x-botao-editar class="mr-2" href="{{ route('representantes.edit', $representante->id) }}"></x-botao-editar>
                            {{-- @if ($representante->conta_corrente->isEmpty())
                            <x-botao-excluir action="{{ route('representantes.destroy', $representante->id) }}"></x-botao-excluir>
                            @endif --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <p>
                            Peso: 
                            <span class="{{ $representante->conta_corrente->sum('peso_agregado') < 0 ? 'text-danger' : 'text-success'}}">
                                @peso($representante->conta_corrente->sum('peso_agregado'))
                            </span>
                        </p>
                        <p>
                            Fator: 
                            <span class="{{ $representante->conta_corrente->sum('fator_agregado') < 0 ? 'text-danger' : 'text-success'}}">
                                @fator($representante->conta_corrente->sum('fator_agregado'))
                            </span>
                        </p>
                        <a class="btn btn-dark" title="Conta Corrente" href="{{ route('conta_corrente_representante.show', $representante->id) }}">
                            Conta Corrente <i class="fas fa-balance-scale"></i>
                        </a>
                        <a class="btn btn-dark" title="Conta Corrente" href="{{ route('venda.show', $representante->id) }}">
                            Vendas <i class="fas fa-shopping-cart"></i>
                        </a>
                    </div>
                </div>
            </div>
        @if ($loop->last)
        </div>  
        @endif
        @empty
            <div class="alert alert-danger">Nenhum registro criado!</div>
        @endforelse
@endsection
@section('script')
<script>
@if(Session::has('message'))
    toastr["success"]("{{ Session::get('message') }}")
@endif
</script>
@endsection