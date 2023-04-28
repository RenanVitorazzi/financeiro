@extends('layout')
@section('title')
Lançamentos não efetuados
@endsection
@section('body')
{{-- <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Despesas</li>
    </ol>
</nav> --}}
<div class='mb-2 d-flex justify-content-between'>
    <h3> Lançamentos não efetuados </h3>
    <h5>Conta: {{ $import->conta->nome }}  - @data($import->dataInicio) até @data($import->dataFim)</h5>
    <div>
        {{-- <x-botao-imprimir class="mr-2" href="{{ route('pdf_despesa_mensal', $mes) }}"></x-botao-imprimir> --}}
        {{-- <x-botao-novo href="{{ route('despesas.create') }}"></x-botao-novo> --}}
    </div>
</div>

<x-table class="table-light">
    <x-table-header>

        <tr>
            <th>#</th>
            <th>Data</th>
            <th>Descrição</th>
            <th>Débito</th>
            <th>Crédito</th>
            <th></th>
        </tr>
    </x-table-header>
    <tbody>
        @forelse ($import->arrayDados as $index => $item)

            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item[0] }}</td>
                <td>{{ $item[1] }}</td>
                @if ($item[3] > 0)
                    <td class='text-danger'></td>
                    <td class='text-success'>@moeda($item[3])</td>
                @else
                    <td class='text-danger'>@moeda($item[3])</td>
                    <td class='text-success'></td>
                @endif

                <td>
                    @if ($item[3] > 0)
                        <a class="btn btn-dark mr-2" target="_blank"
                            href="{{route('criarRecebimentoImportacao', [
                                'data' => DateTime::createFromFormat('d/m/Y', $item[0])->format('Y-m-d'),
                                'descricao' => str_replace('/', '-', $item[1]),
                                'valor' => $item[3],
                                'conta' => $import->conta->id
                            ])}}"
                        >
                            <i class="fas fa-check"></i>
                        </a>
                    @else
                        <a class="btn btn-dark mr-2" target="_blank"
                            href="{{route('criarDespesaImportacao', [
                                'data' => DateTime::createFromFormat('d/m/Y', $item[0])->format('Y-m-d'),
                                'descricao' => str_replace('/', '-', $item[1]),
                                'valor' => $item[3],
                                'conta' => $import->conta->id
                            ])}}"
                        >
                            <i class="fas fa-check"></i>
                        </a>
                    @endif
                    <div class="btn btn-danger botaoIgnorar" data-index = {{ $index }}>
                        <i class="fas fa-window-close"></i>
                    </div>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan=5>Nenhum registro</td>
            </tr>
        @endforelse
    </tbody>
</x-table>


@endsection
@section('script')
<script>
    $(".botaoIgnorar").each( (index, element) => {
        $(element).click( (botao) => {
            $(botao.currentTarget).parent().parent().fadeOut( "slow" );
            console.log($(botao.currentTarget).parent().parent())
        })
    })

    $(".botaoCriarRegistro").each( (index, element) => {
        $(element).click( (elementoBotao) => {
            let botao = $(elementoBotao.currentTarget)

            console.log($(botao.currentTarget).parent().parent())
        })
    })
</script>
@endsection
