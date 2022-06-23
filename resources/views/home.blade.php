@extends('layout')

@section('body')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
<title>Home DL</title>
<h1>Bem-vindo(a), <strong>{{ auth()->user()->name }}</strong>!</h1>
<p></p>
<p></p>
<hr>
<p></p>
<p></p>
<x-table>
    <x-tableheader>
        <th colspan=5>
            Cheques para depósito
            <form style="display: inline-block; float:right;" action="{{ route('depositar_diario') }}" method="POST">
                @csrf
                <button class="btn btn-light">Depositar</button>
            </form>
        </th>
    </x-tableheader>

    <x-tableheader>
        <th>#</th>
        <th>Titular</th>
        <th>Data do cheque</th>
        <th>Valor</th>
        <th>Representante</th>
    </x-tableheader>
    <tbody>

    @forelse ($depositos as $cheque)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $cheque->nome_cheque }}</td>
            <td>@moeda($cheque->valor_parcela)</td>
            <td>@data($cheque->data_parcela)</td>
            <td>{{ $cheque->representante->pessoa->nome ?? '-' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan=5>Nenhum cheque para depósito!</td>
        </tr>
    @endforelse
    </tbody>
    @if ($depositos)
    <tfoot class="thead-dark">
        <th >Total</th>
        <th colspan=4>@moeda($depositos->sum('valor_parcela'))</th>
    </tfoot>
    @endif
</x-table>

<x-table id="adiamentos">
    <x-tableheader id="copiarAdiamentos" style="cursor:pointer">
        <th colspan=8>Prorrogações</th>
    </x-tableheader>

    <x-tableheader>
        <th>#</th>
        <th>Titular</th>
        <th>Valor</th>
        <th>Data</th>
        <th>Adiado para</th>
        <th>Número</th>
        <th>Representante</th>
        <th>Parceiro</th>
    </x-tableheader>
    <tbody>
    @forelse ($adiamentos as $cheque)
        <tr>
            <td>{{ $loop->index + 1}}</td>
            <td>{{ $cheque->nome_cheque }}</td>
            <td>@moeda($cheque->valor_parcela)</td>
            <td>@data($cheque->data_parcela)</td>
            <td>@data($cheque->nova_data)</td>
            <td>{{ $cheque->numero_cheque }}</td>
            <td>{{ $cheque->representante }}</td>
            <td>{{ $cheque->parceiro ?? 'Carteira'}}</td>
        </tr>
    @empty
        <tr>
            <td colspan=8>Nenhum cheque adiado!</td>
        </tr>
    @endforelse
    </tbody>
</x-table>


<x-table>
    <x-tableheader>
        <th colspan=7>Ordens de pagamento para a semana</th>
    </x-tableheader>

    <x-tableheader>
        <th>#</th>
        <th>Nome</th>
        <th>Data Vencimento</th>
        <th>Valor</th>
        <th>Representante</th>
        <th>Observação</th>
        <th></th>
    </x-tableheader>
    <tbody>
    @forelse ($ordensPagamentoParaSemana as $op)
        <tr>
            <td>{{ $loop->index + 1}}</td>
            <td>{{ $op->nome_cheque }}</td>
            <td>@data($op->data_parcela)</td>
            <td>@moeda($op->valor_parcela)</td>
            <td>{{ $op->representante->pessoa->nome }}</td>
            <td>{{ $op->observacao }}</td>
            <td>
                <x-botao-editar href="{{ route('cheques.edit', $op->id) }}"></x-botao-editar>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan=7>Nenhuma op atrasada!</td>
        </tr>
    @endforelse
        @if ($ordensPagamentoParaSemana)
        <tfoot class="thead-dark">
            <th>Total</th>
            <th colspan=6>@moeda($ordensPagamentoParaSemana->sum('valor_parcela'))</th>
        </tfoot>
        @endif
    </tbody>
</x-table>

<a class="btn btn-dark" target="_blank" href="{{ route('pdf_diario') }}">Impresso diário</a>
@endsection
@section('script')
<script>
    $("#copiarAdiamentos").click( () => {
        copyToClipboard()

        toastr.success('Adiamentos copiados')
    })
    
    function copyToClipboard() {
        let msg = '<b>PRORROGAÇÕES</b><br><br>';

        $("#adiamentos > tbody > tr").each( (index, element) => {
            
            var nome = $(element).children("td").eq(1).html()
            var valor = $(element).children("td").eq(2).html()
            var data = $(element).children("td").eq(3).html()
            var nova_data = $(element).children("td").eq(4).html()

            msg += `Titular: ${nome} <br>Valor: ${valor} <br>${data} para ${nova_data}<br><br>`
        });

        let aux = document.createElement("div");
        aux.setAttribute("contentEditable", true);
        aux.innerHTML = msg;
        aux.setAttribute("onfocus", "document.execCommand('selectAll', false, null)"); 
        document.body.appendChild(aux);
        aux.focus();
        document.execCommand("copy");
        document.body.removeChild(aux);
    }
</script>
@endsection