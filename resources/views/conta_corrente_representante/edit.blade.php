@extends('layout')
@section('title')
Adicionar nova conta corrente
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('representantes.index') }}">Representantes</a></li>
        <li class="breadcrumb-item"><a href="{{ route('conta_corrente_representante.show', $contaCorrente->representante->id) }}">Conta Corrente {{ $contaCorrente->representante->pessoa->nome }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Novo</li>
    </ol>
</nav>
    <h3>Nova conta corrente (Representante)</h3>
    <form method="POST" action="{{ route('conta_corrente_representante.update', $contaCorrente->id)}}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-6">
                <x-form-group name="data" type="date" autofocus value="{{ $contaCorrente->data }}">Data</x-form-group>
            </div>
            <div class="col-6 form-group">
                <label for="balanco">Tipo</label>
                <x-select name="balanco" required>
                    @foreach ($balanco as $tipo)
                    <option value='{{ $tipo }}' {{ $contaCorrente->balanco == $tipo ? 'selected' : '' }}> {{ $tipo }} </option>
                    @endforeach
                </x-select>
            </div>
            
            <input type="hidden" name="representante_id" value={{ $contaCorrente->representante->id }}>

            <div class="col-6">
                <x-form-group name="fator" value="{{ $contaCorrente->fator }}">Fator</x-form-group>
            </div>
            <div class="col-6">
                <x-form-group name="peso" value="{{ $contaCorrente->peso }}">Peso</x-form-group>
            </div>
        </div> 
        <div class="form-group">
            <label for="observacao">Observação</label>
            <x-textarea name="observacao">{{ $contaCorrente->observacao }}</x-textarea>
        </div>
       
        <input type="submit" class='btn btn-success'>
    </form>
@endsection