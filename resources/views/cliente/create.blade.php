@extends('layout')
@section('title')
Adicionar cliente
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
    </ol>
</nav>

<form method="POST" action="{{ route('clientes.store')}}">
    @csrf

    @include('formGeral')

    @include('formEndereco')

    @include('formContato')

    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Outros</h5>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="representante">Representante</label>
                        <select type="text" name="representante" id="representante" class="form-control">
                            <option></option>
                            @foreach ($representantes as $representante)
                                <option value="{{ $representante->id }}">
                                    {{ $representante->pessoa->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
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