@extends('layout')
@section('title')
Consignados
@endsection
@section('body')
<div class='mb-2 d-flex justify-content-between'>
    <h3> Consignados </h3>
    <x-botao-novo href="{{ route('consignado.create') }}"></x-botao-novo>
</div>
<x-table>
    <x-table-header> 
        <tr>
            <th>Cliente</th>
            <th>Representante</th>
            <th>Data</th>
            <th>Peso</th>
            <th>Fator</th>
            <th>Ações</th>
        </tr>
    </x-table-header>
    <tbody>
        @forelse ($consignados as $consignado)
        <tr>
            <td>{{ $consignado->cliente->pessoa->nome }}</td>
            <td>{{ $consignado->representante->pessoa->nome}}</td>
            <td>@data($consignado->data)</td>
            <td>@peso($consignado->peso)</td>
            <td>@fator($consignado->fator)</td>
            <td class='d-flex justify-content-center'>
                
                <x-botao-editar class="mr-2" href="{{ route('consignado.edit', $consignado) }}"></x-botao-editar>
                <x-botao-excluir action="{{ route('consignado.destroy', $consignado) }}"></x-botao-excluir>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan='6'>Nenhum registro!</td>
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
    
</script>
@endsection