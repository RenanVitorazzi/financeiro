@extends('layout')
@section('title')
Adicionar conta corrente (representante)
@endsection

@section('body')
    <form method="POST" action="{{ route('venda.store')}}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <x-form-group name="data_venda" type="date" autofocus value="{{ date('Y-m-d') }}" >Data</x-form-group>
            </div>
            <div class="col-md-6 form-group">
                <label for="cliente_id">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="form-control">
                    <option></option>
                    @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old("cliente_id") == $cliente->id ? 'selected': '' }} >
                        {{ $cliente->pessoa->nome }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="balanco">Tipo</label>
                <select name="balanco" id="balanco" class="form-control" required>
                    {{-- <option></option> --}}
                    {{-- <option value='Acerto' {{ old('balanco') == 'Acerto' ? 'selected': '' }}> Acerto </option> --}}
                    <option value='Venda' {{ old('balanco') == 'Venda' ? 'selected': '' }}> Venda </option>
                    <option value='Devolução' {{ old('balanco') == 'Devolução' ? 'selected': '' }}> Devolução </option>
                    <option value='Aberto' {{ old('balanco') == 'Aberto' ? 'selected': '' }}> Aberto </option>
                </select>
            </div>
            
            <div class="col-md-6 form-group">
                <label for="representante_id">Representante</label>
                <select name="representante_id" id="representante_id" class="form-control" required>
                    <option></option>
                    @foreach ($representantes as $representante)
                        <option value="{{ $representante->id }}"
                            {{ $idRepresentante == $representante->id ? 'selected': '' }} >
                            {{ $representante->pessoa->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <x-form-group name="fator" type="number" value="{{ old('fator') }}">Fator</x-form-group>
            </div>
            <div class="col-md-6">
                <x-form-group name="cotacao_fator" type="number" value="{{ old('cotacao_fator') }}">Cotação Fator</x-form-group>
            </div>
            
            <div class="col-md-6">
                <x-form-group name="peso" type="number" value="{{ old('peso') }}">Peso</x-form-group>
            </div>
            <div class="col-md-6">
                <x-form-group name="cotacao_peso" type="number" value="{{ old('cotacao_peso') }}">Cotação Peso</x-form-group>
            </div>
            
            <div class="col-md-6">
                <x-form-group name="valor_total" type="number" value="{{ old('valor_total') }}">Valor Total da Compra</x-form-group>
            </div>
            <div class="col-md-6 form-group">
                <label for="metodo_pagamento">Método de Pagamento</label>
                <select class="form-control" name="metodo_pagamento" id="metodo_pagamento">
                    <option value=""></option>
                    <option  {{ old('balanco') == 'Dinheiro' ? 'selected': '' }} value="Dinheiro">Dinheiro</option>
                    <option  {{ old('balanco') == 'Cheque' ? 'selected': '' }} value="Cheque">Cheque</option>
                    <option  {{ old('balanco') == 'Nota Promissória' ? 'selected': '' }} value="Nota Promissória">Nota Promissória</option>
                </select>
            </div>
        </div> 
     
        <div id="campoQtdParcelas" class="row">
            @if (old('metodo_pagamento') == 'Cheque')
            <div class='form-group col-md-6'>
                <label for="parcelas">Informe o período de prazo</label>
                <input class="form-control" id="prazo" type="number" value="{{ old('prazo') }}">
            </div>
            <div class='form-group col-md-6'>
                <label for="parcelas">Informe a quantidade de parcelas</label>
                <input class="form-control" id="parcelas" name="parcelas" type="number" value="{{ old('parcelas') }}">
            </div>
            @endif
        </div>
        <div id="infoCheques" class="row"></div>
        {{-- 
        <div class="form-group">
            <label for="observacao">Observação</label>
            <textarea name="observacao" id="observacao" class="form-control">{{ old('observacao') }}</textarea>
        </div> 
        --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class='mt-2'>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <input type="submit" class='btn btn-success'>
    </form>
@endsection
@push('script')
<script>
    $("#metodo_pagamento").change( (e) => {
        let metodo = $(e.target).val()

        if (metodo !== 'Cheque') {
            $("#campoQtdParcelas").html("");
            $("#infoCheques").html("");
            return false;
        }
        if (!$("#valor_total").val()) {
            return false;
        }

        $("#campoQtdParcelas").html(`
            <div class='form-group col-md-6'>
                <label for="parcelas">Informe o período de prazo</label>
                <input class="form-control" id="prazo" type="number" value=30>
            </div>
            <div class='form-group col-md-6'>
                <label for="parcelas">Informe a quantidade de parcelas</label>
                <input class="form-control" id="parcelas" name="parcelas" type="number">
            </div>
        `)

        $("#parcelas").change ( (e) => {
            let parcelas = $(e.target).val()
            let prazo = $("#prazo").val()
            let dataVenda = $("#data_venda").val()
            let valorTotal = $("#valor_total").val()
            let proximaData;
            let campoValor;
            let html = "";

            if (valorTotal) {
                campoValor = valorTotal / parcelas
                campoValorTratado = campoValor.toFixed(2)
            }

            if (parcelas < 0 && parcelas > 9) {
                $("#cheques").html(`
                    <div class='alert alert-danger'>Número de parcelas não aceito ${parcelas}!</div>
                `);
                return false;
            } else if (!dataVenda) {
                $("#cheques").html(`
                    <div class='alert alert-danger'>Informe a data da venda!</div>
                `);
                return false;
            }
            
            for (let index = 0; index < parcelas; index++) {
                if (dataVenda && prazo) {
                    if (!proximaData) {
                        proximaData = addDays(dataVenda, prazo);
                    } else {
                        proximaData = addDays(proximaData, prazo);
                    }
                }
                
                html += `
                    <div class="col-md-2 form-group">
                        Cheque ${index+1}
                    </div>
                    <div class="col-md-5 form-group">
                        <input type="date" name="data_parcela[]" class="form-control" value="${proximaData}">
                    </div>
                    <div class="col-md-5 form-group">
                        
                        <input type="number" name="valor_parcela[]" class="form-control" value="${campoValorTratado}">
                    </div>
                `;

            }
            $("#infoCheques").html(html);
        })
    })

    $("#cotacao_fator, #fator, #cotacao_peso, #peso").change( (e) => {
        let cotacao_fator = $("#cotacao_fator").val()
        let cotacao_peso = $("#cotacao_peso").val()
        let fator = $("#fator").val()
        let peso = $("#peso").val()

        calcularTotalVenda(cotacao_fator, cotacao_peso, fator, peso)

    })

    function addDays(date, days) {
        let arrDate = date.split("-")
        let daysFiltered = parseInt(days)

        var result = new Date(arrDate[0], arrDate[1]-1, arrDate[2])
        result.setDate(result.getDate() + daysFiltered);
    
        return result.getFullYear() + '-' 
        + (adicionaZero(result.getMonth()+1).toString()) + "-"
        + adicionaZero(result.getDate().toString());
    }

    function adicionaZero(numero){
        if (numero <= 9) 
            return "0" + numero;
        else
            return numero; 
    }

    function calcularTotalVenda (cotacao_fator, cotacao_peso, fator, peso) {
        if (!cotacao_fator || !fator || !peso || !cotacao_peso) {
            return false;
        }

        let totalFator = cotacao_fator * fator;
        let totalPeso = cotacao_peso * peso;
        let totalCompra = totalFator + totalPeso;
        // parseFloat(totalCompra);

        $("#valor_total").val(totalCompra)
    }
</script>
@endpush