@extends('layout')
@section('title')
Anexos
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
        <li class="breadcrumb-item active" aria-current="page">Anexos</li>
    </ol>
</nav>

<div class="text-right">
    <a href="{{ route('conta_corrente_representante.edit', $contaCorrente->id) }}" class="btn btn-dark">
        Editar <span class="fas fa-pencil-alt"></span>
    </a>
    <a href="{{ route('ccr_anexo.create', ['id' => $contaCorrente->id]) }}" class="btn btn-success">
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
        <p>Fator: {{ $contaCorrente->fator }}<p>
        <p>Representante: {{ $contaCorrente->representante->pessoa->nome }}<p>
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
                            <x-botao-excluir action="{{ route('ccr_anexo.destroy', $file->id) }}"></x-botao-excluir>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif
@endsection
