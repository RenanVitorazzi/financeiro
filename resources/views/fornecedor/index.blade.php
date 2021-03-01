@extends('layout')
@section('title')
Fornecedores
@endsection
@section('body')
<div class='mb-4'>
    <h3 class='d-inline' style="color:#212529">Fornecedores</h3>  
    <a href="{{ route('fornecedores.create') }}" class="btn btn-success float-right">
        Novo <i class='fas fa-plus'></i>
    </a>
</div>
<div class='bg-white rounded'>
    @if(Session::has('message'))
        <p class="alert alert-success">{{ Session::get('message') }}</p>
    @endif
        <ul class="d-flex list-group list-group">
            @forelse ($fornecedores as $fornecedor)
                <li class='list-group-item d-flex justify-content-between'>
                    <div class='mt-2'>
                        {{ $fornecedor->pessoa->nome }} - adicionar balanço
                    </div>
                    <div class='d-flex'>
                        <a class="btn btn-primary mr-2" title="Conta corrente" href="{{ route('fornecedores.show', $fornecedor->id) }}">
                            <i class="fas fa-chart-area"></i>
                        </a>
                        <a class="btn btn-dark mr-2" title="Editar" href="{{ route('fornecedores.edit', $fornecedor->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form method="POST" action="{{ route('fornecedores.destroy', $fornecedor->id) }}">
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
</div>
@endsection