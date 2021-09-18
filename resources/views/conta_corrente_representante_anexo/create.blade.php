@extends('layout')
@section('title')
Novo Anexo
@endsection
@section('body')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        @if (!auth()->user()->is_representante)
        <li class="breadcrumb-item"><a href="{{ route('representantes.index') }}">Representantes</a></li>
        @endif
        <li class="breadcrumb-item">
            <a href="{{ route('conta_corrente_representante.show', $contaCorrente->representante_id) }}">
                Conta Corrente {{ $contaCorrente->representante->pessoa->nome }} 
            </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('ccr_anexo.index',['id' => $contaCorrente->id]) }}">Anexos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Novo Anexo</li>
    </ol>
</nav>

<form method="POST" action="{{ route('ccr_anexo.store') }}" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="conta_corrente_id" value="{{ $contaCorrente->id }}">
    
    <div class="form-group">
        <label for="anexo">Anexo de Arquivo</label>
        <input type="file" id="anexo" name="anexo[]" class="form-control-file" multiple required>
    </div>
    
    <input type="submit" class='btn btn-success'>
</form>
@endsection
