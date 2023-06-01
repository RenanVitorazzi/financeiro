@extends('layout')
@section('title')
Adicionar estoque
@endsection
@section('body')


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('estoque.index') }}">Estoque</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
    </ol>
</nav>
@if($conta_corrente)
<div class="card mb-2">
    <div class="card-body">
        <h5 class="card-title">Lançado no Conta Corrente</h5>
        <div class="row">
            <div class="col-3">
                <label for="balanco">Data</label>
                <input class="form-control" disabled type="date" value="{{ $conta_corrente->data }}"></input>
            </div>

            <div class="col-3">
                <label for="balanco">Nome</label>
                <input class="form-control" disabled type="text" value="{{ $conta_corrente->nome }}"></input>
            </div>
            <div class="col-3">
                <label for="balanco">Peso (g)</label>
                <input class="form-control" disabled type="number" value="{{ $conta_corrente->peso }}"></input>
            </div>
            <div class="col-3">
                <label for="balanco">Balanço</label>
                <input class="form-control" disabled type="text" value="{{ $balancoReal }}"></input>
            </div>
        </div>
    </div>
</div>
@endif
<form method="POST" action="{{ route('estoque.store')}}">
    @csrf
    @if($conta_corrente)
        <input type="hidden" value="{{ $tabela }}" name="tabela"></input>
        <input type="hidden" value="{{ $conta_corrente->id}}" name="conta_corrente_id"></input>
    @endif
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Cadastrar</h5>
            <div class="row">
                <div class="col-3">
                    <x-form-group type="date" name="data" value="{{ $conta_corrente->data ?? old('data') }}">Data</x-form-group>
                </div>
                <div class="col-3">
                    <x-form-group type="text" name="peso" value="{{ old('peso') }}">Peso</x-form-group>
                </div>
                <div class="col-3">
                    <x-form-group type="text" name="fator" value="{{ old('fator') }}">Fator</x-form-group>
                </div>
                <div class="col-3">
                    <label for="balanco">Balanço</label>
                    <x-select name="balanco" value="{{ old('balanco') }}">
                        <!-- COMPRA DO FORNECEDOR OU DEVOLUÇÃO ATACADO -->
                        @if( ($balancoReal=='Compra' && $tabela == 'conta_corrente') || ($balancoReal=='Devolução' && $tabela == 'conta_corrente_representante'))
                            <option value='Crédito' selected>Crédito (Entrada)</option>
                        <!-- REPOSIÇÃO/COMPRA DO REPRESENTANTE -->
                        @elseif( ($balancoReal=='Reposição' && $tabela == 'conta_corrente_representante'))
                            <option value='Débito' selected>Débito (Saída)</option>
                        @else
                            <option></option>
                            <option value='Crédito'>Crédito (Entrada)</option>
                            <option value='Débito'>Débito (Saída)</option>
                        @endif
                    </x-select>
                </div>
                <div class='col-12'>
                    <label for="observacao">Observação</label>
                    <x-text-area name='observacao'> {{old('observacao')}} </x-text-area>
                </div>
            </div>
        </div>
    </div>
    <input type="submit" class='btn btn-success'>
</form>

@endsection
@section('script')
@endsection
