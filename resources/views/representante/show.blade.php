@extends('layout')

@section('title')
Representantes
@endsection

@section('body')
<div class='mb-4'>
    <h3 class='d-inline' style="color:#212529">Conta Corrente - {{ $contaCorrente[0]->representante->pessoa->nome }}</h3>  
    <x-botao-novo href="{{ route('representantes.create') }}"></x-botao-novo>

</div>
    @if(Session::has('message'))
        <p class="alert alert-success">{{ Session::get('message') }}</p>
    @endif
    
    {{-- <h3 class="{{ $totalGeral > 0 ? 'text-success' : 'text-danger' }} font-weight-bold d-inline float-right">
        {{ number_format($totalGeral, 2) }}g
    </h3>  --}}

    @forelse ($contaCorrente as $registro)
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

            </tbody>
        </x-table>
    @empty
        <div class="alert alert-danger">Nenhum registro criado</div>
    @endforelse
@endsection