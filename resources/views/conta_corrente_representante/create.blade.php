@extends('layout')
@section('title')
Adicionar conta corrente (representante)
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('representantes.index') }}">Representantes</a></li>
        <li class="breadcrumb-item"><a href="{{ route('conta_corrente_representante.show', $representante->id) }}">Conta Corrente {{ $representante->pessoa->nome }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Novo</li>
    </ol>
</nav>
<form method="POST" action="{{ route('conta_corrente_representante.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-6">
            <x-form-group name="data" type="date" autofocus value="{{ date('Y-m-d') }}">Data</x-form-group>
        </div>
        <div class="col-6 form-group">
            <label for="balanco">Tipo</label>
            <x-select name="balanco" required>
                @foreach ($balanco as $tipo)
                <option value='{{ $tipo }}' {{ old('balanco') == $tipo ? 'selected': '' }}> {{ $tipo }} </option>
                @endforeach
            </x-select>
        </div>
        
        <input type="hidden" name="representante_id" value={{ $representante->id }}>

        <div class="col-6">
            <x-form-group name="peso" value="{{ old('peso') }}" type="number" step="0.001" min="0">Peso</x-form-group>
        </div>

        <div class="col-6">
            <x-form-group name="fator" value="{{ old('fator') }}" type="number" step="0.001" min="0">Fator</x-form-group>
        </div>
        
    </div> 
    <div class="form-group">
        <label for="observacao">Observação</label>
        <x-textarea name="observacao">{{ old('observacao') }}</x-textarea>
    </div>
    <div class="form-group">
        <label for="anexo">Anexo de Arquivo</label>
        <input type="file" id="anexo" name="anexo[]" class="form-control-file" multiple >
    </div>

    <input type="submit" class='btn btn-success'>
</form>
@endsection