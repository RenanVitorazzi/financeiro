@extends('layout')
@section('title')
Adicionar nova conta
@endsection
@section('body')
    <h3>Nova conta corrente (Fornecedores)</h3>
    <form method="POST" action="{{ route('conta_corrente.update', $contaCorrente->id)}}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-4">
                <x-form-group name="data" type="date" value="{{ $contaCorrente->data }}">Data</x-form-group>
            </div>
            <div class="col-md-4 form-group">
                <label for="balanco">Tipo</label>
                <select name="balanco" id="balanco" class="form-control" autofocus required>
                    <option></option>
                    <option value='Crédito' {{ $contaCorrente->balanco == 'Crédito' ? 'selected': '' }}> Fechamento </option>
                    <option value='Débito' {{ $contaCorrente->balanco == 'Débito' ? 'selected': '' }}> Compra </option>
                </select>
            </div>
            <div class="col-md-4 form-group">
                <label for="fornecedor_id">Fornecedor</label>
                <select name="fornecedor_id" id="fornecedor_id" class="form-control">
                    <option></option>
                    @foreach ($fornecedores as $fornecedor)
                        <option value="{{ $fornecedor->id }}"  {{ $contaCorrente->fornecedor_id == $fornecedor->id ? 'selected': '' }}> {{ $fornecedor->pessoa->nome }} </option>
                    @endforeach
                </select>
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
            <textarea name="observacao" id="observacao" class="form-control">{{ $contaCorrente->observacao }}</textarea>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class='mt-2'>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <input type="submit" class='btn btn-success'>
    </form>
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