@extends('layout')
@section('title')
Adicionar cheque
@endsection
@section('body')
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cheques.index') }}">Cheques</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
    </ol>
</nav>

<form method="POST" action="{{ route('cheques.store')}}">
    @csrf

    <div class="row">
        <div class="col-4 form-group">
            <label for="quantidade_cheques">Quantidade de cheques</label>
            <x-input name="quantidade_cheques" type="number" value="{{ old('quantidade_cheques') }}"></x-input>
        </div>
        <div class="col-4 form-group">
            <label for="data_troca">Data da troca</label>
            <x-input name="data_troca" type="date" value="{{ old('data_troca') }}"></x-input>
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
        <div class="col-4 form-group">
            <label for="nova_troca">Criar troca?</label>
            <x-select type="checkbox" name="nova_troca" type="number">
                <option value="Não" {{ old('nova_troca') == 'Não' ? 'selected' : '' }}>Não</option>
                <option value="Sim" {{ old('nova_troca') == 'Sim' ? 'selected' : '' }}>Sim</option>
            </x-select>
        </div>
        <div class="col-4 form-group" id="taxa_group" style="{{ old('nova_troca') == 'Sim' ? 'display:block' : 'display:none' }}">
            <label for="taxa_juros">Taxa de juros (%)</label>
            <x-input name="taxa_juros" type="number" step="0.01" value="{{ old('taxa_juros') }}"></x-input>
        </div>
    </div>
    <div id="campo_tabela">
    @if( old('quantidade_cheques') > 0)
        <x-table class="table-striped" id="tabelaBalanco">
            <x-table-header>
                <tr>
                    <th>Titular</th>
                    <th>Banco</th>
                    <th>Número</th>
                    <th>Valor</th>
                    <th>Data</th>
                </tr>
            </x-table-header>
            <tbody>
                @for ($i = 0; $i < old('quantidade_cheques'); $i++)    
                    <tr>
                        <td>
                            <x-input value="{{ old('nome_cheque.'. $i) }}"  name="nome_cheque[{{ $i }}]" class="input_cheque {{ $errors->has('nome_cheque.'.$i) ? 'is-invalid' : '' }}" ></x-input>
                            @error('nome_cheque.'.$i)
                                <div class="invalid-feedback d-inline">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>
                        <td>
                            <x-input value="{{ old('numero_banco.'. $i) }}" name="numero_banco[{{ $i }}]" class="{{ $errors->has('numero_banco.'.$i) ? 'is-invalid' : '' }}"></x-input>
                            @error('numero_banco.'.$i)
                                <div class="invalid-feedback d-inline">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>
                        <td>
                            <x-input value="{{ old('numero_cheque.'. $i) }}" name="numero_cheque[{{ $i }}]" class="{{ $errors->has('numero_cheque.'.$i) ? 'is-invalid' : '' }}"></x-input>
                            @error('numero_cheque.'.$i)
                                <div class="invalid-feedback d-inline">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>
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
    listenerNomes()
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
                    <input class="form-control input_cheque" name="nome_cheque[${index}]" id="teste_${index}" autocomplete="off">
                </td>
                <td>
                    <input class="form-control" type="number" name="numero_banco[${index}]">
                </td>
                <td>
                    <input class="form-control" name="numero_cheque[${index}]">
                </td>
                <td>
                    <input class="form-control" type="number" name="valor_parcela[${index}]" min="1" step="0.01">
                </td>
                <td>
                    <input class="form-control" type="date" name="data_parcela[${index}]" >
                </td>
                
            </tr>`
        }
                
        $("#campo_tabela").html(`
            <x-table class="table-striped" id="tabelaBalanco">
                <x-table-header>
                    <tr>
                        <th>Titular</th>
                        <th>Banco</th> 
                        <th>Número</th>
                        <th>Valor</th>
                        <th>Data</th>
                    </tr>
                </x-table-header>
                <tbody>
                    ${body}
                </tbody>
            </x-table> 
        `)

        listenerNomes()
    }

    function listenerNomes () {
        $(".input_cheque").focus( (e) => {
            let arrayNome = criarArrayNome() 
            
            $(e.target).autocomplete({
                minLength: 2,
                source: arrayNome,
                autoFocus: true,
            });
        })
    }

    function criarArrayNome () {
        let arrayNome = []
        
        $(".input_cheque").each( (index, element) => {
            if ($(element).val() && !arrayNome.includes($(element).val())) {
                arrayNome.push($(element).val())
            }
        })
        
        return arrayNome
    }

    function trocaListener() {
        $("#nova_troca").change( () => {
            $("#taxa_group").toggle() 
        })
    }
    
    trocaListener()
</script>
@endsection