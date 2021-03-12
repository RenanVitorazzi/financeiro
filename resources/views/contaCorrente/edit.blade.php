@extends('layout')
@section('title')
Adicionar nova conta
@endsection
@section('body')
    <h3>Nova compra/fechamento {{ $contaCorrente->fornecedor->pessoa->nome}} </h3>
    <form method="POST" action="{{ route('conta_corrente.update', $contaCorrente->id)}}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <x-form-group name="data" type="date" value="{{ $contaCorrente->data }}">Data</x-form-group>
            </div>
            <div class="col-md-6 form-group">
                <label for="balanco">Balanço</label>
                <x-select name="balanco" id="balanco" autofocus required>
                    <option></option>
                    <option value='Crédito' {{ $contaCorrente->balanco == 'Crédito' ? 'selected': '' }}> Fechamento </option>
                    <option value='Débito' {{ $contaCorrente->balanco == 'Débito' ? 'selected': '' }}> Compra </option>
                </x-select>
            </div>
            <div class="col-md-4">
                <x-form-group name="cotacao" value="{{ $contaCorrente->cotacao }}">Cotação do dia</x-form-group>
            </div>
            <div class="col-md-4">
                <x-form-group name="valor" value="{{ $contaCorrente->valor }}">Valor pago</x-form-group>
            </div>
            <div class="col-md-4">
                <x-form-group name="peso" value="{{ $contaCorrente->peso }}">Peso (g)</x-form-group>
            </div>
        </div> 
        <div class="form-group">
            <label for="observacao">Observação</label>
            <x-text-area name="observacao">{{ $contaCorrente->observacao }}</x-text-area>
        </div>
        <input type="submit" class='btn btn-success'>
    </form>
@endsection
@section('script')
    <script>
        $("#cotacao, #valor").change( () => {
            let cotacao = parseFloat($("#cotacao").val());
            let valor = parseFloat($("#valor").val());

            if (!cotacao || !valor) {
                return false;
            }

            let peso = valor/cotacao;
            $("#peso").val(peso.toFixed(2));
        })
    </script>
@endsection