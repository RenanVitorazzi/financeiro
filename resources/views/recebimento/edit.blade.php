@extends('layout')
@section('title')
Editar recebimento
@endsection
@section('body')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('recebimentos.index') }}">Recebimentos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>

<form method="POST" action="{{ route('recebimentos.update', $pagamentosRepresentantes) }}">
    @csrf
    @method('PUT')
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Editar pagamento</h5>
            <x-table>
                <x-table-header>
                    <tr>
                        <th colspan=6>Informações do cheque</th>
                    </tr>
                    <tr>
                        <th>Nome titular</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Representante</th>
                        <th>Parceiro</th>
                        <th>Status</th>
                    </tr>
                </x-table-header> 
                <tbody>
                    <tr>
                        <td>{{ $pagamentosRepresentantes->parcela->nome_cheque ?? $pagamentosRepresentantes->parcela->venda->cliente->pessoa->nome}}</td>
                        <td>@data($pagamentosRepresentantes->parcela->data_parcela)</td>
                        <td>@moeda($pagamentosRepresentantes->parcela->valor_parcela)</td>
                        <td>{{ $pagamentosRepresentantes->parcela->representante->pessoa->nome }}</td>
                        <td>{{ $pagamentosRepresentantes->parcela->parceiro->pessoa->nome ?? 'Carteira'}}</td>
                        <td>{{ $pagamentosRepresentantes->parcela->status }}</td>
                    </tr>
                </tbody>
            </x-table>
            @if (!$outrosPagamentos->isEmpty())
                <x-table>
                    <x-table-header>
                        <tr>
                            <th colspan=3>Pagamentos relacionados ao mesmo cheque</th>
                        </tr>
                        <tr>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Conta</th>
                        </tr>
                    </x-table-header> 
                    <tbody>
                        @foreach ($outrosPagamentos as $outroPagamento)
                            <tr>
                                <td>@data($outroPagamento->data)</td>
                                <td>@moeda($outroPagamento->valor)</td>
                                <td>{{ $outroPagamento->conta->nome }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan=2>Total</th>
                            <th>@moeda($outrosPagamentos->sum('valor'))</th>
                        </tr>
                    </tfoot>
                </x-table>
            @endif
            <div class="row">
                <div class="col-4">
                    <x-form-group type="date" name="data" value="{{  $pagamentosRepresentantes->data ?? old('data') }}">Data</x-form-group>
                </div>
                <div class="col-4">
                    <x-form-group name="valor" value="{{  $pagamentosRepresentantes->valor ?? old('valor') }}">Valor</x-form-group>
                </div>
                
                <div class="col-4 form-group">
                    <label for="conta_id">Conta</label>
                    <x-select name="conta_id">
                        <option></option>
                        @foreach($contas as $conta)
                            <option value={{ $conta->id }} {{ $pagamentosRepresentantes->conta_id == $conta->id ? 'selected' : '' }}>
                                {{ $conta->nome }}
                            </option>
                        @endforeach
                            <option value="999">Conta de Parceiro</option>
                    </x-select>
                </div>
                <div class="col-4 form-group">
                    <label for="forma_pagamento">Forma de Pagamento</label>
                    <x-select name="forma_pagamento">
                        @foreach($formasPagamento as $formaPagamento)
                            <option value={{ $formaPagamento }} {{ $pagamentosRepresentantes->forma_pagamento == $formaPagamento ? 'selected' : '' }}>
                                {{ $formaPagamento }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
                <div class="col-4 form-group">
                    <label for="confirmado">Pagamento Confirmado?</label>
                    <x-select name="confirmado" value="{{ old('confirmado') }}">
                        <option value=1 {{ $pagamentosRepresentantes->confirmado ? 'selected' : '' }}> Sim </option>
                        <option value=0 {{ $pagamentosRepresentantes->confirmado ? '' : 'selected' }}> Não </option>
                    </x-select>
                </div>
                
                <div class="col-12">
                    <x-form-group type="text" name="comprovante_id" value="{{ $pagamentosRepresentantes->comprovante_id ?? old('comprovante_id') }}">Comprovante ID</x-form-group>
                </div>
                <div class="col-12 form-group">
                    <label for="observacao">Observação</label>
                    <x-text-area name="observacao" type="text" value="{{ $pagamentosRepresentantes->observacao ?? old('observacao') }}"></x-text-area>
                </div>
            </div> 
        </div>
    </div>

    <input type="submit" class='btn btn-success'>
</form>
@endsection