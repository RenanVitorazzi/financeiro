@extends('layout')
@section('title')
Cadastrar fornecedor
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('fornecedores.index') }}">Fornecedores</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
    </ol>
</nav>

<form method="POST" action="{{ route('fornecedores.store') }}">
    @csrf

    @include('formGeral')

    @include('formEndereco')

    @include('formContato')
    
    <input type="submit" class='btn btn-success'>
</form>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js1/cep.js') }}"></script>
@endsection