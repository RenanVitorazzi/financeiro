@extends('layout')

@section('body')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
<title>Home</title>
@if($fixasNaoPagas->count() > 0)
    <div class="alert alert-warning">
        Você tem {{ $fixasNaoPagas->count() }} despesa para pagar nos próximos 7 dias
    </div>
@endif
<div class="table-responsive">
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
            <td>@data($cheque->data_parcela)</td>
            <td>@moeda($cheque->valor_parcela)</td>
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
</div>
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