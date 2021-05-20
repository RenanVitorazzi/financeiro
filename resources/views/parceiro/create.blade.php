@extends('layout')
@section('title')
Adicionar parceiro
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('parceiros.index') }}">Parceiros</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
    </ol>
</nav>

<form method="POST" action="{{ route('parceiros.store')}}">
    @csrf

    @include('formGeral')
    @include('formEndereco')
    @include('formContato')

    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Outros</h5>
            <div class="row">
                <div class="col-4">
                    <x-form-group type="number" step="0.01" name='porcentagem_padrao' value="{{ old('porcentagem_padrao') }}">Taxa Padrão (%)</x-form-group>
                </div>
            </div> 
        </div>
    </div>

    <input type="submit" class='btn btn-success'>
</form>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js1/cep.js') }}"></script>
@endsection