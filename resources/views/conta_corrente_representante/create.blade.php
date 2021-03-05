@extends('layout')
@section('title')
Adicionar conta corrente (representante)
@endsection

@section('body')
    <form method="POST" action="{{ route('conta_corrente_representante.store')}}">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <x-form-group name="data" type="date" autofocus value="{{ date('Y-m-d') }}">Data</x-form-group>
            </div>
            <div class="col-md-4 form-group">
                <label for="balanco">Tipo</label>
                <select name="balanco" id="balanco" class="form-control" required>
                    <option></option>
                    <option value='Reposição' {{ old('balanco') == 'Reposição' ? 'selected': '' }}> Reposição </option>
                    <option value='Venda' {{ old('balanco') == 'Venda' ? 'selected': '' }}> Venda </option>
                    <option value='Devolução' {{ old('balanco') == 'Devolução' ? 'selected': '' }}> Devolução </option>
                </select>
            </div>
            
            <div class="col-md-4 form-group">
                <label for="representante_id">Representante</label>
                <select name="representante_id" id="representante_id" class="form-control" required>
                    <option></option>
                   @foreach ($representantes as $representante)
                        <option value="{{ $representante->id }}"
                            {{ old('representante_id') == $representante->id ? 'selected': '' }}
                            >
                            {{ $representante->pessoa->nome }}
                        </option>
                        
                   @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <x-form-group name="fator" value="{{ old('fator') }}">Fator</x-form-group>
            </div>
            <div class="col-md-4">
                <x-form-group name="peso" value="{{ old('peso') }}">Peso</x-form-group>
            </div>
        </div> 
        <div class="form-group">
            <label for="observacao">Observação</label>
            <textarea name="observacao" id="observacao" class="form-control">{{ old('observacao') }}</textarea>
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