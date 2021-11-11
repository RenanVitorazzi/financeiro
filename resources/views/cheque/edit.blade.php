@extends('layout')
@section('title')
Editar cheque
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cheques.index') }}">Cheques</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>
<div class="container">
    <form method="POST" action=" {{ route('cheques.update', $cheque->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-6">
                <x-form-group type="date" name="data_parcela" value="{{ $cheque->data_parcela }}">Data da parcela</x-form-group>
            </div>
            <div class="col-6">
                <x-form-group name="numero_cheque" value="{{ $cheque->numero_cheque }}">Número </x-form-group>
            </div>
        </div>
                
        <div class="row">
            <div class="col-6">
                <x-form-group name="nome_cheque" value="{{ $cheque->nome_cheque }}">Nome </x-form-group>
            </div>
            <div class="col-6">
                <x-form-group name="valor_parcela" value="{{ $cheque->valor_parcela }}">Valor (R$)</x-form-group>
            </div>
        </div>
    
        <div class="row">
            <div class="col-6 form-group">
                <label for="status">Situação </label>
                <x-select name="status" id="status">
                    @foreach ($situacoesCheque as $situacao)
                        <option value="{{ $situacao }}" 
                            {{ $cheque->status === $situacao ? 'selected' : '' }}> {{ $situacao }}</option>
                    @endforeach
                </x-select>
            </div>
            <div id="motivo_form" class="col-6 {{ $cheque->status === 'Devolvido' ? '' : 'd-none'}}">
                <x-form-group name="motivo" value="{{ $cheque->motivo }}">Motivo da devolução </x-form-group>
            </div>
        </div>

        <label for="observacao">Observação</label>    
        <x-text-area name="observacao">{{ $cheque->observacao }}</x-text-area>
                
        <input type="submit" class="btn btn-success mt-2">
    </form>
</div>
@endsection
@section('script')
<script>
    $("#status").change( (e) => {
        if ($(e.target).val() == 'Devolvido') {
            $("#motivo_form").removeClass('d-none')
        } else {
            $("#motivo_form").addClass('d-none')
        }
    })
</script>
@endsection