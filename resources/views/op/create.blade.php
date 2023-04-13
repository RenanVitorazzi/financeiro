@extends('layout')
@section('title')
Adicionar OP
@endsection
@section('body')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ops.index') }}">Ordens de pagamento</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
    </ol>
</nav>

<form method="POST" action="{{ route('ops.store')}}">
    @csrf

    <div class="row">
        <div class="col-4 form-group">
            <label for="quantidade_cheques">Quantidade de parcelas</label>
            <x-input name="quantidade_cheques" type="number" value="{{ old('quantidade_cheques') }}"></x-input>
        </div>
        <div class="col-4 form-group">
            <label for="nome_cheque">Titular</label>
            <x-input name="nome_cheque" type="text" value="{{ old('nome_cheque') }}" class="{{ $errors->has('valor_parcela') ? 'is-invalid' : '' }}"></x-input>
            @error('nome_cheque')
                <div class="invalid-feedback d-inline">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-4 form-group">
            <label for="representante_id">Representante</label>
            <x-select name="representante_id">
                <option></option>
                @foreach ($representantes as $representante)
                    <option value="{{ $representante->id }}" {{ old('representante_id') == $representante->id ? 'selected' : '' }}>{{ $representante->pessoa->nome }}</option>
                @endforeach
            </x-select>
        </div>
        
    </div>
    <div id="campo_tabela">
    @if( old('quantidade_cheques') > 0)
        <x-table class="table-striped" id="tabelaBalanco">
            <x-table-header>
                <tr>
                    <th>Valor</th>
                    <th>Vencimento</th>
                    <th>Observação</th>
                </tr>
            </x-table-header>
            <tbody>
                @for ($i = 0; $i < old('quantidade_cheques'); $i++)    
                    <tr>
                        <td>
                            <x-input value="{{ old('valor_parcela.'. $i) }}" type="number" name="valor_parcela[{{ $i }}]" class="{{ $errors->has('valor_parcela.'.$i) ? 'is-invalid' : '' }}" min="1" step="0.01"></x-input>
                            @error('valor_parcela.'.$i)
                                <div class="invalid-feedback d-inline">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>
                        <td>
                            <x-input value="{{ old('data_parcela.'. $i) }}" type="date" name="data_parcela[{{ $i }}]" class="{{ $errors->has('data_parcela.'.$i) ? 'is-invalid' : '' }}"></x-input>
                            @error('data_parcela.'.$i)
                                <div class="invalid-feedback d-inline">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>
                        <td>
                            <x-input value="{{ old('observacao.'. $i) }}" type="date" name="observacao[{{ $i }}]" class="{{ $errors->has('observacao.'.$i) ? 'is-invalid' : '' }}"></x-input>
                            @error('observacao.'.$i)
                                <div class="invalid-feedback d-inline">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>
                    </tr>
                @endfor
            </tbody>
        </x-table>
    @endif
    </div>
    <input type="submit" class='btn btn-success'>
</form>
@endsection
@section('script')

<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.min.js"></script>
<script>
    
    const QTD_CHEQUES = $("#quantidade_cheques") 
    listenerQuantidade()
    
    function listenerQuantidade () {
        QTD_CHEQUES.change( () => {
            criarTabela()
        })
    }

    function criarTabela() {
        let body = ""
        for (let index = 0; index < QTD_CHEQUES.val(); index++) {
            body +=    
            `<tr>
                <td>
                    <input class="form-control" type="number" name="valor_parcela[${index}]" min="1" step="0.01">
                </td>
                <td>
                    <input class="form-control" type="date" name="data_parcela[${index}]" >
                </td>
                <td>
                    <input class="form-control" name="observacao[${index}]">
                </td>
            </tr>`
        }
                
        $("#campo_tabela").html(`
            <x-table class="table-striped" id="tabelaBalanco">
                <x-table-header>
                    <tr>
                        <th>Valor</th>
                        <th>Vencimento</th>
                        <th>Observação</th>
                    </tr>
                </x-table-header>
                <tbody>
                    ${body}
                </tbody>
            </x-table> 
        `)

    }

</script>
@endsection 