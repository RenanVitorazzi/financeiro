@extends('layout')
@section('title')
Nova troca de cheques
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('troca_cheques.index') }}">Troca de cheques</a></li>
        <li class="breadcrumb-item active" aria-current="page">Nova troca</li>
    </ol>
</nav>
    <div class="d-flex justify-content-between">
        <h3>Trocar cheques</h3>
    </div>
    <form action="{{ route('troca_cheques.store') }}" method="POST" id="formTrocaCheques">
        
        @csrf

        <div class="row">
            <div class="form-group col-6">
                <label for="titulo">Título</label>
                <x-input name="titulo" value="{{ old('titulo') ?: 'Troca '.date('d/m/Y') }}"></x-input>
            </div>
            <div class="col-6">
                <x-form-group type='date' name="data_troca" value="{{ date('Y-m-d')}}">Data da troca</x-form-group>
            </div>
        </div>            

        <x-table id="tabelaCheques" class="table-striped">
            <x-table-header>
                <tr>
                    <th><input type="checkbox" id="selecionaTodos"></th>
                    <th>Titular</th>
                    <th>Representante</th>
                    <th>Número</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Observação</th>
                </tr>
            </x-table-header>
            <tbody>
                @forelse ($cheques as $cheque)
                    <tr>
                        <td>
                            <input type="checkbox" name="cheque_id[]" value="{{ $cheque->id }}">
                        </td>
                        <td>{{ $cheque->nome_cheque }}</td>
                        <td>{{ $cheque->nome }}</td>
                        <td>{{ $cheque->numero_cheque }}</td>
                        <td>@data($cheque->data_parcela)</td>
                        <td>@moeda($cheque->valor_parcela)</td>
                        <td>{{ $cheque->observacao }}</td>
                    </tr>
                @empty
                <tr>
                    <td colspan=5>Nenhum cheque</td>
                </tr>
                @endforelse
            </tbody>
        </x-table>
        <div class="row">
            
            <div class="col-6">
                <label for="parceiro_id">Parceiro</label>
                <x-select name="parceiro_id">
                    <option value=""></option>
                    @foreach ($parceiros as $parceiro)
                        <option data-porcentagem="{{ $parceiro->porcentagem_padrao }}" value="{{ $parceiro->id }} "> {{ $parceiro->pessoa->nome }} ({{ $parceiro->porcentagem_padrao }}%)</option>
                    @endforeach
                </x-select>
            </div>
            
            <div class="form-group col-6">
                <label for="taxa_juros">Taxa (%)</label>
                <x-input name="taxa_juros" type="number" value="{{ old('taxa_juros') }}" max="100" step="0.01"></x-input>
            </div>

            <div class="form-group col-12">
                <label for="observacao">Observação</label>
                <x-text-area name="observacao">{{ old('observacao') }}</x-text-area>
            </div>
            
        </div>
        @error('cheque_id')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <input class="btn btn-success" id="trocarCheques" type="submit">
        
    </form>
@endsection
@section('script')
<script>
    $("#tabelaCheques").DataTable({
        "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"] ]
    });

    $("#selecionaTodos").click( (e) => {
        let status = $(e.target).prop("checked");
        $("input[name='cheque_id[]']").each( (index, element) => {
           $(element).prop("checked", status);
        });
    })

    $("#formTrocaCheques").submit( (event) => {
        event.preventDefault()

        let data = $("#data_troca").val()
        let qtdCheques = $("input[name='cheque_id[]']:checked").length

        if (!data || qtdCheques === 0) {
            Swal.fire({
                title: 'Erro!',
                text: 'Informe no mínimo a data e um cheque',
                icon: 'error'
            })

            return
        }
        console.log($("input[name='cheque_id[]']:checked"));
        $("#formTrocaCheques")[0].submit()
    });

    $("#parceiro_id").change( (e) => {
        let porcentagem_troca = $(e.target).find('option:selected').data("porcentagem") 
        console.log(porcentagem_troca);
        $("#taxa_juros").val(porcentagem_troca)
    })

</script>
@endsection