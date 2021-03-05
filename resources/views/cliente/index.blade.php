@extends('layout')
@section('title')
Clientes
@endsection
@section('body')
<div class='mb-2 d-flex justify-content-between'>
    <h3> Relação de clientes </h3>
    <x-botao-novo href="{{ route('clientes.create') }}"></x-botao-novo>
</div>
@if(Session::has('message'))
    <p class="alert alert-success">{{ Session::get('message') }}</p>
@endif
<x-table id="myTable">
    <x-table-header>
        <tr>
            <th>Nome</th>
            <th>Representante</th>
            <th>Ações</th>
        </tr>
    </x-table-header>
    <tbody>
        @forelse ($clientes as $cliente)
        <tr>
            <td>{{ $cliente->pessoa->nome }}</td>
            <td>{{ $cliente->representante->pessoa->nome ?? 'Sem representante'}}</td>
            <td class='d-flex justify-content-center'>
                <a class="btn btn-primary mr-2" title="Visualizar" href="{{ route('clientes.show', $cliente->id) }}">
                    <i class="fas fa-eye"></i>
                </a>
                <a class="btn btn-dark mr-2" title="Editar" href="{{ route('clientes.edit',  $cliente) }}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <form method="POST" action="{{ route('clientes.destroy', $cliente->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class='btn btn-danger' type='submit'> 
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan='3'>Nenhum registro criado!</td>
        </tr>
        @endforelse
    </tbody>
</x-table>
@endsection
@push('script')
<script>
    $(document).ready( function () {
        $('#myTable').DataTable( {
            
        } );
    } );
</script>
@endpush