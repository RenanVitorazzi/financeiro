@extends('layout')
@section('title')
Editar Lançamento - Estoque
@endsection
@section('body')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('estoque.index') }}">Estoque</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>

<form method="POST" action="{{ route('estoque.update', $estoque->id)}}">
    @csrf
    @method('PUT')
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Editar Lançamento</h5>
            <div class="row">
                <div class="col-3">
                    <x-form-group type="date" name="data" value="{{  old('data') ?? $estoque->data }}">Data</x-form-group>
                </div>
                <div class="col-3">
                    <x-form-group type="number" name="peso" value="{{ old('peso') ?? $estoque->peso }}">Peso</x-form-group>
                </div>
                <div class="col-3">
                    <x-form-group type="number" name="fator" value="{{ old('fator') ?? $estoque->fator }}">Fator</x-form-group>
                </div>
                <div class="col-3">
                    <label for="balanco">Balanço</label>
                    <x-select name="balanco">
                        @if($estoque->balanco == 'Crédito') 
                            <option value='Crédito' selected>Crédito (Entrada)</option>
                        @elseif($estoque->balanco == 'Débito')
                            <option value='Débito' selected>Débito (Saída)</option>
                        @endif
                    </x-select>
                </div>
            </div> 
        </div>
    </div>
    <input type="submit" class='btn btn-success'>
</form>

@endsection