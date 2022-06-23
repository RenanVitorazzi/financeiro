@extends('layout')
@section('title')
Cadastro de despesa
@endsection
@section('body')
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('despesas.index') }}">Despesas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
    </ol>
</nav>

<div class="btn btn-dark" id="procurarFixa">
    Procurar despesa fixa <i class="ml-2 fas fa-search"></i>
</div>
<br>
<br>
<form method="POST" action="{{ route('despesas.store')}}">
    @csrf
    <div class="row">
        <div class="col-6 form-group">
            <label for="nome">Nome da despesa</label>
            <x-input name="nome" type="text" value="{{ old('nome') }}"></x-input>
        </div>
        <div class="col-6 form-group">
            <label for="data_vencimento">Data do vencimento</label>
            <x-input name="data_vencimento" type="date" value="{{ old('data_vencimento') }}"></x-input>
        </div>
        <div class="col-6 form-group">
            <label for="valor">Valor</label>
            <x-input name="valor" type="text" value="{{ old('valor') }}"></x-input>
        </div>

        <div class="col-6 form-group">
            <label for="data_referencia">Mês de referência</label>
            <x-input name="data_referencia" type="date" value="{{ old('data_referencia') }}"></x-input>
        </div>

        <div class="col-6 form-group">
            <label for="local_id">Local</label>
            <x-select name="local_id">
                <option></option>
                @foreach ($locais as $local)
                    <option value="{{ $local->id }}" {{ old('local_id') == $local->id ? 'selected' : '' }}>{{ $local->nome }}</option>
                @endforeach
            </x-select>
        </div>
        <div class="col-6 form-group">
            <x-input name="fixas_id" type="hidden" value="{{ old('fixas_id') }}"></x-input>
        </div>
        
        <div class="col-12 form-group">
            <label for="observacao">Observação</label>
            <x-text-area name="observacao" type="text" value="{{ old('observacao') }}"></x-text-area>
        </div>

    </div>
    {{-- <p>@json($fixas)</p> --}}
    <input type="submit" class='btn btn-success'>
</form>
@endsection
@section('script')
<script>
    FIXAS = JSON.parse(@json($fixas));
    
    $("#procurarFixa").click( (e) => {
        $("#modal-title2").text('Despesas Fixas')
        $("#modal2").modal("show")
        let html = ``
        html += `
            <x-table>
                <x-table-header>
                    <th>Nome</th>  
                    <th>Valor</th>  
                    <th>Dia de vencimento</th>  
                    <th>Local</th>  
                    <th></th>  
                </x-table-header>
                <tbody>  
        `
            FIXAS.forEach(element => {
                console.log(element)
                html += `
                    <tr>
                        <td>${element.nome}</td>
                        <td>${element.valor}</td>
                        <td>${element.dia_vencimento}</td>
                        <td>${element.local.nome}</td>
                        <td>
                            <div class="btn btn-secondary puxarInfos" 
                                data-nome="${element.nome}"
                                data-valor="${element.valor}"
                                data-dia_vencimento="${element.dia_vencimento}"
                                data-local_id="${element.local_id}"
                                data-id="${element.id}"
                            >
                                <i class="fas fa-check"></i>       
                            </div>
                        </td>
                `
            });
        
        html += `  
                </tbody>
            </x-table>
        `
        $("#modal-body2").html(html)

        $(".puxarInfos").click( (e) => {
            let target = $(e.currentTarget)

            $("#nome").val(target.data('nome'))
            $("#valor").val(target.data('valor'))
            $("#local_id").val(target.data('local_id'))

            let dataJs = new Date()
            let dia = dataJs.getUTCDate()  
            let mes = ('0' + (dataJs.getMonth() + 1)).slice(-2);
            let mesPassado = ('0' + (dataJs.getMonth() )).slice(-2);
            let ano = dataJs.getUTCFullYear() 
            
            $("#data_vencimento").val(ano +'-'+ mes +'-'+ ('0' + target.data('dia_vencimento')).slice(-2))
            
            $("#data_referencia").val(ano +'-'+ mesPassado +'-'+ ('0' + target.data('dia_vencimento')).slice(-2))
            
            $("#fixas_id").val(target.data('id'))

            $("#modal2").modal("hide")
        })
    })

    
</script>
@endsection