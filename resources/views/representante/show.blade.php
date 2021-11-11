@extends('layout')
@section('title')
{{ $representante->pessoa->nome }} 
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        @if (!auth()->user()->is_representante)
        <li class="breadcrumb-item"><a href="{{ route('representantes.index') }}">Representantes</a></li>
        @endif
        <li class="breadcrumb-item active">{{ $representante->pessoa->nome }} </li>
    </ol>
</nav>

<div class='mb-2 d-flex justify-content-between'>
    <h3>{{ $representante->pessoa->nome }}</h3>
</div>

<div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-header">Conta Corrente</div>
            <div class="card-body"> 
                <p>Peso: @peso($representante->conta_corrente_sum_peso_agregado)g</p>
                <p>Fator: @fator($representante->conta_corrente_sum_fator_agregado)</p>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">Devolvidos</div>
            <div class="card-body">@moeda($devolvidos->sum('valor_parcela'))</div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">Prorrogações <button class="btn btn-dark btnAdiamento"><span class="fas fa-eye"></span></button></div>
            <div class="card-body">
                <p>@moeda($representante->parcelas->sum('adiamentos_sum_juros_totais'))</p>
            </div>
        </div>
    </div>
</div>
<p></p>
<div class="card">
    <div class="card-header">Cheques Prorrogados</div>
    <div class="card-body"> 
        <x-table>
            <thead>
                <tr>
                    <th>Titular</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Nova data</th>
                    <th>Parceiro</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($representante->parcelas as $cheque)
                <tr>
                        <td>{{ $cheque->nome_cheque }}</td>
                        <td>@moeda($cheque->valor_parcela)</td>
                        <td>@data($cheque->data_parcela)</td>
                        <td>@data('2021-05-10')</td>
                        <td>{{ $cheque->parceiro->pessoa->nome }}</td>
                </tr>
                @endforeach
            </tbody>
        </x-table>
    </div>
</div>

<p></p>
<div class="card">
    <div class="card-header">Cheques Devolvidos</div>
    <div class="card-body"> 
        <x-table>
            <thead>
                <tr>
                    <th>Titular</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Parceiro</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($devolvidos as $cheque)
                <tr>
                    <td>{{ $cheque->nome_cheque }}</td>
                    <td>@moeda($cheque->valor_parcela)</td>
                    <td>@data($cheque->data_parcela)</td>
                    <td>{{ $cheque->parceiro->pessoa->nome }}</td>
                </tr>
                @empty
                    <tr>
                        <td colspan=4>Nenhum cheque devolvido</td>
                    </tr>
                @endforelse 
            </tbody>
        </x-table>
    </div>
</div>
@endsection
@section('script')

<script>
   
</script>
@endsection