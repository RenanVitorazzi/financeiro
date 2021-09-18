@extends('layout')
@section('title')
Procurar cheque
@endsection
@section('body')
<h3>Procurar cheque</h3>
<form id="form_procura_cheque" method="POST" action="{{ route('consulta_cheque') }}">
    @csrf

    <div class="row">
        <div class="col-3 form-group">
            <x-select name="tipo_select" type="number" value="{{ old('tipo_select') }}">
                <option value="valor_parcela">Valor</option>
                <option value="numero_cheque">Número</option>
                <option value="nome_cheque">Titular</option>
                <option value="data_parcela">Data</option>
                <option value="representante_id">Representante</option>
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
@endsection
@section('script')
<script>
    const TAXA = 3;
    const MODAL = $("#modal")
    const MODAL_BODY = $("#modal-body")
    procurarCheque()

    function adiarCheque(element) {

        let data = $(element).data()
        console.log(data);
        let novaData = addDays(data.dia, 15)
        let jurosTotais = calcularNovosJuros(element, 15)
        MODAL.modal("show")
        
        $("#modal-title").html("Prorrogação")
        
        MODAL_BODY.html(`
            <form id="formAdiamento" action="{{ route('adiamentos.store') }}"> 
                <meta name="csrf-token-2" content="{{ csrf_token() }}">
                <p>Titular: <b>${data.nome}</b></p>
                <p>Valor do cheque: <b>${data.valor}</b></p>
                <p>Data: <b>${transformaData(data.dia)}</b></p>
                <p>Dias adiados: <b><span id="diasAdiados">15</span></b></p>

                <x-input hidden type="date" value="${data.dia}" name="parcela_data"></x-input>
                <x-input hidden type="text" value="${data.id}" name="parcela_id"></x-input>
                
                <div class="form-group">
                    <label for="nova_data">Informe a nova data</label>
                    <x-input type="date" value="${novaData}" name="nova_data"></x-input>
                </div>
                <div class="form-group">
                    <label for="taxa_juros">Informe a taxa de juros (%)</label>
                    <x-input type="number" value="${TAXA}" name="taxa_juros"></x-input>
                </div>
                <div class="form-group">
                    <label for="juros_totais">Valor total de juros</label>
                    <x-input readonly type="number" value="${jurosTotais}" name="juros_totais"></x-input>
                </div>
                
                <div class="form-group">
                    <label for="observacao">Observação</label>
                    <x-textarea name="observacao"></x-textarea>
                </div>
            </form>

        `)

        $("#taxa_juros, #nova_data").change( () => {
            let dataNova = $("#nova_data").val()
            let diferencaDias = calcularDiferencaDias(data.dia, dataNova)

            let jurosNovos = calcularNovosJuros(element, diferencaDias)

            $("#diasAdiados").html(diferencaDias)
            $("#juros_totais").val(jurosNovos)
        })

        
    }

    $(".modal-footer > .btn-primary").click( () => {
        let dataForm = $("#formAdiamento").serialize()
        console.log(dataForm);

        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-2"]').attr('content')
            },
            url: $('#formAdiamento').attr('action'),
            data: dataForm,
            dataType: 'json',
            beforeSend: () => {
                swal.showLoading()
            },
            success: (response) => {
                console.log(response);
                Swal.fire({
                    title: response.title,
                    icon: response.icon,
                    text: response.text
                })
                    
                MODAL.modal("hide")
                $("#form_procura_cheque").submit()
            },
            error: (jqXHR, textStatus, errorThrown) => {
                var response = JSON.parse(jqXHR.responseText)
                var errorString = ''
                $.each( response.errors, function( key, value) {
                    errorString += '<div>' + value + '</div>'
                });
        
                Swal.fire({
                    title: 'Erro',
                    icon: 'error',
                    html: errorString
                })
            }
        });
    })

    function addDays (date, days) {
        var result = new Date(date)
        result.setDate(result.getDate() + days)
        return result.toISOString().slice(0,10)
    }

    function calcularNovosJuros (element, dias) {
        let taxa = $("#taxa").val();
        let valor_cheque = $(element).data("valor")
        let porcentagem = taxa / 100 || TAXA / 100 ;
        
        return ( ( (valor_cheque * porcentagem) / 30 ) * dias).toFixed(2)
    }

    function calcularDiferencaDias (dataAntiga, dataNova) {
        let date1 = new Date(dataAntiga)
        let date2 = new Date(dataNova)
        if (date1.getTime() > date2.getTime()) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'A data de adiamento deve ser maior que a data do cheque!'
            })
        }
        
        const diffTime = Math.abs(date2 - date1)
        return Math.ceil(diffTime / (1000 * 60 * 60 * 24))
    }

    $("#tipo_select").change( (e) => {
        if (e.target.value==='data_parcela') {
            $('#texto_pesquisa').get(0).type = 'date';
            return
        }

        $('#texto_pesquisa').get(0).type = 'text';
    })

    function procurarCheque () {
        
        $("#form_procura_cheque").submit( (e) => {
            
            e.preventDefault()
            let dataForm = $(e.target).serialize() 
            console.log(dataForm);
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
                    console.log(response);
                    let tableBody = ''
    
                    response.forEach(element => {
                        let dataTratada = transformaData(element.data_parcela)
                        let ondeEstaCheque = carteiraOuParceiro(element.parceiro_id, element.nome_parceiro)
                        if (element.status === 'Adiado') {
                            tableBody += `
                                <tr>
                                    <td>${element.nome_cheque}</td>
                                    <td><span class="text-muted">(${dataTratada})</span> ${transformaData(element.nova_data)}</td>
                                    <td>${element.valor_parcela}</td>
                                    <td>${element.nome_representante}</td>
                                    <td>${ondeEstaCheque}</td>
                                    <td>${element.numero_banco}</td>
                                    <td>${element.numero_cheque}</td>
                                    <td>${element.status}</td>
                                    <td>
                                        <div class="btn btn-dark btn-adiar" 
                                            data-id="${element.id}" 
                                            data-dia="${element.data_parcela}" 
                                            data-valor="${element.valor_parcela}" 
                                            data-nome="${element.nome_cheque}"
                                        > Adiar <i class="far fa-clock"></i> </div>    
                                    </td>
                                </tr>
                            `
                        } else {
                            tableBody += `
                                <tr>
                                    <td>${element.nome_cheque}</td>
                                    <td>${dataTratada}</td>
                                    <td>${element.valor_parcela}</td>
                                    <td>${element.nome_representante}</td>
                                    <td>${ondeEstaCheque}</td>
                                    <td>${element.numero_banco}</td>
                                    <td>${element.numero_cheque}</td>
                                    <td>${element.status}</td>
                                    <td>
                                        <div class="btn btn-dark btn-adiar" 
                                            data-id="${element.id}" 
                                            data-dia="${element.data_parcela}" 
                                            data-valor="${element.valor_parcela}" 
                                            data-nome="${element.nome_cheque}"
                                        > Adiar <i class="far fa-clock"></i> </div>    
                                    </td>
                                </tr>
                            `
                        }
                    })
    
                    $("#table_div").html(`
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
                                    <th>Banco</th>
                                    <th>Nº</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </x-table-header>
                            <tbody>
                                ${tableBody}
                            </tbody>
                        </x-table>
                    `)
    
                    $(".btn-adiar").each( (index, element) => {
                        $(element).click( () => {
                            adiarCheque(element)
                        })
                    });
    
                    Swal.close()
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error(jqXHR)
                    console.error(textStatus)
                    console.error(errorThrown)
                }
            });
        })
    }

    function transformaData (data) {
        var parts = data.split("-");
        return parts[2]+'/'+parts[1]+'/'+parts[0];
    }

    function carteiraOuParceiro (id, nome) {
        if (id === null) {
            return 'Carteira'
        }

        return nome
    }
    
</script>
@endsection