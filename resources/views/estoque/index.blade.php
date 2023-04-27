@extends('layout')
@section('title')
Estoque
@endsection
@section('body')

<div class='mb-2 d-flex justify-content-between'>
    <h3> Estoque </h3>
    <div>
        <!-- <x-botao-novo href="{{ route('ops.create') }}"></x-botao-novo> -->
        <x-botao-imprimir href="{{ route('pdf_estoque') }}"></x-botao-imprimir>
    </div>
</div>

<h5 class="alert alert-warning">
    Você tem {{ count($lancamentos_pendentes) }} lançamentos pendentes
    <div class="btn btn-warning btn-lancar">Lançar</div>
</h5>

<x-table id="tabelaBalanco">
    <x-table-header>
        <tr>
            <th>Data</th>
            <th>Balanço</th>
            <th>Peso/Fator</th>
            <th>Fornecedor/Representante</th>
            <th>Saldo</th>
            <th>Ações</th>
        </tr>
    </x-table-header>
    <tbody>
        @forelse ($lancamentos as $lancamento)
            <tr>
                <td>@data($lancamento->data)</td>
                    @if ($lancamento->balanco_estoque == 'Débito')
                        <td class='text-danger'>{{ $lancamento->balanco_estoque }}</b></td>
                    @elseif ($lancamento->balanco_estoque == 'Crédito')
                        <td class='text-success'><b>{{ $lancamento->balanco_estoque }}</b></td>
                    @endif
                <td>@peso($lancamento->peso) <br> @fator($lancamento->fator)</td>
                <td>
                    @if ($lancamento->representante_id)
                        {{ $lancamento->balanco_representante }}
                        {{ $lancamento->nome_representante }}
                        {{ $lancamento->observacao_representante }}
                    @elseif ($lancamento->fornecedor_id)
                        {{ $lancamento->balanco_fornecedor }}
                        {{ $lancamento->nome_fornecedor }}
                        {{ $lancamento->observacao_fornecedor }}
                    @endif
                </td>
                <td>@peso($lancamento->saldo_peso) <br> @fator($lancamento->saldo_fator)</td>
                <td>
                    @if($lancamento->representante_id != NULL && $lancamento->representante_atacado != NULL)
                        <x-botao-editar class="mr-2" href="{{ route('estoque.edit', $lancamento->id) }}"></x-botao-editar>
                    @endif
                </td>
            </tr>
        @empty
        <tr>
            <td colspan=6>Nenhum registro</td>
        </tr>
        @endforelse
    </tbody>
</x-table>

@endsection
@section('script')
<script>
    const LANCAMENTOS_PENDENTES = @json($lancamentos_pendentes);

    let tbody = ``;

    $(LANCAMENTOS_PENDENTES).each( (index, element) => {
        let conta_corrente_id = element.id
        let tabela = element.tabela
        let route = "{{ route('lancar_cc_estoque', [':conta_corrente_id',':tabela']) }}"
        route = route.replace(':conta_corrente_id', conta_corrente_id);
        route = route.replace(':tabela', tabela);

        tbody += `
            <tr>
                <td>${element.data_tratada}</td>
                <td>${element.nome}</td>
                <td>${element.peso}</td>
                <td>
                    <a class="btn btn-dark" href="${route}">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
        `;
    })

    $(".modal-body").html(`
        <x-table>
            <x-table-header>
                <tr>
                    <th>Data</th>
                    <th>Nome</th>
                    <th>Lançamento (g)</th>
                    <th></th>
            </x-table-header>
            <tbody>
                ${tbody}
            </tbody>
        </x-table>
    `);

    $(document).ready( function () {
        $('#tabelaBalanco').dataTable( {
            "ordering": false
        } );
    } );

    $('.btn-lancar').click( () => {
        $("#modal2").modal('show')

        $(".modal-header").text(`Lançamentos Pendentes`)
        $(".modal-footer > .btn-primary").remove()
    })
</script>
@endsection
