@extends('layout')
@section('title')
Conta Corrente {{ $representante->pessoa->nome }} 
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        @if (!auth()->user()->is_representante)
        <li class="breadcrumb-item"><a href="{{ route('representantes.index') }}">Representantes</a></li>
        @endif
        <li class="breadcrumb-item active">Conta Corrente {{ $representante->pessoa->nome }} </li>
    </ol>
</nav>

<div class='mb-2 d-flex justify-content-between'>
    <h3>Conta Corrente - {{ $representante->pessoa->nome }}</h3>
    <div>
        @if (count($contaCorrente) > 0)
        <x-botao-imprimir class="mr-2" href="{{ route('impresso_ccr', ['id' => $representante->id]) }}"></x-botao-imprimir>
        @endif
        <x-botao-novo href="{{ route('conta_corrente_representante.create', ['representante_id' => $representante->id]) }}"></x-botao-novo>
    </div>
</div>
<div>
    @if (count($contaCorrente) > 0)
        <h3 class="{{ $contaCorrente[0]->saldo_peso > 0 ? 'text-success' : 'text-danger' }} font-weight-bold d-inline">
            Peso: @peso($contaCorrente[0]->saldo_peso)g
        </h3> 
        <h3 class="{{ $contaCorrente[0]->saldo_fator > 0 ? 'text-success' : 'text-danger' }} font-weight-bold float-right">
            Fator: @fator($contaCorrente[0]->saldo_fator)
        </h3> 
    @endif
</div>

<x-table>
    <x-table-header>
        <th>Data</th>
        <th>Relação</th>
        <th>Balanço</th>
        <th>Observação</th>
        <th>Saldo</th>
        <th>Ações</th>
    </x-table-header>
    <tbody>
        @forelse ($contaCorrente as $registro)
            <tr>
                <td>@data($registro->data)</td>
                <td>
                    <div>Peso: @peso($registro->peso)</div>
                    <div>Fator: @fator($registro->fator)</div>
                </td>
                <td class="{{ $registro->balanco == 'Reposição' ? 'text-danger' : 'text-success' }}">
                    <b>{{ $registro->balanco }}</b>
                    <i class="fas {{ $registro->balanco == 'Reposição' ? 'fa-angle-down' : 'fa-angle-up' }}"></i>
                </td>
                <td>{{ $registro->observacao }}</td>
                <td>
                    <div>Peso: @peso($registro->saldo_peso)</div>
                    <div>Fator: @fator($registro->saldo_fator)</div>
                </td>
                <td>
                    <a class="btn btn-dark" href="{{ route('ccr_anexo.index', ['id' => $registro->id]) }}" title="Anexos">
                        <i class="fas fa-file-image"></i>
                    </a>
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
@section('script')
<script>
@if(Session::has('message'))
    toastr["success"]("{{ Session::get('message') }}")
@endif
</script>
@endsection