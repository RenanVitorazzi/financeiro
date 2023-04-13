@extends('layout')
@section('title')
Entrega de cheques
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('entrega_parcela.index') }}">Entrega de cheques</a></li>
        <li class="breadcrumb-item active" aria-current="page">Receber</li>
    </ol>
</nav>
<div class="d-flex justify-content-between">
    <h3>
        Cheques - 
        {{ $tipo == 'entregue_parceiro' ? $parceiro->pessoa->nome : $representante->pessoa->nome }}
    </h3>
    @if ($tipo == 'entregue_representante')
        <div>
            <x-botao-imprimir 
                href="{{ route('pdf_cheques_entregues', $representante->id) }}"
            ></x-botao-imprimir>
        </div>
    @endif
</div>
<form action="{{ route('entrega_parcela.store') }}" method="POST" id="formCheques">
    @csrf
    <input type="hidden" name='tipo' value={{ $tipo }}>
    <x-table id="tabelaCheques">
        <x-table-header>
            <tr>
                <th><input type="checkbox" id="selecionaTodos"></th>
                <th>Data</th>
                <th>Titular do Cheque</th>
                <th>Valor</th>
                <th>Número</th>
                <th>Status</th>
            </tr>
        </x-table-header>
        <tbody>
            @forelse ($cheques as $cheque)
            <tr>
                <td>
                    <input type="checkbox" name="cheque_id[]" value="{{ $cheque->id }}">
                </td>
                <td>@data($cheque->data_parcela)</td>
                <td>{{ $cheque->nome_cheque }}</td>
                <td>@moeda($cheque->valor_parcela)</td>
                <td>{{ $cheque->numero_cheque }}</td>
                <td>{{ $cheque->status }} {{ $cheque->motivo }}</td>
            </tr>
            @empty
            <tr>
                <td colspan=7>Nenhum registro</td>
            </tr>
            @endforelse
        </tbody>
    </x-table>
    <input class="btn btn-success" type="submit">
    
</form>

@endsection
@section('script')
<script>
   $("#tabelaCheques").DataTable({
        "lengthMenu": [ [-1], ["Todos"] ]
    });

    $("#selecionaTodos").click( (e) => {
        
        let status = $(e.target).prop("checked")

        $("input[name='cheque_id[]']").each( (index, element) => {
           $(element).prop("checked", status)
        });
    })

    $("#formCheques").submit( (event) => {
        event.preventDefault()

        let qtdCheques = $("input[name='cheque_id[]']:checked").length

        if (qtdCheques === 0) {
            Swal.fire({
                title: 'Erro!',
                text: 'Informe no mínimo um cheque',
                icon: 'error'
            })

            return
        }
        console.log($("input[name='cheque_id[]']:checked"));
        $("#formCheques")[0].submit()
    });

    @if(Session::has('message'))
        toastr["success"]("{{ Session::get('message') }}")
    @endif
</script>
@endsection