@extends('layout')
@section('title')
Adicionar vendas
@endsection
@section('body')
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">

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
<form method="POST" action="{{ route('venda.store') }}" id="formEnviarVenda">
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
                        {{ $cliente->nome }}
                    </option>
                    @endforeach
                </x-select>
                <div class="btn btn-dark procurarCliente">
                    <span class="fas fa-search"></span>
                </div>
            </div>
        </div>
    </div>
        
    <div id="consignado"></div>
        
    <input type="hidden" name="balanco" value="Venda">
    <input type="hidden" name="representante_id" id="representante_id" value="{{ $representante_id }}">
        
        <x-table class="table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
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
                    <td><x-input name="valor_total" type="number" step="0.01" value="{{ old('valor_total') }}" ></x-input></td>
                </tr>
            </tbody>
        </x-table>
        <div class='row'>
            <div class="col-4 form-group">
                <label for="metodo_pagamento">Método de Pagamento</label>
                <x-select name="metodo_pagamento" required>
                    <option value=""></option>
                    @foreach ($metodo_pagamento as $metodo)
                        <option  {{ old('metodo_pagamento') == $metodo ? 'selected' : '' }} value="{{ $metodo }}">{{ $metodo }}</option>
                    @endforeach
                </x-select> 
            </div>
            <div class="col-4 form-group" id="groupDiaVencimento">
                <label for="dia_vencimento">Dia de vencimento</label>
                <x-input name="dia_vencimento" type="number" value="{{old('dia_vencimento')}}"></x-input>
            </div>
            <div class="col-4 form-group" id="groupParcelas">
                <label for="parcelas">Quantidade de parcelas</label>
                <x-input name="parcelas" type="number" value="{{old('parcelas')}}"></x-input>
            </div>
        </div> 
    
    <div id="infoCheques" class="row">
        @if (old('parcelas') && old('parcelas') > 0)
            @for ($i = 0; $i < old('parcelas'); $i++)
                <div class="col-4">
                    <div class="card mb-4 card-hover">
                        <div class="card-body">
                            <h5 class="card-title mb-4"> 
                                <div class="d-flex justify-content-between">
                                    <div>{{ $i + 1 }}ª Parcela</div>
                                    @if($i == 0) 
                                        <div class="btn btn-dark copiarDadosPagamento">Copiar</div>
                                    @endif
                                </div>
                            </h5>
                            <div class='form-group'>
                                <label for="forma_pagamento[{{$i}}]">Informe a forma de pagamento</label>
                                <x-select class="form-control {{ $errors->has('forma_pagamento.'.$i) ? 'is-invalid' : ''}}" name="forma_pagamento[{{$i}}]" id="forma_pagamento[{{$i}}]" data-index="{{$i}}" >
                                    <option value=""></option>
                                    @foreach ($forma_pagamento as $forma)
                                        <option value="{{ $forma }}" {{ $forma == old('forma_pagamento.'.$i) ? 'selected' : '' }}>
                                            {{ $forma }}
                                        </option>
                                    @endforeach
                                </x-select>
                                @error('forma_pagamento.'.$i)
                                    <div class="invalid-feedback d-inline">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group {{old('forma_pagamento.'.$i) == 'Cheque' ? '' : 'd-none'}}" id="groupNome_{{$i}}">
                                <label for="nome_cheque[{{$i}}]">Nome</label>
                                <div class="d-flex">
                                    <x-input type="text" name="nome_cheque[{{$i}}]" 
                                        id="nome_cheque[{{$i}}]" 
                                        class="form-control primeiroInputNome {{ $errors->has('nome_cheque.'.$i) ? 'is-invalid' : ''}}"
                                        value="{{old('nome_cheque.'.$i)}}"
                                    ></x-input>
                                    @error('nome_cheque.'.$i)
                                        <div class="invalid-feedback d-inline">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group {{old('forma_pagamento.'.$i) == 'Cheque' ? '' : 'd-none'}}" id="groupNumero_{{$i}}">
                                <label for="numero_banco[{{$i}}]">Número do Banco</label>
                                <div class="d-flex">
                                    <x-input type="text" 
                                        name="numero_banco[{{$i}}]" 
                                        id="numero_banco[{{$i}}]" 
                                        class="form-control {{ $errors->has('numero_banco.'.$i) ? 'is-invalid' : ''}}" 
                                        value="{{ old('numero_banco.'.$i) }}"
                                    ></x-input>
                                    @error('numero_banco.'.$i)
                                        <div class="invalid-feedback d-inline">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group {{old('forma_pagamento.'.$i) == 'Cheque' ? '' : 'd-none'}}" id="groupNumero_{{$i}}">
                                <label for="numero_cheque[{{$i}}]">Número do Cheque</label>
                                <div class="d-flex">
                                    <x-input type="text" 
                                        name="numero_cheque[{{$i}}]" 
                                        id="numero_cheque[{{$i}}]" 
                                        class="form-control {{ $errors->has('numero_cheque.'.$i) ? 'is-invalid' : ''}}"
                                        value="{{old('numero_cheque.'.$i)}}"
                                    ></x-input>
                                    @error('numero_cheque.'.$i)
                                        <div class="invalid-feedback d-inline">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="data_parcela[{{$i}}]">Data da Parcela</label>
                                <x-input type="date" 
                                    name="data_parcela[{{$i}}]" 
                                    id="data_parcela[{{$i}}]" 
                                    class="form-control {{ $errors->has('data_parcela.'.$i) ? 'is-invalid' : ''}}" 
                                    value="{{old('data_parcela.'.$i)}}"
                                ></x-input>
                                @error('data_parcela.'.$i)
                                    <div class="invalid-feedback d-inline">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="valor_parcela[{{$i}}]">Valor</label>
                                <x-input type="number" 
                                    name="valor_parcela[{{$i}}]" 
                                    id="valor_parcela[{{$i}}]" 
                                    class="form-control primeiroInputValor {{ $errors->has('valor_parcela.'.$i) ? 'is-invalid' : ''}}" 
                                    value="{{old('valor_parcela.'.$i)}}"
                                ></x-input>
                                @error('valor_parcela.'.$i)
                                    <div class="invalid-feedback d-inline">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                           
                            <div class="form-group">
                                <label for="status[{{$i}}]">Status</label>
                                <x-select name="status[{{$i}}]" id="status[{{$i}}]" class="{{ $errors->has('status.'.$i) ? 'is-invalid' : ''}}">
                                    <option value=""></option>
                                    @if(old('forma_pagamento.'.$i) == 'Cheque')
                                        <option value="Aguardando" {{ old('status.'.$i) == 'Aguardando' ? 'selected' : ''}}>Aguardando Depósito</option>
                                        <option value="Aguardando Envio" {{ old('status.'.$i) == 'Aguardando Envio' ? 'selected' : ''}}>Aguardando Envio</option>
                                    @elseif(old('forma_pagamento.'.$i) == 'Pix' || old('forma_pagamento.'.$i) == 'Dinheiro')
                                        <option value="Pago">Pago</option>
                                    @elseif(old('forma_pagamento.'.$i) == 'Transferência Bancária')  
                                        <option value="Pago" {{ old('status.'.$i) == 'Pago' ? 'selected' : ''}}>Pago</option>
                                        <option value="Aguardando Pagamento" {{ old('status.'.$i) == 'Aguardando Pagamento' ? 'selected' : ''}}>Aguardando Pagamento</option>
                                    @endif
                                </x-select>

                                @error('status.'.$i)
                                    <div class="invalid-feedback d-inline">
                                        {{ $message }}
                                    </div>
                                @enderror
                                
                            </div>
                            <div class="form-group">
                                <label for="observacao[{{$i}}]">Observação</label>
                                <x-textarea name="observacao[{{$i}}]" id="observacao[{{$i}}]" class="form-control">{{old('observacao.'.$i)}}</x-textarea>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        @endif
    </div>
    @if($errors->any())
        <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
        </div>
    @endif
    <input type="submit" class='btn btn-success'>
</form>
@endsection
@section('script')
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.min.js"></script>
<script>
    const FORMA_PAGAMENTO = ['Dinheiro', 'Cheque', 'Transferência Bancária', 'Pix']
    let option = `<option></option>`
    let representanteId = $("#representante_id").val()

    FORMA_PAGAMENTO.forEach(element => {
        option += `<option value="${element}">${element}</option>`;
    })

    $("#metodo_pagamento").change( (e) => {
        let metodo = $(e.target).val()

        $("#infoCheques").html("")
        //tipoPagamento(metodo)

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
                    <div class="col-4">
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
                                        <input type="text" name="nome_cheque[${index}]" id="nome_cheque[${index}]" class="form-control primeiroInputNome titularCheque">
                                        
                                    </div>
                                </div>
                                <div class="form-group d-none" id="groupNumero_${index}">
                                    <label for="numero_banco[${index}]">Número do Banco</label>
                                    <div class="d-flex">
                                        <input type="text" name="numero_banco[${index}]" id="numero_banco[${index}]" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group d-none" id="groupBanco_${index}">
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
                                    <label for="status[${index}]">Status</label>
                                    <select name="status[${index}]" id="status[${index}]" class="form-control">
                                        <option value="Aguardando" selected>Aguardando Depósito</option>  
                                        <option value="Pago">Pago</option>
                                        <option value="Aguardando Envio">Aguardando Envio</option>
                                        <option value="Aguardando Pagamento">Aguardando Pagamento</option>
                                    </select>
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
        $("#modal2").modal('show')

        $("#modal-header2").text(`Procurar cliente`)
        $("#modal-footer2 > .btn-primary").remove()

        $("#modal-body2").html(`
            <form id="formProcurarCliente" method="GET" action="{{ route('procurarCliente') }}">
                <input type='hidden' value="{{ $representante_id }}" name="representante_id">
                <div class="d-flex justify-content-between">
                    <input class="form-control" id="dado" name="dado" placeholder="Informe o CPF ou nome do Cliente">
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

            copiarInput(
                $("input[name^='numero_banco']:eq(0)").val(), 
                $("input[name^='numero_banco']:not(:eq(0))")
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
                    $("#groupBanco_" + indexSelect).removeClass('d-none')
                    
                    listenerNomes()
                    tratarCampoStatus(indexSelect, valorSelect)
                } else if (valorSelect == 'Dinheiro' || valorSelect == 'Pix') {
                    $("#groupNumero_" + indexSelect).addClass('d-none')
                    $("#groupNome_" + indexSelect).addClass('d-none')
                    $("#groupBanco_" + indexSelect).addClass('d-none')
                    
                    tratarCampoStatus(indexSelect, valorSelect)
                } else if (valorSelect == 'Transferência Bancária') {
                    $("#groupNumero_" + indexSelect).addClass('d-none')
                    $("#groupNome_" + indexSelect).addClass('d-none')
                    $("#groupBanco_" + indexSelect).addClass('d-none')

                    tratarCampoStatus(indexSelect, valorSelect)
                }

            });
            
        })
    }

    function tratarCampoStatus(index, valorSelect) {
        let opcoesDisponiveis = []
        let element = $("select[name^='status']:eq(" + index + ")")

        if (valorSelect == 'Cheque') {
            opcoesDisponiveis = {
                '': '',
                'Aguardando Depósito': 'Aguardando',
                'Aguardando Envio': 'Aguardando Envio' 
            }
        } else if (valorSelect == 'Pix' || valorSelect == 'Dinheiro') {
            opcoesDisponiveis = {
                'Pago': 'Pago'
            }
        } else if (valorSelect == 'Transferência Bancária') {
            opcoesDisponiveis = {
                '': '',
                'Pago': 'Pago', 
                'Aguardando Pagamento': 'Aguardando Pagamento'
            }
        }
        
        element.empty()

        $.each(opcoesDisponiveis, function(key,value) {
            element.append($("<option></option>")
            .attr("value", value).text(key));
        });
    }

    function listenerNomes () {
        $(".titularCheque").focus( (e) => {
            $(e.target).autocomplete({
                minLength: 0,
                source: titularDoUltimoCheque,
                autoFocus: true,
            });
        })
    }
    
    let titularDoUltimoCheque = [];

    $("#cliente_id").change( (e) => {
        
        let clienteId = $(e.target).val()

        if (clienteId) {
            $.ajax({
                type: 'GET',
                url: '/titularDoUltimoCheque',
                data: {
                    'cliente_id': clienteId
                },
                dataType: 'json',
                beforeSend: () => {
                    swal.showLoading()
                },
                success: (response) => {
                    titularDoUltimoCheque = []
                    swal.close()

                    for (let i in response) {
                        titularDoUltimoCheque.push(response[i].nome_cheque)
                    }
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error(jqXHR)
                    console.error(textStatus)
                    console.error(errorThrown)
                }
            });

            $.ajax({
                type: 'GET',
                url: '/procurarConsignado',
                data: {
                    'cliente_id': clienteId,
                    'representante_id': representanteId
                },
                dataType: 'json',
                beforeSend: () => {
                    swal.showLoading()
                },
                success: (response) => {
                    criarTextoAlertaConsignado(response)
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error(jqXHR)
                    console.error(textStatus)
                    console.error(errorThrown)
                }
            });
        } 
    })

    function criarTextoAlertaConsignado(response) {
        
        if (response.length === 0) {
            $("#consignado").html('')
            return
        }

        let arrayDataConsignado = response[0].data.split('-')
        let dataConsignadoTratada = arrayDataConsignado[2] + '/' + arrayDataConsignado[1] + '/' + arrayDataConsignado[0]

        let html = `
            <div class='alert alert-dark'>
                <h5>Dados do consignado</h5>
                <hr>  
                <p>Data: <b>${dataConsignadoTratada}</b></p>
                <p>Peso: <b>${response[0].peso}</b></p>
                <p>Fator: <b>${response[0].fator}</b></p> 
               
                <div class="form-group">
                    <label for="baixar"><b>Baixar consignado?</b></label>
                    <input type="checkbox" id="baixar" name="baixar" checked value="${response[0].id}">
                </div>
            </div>
        `

        $("#consignado").html(html)
    }

    listenerFormaPagamentoParcela ()

    let moeda = Intl.NumberFormat('en-GB', {
        style: 'currency',
        currency: 'BRL',
    });

    $("#formEnviarVenda").submit( (element) => {
        element.preventDefault();
        
        let valorTotalPago = 0;
        $("input[name^='valor_parcela']").each( (index, element) => {
            valorTotalPago += parseFloat($(element).val())
            // console.log({index, element})
        })

        let valorTotalPedido = parseFloat($("#valor_total").val())
        let form = element.target;

        if (valorTotalPago < valorTotalPedido) {
           
            Swal.fire({
                title: 'Atenção!',
                html: 
                    "O valor pago é <b>menor</b> que o valor do pedido!" + 
                    "<br> Valor total pago: " + moeda.format(valorTotalPago) + 
                    "<br> Valor total do pedido: " + moeda.format(valorTotalPedido) ,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    return
                }
            })
        }
        form.submit();
    })
</script>
@endsection