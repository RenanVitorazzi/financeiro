@extends('layout')
@section('title')
Adicionar vendas
@endsection
@section('body')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        @if (!auth()->user()->is_representante)
        <li class="breadcrumb-item"><a href="{{ route('representantes.index') }}">Representantes</a></li>
        @endif
        <li class="breadcrumb-item"><a href="{{ route('venda.show', $representante_id) }}">Vendas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Novo</li>
    </ol>
</nav>
<form method="POST" action="{{ route('venda.store')}}">
    @csrf
    <div class="row">
        <div class="col-6">
            <x-form-group name="data_venda" type="date" autofocus value="{{ date('Y-m-d') }}" required>Data</x-form-group>
        </div> 
        <div class="col-6 form-group">
            <label for="cliente_id">Cliente</label>
            <div class="d-flex">
                <x-select name="cliente_id" required>
                    <option></option>
                    @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old("cliente_id") == $cliente->id ? 'selected': '' }} >
                        {{ $cliente->pessoa->nome }}
                    </option>
                    @endforeach
                </x-select>
                <div class="btn btn-dark procurarCliente">
                    <span class="fas fa-search"></span>
                </div>
            </div>
        </div>
        
        <input type="hidden" name="balanco" value="Venda">
        <input type="hidden" name="representante_id" id="representante_id" value="{{ $representante_id }}">
        
        <x-table class="table-striped table-bordered table-dark">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                    {{-- <th>Total</th> --}}
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Peso</td>
                    <td><x-input type="number" name="peso" step="0.001" value="{{ old('peso') }}"></x-input></td>
                    <td><x-input type="number" name="cotacao_peso" step="0.01" value="{{ old('cotacao_peso') }}"></x-input></td>
                </tr>
                <tr>
                    <td>Fator</td>
                    <td><x-input type="number" name="fator" step="0.01" value="{{ old('fator') }}"></x-input></td>
                    <td><x-input type="number" name="cotacao_fator" step="0.01" value="{{ old('cotacao_fator') }}"></x-input></td>
                </tr>
                <tr>
                    <td colspan='2'>Total</td>
                    {{-- <td></td> --}}
                    <td><x-input name="valor_total" type="number" step="0.01" value="{{ old('valor_total') }}" ></x-input></td>
                    {{-- <td><x-input type="number" name="cotacao_fator" required></x-input></td> --}}
                </tr>
            </tbody>
        </x-table>

        <div class="col-4 form-group">
            <label for="metodo_pagamento">Método de Pagamento</label>
            <x-select name="metodo_pagamento" required>
                <option value=""></option>
                @foreach ($metodo_pagamento as $metodo)
                    <option  {{ old('metodo_pagamento') == $metodo ? 'selected' : '' }} value="{{ $metodo }}">{{ $metodo }}</option>
                @endforeach
            </x-select> 
        </div>
        <div class="col-4 form-group d-none" id="groupDiaVencimento">
            <label for="dia_vencimento">Dia de vencimento</label>
            <x-input name="dia_vencimento" type="number"></x-input>
        </div>
        <div class="col-4 form-group d-none" id="groupParcelas">
            <label for="parcelas">Quantidade de parcelas</label>
            <x-input name="parcelas" type="number"></x-input>
        </div>
    </div> 
    
    {{-- <div id="campoQtdParcelas" class="row">
        @if (old('metodo_pagamento') == 'Parcelado')
        <div class="col-sm-6 col-md-4 col-lg-3">
            <x-form-group name="prazo" type="number" value="{{ old('prazo') }}">Prazo</x-form-group>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <x-form-group name="parcelas" type="number" value="{{ old('parcelas') }}">Parcelas</x-form-group>
        </div>
        @elseif (old('metodo_pagamento') == 'À vista')
        <div class="col-md-4 col-sm-6 col-lg-3">
            <div class="card mb-4 card-hover">
                <div class="card-body">
                    <h5 class="card-title mb-4"> 
                        <div class="d-flex justify-content-between">
                            Pagamento
                        </div>
                    </h5>
                    <div class='form-group'>
                        <label for="forma_pagamento[0]">Informe a forma de pagamento</label>
                        <x-select name="forma_pagamento[0]">
                            @foreach ($forma_pagamento as $pagamento)
                            <option value="{{ $pagamento }}" {{ old("forma_pagamento.0") == $pagamento ? 'selected': '' }} >
                                {{ $pagamento }}
                            </option>
                            @endforeach
                        </x-select>
                    </div>
                   
                    <div class="form-group {{ old('forma_pagamento.0') == 'Cheque' ? '' : 'd-none' }}" id="groupNome_0">
                        <label for="nome_cheque[0]">Nome</label>
                        @if ($errors->has('nome_cheque.0'))
                            <x-input name="nome_cheque[0]" value="{{ old('nome_cheque.0') }}" class="is-invalid"></x-input>
                            <div class="invalid-feedback d-inline">{{ $errors->first('nome_cheque.0') }}</div>
                        @else
                            <x-input name="nome_cheque[0]" value="{{ old('nome_cheque.0') }}"></x-input>
                        @endif
                    </div>

                    <div class="form-group {{ old('forma_pagamento.0') == 'Cheque' ? '' : 'd-none' }}" id="groupNumero_0">
                        <label for="numero_cheque[0]">Número do Cheque</label>
                        <x-input name="numero_cheque[0]" value="{{ old('numero_cheque.0') }}"></x-input>
                    </div>

                    <div class="form-group">
                        <label for="data_parcela[0]">Data</label>
                        @if ($errors->has('data_parcela.0'))
                            <x-input name="data_parcela[0]" type="date" value="{{ old('data_parcela.0') }}" class="is-invalid"></x-input>
                            <div class="invalid-feedback d-inline">{{ $errors->first('data_parcela.0') }}</div>
                        @else
                            <x-input name="data_parcela[0]" type="date" value="{{ old('data_parcela.0') }}"></x-input>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="valor_parcela[]">Valor</label>
                        @if ($errors->has('valor_parcela.0'))
                            <x-input name="valor_parcela[]" type="number" step="0.01" value="{{ old('valor_parcela.0') }}" class="is-invalid"></x-input>
                            <div class="invalid-feedback d-inline">{{ $errors->first('valor_parcela.0') }}</div>
                        @else
                            <x-input name="valor_parcela[]" type="number" step="0.01" value="{{ old('valor_parcela.0') }}"></x-input>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="observacao[]">Observação</label>
                        <x-text-area name="observacao[]" id="observacao[]"></x-text-area>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div> --}}
    <div id="infoCheques" class="row">
        @if (old('metodo_pagamento') == 'Parcelado')
            @foreach (old('parcelas') as $item)
            <div class="col-md-4 col-sm-6 col-lg-3">
                <div class="card mb-4 card-hover">
                    <div class="card-body">
                        <h5 class="card-title mb-4"> 
                            <div class="d-flex justify-content-between">
                                <div>${index + 1}ª Parcela</div>
                                ${btnCopiarDados}
                            </div>
                        </h5>
                        <div class='form-group'>
                            <label for="forma_pagamento[${index}]">Informe a forma de pagamento</label>
                            <select class="form-control" name="forma_pagamento[${index}]" id="forma_pagamento[${index}]" data-index="${index}">
                                ${option}
                            </select>
                        </div>
                        <div class="form-group d-none" id="groupNome_${index}">
                            <label for="nome_cheque[${index}]">Nome</label>
                            <div class="d-flex">
                                <input type="text" name="nome_cheque[${index}]" id="nome_cheque[${index}]" class="form-control primeiroInputNome">
                                
                            </div>
                        </div>
                        <div class="form-group d-none" id="groupNumero_${index}">
                            <label for="numero_cheque[${index}]">Número do Cheque</label>
                            <div class="d-flex">
                                <input type="text" name="numero_cheque[${index}]" id="numero_cheque[${index}]" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="data_parcela[${index}]">Data da Parcela</label>
                            <input type="date" name="data_parcela[${index}]" id="data_parcela[${index}]" class="form-control" value="${proximaData}">
                        </div>
                        <div class="form-group">
                            <label for="valor_parcela[${index}]">Valor</label>
                            <input type="number" name="valor_parcela[${index}]" id="valor_parcela[${index}]" class="form-control primeiroInputValor" value="${campoValorTratado}">
                        </div>
                        <div class="form-group">
                            <label for="observacao[${index}]">Observação</label>
                            <textarea name="observacao[${index}]" id="observacao[${index}]" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    <input type="submit" class='btn btn-success'>
</form>
@endsection
@section('script')
<script>
    // const CAMPO_PARCELAS = $("#campoQtdParcelas")
    const FORMA_PAGAMENTO = ['Dinheiro', 'Cheque', 'Transferência Bancária', 'Depósito']
    let option = `<option></option>`

    FORMA_PAGAMENTO.forEach(element => {
        option += `<option value="${element}">${element}</option>`;
    })

    function tipoPagamento(forma_pagamento) {
        let htmlPagamento = "";
        
        if (forma_pagamento == 'À vista') {
            $("#groupDiaVencimento").addClass('d-none')
            $("#groupParcelas").addClass('d-none')

            let valor = $("#valor_total").val()

            htmlPagamento = `
                <div class="col-md-4 col-sm-6 col-lg-3">
                    <div class="card mb-4 card-hover">
                        <div class="card-body">
                            <h5 class="card-title mb-4"> 
                                <div class="d-flex justify-content-between">
                                    <div>Pagamento</div>
                                </div>
                            </h5>
                            <div class='form-group'>
                                <label for="forma_pagamento[0]">Informe a forma de pagamento</label>
                                <select class="form-control" name="forma_pagamento[0]" id="forma_pagamento[0]" data-index="0">
                                    ${option}
                                </select>
                            </div>
                            <div class="form-group d-none" id="groupNome_0">
                                <label for="nome_cheque[0]">Nome</label>
                                <div class="d-flex">
                                    <input type="text" name="nome_cheque[0]" id="nome_cheque[0]" class="form-control">
                                </div>
                            </div>
                            <div class="form-group d-none" id="groupNumero_0">
                                <label for="numero_cheque[0]">Número do Cheque</label>
                                <div class="d-flex">
                                    <input type="text" name="numero_cheque[0]" id="numero_cheque[0]" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="data_parcela[0]">Data da Parcela</label>
                                <input type="date" name="data_parcela[0]" id="data_parcela[0]" class="form-control" value="{{date('Y-m-d')}}">
                            </div>
                            <div class="form-group">
                                <label for="valor_parcela[0]">Valor</label>
                                <input type="number" name="valor_parcela[0]" id="valor_parcela[0]" class="form-control" value="${valor}">
                            </div>
                            <div class="form-group">
                                <label for="observacao[0]">Observação</label>
                                <textarea name="observacao[0]" id="observacao[0]" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `
            
            $("#infoCheques").html(htmlPagamento)
            listenerFormaPagamentoParcela()
        } else if (forma_pagamento == 'Parcelado') {
            $("#groupDiaVencimento").removeClass('d-none')
            $("#groupParcelas").removeClass('d-none')
        }
    }

    $("#metodo_pagamento").change( (e) => {
        let metodo = $(e.target).val()

        $("#infoCheques").html("")
        tipoPagamento(metodo)

        htmlParcelas()
    })

    function calcularDataVencimento (index, dataVenda, diaVencimento) {
        let dataVendaObj = new Date(dataVenda)
        
        let ultimoDiaDoMes = new Date(
            dataVendaObj.getFullYear(), 
            dataVendaObj.getMonth() + index + 1,
            0
        )
        
        let dataVencimentoObj = (diaVencimento > ultimoDiaDoMes.getDate()) 
        ? ultimoDiaDoMes 
        : new Date(
            dataVendaObj.getFullYear(), 
            dataVendaObj.getMonth() + index,
            diaVencimento
        ) 

        return dataVencimentoObj.getFullYear() + '-' 
        + (adicionaZero(dataVencimentoObj.getMonth()+1).toString()) + "-"
        + adicionaZero(dataVencimentoObj.getDate().toString());
    
    }

    function htmlParcelas () {
        $("#parcelas").change ( (e) => {
            let parcelas = $(e.target).val() || 1
            let diaVencimento = $("#dia_vencimento").val()
            let dataVenda = $("#data_venda").val()
            let valorTotal = $("#valor_total").val() || 0
            let proximaData
            let campoValor = valorTotal / parcelas
            let campoValorTratado = campoValor.toFixed(2)
            let html = "";

            if (!dataVenda) {
                Swal.fire(
                    'Erro!',
                    'Informe a data da venda!',
                    'error'
                ).then((result) => {
                    $("#infoCheques").html('')
                    $("#data_venda").focus()
                    return
                })
            }
            
            for (let index = 0; index < parcelas; index++) {
                
                let dataVencimento = calcularDataVencimento(index, dataVenda, diaVencimento)
                
                let btnCopiarDados = (index == 0) 
                ? '<div class="btn btn-dark copiarDadosPagamento">Copiar</div>' 
                : ''

                html += `
                    <div class="col-md-4 col-sm-6 col-lg-3">
                        <div class="card mb-4 card-hover">
                            <div class="card-body">
                                <h5 class="card-title mb-4"> 
                                    <div class="d-flex justify-content-between">
                                        <div>${index + 1}ª Parcela</div>
                                        ${btnCopiarDados}
                                    </div>
                                </h5>
                                <div class='form-group'>
                                    <label for="forma_pagamento[${index}]">Informe a forma de pagamento</label>
                                    <select class="form-control" name="forma_pagamento[${index}]" id="forma_pagamento[${index}]" data-index="${index}">
                                        ${option}
                                    </select>
                                </div>
                                <div class="form-group d-none" id="groupNome_${index}">
                                    <label for="nome_cheque[${index}]">Nome</label>
                                    <div class="d-flex">
                                        <input type="text" name="nome_cheque[${index}]" id="nome_cheque[${index}]" class="form-control primeiroInputNome">
                                        
                                    </div>
                                </div>
                                <div class="form-group d-none" id="groupNumero_${index}">
                                    <label for="numero_cheque[${index}]">Número do Cheque</label>
                                    <div class="d-flex">
                                        <input type="text" name="numero_cheque[${index}]" id="numero_cheque[${index}]" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="data_parcela[${index}]">Data da Parcela</label>
                                    <input type="date" name="data_parcela[${index}]" id="data_parcela[${index}]" class="form-control" value="${dataVencimento}">
                                </div>
                                <div class="form-group">
                                    <label for="valor_parcela[${index}]">Valor</label>
                                    <input type="number" step="0.01" name="valor_parcela[${index}]" id="valor_parcela[${index}]" class="form-control primeiroInputValor" value="${campoValorTratado}">
                                </div>
                                <div class="form-group">
                                    <label for="observacao[${index}]">Observação</label>
                                    <textarea name="observacao[${index}]" id="observacao[${index}]" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                `

            }
            
            $("#infoCheques").html(html);

            copiarDadosPagamento()
            
            listenerFormaPagamentoParcela()
        })
    }

    $("#cotacao_fator, #fator, #cotacao_peso, #peso").change( (e) => {
        
        if (!$("#cotacao_fator").val() && !$("#cotacao_peso").val()) {
            return false;
        }

        let cotacao_fator = $("#cotacao_fator").val() || 0
        let cotacao_peso = $("#cotacao_peso").val() || 0
        let fator = $("#fator").val() || 0
        let peso = $("#peso").val() || 0

        calcularTotalVenda(cotacao_fator, cotacao_peso, fator, peso)
    })

    // function addDays(date, days) {
    //     let arrDate = date.split("-")
    //     let daysFiltered = parseInt(days)

    //     var result = new Date(arrDate[0], arrDate[1]-1, arrDate[2])
    //     result.setDate(result.getDate() + daysFiltered);
    
    //     return result.getFullYear() + '-' 
    //     + (adicionaZero(result.getMonth()+1).toString()) + "-"
    //     + adicionaZero(result.getDate().toString());
    // }

    function adicionaZero(numero){
        if (numero <= 9) 
            return "0" + numero;
        else
            return numero; 
    }

    function calcularTotalVenda (cotacao_fator, cotacao_peso, fator, peso) {

        let totalFator = cotacao_fator * fator
        let totalPeso = cotacao_peso * peso
        let totalCompra = totalFator + totalPeso
        let valorTotalCompraTratado = totalCompra.toFixed(2)
        
        $("#valor_total").val(valorTotalCompraTratado)
    }

    $(".procurarCliente").click( () => {
        $(".modal").modal('show')

        $(".modal-header").text(`Procurar cliente`)
        $(".modal-footer > .btn-primary").remove()

        $(".modal-body").html(`
            <form id="formProcurarCliente" method="GET" action="{{ route('procurarCliente') }}">
                <input type="hidden" name="representante_id" value="{{ $representante_id }}">
                <div class="d-flex justify-content-between">
                    <input class="form-control" id="dado" name="dado" placeholder="Informe o cpf ou nome do Cliente">
                    <button type="submit" class="btn btn-dark ml-2">
                        <span class="fas fa-search"></span>
                    </button>
                </div>
            </form>
            <div id="respostaProcura" class="mt-2"></div>
        `);

        $("#formProcurarCliente").submit( (element) => {
            element.preventDefault();
            
            let form = element.target;

            if (!$("#dado").val()) {
                $("#respostaProcura").html(`<div class="alert alert-danger">Informe o nome ou o cpf</div>`)
                return false;
            }

            $.ajax({
                type: $(form).attr('method'),
                url: $(form).attr('action'),
                data: $(form).serialize(),
                dataType: 'json',
                beforeSend: () => {
                    swal.showLoading()
                },
                success: (response) => {
                    swal.close()
                    let clientes = response.clientes
                    let html = ""

                    clientes.forEach(element => {
                        html += `
                            <tr>
                                <td>${element.pessoa.nome}</td>
                                <td>
                                    <div class="btn btn-dark btn-selecionar" data-id="${element.id}">
                                        <span class="fas fa-check"></span>
                                    <div>
                                </td>
                        `
                    });

                    $("#respostaProcura").html(`
                        <table class="table text-center table-light">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nome</th>
                                    <th><span class="fas fa-check"></th>
                                </tr>    
                            </thead>
                            <tbody>
                                ${html}
                            </tbody>
                        </table>
                    `)

                    $(".btn-selecionar").each( (index, element) => {
                        $(element).click( () => {
                            let cliente_id = $(element).data("id")
                            $(".modal").modal("hide")
                            $("#cliente_id").val(cliente_id)
                        })
                    })
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error(jqXHR)
                    console.error(textStatus)
                    console.error(errorThrown)
                }
            });
        })
    });

    function copiarDadosPagamento () {
        $(".copiarDadosPagamento").click( () => { 
            
            copiarInput(
                $("input[name^='nome_cheque']:eq(0)").val(), 
                $("input[name^='nome_cheque']:not(:eq(0))")
            )

            copiarInput(
                $("input[name^='valor_parcela']:eq(0)").val(), 
                $("input[name^='valor_parcela']:not(:eq(0))")
            )

            copiarInput(
                $("select[name^='forma_pagamento']:eq(0)").val(), 
                $("select[name^='forma_pagamento']:not(:eq(0))")
            )

        })
    }

    function copiarInput (valorInput, campos) {
        if (!valorInput) {
            return
        }
        
        campos.each( (index, element) => {
            $(element).val(valorInput).change()
        })
    }

    function listenerFormaPagamentoParcela () {
        $("select[name^='forma_pagamento']").each( (index, element) => {
            $(element).change( (e) => {
                let select = $(e.target)
                let valorSelect = select.val()
                let indexSelect = $(e.target).data('index')

                if (valorSelect == 'Cheque') {
                    $("#groupNumero_" + indexSelect).removeClass('d-none')
                    $("#groupNome_" + indexSelect).removeClass('d-none')
                    return
                }

                $("#groupNumero_" + indexSelect).addClass('d-none')
                $("#groupNome_" + indexSelect).addClass('d-none')
                
            });
            
        })
    }
</script>
@endsection