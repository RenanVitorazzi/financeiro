@extends('layout')

@section('title')
Representantes
@endsection

@section('body')
<div class='mb-4'>
    <h3 class='d-inline' style="color:#212529">Representantes</h3>  
    <a href="{{ route('representantes.create') }}" class="btn btn-success float-right">
        Novo <i class='fas fa-plus'></i>
    </a>
</div>
    @if(Session::has('message'))
        <p class="alert alert-success">{{ Session::get('message') }}</p>
    @endif
    
    @forelse ($representantes as $representante)
        @if ($loop->first)
        <div class='row'>  
        @endif
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class='mt-2'>{{ $representante->pessoa->nome }}</div>
                        <div class="d-flex">
                            <a class="btn btn-primary mr-2" title="Conta Corrente" href="{{ route('conta_corrente_representante.show', $representante->id) }}">
                                <i class="fas fa-balance-scale"></i>
                            </a>
                            <a class="btn btn-dark mr-2" title="Editar" href="{{ route('representantes.edit', $representante->id) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form method="POST" action="{{ route('representantes.destroy', $representante->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class='btn btn-danger' type='submit'> 
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>CPF: {{ $representante->pessoa->cpf }}</p>
                        <p>Nascimento: {{ date('d/m/Y', strtotime($representante->pessoa->nascimento)) }}</p>
                        <p>Celular: {{ $representante->pessoa->celular }}</p>
                        <p>CEP: {{ $representante->pessoa->cep }}</p>
                    </div>
                </div>
            </div>
        @if ($loop->last)
        </div>  
        @endif
        @empty
            <div class="alert alert-danger">Nenhum registro criado!</div>
        @endforelse
@endsection