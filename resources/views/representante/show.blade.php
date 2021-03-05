@extends('layout')

@section('title')
Representantes
@endsection

@section('body')
<div class='mb-4'>
    <h3 class='d-inline' style="color:#212529">Conta Corrente - {{ $representante->pessoa->nome }}</h3>  
    <x-botao-novo href="{{ route('conta_corrente_representante.create') }}"></x-botao-novo>
</div>
    @if(Session::has('message'))
        <p class="alert alert-success">{{ Session::get('message') }}</p>
    @endif
    <div>
        <h3 class="{{ $balancoPeso > 0 ? 'text-success' : 'text-danger' }} font-weight-bold d-inline">
            Peso: {{ number_format($balancoPeso, 2) }}g
        </h3> 
        <h3 class="{{ $balancoFator > 0 ? 'text-success' : 'text-danger' }} font-weight-bold float-right">
            Fator: {{ number_format($balancoFator, 2) }}g
        </h3> 
    </div>
  
    <x-table>
        <x-table-header>
            <th>Data</th>
            <th>Peso</th>
            <th>Fator</th>
            <th>Balanço</th>
            <th>Observação</th>
            <th>Ações</th>
        </x-table-header>
        <tbody>
            @forelse ($contaCorrente as $registro)
            <tr>
                <td>{{ date('d/m/Y', strtotime($registro->data)) }}</td>
                <td>{{ number_format($registro->peso, 2)}}</td>
                <td>{{ number_format($registro->fator, 2)}}</td>
                <td class="{{ $registro->balanco == 'Reposição' ? 'text-danger' : 'text-success' }}">
                    <b>{{ $registro->balanco }}</b>
                    <i class="fas {{ $registro->balanco == 'Reposição' ? 'fa-angle-down' : 'fa-angle-up' }}"></i>
                </td>
                <td>{{ $registro->observacao }}</td>
                <td>
                    <x-botao-editar href='{{ route("conta_corrente_representante.edit", $registro->id) }}'></x-botao-editar>
                    <x-botao-excluir action='{{ route("conta_corrente_representante.destroy", $registro->id) }}'></x-botao-excluir>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="table-danger">Nenhum registro criado</td>
            </tr>
            @endforelse
        </tbody>
    </x-table>
@endsection