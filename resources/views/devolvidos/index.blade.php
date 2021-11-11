@extends('layout')
@section('title')
Devolvidos
@endsection
@section('body')
<div class='mb-2 d-flex justify-content-between'>
    <h3> Devolvidos </h3>
</div>
       
<x-table id="devolvidos">
    <x-table-header>
        <tr>
            {{-- <th>Cliente</th> --}}
            <th>Titular</th>
            @if (!auth()->user()->is_representante)
            <th>Representante</th>
            @endif
            <th>Data</th>
            <th>Valor</th>
            <th>Número</th>
            <th>Motivo</th>
            <th>Observação</th>
            <th>Ações</th>
        </tr>
    </x-table-header>
    <tbody>
        @forelse ($cheques as $parcela)
            <tr>
                {{-- <td>{{ $parcela->venda_id ? $parcela->cliente : 'Não informado' }}</td> --}}
                <td>{{ $parcela->nome_parcela }}</td>
                @if (!auth()->user()->is_representante)
                    @if ($parcela->representante_id)
                    <td>{{ $parcela->representante->pessoa->nome }}</td>
                    @else
                    <td></td>
                    @endif
                @endif
                <td>@data($parcela->data_parcela)</td>
                <td>@moeda($parcela->valor_parcela)</td>
                <td>{{ $parcela->numero_cheque }}</td>
                <td>{{ $parcela->motivo }}</td>
                <td>{{ $parcela->observacao }}</td>
                <td>
                    <form action="{{ route('pagarChequeDevolvido', $parcela->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-success btn-pago">Pago</button> 
                    </form>
                </td>
            </tr>
        @empty
        <tr>
            <td colspan=7>Nenhum registro</td>
        </tr>
        @endforelse
    </tbody>
</x-table>

@endsection
@section('script')
<script>
    const MODAL = $("#modal")
    const MODAL_BODY = $("#modal-body")
    const MODAL_HEADER = $("#modal-header")
 
 $("#devolvidos").dataTable();

    $(".btn-pago").each( (index, element) => {
        $(element).click( () => {
            element.preventDefault()

            informarPagamento(element)
        })
    });

    function informarPagamento (e) {

        let parcela_id = $(e).data("id")

        Swal.fire({
            icon: 'question',
            text: 'Tem certeza que deseja dar baixa no pagamento?',
            showConfirmButton: true,
            confirmButtonText: 'Sim',
            showCancelButton: true,
            cancelButtonText: 'Não',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Sucesso!',
                    'Baixa realizada.',
                    'success'
                )
            }
        })
    }
</script>
@endsection