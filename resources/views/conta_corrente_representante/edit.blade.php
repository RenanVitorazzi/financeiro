@extends('layout')
@section('title')
Adicionar nova conta
@endsection
@section('body')
    <h3>Nova conta corrente (Representante)</h3>
    <form method="POST" action="{{ route('conta_corrente_representante.update', $contaCorrente->id)}}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-4">
                <x-form-group name="data" type="date" autofocus value="{{ $contaCorrente->data }}">Data</x-form-group>
            </div>
            <div class="col-md-4 form-group">
                <label for="balanco">Tipo</label>
                <select name="balanco" id="balanco" class="form-control" required>
                    <option></option>
                    <option value='Reposição' {{ $contaCorrente->balanco == 'Reposição' ? 'selected': '' }}> Reposição </option>
                    <option value='Venda' {{ $contaCorrente->balanco == 'Venda' ? 'selected': '' }}> Venda </option>
                    <option value='Devolução' {{ $contaCorrente->balanco == 'Devolução' ? 'selected': '' }}> Devolução </option>
                </select>
            </div>
            
            <div class="col-md-4 form-group">
                <label for="representante_id">Representante</label>
                <select name="representante_id" id="representante_id" class="form-control" required>
                    <option></option>
                   @foreach ($representantes as $representante)
                        <option value="{{ $representante->id }}"
                            {{ $contaCorrente->representante_id == $representante->id ? 'selected': '' }}
                            >
                            {{ $representante->pessoa->nome }}
                        </option>
                        
                   @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <x-form-group name="fator" value="{{ $contaCorrente->fator }}">Fator</x-form-group>
            </div>
            <div class="col-md-4">
                <x-form-group name="peso" value="{{ $contaCorrente->peso }}">Peso</x-form-group>
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
@endsection