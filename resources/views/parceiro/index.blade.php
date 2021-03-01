@extends('layout')
@section('title')
Parceiros
@endsection
@section('body')
    <div class="container">
        <div class="jumbotron"><h1>RELAÇÃO DE PARCEIROS</h1></div>
        @if(Session::has('message'))
            <p class="alert alert-success">{{ Session::get('message') }}</p>
        @endif
        <ul class="d-flex list-group list-group">
            @forelse ($parceiros as $parceiro)
                <li class='list-group-item d-flex justify-content-between'>
                    <div class='mt-2'>
                        {{ $parceiro->pessoa->nome }}
                        <span class="text-muted">{{ $parceiro->porcentagem_padrao }}%</span>
                    </div>
                    <div class='d-flex'>
                        <a class="btn btn-dark mr-2" title="Editar" href="{{ route('parceiros.edit', $parceiro->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form method="POST" action="{{ route('parceiros.destroy', $parceiro->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class='btn btn-danger' type='submit'> 
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </li>
                
            @empty
                <li class='list-group-item list-group-item-danger'>Nenhum registro criado!</li>
            @endforelse
        </ul>
        <a href="{{ route('parceiros.create') }}" class="btn btn-success  float-right mt-2">
            <i class='fas fa-plus'></i>
        </a>
    </div>
@endsection