@extends('layout')

@section('body')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
<h1>Bem-vindo(a), <strong>{{ auth()->user()->name }}</strong>!</h1>
<p></p>
<p></p>
<hr>
<p></p>
<p></p>
<x-table>
    <x-tableheader>
        <th colspan=4>Cheques para depósito</th>
    </x-tableheader>

    <x-tableheader>
        <th>Titular</th>
        <th>Data do cheque</th>
        <th>Valor</th>
        <th>Representante</th>
    </x-tableheader>
    <tbody>

    @forelse ($chequesParaDepositar as $cheque)
        <tr>
            <td>{{ $cheque->nome_cheque }}</td>
            <td>@moeda($cheque->valor_parcela)</td>
            <td>@data($cheque->data_parcela)</td>
            <td>{{ $cheque->representante->pessoa->nome }}</td>
        </tr>
    @empty
        <tr>
            <td colspan=4>Nenhum cheque para depósito!</td>
        </tr>
    @endforelse
    </tbody>
    @if ($chequesParaDepositar)
    <tfoot class="thead-dark">
        <th >Total</th>
        <th colspan=3>@moeda($chequesParaDepositar->sum('valor_parcela'))</th>
    </tfoot>
    @endif
</x-table>
@endsection