@extends('layout')
@section('title')
Editar vendas
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        @if (!auth()->user()->is_representante)
        <li class="breadcrumb-item"><a href="{{ route('representantes.index') }}">Representantes</a></li>
        @endif
        <li class="breadcrumb-item"><a href="{{ route('venda.show', $venda->representante_id) }}">Vendas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>
    <form method="POST" action="{{ route('venda.update', $venda->id)}}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <x-form-group name="data_venda" type="date" autofocus value="{{ $venda->data_venda }}" >Data</x-form-group>
            </div>
            <div class="col-md-6 form-group">
                <label for="cliente_id">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="form-control">
                    <option></option>
                    @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $venda->cliente_id == $cliente->id ? 'selected': '' }} >
                        {{ $cliente->pessoa->nome }}
                    </option>
                    @endforeach
                </select>
            </div>
            {{-- <div class="col-md-6 form-group">
                <label for="balanco">Tipo</label>
                <x-select name="balanco" required>
                    <option></option>
                    <option value='Acerto' {{ $venda->balanco == 'Acerto' ? 'selected': '' }}> Acerto </option>
                    <option value='Venda' {{ $venda->balanco == 'Venda' ? 'selected': '' }}> Venda </option>
                    <option value='Devolução' {{ $venda->balanco == 'Devolução' ? 'selected': '' }}> Devolução </option>
                    <option value='Aberto' {{ $venda->balanco == 'Aberto' ? 'selected': '' }}> Aberto </option>
                </x-select>
            </div> --}}
            
            <div class="col-md-6 form-group">
                <label for="representante_id">Representante</label>
                <select name="representante_id" id="representante_id" class="form-control" required>
                    <option></option>
                    @foreach ($representantes as $representante)
                        <option value="{{ $representante->id }}"
                            {{ $venda->representante_id == $representante->id ? 'selected': '' }} >
                            {{ $representante->pessoa->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <x-table class="table-striped table-bordered table-dark">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Peso</td>
                        <td><x-input type="number" name="peso" step="0.001" value="{{ $venda->peso}}"></x-input></td>
                        <td><x-input type="number" name="cotacao_peso" step="0.01" value="{{ $venda->cotacao_peso}}"></x-input></td>
                    </tr>
                    <tr>
                        <td>Fator</td>
                        <td><x-input type="number" name="fator" step="0.01" value="{{ $venda->fator}}"></x-input></td>
                        <td><x-input type="number" name="cotacao_fator" step="0.01" value="{{ $venda->cotacao_fator}}"></x-input></td>
                    </tr>
                    <tr>
                        <td colspan='2'>Total</td>
                        <td><x-input name="valor_total" type="number" step="0.01" value="{{ $venda->valor_total }}" ></x-input></td>
                    </tr>
                </tbody>
            </x-table>

            <div class="col-sm-6 col-md-4 col-lg-3 form-group">
                <label for="metodo_pagamento">Método de Pagamento</label>
                <x-select name="metodo_pagamento" required>
                    <option value=""></option>
                    @foreach ($metodo_pagamento as $metodo)
                        <option  {{ $venda->metodo_pagamento == $metodo ? 'selected' : '' }} value="{{ $metodo }}">{{ $metodo }}</option>
                    @endforeach
                </x-select> 
            </div>
        </div> 
        <div id="campoQtdParcelas" class="row">
            @if ($venda->metodo_pagamento === 'Cheque')
            <div class='form-group col-md-6'>
                <label for="parcelas">Informe o período de prazo</label>
                <input class="form-control" id="prazo" type="number" value="30">
            </div>
            <div class='form-group col-md-6'>
                <label for="parcelas">Informe a quantidade de parcelas</label>
                <input class="form-control" name="parcelas" id="parcelas" type="number" value="{{ $venda->parcelas }}">
            </div>
            @endif
        </div>
        <div id="infoCheques" class="row">
            @foreach ($venda->parcela as $parcela)            
            <div class="col-md-2 form-group">
                Cheque {{$loop->index+1}}
            </div>
            <div class="col-md-5 form-group">
                <input type="date" name="data_parcela[]" class="form-control" value="{{$parcela->data_parcela}}">
            </div>
            <div class="col-md-5 form-group">
                
                <input type="number" name="valor_parcela[]" class="form-control" value="{{$parcela->valor_parcela}}">
            </div>
            @endforeach
        </div>
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
@section('script')
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
                <input class="form-control" id="parcelas" type="number">
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
@endsection