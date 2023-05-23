@extends('layout')
@section('title')
Clientes
@endsection
@section('body')
<div class='mb-2 d-flex justify-content-between'>
    <h3> Clientes </h3>
    <x-botao-novo href="{{ route('clientes.create') }}"></x-botao-novo>
</div>
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
                <a class="btn btn-dark mr-2" title="Visualizar" href="{{ route('clientes.show', $cliente->id) }}">
                    <i class="fas fa-eye"></i>
                </a>
                <x-botao-editar class="mr-2" href="{{ route('clientes.edit', $cliente->id) }}"></x-botao-editar>
                <x-botao-excluir action="{{ route('clientes.destroy', $cliente->id) }}"></x-botao-excluir>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan='3'>Nenhum registro!</td>
        </tr>
        @endforelse
    </tbody>
</x-table>
@endsection
@section('script')
<script>
    @if(Session::has('message'))
        toastr["success"]("{{ Session::get('message') }}")
    @endif

    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
</script>
@endsection
