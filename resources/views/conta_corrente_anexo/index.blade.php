@extends('layout')
@section('title')
Anexos
@endsection
@section('body')
{{-- <style>
    .container-img:hover .img-fluid{
        opacity: 0.5;
    }

    .container-img:hover .delete {
        transition: display .5s ease-out;
        display: inline-block;
    }

    .img-fluid {
        transition: opacity .5s ease-out;
        height: 450px;
        object-fit: cover;
    }

    .delete {
        display: none;
        position: absolute;
        top: 50%;
        left:50%;
        transform: translate(-50%,-50%);
    }
</style> --}}

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('fornecedores.index') }}">Fornecedores</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('fornecedores.show', $contaCorrente->fornecedor_id) }}">
                Conta Corrente {{ $contaCorrente->fornecedor->pessoa->nome }} 
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Anexos</li>
    </ol>
</nav>

<div class="text-right">
    <a href="{{ route('conta_corrente.edit', $contaCorrente->id) }}" class="btn btn-dark">
        Editar <span class="fas fa-pencil-alt"></span>
    </a>
    <a href="{{ route('conta_corrente_anexo.create', ['id' => $contaCorrente->id]) }}" class="btn btn-success">
        Adicionar Anexo <span class="fas fa-plus"></span>
    </a>
</div>

<div class="row mt-2">
    <div class="col-6">
        <p>Data: {{ date('d/m/Y', strtotime($contaCorrente->data)) }}<p>
        <p>Balanço: {{ $contaCorrente->balanco }}<p>
        
        <p>Observação: {{ $contaCorrente->observacao }}<p>
    </div>
    <div class="col-6">    
        <p>Peso: {{ $contaCorrente->peso }}<p>
        <p>Fornecedor: {{ $contaCorrente->fornecedor->pessoa->nome }}<p>
        @if ($contaCorrente->balanco == 'Crédito')
            <p>Cotação: R${{ $contaCorrente->cotacao }}<p>
            <p>Valor: R${{ $contaCorrente->valor }}<p>
        @endif
    </div>
</div>
@if (!$files->isEmpty())
    <section>
        <div class="text-center">
            <h5>Anexos</h5>
        </div>
        <ul class="list-group">
            @foreach ($files as $file)
                <li class="list-group-item d-flex justify-content-between">
                    <div class="mt-2">
                        {{ $file->nome }}
                    </div>
                    <div>
                        <a class="btn btn-dark mr-2" href="{{ asset('storage/' . $file->path) }}" target="_blank">
                            <i class="fas fa-eye"></i>
                        </a>
                        <x-botao-excluir action="{{ route('conta_corrente_anexo.destroy', $file->id) }}"></x-botao-excluir>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>
@endif

{{-- <div class="row">
    @foreach ($files as $file)
        @if( substr($file->path, -3, 3) === 'pdf' )
        <div class="col-6 form-group mb-4">
            <a href="{{ asset('storage/' . $file->path) }}" target="_blank">
                {{ $file->nome }}
            </a>
            <form method="POST" class="d-inline" action="{{ route('conta_corrente_anexo.destroy', $file->id) }}" onsubmit="confirmarExclusao(event, this)">
                @csrf
                @method('DELETE')
                
                <button class="btn btn-danger" type='submit'>
                    <i class="fas fa-trash"></i>
                </button>
            </form> 
        </div>
        @else
            <div class="col-6 text-center form-group mb-4">
                <h5>
                    <a href="{{ asset('storage/' . $file->path) }}" target="_blank">
                        {{ $file->nome }}
                    </a>
                </h5>
                <div class="container-img">
                    <img class="img-fluid rounded" src="{{ asset('storage/' . $file->path) }}" alt="">
                    <form method="POST" action="{{ route('conta_corrente_anexo.destroy', $file->id) }}" onsubmit="confirmarExclusao(event, this)">
                        @csrf
                        @method('DELETE')
                        
                        <button class="delete btn btn-danger" type='submit'>
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endif
    @endforeach
</div> --}}
@endsection
