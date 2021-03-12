@extends('layout')
@section('title')
Adicionar nova conta
@endsection
@section('body')
    <h3>Nova conta corrente (Fornecedores)</h3>
    <form method="POST" action="{{ route('conta_corrente.store')}}">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <x-form-group name="data" type="date" value="{{ date('Y-m-d') }}" >Data</x-form-group>
               
            </div>
            @error('balanco')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="col-md-4 form-group">
                <label for="balanco">Tipo</label>
                <x-select name="balanco" id="balanco" class="form-control" autofocus required class="@error('balanco') is-invalid @enderror">
                    <option></option>
                    <option value='Crédito'> Fechamento </option>
                    <option value='Débito'> Compra </option>
                </x-select>
            </div>
            <div class="col-md-4 form-group">
                <label for="fornecedor_id">Fornecedor</label>
                <x-select name="fornecedor_id" id="fornecedor_id" class="form-control">
                    <option value="{{ $fornecedor->id }}"> {{ $fornecedor->pessoa->nome }} </option>
                </x-select>
            </div>
            <div class="col-md-4">
                <x-form-group name="cotacao">Cotação do dia</x-form-group>
            </div>
            <div class="col-md-4">
                <x-form-group name="valor">Valor</x-form-group>
            </div>
            <div class="col-md-4">
                <x-form-group name="peso">Peso (g)</x-form-group>
            </div>
        </div> 
        <div class="form-group">
            <label for="observacao">Observação</label>
            <x-textarea name="observacao" id="observacao" class="form-control"></x-textarea>
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