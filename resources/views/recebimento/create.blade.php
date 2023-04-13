@extends('layout')
@section('title')
Adicionar recebimento
@endsection
@section('body')
<style>
    .info-cheque-selecionado {
        display: none;
    }
</style>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('recebimentos.index') }}">Recebimentos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cadastrar</li>
    </ol>
</nav>

<form method="POST" action="{{ route('recebimentos.store')}}">
    @csrf
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Cadastrar</h5>
            
            <div class="btn btn-dark informar_parcela">Relacionar o pagamento à um cheque ou parcela</div>
            
            <div>
                <hr>
                <div class="row">
                    <div class="col-4">
                        <x-form-group readonly type="date" name="data_parcela" value="{{ old('data_parcela') }}">Data do cheque</x-form-group>
                    </div>
                    <div class="col-4">
                        <x-form-group readonly type="text" name="nome_parcela" value="{{ old('nome_parcela') }}">Titular do cheque</x-form-group>
                    </div>
                    <div class="col-4">
                        <x-form-group readonly type="number" name="valor_parcela" value="{{ old('valor_parcela') }}">Valor do cheque</x-form-group>
                    </div>
                    <div class="col-4">
                        <x-form-group readonly type="number" name="parcela_id" value="{{ old('parcela_id') }}">Código do cheque</x-form-group>
                    </div>
                    <div class="col-4 form-group">
                        <label for="representante_id">Representante</label>
                        <x-select readonly name="representante_id">
                            <option></option>
                            @foreach($representantes as $representante)
                                <option value="{{$representante->id}}" {{ old('representante_id') == $representante->id ? 'selected' : '' }} >
                                    {{$representante->pessoa->nome}}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="col-4 form-group">
                        <label for="parceiro_id">Parceiro</label>
                        <x-select readonly name="parceiro_id">
                            <option value="">Carteira</option>
                            @foreach($parceiros as $parceiro)
                                <option value="{{$parceiro->id}}" {{ old('parceiro_id') == $parceiro->id ? 'selected' : '' }} >
                                    {{$parceiro->pessoa->nome}}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
                </div>
                <hr>
            </div>
            <p></p>
            <div id='pagamentosParcela'></div>
            <p></p>
            <div class="row">
                <div class="col-4">
                    <x-form-group type="date" name="data" value="{{ old('data') ?? date('Y-m-d') }}">Data</x-form-group>
                </div>
                <div class="col-4">
                    <x-form-group name="valor" value="{{ old('valor') }}">Valor</x-form-group>
                </div>
                
                <div class="col-4 form-group">
                    <label for="conta_id">Conta</label>
                    <x-select name="conta_id">
                        <option></option>
                        @foreach($contas as $conta)
                            <option value={{ $conta->id }} {{ old('conta_id') == $conta->id ? 'selected' : '' }}>{{ $conta->nome }}</option>
                        @endforeach
                            <option value="999">Conta de Parceiro</option>
                    </x-select>
                </div>
                <div class="col-4 form-group">
                    <label for="forma_pagamento">Forma de Pagamento</label>
                    <x-select name="forma_pagamento" value="{{ old('forma_pagamento') }}">
                        <option></option>
                        <option value='Pix' {{ old('forma_pagamento') == 'PIX' ? 'selected' : '' }} > PIX </option>
                        <option value='TED' {{ old('forma_pagamento') == 'TED' ? 'selected' : '' }} > TED </option>
                        <option value='Depósito' {{ old('forma_pagamento') == 'Depósito' ? 'selected' : '' }} > Depósito </option>
                        <option value='DOC' {{ old('forma_pagamento') == 'DOC' ? 'selected' : '' }} > DOC </option>
                        <option value='Dinheiro' {{ old('forma_pagamento') == 'Dinheiro' ? 'selected' : '' }} > Dinheiro </option>
                    </x-select>
                </div>
                <div class="col-4 form-group">
                    <label for="confirmado">Pagamento Confirmado?</label>
                    <x-select name="confirmado">
                        <option></option>
                        <option value=1 {{ old('confirmado') == 'Sim' ? 'selected' : '' }} > Sim </option>
                        <option value=0 {{ old('confirmado') == 'Não' ? 'selected' : '' }} > Não </option>
                    </x-select>
                </div>
                <div class="col-4 form-group">
                    <label for="tipo_pagamento">Pagamento</label>
                    <x-select name="tipo_pagamento" value="{{ old('tipo_pagamento') }}">
                        <option></option>
                        <option value=2 {{ old('tipo_pagamento') == '2' ? 'selected' : '' }} > Cliente para a empresa </option>
                        <option value=1 {{ old('tipo_pagamento') == '1' ? 'selected' : '' }} > Empresa para o parceiro </option>
                        <option value=3 {{ old('tipo_pagamento') == '3' ? 'selected' : '' }} > Cliente para o parceiro </option>
                        <option value=4 {{ old('tipo_pagamento') == '4' ? 'selected' : '' }} > Cliente para outro parceiro </option>
                    </x-select>
                </div>
                <div class="col-12">
                    <x-form-group type="text" name="comprovante_id" value="{{ old('comprovante_id') }}">Comprovante ID</x-form-group>
                </div>
                <!-- <div class="col-4 form-group">
                    <label for="parceiro_id">Parceiro</label>
                    <x-select name="parceiro_id" value="{{ old('parceiro_id') }}">
                        <option></option>
                        @foreach($parceiros as $parceiro)
                            <option value={{$parceiro->id}}> {{$parceiro->pessoa->nome}} </option>
                        @endforeach

                    </x-select>
                </div> -->
                <div class="col-12 form-group">
                    <label for="observacao">Observação</label>
                    <x-text-area name="observacao" type="text" value="{{  old('observacao') }}"></x-text-area>
                </div>
                <!-- <div class="col-12 form-group">
                    <label for="anexo">Anexo de Arquivo</label>
                    <input type="file" id="anexo" name="anexo[]" class="form-control-file">
                </div>
                 -->
            </div> 
        </div>
    </div>

    <input type="submit" class='btn btn-success'>
</form>
@endsection
@section('script')
<script>    
    $("#modal-body2").html(`
        <form id="form_procura_cheque" method="POST" action="{{ route('consulta_parcela_pagamento') }}">
            @csrf

            <div class="row">
                <div class="col-3 form-group">
                    <x-select name="tipo_select" type="number" value="{{ old('tipo_select') }}">
                        <option value="valor_parcela">Valor</option>
                        <option value="numero_cheque">Número</option>
                        <option value="nome_cheque">Titular</option>
                        <option value="data_parcela">Data</option>
                        <option value="representante_id">Representante</option>
                        <option value="status">Status</option>
                    </x-select>
                </div>
            
                <div class="col-7 form-group">
                    <x-input name="texto_pesquisa"></x-input>
                </div>
                <div class="col-2 form-group">
                    <input type="submit" class='btn btn-dark'>
                </div>
            </div>
                
        </form>
        <div id="table_div"></div>
    `)
    

    $("#form_procura_cheque").submit( (e) => {
            
        e.preventDefault()
        let dataForm = $(e.target).serialize() 
        
        $.ajax({
            type: 'GET',
            url: e.target.action,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: dataForm,
            dataType: 'json',
            beforeSend: () => {
                Swal.showLoading()
            },
            success: (response) => {
                let tableBody = ''
                console.log(response)
                response.forEach(element => {
                    let dataTratada = transformaData(element.data_parcela)
                    let ondeEstaCheque = carteiraOuParceiro(element.parceiro_id, element.nome_parceiro)
                    let numero_banco = tratarNulo(element.numero_banco)
                    let numero_cheque = tratarNulo(element.numero_cheque)
                    let representante = tratarNulo(element.nome_representante)
                    let cliente = tratarNulo(element.nome_cliente)
                    if (element.status === 'ADIADO') {
                        tableBody += `
                            <tr>
                                <td>${element.nome_cheque ?? element.nome_cliente}</td>
                                <td><span class="text-muted">(${dataTratada})</span> ${transformaData(element.nova_data)}</td>
                                <td>${element.valor_parcela_tratado}</td>
                                <td>${representante}</td>
                                <td>${ondeEstaCheque}</td>
                                <td>${element.forma_pagamento} ${numero_cheque}<br>${element.status}</td>
                                <td> 
                                    <div class="btn btn-dark btn-selecionar-cheque" 
                                        data-id="${element.id}" 
                                        data-dia="${element.data_parcela}" 
                                        data-valor="${element.valor_parcela}" 
                                        data-nome="${element.nome_cheque}"
                                        data-parceiro_id="${element.parceiro_id}"
                                        data-representante_id="${element.representante_id}"
                                        data-cliente="${element.nome_cliente}"
                                    > Selecionar </div>   
                                </td> 
                            </tr>
                        `
                    } else {
                        tableBody += `
                            <tr>
                                <td>${element.nome_cheque ?? element.nome_cliente}</td>
                                <td>${dataTratada}</td>
                                <td>${element.valor_parcela_tratado}</td>
                                <td>${representante}</td>
                                <td>${ondeEstaCheque}</td>
                                <td>${element.forma_pagamento} ${numero_cheque}<br>${element.status}</td>
                                <td> 
                                    <div class="btn btn-dark btn-selecionar-cheque" 
                                        data-id="${element.id}" 
                                        data-dia="${element.data_parcela}" 
                                        data-valor="${element.valor_parcela}" 
                                        data-nome="${element.nome_cheque}"
                                        data-parceiro_id="${element.parceiro_id}"
                                        data-representante_id="${element.representante_id}"
                                        data-cliente="${element.nome_cliente}"
                                    > Selecionar </div>   
                                </td> 
                            </tr>
                        `
                    }
                })

                $(".modal-body > #table_div").html(`
                    <x-table>
                        <x-table-header>
                            <tr>
                                <th colspan=10>Número total de resultado: ${response.length}</th>  
                            </tr>
                            <tr>
                                <th>Titular</th>
                                <th>Data</th>
                                <th>Valor</th>
                                <th>Representante</th>
                                <th>Parceiro</th>
                                <th>Pgto</th>
                                <th><i class="fas fa-check"></i></th>  
                            </tr>
                        </x-table-header>
                        <tbody>
                            ${tableBody}
                        </tbody>
                    </x-table>
                `)

                $(".btn-selecionar-cheque").each( (index, element) => {
                    $(element).click( (e) => {
                        console.log(e.target)
                        $("#nome_parcela").val($(e.target).data('nome') ?? $(e.target).data('cliente'))
                        $("#valor_parcela").val($(e.target).data('valor'))
                        $("#valor").val($(e.target).data('valor'))
                        $("#data_parcela").val($(e.target).data('dia'))
                        $("#parcela_id").val($(e.target).data('id'))
                        $("#representante_id").val($(e.target).data('representante_id'))
                        $("#parceiro_id").val($(e.target).data('parceiro_id'))

                        $("#modal2").modal("hide")

                        
                        //procurar no banco infos de pagamento desse cheque
                        let pagamentos = procurarPagamentos($(e.target).data('id'))
                    }) 
                
                })
            
                Swal.close()
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error(jqXHR)
                console.error(textStatus)
                console.error(errorThrown)
            }
        });
            
    })

    $('.informar_parcela').click( () => {
        $("#modal2").modal('show')
        $("#modal-header2").text(`Procurar Cheque`)
        
    })

    function procurarPagamentos(parcela_id) {
        let tableBodyPagamentos = '';
        let totalPago = 0;

        $.ajax({
            type: 'GET',
            url: '/procurar_pagamento',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'parcela_id': parcela_id
            },
            dataType: 'json',
            beforeSend: () => {
                Swal.showLoading()
            },
            success: (response) => {
                
                response.forEach(element => {
                    let valorTratado = parseFloat(element.valor)

                    tableBodyPagamentos += `
                        <tr class = ${element.confirmado ? '' : 'table-danger'}>
                            <td>${transformaData(element.data)}</td>
                            <td>${moeda.format(valorTratado)}</td>
                            <td>${element.conta.nome}</td>
                            <td>${element.forma_pagamento}</td>
                            <td>${element.confirmado ? 'Sim' : 'Não'}</td>
                        <tr>
                    `
                    totalPago += valorTratado;
                })

                $("#pagamentosParcela").html(`
                    <x-table>
                        <x-table-header>
                            <tr>
                                <th>Data</th>
                                <th>Conta</th>
                                <th>Forma do Pagamento</th>
                                <th>Valor</th>
                                <th>Confirmado?</th>
                            </tr>
                        </x-table-header>
                        <tbody>
                            ${tableBodyPagamentos}
                        </tbody>
                        <t-foot>
                            <tr>
                                <td colspan=3>Total pago</td>
                                <td colspan=2>${moeda.format(totalPago)}</td>
                            </tr>
                        </t-foot>
                    </x-table>
                `)

                Swal.close()
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error(jqXHR)
                console.error(textStatus)
                console.error(errorThrown)
            }
        });
    }

    let moeda = Intl.NumberFormat('en-GB', {
        style: 'currency',
        currency: 'BRL',
    });

    function transformaData (data) {
        var parts = data.split("-");
        return parts[2]+'/'+parts[1]+'/'+parts[0];
    }

    function carteiraOuParceiro (id, nome) {
        if (id === null) {
            return 'CARTEIRA'
        }

        return nome
    }

    function tratarNulo (valor) {
        if (valor === null) {
            return '';
        }
        return valor
    }

    $("#tipo_pagamento").change( (e) => {
        let valor = $(e.target).val()
        if (valor === 2) {
            $("#parceiro_id").fadeIn();
        }
        console.log($(e.target).val());
    })
</script>
@endsection